<?php
require_once 'connection/db.php';

// Insert Project Content
if (isset($_POST['add_contact'])) {
    $picture = $_POST['picture'];
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

    $db->managecontact('create', null,$title, $url_link, $picture);
    header("Location: admin.php?section=contact&action=success");
    exit;
}

// Update Project Content
if (isset($_POST['update_contact'])) {
    $id = $_POST['id'];
    $picture= $_POST['picture'];
    $url_link = $_POST['url_link'];
   

    // Image Upload
    if (!empty($_FILES['picture']['name'])) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $picture = $uploadDir . uniqid() . "-" . basename($_FILES['picture']['name']);
        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
    }

    $db->managecontact('update', $id,$title, $url_link, $picture);
    header("Location: admin.php?section=contact&action=update_success");
    exit;
}

// Delete Project Content
if (isset($_GET['delete_contact'])) {
    $id = $_GET['delete_contact'];
    $db->managecontact('delete', $id);
    header("Location: admin.php?section=contact&action=delete_success");
    exit;
}

// Fetch Project Content 
$contactContent = $db->managecontact('read');

?>
