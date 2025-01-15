<?php
require_once 'connection/db.php';

// Insert About Content
if (isset($_POST['add_hero'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
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

    $db->managehero('create', null, $title, $description, $picture);
    header("Location: admin.php?section=hero&action=success");
    exit;
}

// Update About Content
if (isset($_POST['update_hero'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
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

    $db->managehero('update', $id, $title, $description, $picture);
    header("Location: admin.php?section=hero&action=update_success");
    exit;
}

// Delete About Content
if (isset($_GET['delete_hero'])) {
    $id = $_GET['delete_hero'];
    $db->managehero('delete', $id);
    header("Location: admin.php?section=hero&action=delete_success");
    exit;
}

// Fetch About Content 
$heroContent = $db->managehero('read');
?>
