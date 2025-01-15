<?php
require_once 'connection/db.php';


if (isset($_POST['add_experience'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $db->manageExperience('create', null, $title, $description);
    header("Location: admin.php?section=experience&action=success");
    exit;
}


if (isset($_POST['update_experience'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $db->manageExperience('update', $id, $title, $description);
    header("Location: admin.php?section=experience&action=update_success");
    exit;
}


if (isset($_GET['delete_experience'])) {
    $id = $_GET['delete_experience'];
    $db->manageExperience('delete', $id);
    header("Location: admin.php?section=experience&action=delete_success");
    exit;
}


$experienceContent = $db->manageExperience('read');
?>
