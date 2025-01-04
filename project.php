<?php
require_once 'connection/db.php';

// Insert Project Content
if (isset($_POST['add_project'])) {
    $title = $_POST['title'];
    $url_link = $_POST['url_link'];
    $picture = '';

    //  Image Upload
    if (!empty($_FILES['picture']['name'])) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $picture = $uploadDir . uniqid() . "-" . basename($_FILES['picture']['name']);
        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
    }

    $db->manageProject('create', null, $title, $url_link, $picture);
    header("Location: admin.php?section=project&action=success");
    exit;
}

// Update Project Content
if (isset($_POST['update_project'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $url_link = $_POST['url_link'];
    $picture = $_POST['existing_picture'];

    // Image Upload
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

// Delete Project Content
if (isset($_GET['delete_project'])) {
    $id = $_GET['delete_project'];
    $db->manageProject('delete', $id);
    header("Location: admin.php?section=project&action=delete_success");
    exit;
}

// Fetch Project Content 
$projectContent = $db->manageProject('read');
?>
