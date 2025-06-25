<?php
require_once 'connection/db.php';


if (isset($_POST['add_project'])) {
    $title = $_POST['title'];
    $url_link = $_POST['url_link'];
    $picture = '';

    // File upload handling with validation
    if (!empty($_FILES['picture']['name'])) {
        // Define allowed file types
        $allowed_types = [
            'image/jpeg', 
            'image/png', 
            'image/gif', 
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/zip'
        ];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        $file_type = $_FILES['picture']['type'];
        $file_size = $_FILES['picture']['size'];
        
        // Validate file type and size
        if (!in_array($file_type, $allowed_types)) {
            die("Error: Only JPG, PNG, GIF images and PDF files are allowed.");
        }
        
        if ($file_size > $max_size) {
            die("Error: File size must be less than 5MB.");
        }
        
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Generate safe filename
        $picture = $uploadDir . uniqid() . "-" . preg_replace("/[^A-Za-z0-9.-]/", "", basename($_FILES['picture']['name']));
        
        // Move the file
        if (!move_uploaded_file($_FILES['picture']['tmp_name'], $picture)) {
            die("Error: Failed to upload file.");
        }
    }

    $db->manageProject('create', null, $title, $url_link, $picture);
    header("Location: admin.php?section=project&action=success");
    exit;
}


if (isset($_POST['update_project'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $url_link = $_POST['url_link'];
    $picture = $_POST['existing_picture'];

    
    if (!empty($_FILES['picture']['name'])) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $picture = $uploadDir . uniqid() . "-" . basename($_FILES['picture']['name']);
        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
    }

    $db->manageProject('update', $id, $title, $url_link, $picture);
    header("Location: admin.php?section=project&action=update_success");
    exit;
}


if (isset($_GET['delete_project'])) {
    $id = $_GET['delete_project'];
    $db->manageProject('delete', $id);
    header("Location: admin.php?section=project&action=delete_success");
    exit;
}


$projectContent = $db->manageProject('read');
?>
