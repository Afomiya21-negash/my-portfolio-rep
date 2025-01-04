<?php
require_once 'connection/db.php';

//  Adding New Content for About Section
if (isset($_POST['add_about'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $picture = null;

    //  Image Upload
    if (!empty($_FILES['picture']['name'])) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $picture = $uploadDir . uniqid() . "-" . basename($_FILES['picture']['name']);
        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
    }

    // Add Content to Database
    $db->manageAbout('create', null, $title, $description, $picture);

    // Redirect to Admin Panel
    header("Location: admin.php?section=about&add=success");
    exit;
}

// Adding New Content for Experience Section
if (isset($_POST['add_experience'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $db->manageExperience('create', null, $title, $description);

    // Redirect to Admin Panel
    header("Location: admin.php?section=experience&add=success");
    exit;
}

//  Adding New Content for Projects Section
if (isset($_POST['add_project'])) {
    $title = $_POST['title'];
    $url_link = $_POST['url_link'];
    $picture = null;

    // Image Upload
    if (!empty($_FILES['picture']['name'])) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $picture = $uploadDir . uniqid() . "-" . basename($_FILES['picture']['name']);
        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
    }

    $db->manageProject('create', null, $title, $url_link, $picture);

    // Redirect to Admin Panel
    header("Location: admin.php?section=projects&add=success");
    exit;
}
?>
