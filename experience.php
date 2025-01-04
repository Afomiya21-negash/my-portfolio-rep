<?php
require_once 'connection/db.php';

// Insert Experience Content
if (isset($_POST['add_experience'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $db->manageExperience('create', null, $title, $description);
    header("Location: admin.php?section=experience&action=success");
    exit;
}

// Update Experience Content
if (isset($_POST['update_experience'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $db->manageExperience('update', $id, $title, $description);
    header("Location: admin.php?section=experience&action=update_success");
    exit;
}

// Delete Experience Content
if (isset($_GET['delete_experience'])) {
    $id = $_GET['delete_experience'];
    $db->manageExperience('delete', $id);
    header("Location: admin.php?section=experience&action=delete_success");
    exit;
}

// Fetch Experience Content 
$experienceContent = $db->manageExperience('read');
?>
