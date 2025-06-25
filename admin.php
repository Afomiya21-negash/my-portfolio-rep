<?php
// Start with a clean output buffer
ob_start();

// Include session configuration
require_once 'session_config.php';
require_once 'connection/db.php';
require_once 'about.php';
require_once 'experience.php';
require_once 'project.php';
require_once 'hero.php';
require_once 'contact.php';

// Debug session (comment out in production)
// echo "<pre>SESSION: "; print_r($_SESSION); echo "</pre>";

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // User is not logged in, clear output buffer
    ob_end_clean();
    
    // Set no-cache headers
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
    // Redirect to login page
    header('Location: login.php');
    exit; // Important: stop script execution after redirect
}

// Session timeout (30 minutes)
$session_timeout = 30 * 60; // 30 minutes in seconds
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    // Last activity was more than 30 minutes ago
    session_unset();     // Unset $_SESSION variables
    session_destroy();   // Destroy the session
    
    // Clear output buffer
    ob_end_clean();
    
    // Set no-cache headers
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
    // Redirect to login page
    header("Location: login.php");
    exit;
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Continue with the rest of the page
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        /* Add these styles to enhance the admin panel */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        
        h1 {
            color: #3b6d91;
            text-align: center;
            margin-bottom: 30px;
        }
        
        h2 {
            color: #3b6d91;
            border-bottom: 2px solid #3b6d91;
            padding-bottom: 10px;
            margin-top: 30px;
        }
        
        section {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        form {
            display: grid;
            grid-gap: 15px;
        }
        
        label {
            font-weight: bold;
        }
        
        input, textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }
        
        button {
            background-color: #3b6d91;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        
        button:hover {
            background-color: #2c5476;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        a {
            color: #3b6d91;
            text-decoration: none;
        }
        
        a:hover {
            text-decoration: underline;
        }
        
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #e74c3c;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
        }
        
        .logout-btn:hover {
            background-color: #c0392b;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <a href="logout.php" class="logout-btn">Logout</a>
    <a href="manage_users.php" class="admin-btn">Manage Users</a>
    <h1>Admin Panel</h1>
    <section>
        <h2>Manage Hero Section</h2>
        <p class="admin-note">The hero section is the first thing visitors see. Add a professional photo and a brief introduction about yourself.</p>

        <form action="add_content.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="">
            <label for="title">Title/Name:</label>
            <input type="text" id="title" name="title" placeholder="Hello, I'm John Doe">

            <label for="description">Tagline/Description:</label>
            <textarea id="description" name="description" placeholder="Web Developer & UI/UX Designer"></textarea>

            <label for="picture">Profile Picture:</label>
            <p class="field-note">Recommended: Square image (1:1 ratio), at least 500x500px. Will be displayed as a circle.</p>
            <input type="file" id="picture" name="picture">

            <button type="submit" name="add_hero">Add</button>
        </form>
      
        <h3>added hero Content</h3>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Picture</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $heroContent->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']); ?></td>
                <td><?= htmlspecialchars($row['description']); ?></td>
                <td>
                    <?php if (!empty($row['picture'])): ?>
                        <img src="<?= htmlspecialchars($row['picture']); ?>" alt="About Image" width="100">
                    <?php endif; ?>
                </td>
                <td>

                    <a href="edit_content.php?section=hero&id=<?= $row['id']; ?>">Edit</a>
                    <a href="hero.php?delete_hero=<?= $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>

  
    <!-- About Section -->
    <section>
        <h2>Manage About Section</h2>
        <p class="admin-note">Share your background, skills, and what makes you unique. Use paragraphs to organize your content.</p>

        <form action="add_content.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="">
            <label for="title">Section Title:</label>
            <input type="text" id="title" name="title" placeholder="About Me">

            <label for="description">Your Bio:</label>
            <textarea id="description" name="description" rows="8" placeholder="I'm a passionate web developer with experience in..."></textarea>

            <label for="picture">Secondary Photo:</label>
            <p class="field-note">Recommended: Professional photo, landscape orientation (4:3 ratio).</p>
            <input type="file" id="picture" name="picture">

            <button type="submit" name="add_about">Add</button>
        </form>
      
        <h3>added About Content</h3>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Picture</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $aboutContent->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']); ?></td>
                <td><?= htmlspecialchars($row['description']); ?></td>
                <td>
                    <?php if (!empty($row['picture'])): ?>
                        <img src="<?= htmlspecialchars($row['picture']); ?>" alt="About Image" width="100">
                    <?php endif; ?>
                </td>
                <td>

                    <a href="edit_content.php?section=about&id=<?= $row['id']; ?>">Edit</a>
                    <a href="about.php?delete_about=<?= $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <!-- Experience Section -->
    <section>
        <h2>Manage Experience Section</h2>
        <p class="admin-note">Add your skills, work history, or education. Each entry will appear as a separate card in a 2-column layout.</p>

        <form action="add_content.php" method="POST">
            <input type="hidden" name="id" value="">
            <label for="title">Category/Title:</label>
            <input type="text" id="title" name="title" placeholder="Frontend Development">

            <label for="description">Details:</label>
            <textarea id="description" name="description" rows="6" placeholder="HTML: Advanced&#10;CSS: Advanced&#10;JavaScript: Intermediate"></textarea>
            <p class="field-note">Tip: Use <span>keyword</span>: value format to highlight skills. Line breaks will be preserved.</p>

            <button type="submit" name="add_experience">Add</button>
        </form>
        

        <h3>Added Experience Content</h3>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $experienceContent->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']); ?></td>
                <td><?= htmlspecialchars($row['description']); ?></td>
                <td>
                    <a href="edit_content.php?section=experience&id=<?= $row['id']; ?>">Edit</a>
                    <a href="experience.php?delete_experience=<?= $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <!-- Projects Section -->
    <section>
        <h2>Manage Projects Section</h2>
        <p class="admin-note">Showcase your best work. Each project will display as a card with an image and link.</p>

        <form action="add_content.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="">
            <label for="title">Project Title:</label>
            <input type="text" id="title" name="title" required placeholder="E-commerce Website">

            <label for="url_link">Project Link:</label>
            <input type="url" id="url_link" name="url_link" required placeholder="https://example.com">

            <label for="picture">Project Image:</label>
            <p class="field-note">Recommended: 16:9 ratio (e.g., 800x450px). High-quality screenshots work best.</p>
            <input type="file" id="picture" name="picture">

            <button type="submit" name="add_project">Add Project</button>
        </form>

        <h3>Added Projects</h3>
        <table>
            <tr>
                <th>Title</th>
                <th>Link</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $projectContent->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']); ?></td>
                <td><a href="<?= htmlspecialchars($row['url_link']); ?>" target="_blank">View Project</a></td>
                <td>
                    <?php if (!empty($row['picture'])): ?>
                        <img src="<?= htmlspecialchars($row['picture']); ?>" alt="Project Image" width="100">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="edit_content.php?section=project&id=<?= $row['id']; ?>">Edit</a>
                    <a href="admin.php?delete_project=<?= $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>
    <section>
        <h2>Manage Contact Section</h2>
        <p class="admin-note">Add ways for visitors to reach you. Each contact method will display as a button with an icon.</p>

        <form action="add_content.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="">
            <label for="title">Contact Label:</label>
            <input type="text" id="title" name="title" required placeholder="Email: john@example.com">

            <label for="url_link">Contact Link:</label>
            <input type="url" id="url_link" name="url_link" required placeholder="mailto:john@example.com">
            <p class="field-note">Use mailto: for email, tel: for phone numbers, or regular URLs for social media.</p>

            <label for="picture">Icon:</label>
            <p class="field-note">Small icon (24x24px) representing the contact method (email, phone, LinkedIn, etc.)</p>
            <input type="file" id="picture" name="picture">

            <button type="submit" name="add_contact">Add Contact Method</button>
        </form>
        
       

        <h3>added contact</h3>
        <table>
            <tr>
            <th>Title</th>
                <th>Link</th>
                <th>Picture</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $contactContent->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']); ?></td>
                <td><a href="<?= htmlspecialchars($row['url_link']); ?>" target="_blank">View Project</a></td>
                <td>
                    <?php if (!empty($row['picture'])): ?>
                        <img src="<?= htmlspecialchars($row['picture']); ?>" alt="Project Image" width="100">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="edit_content.php?section=contact&id=<?= $row['id']; ?>">Edit</a>
                    <a href="admin.php?delete_contact=<?= $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>
</body>
</html>
