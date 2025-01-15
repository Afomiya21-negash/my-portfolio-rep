<?php
require_once 'connection/db.php';

// Check if a section is provided
if (!isset($_GET['section']) || empty($_GET['section'])) {
    die("No section provided for editing.");
}

$section = $_GET['section'];

// Fetch content from the database for the given section
$result = null;
if ($section === 'hero') {
    $result = $db->managehero('read');
}elseif($section === 'about'){
    $result = $db->manageAbout('read');}
 elseif ($section === 'experience') {
    $result = $db->manageExperience('read');
} elseif ($section === 'projects') {
    $result = $db->manageProject('read');}
    elseif ($section === 'contact') {
        $result = $db->managecontact('read');
}

//  no database content exists, load static content from default.html
$content = null;
if (!$result || $result->num_rows === 0) {
    $defaultContent = file_get_contents('default.html');
    $dom = new DOMDocument();
    libxml_use_internal_errors(true); //  HTML warnings
    $dom->loadHTML($defaultContent);
    libxml_clear_errors();

    $defaultNode = $dom->getElementById($section);
    if ($defaultNode) {
        $content = [
            'title' => $defaultNode->getElementsByTagName('h2')[0]->textContent ?? 'Default Title',
            'description' => $defaultNode->getElementsByTagName('p')[0]->textContent ?? 'Default Description',
            'image_url' => null,
            'url_link' => null,
        ];
    } else {
        die("Section not found in static content.");
    }
} else {
    // If database content exists, load it
    $content = $result->fetch_assoc();
}

//  form submission to update dynamic content
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'] ?? null;
    $url_link = $_POST['url_link'] ?? null;
    $imageFileName = $content['image_url'] ?? null;

    //  image upload
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imageFileName = $uploadDir . uniqid() . "-" . basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imageFileName)) {
            die("Error uploading image.");
        }
    }

    // Update content in the database
    if ($section === 'hero') {
        $db->managehero('update', $content['id'] ?? null, $title, $description, $imageFileName);
    } elseif($section === 'about') {
        $db->manageAbout('update', $content['id'] ?? null, $title, $description, $imageFileName);
    }
    elseif ($section === 'experience') {
        $db->manageExperience('update', $content['id'] ?? null, $title, $description);
    } elseif ($section === 'projects') {
        $db->manageProject('update', $content['id'] ?? null, $title, $url_link, $imageFileName);
    }
    elseif ($section === 'contact') {
        $db->managecontact('update', $content['id'] ?? null,$title, $url_link, $imageFileName);
    }

    header("Location: index.php?section=$section&update=success");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Section: <?= htmlspecialchars($section); ?></title>
  
</head>
<body>
    <h2>Edit Section: <?= htmlspecialchars($section); ?></h2>

    <form action="edit_content.php?section=<?= htmlspecialchars($section); ?>" method="POST" enctype="multipart/form-data">
       
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($content['title'] ?? ''); ?>" required>

        <!-- Description Field -->
        <label for="description">Description:</label>
        <textarea name="description" id="description" ><?= htmlspecialchars($content['description'] ?? ''); ?></textarea>

        <!-- URL Link Field  -->
        <?php if ($section === 'projects'): ?>
            <label for="url_link">Project Link:</label>
            <input type="url" name="url_link" id="url_link" value="<?= htmlspecialchars($content['url_link'] ?? ''); ?>">
        <?php endif; ?>
        <?php if ($section === 'contact'): ?>
            <label for="url_link">contact Link:</label>
            <input type="url" name="url_link" id="url_link" value="<?= htmlspecialchars($content['url_link'] ?? ''); ?>">
        <?php endif; ?>

        <!-- Image Upload -->
        <label for="image">Image:</label>
        <?php if (!empty($content['image_url'])): ?>
            <img src="<?= htmlspecialchars($content['image_url']); ?>" alt="Current Image" width="150"><br>
        <?php endif; ?>
        <input type="file" name="image" id="image">

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
