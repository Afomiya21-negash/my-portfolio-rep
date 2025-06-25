<?php
require_once 'connection/db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>
    <link rel="stylesheet" href="home.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav>
        <ul class="side">
            <li onclick = "hideSideBar()"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#experience">Experience</a></li>
            <li><a href="#projects">Projects</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <ul>
            <h3><span style="color: #3b6d91;">A</span>fomiya</h3>
            <li class="hide"><a href="#about">About</a></li>
            <li class="hide"><a href="#experience">Experince</a></li>
            <li class="hide"><a href="#projects">Projects</a></li>
            <li class="hide"><a href="#contact">contact</a></li>
            <li onclick = "showSideBar()" class="menu"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#5f6368"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>

        </ul>
    </nav>
    <!-- Hero Section -->
<header class="hero">
  <div class="profile-container">
    <?php
    $heroContent = $db->managehero('read');
    if ($heroContent->num_rows > 0) {
        while ($row = $heroContent->fetch_assoc()) {
            echo "<img src='" . htmlspecialchars($row['picture']) . "' alt='Profile Picture'>";
        }
    }
    ?>
  </div>
  <div class="header-content">
    <?php
    $heroContent = $db->managehero('read');
    if ($heroContent->num_rows > 0) {
        while ($row = $heroContent->fetch_assoc()) {
            echo "<h1>" . htmlspecialchars($row['title']) . "</h1>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        }
    }
    ?>
    <div class="btn-container">  
        <button><a href="#contact">Contact Me</a></button>
        <button><a href="#projects">View Projects</a></button>
    </div>
  </div>
</header>

<!-- About Section -->
<section id="about" class="about-section">
    <h2>About Me</h2>
    <div class="container1">
        <div class="profile-photo">
            <?php
            $aboutContent = $db->manageAbout('read');
            if ($aboutContent->num_rows > 0) {
                while ($row = $aboutContent->fetch_assoc()) {
                    if (!empty($row['picture'])) {
                        echo "<img src='" . htmlspecialchars($row['picture']) . "' alt='About Picture'>";
                    }
                }
            }
            ?>
        </div>
        <div class="about-content">
            <?php
            $aboutContent = $db->manageAbout('read');
            if ($aboutContent->num_rows > 0) {
                while ($row = $aboutContent->fetch_assoc()) {
                    echo "<p>" . nl2br(htmlspecialchars($row['description'])) . "</p>";
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- Experience Section -->
<h2 class="experience-head" id="experience">Experience</h2>
<section class="experience-section">
    <?php
    $experienceContent = $db->manageExperience('read');
    if ($experienceContent->num_rows > 0) {
        while ($row = $experienceContent->fetch_assoc()) {
            echo "<div class='container'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<div>" . nl2br(htmlspecialchars($row['description'])) . "</div>";
            echo "</div>";
        }
    } else {
        echo "<div class='container'>";
        echo "<h3>No Experience Added Yet</h3>";
        echo "<p>Experience details will appear here.</p>";
        echo "</div>";
    }
    ?>
</section>

<!-- Projects Section -->
<div class="project-head" id="projects">
    <h2>Projects</h2>
</div>
<section class="projects-section">
    <div class="container1">
        <?php
        $projectContent = $db->manageProject('read');
        if ($projectContent->num_rows > 0) {
            while ($row = $projectContent->fetch_assoc()) {
                echo '<div class="project-photo">';
                echo '<div class="project-item">';
                
                // Check file type and display accordingly
                if (!empty($row['picture'])) {
                    $file_extension = pathinfo($row['picture'], PATHINFO_EXTENSION);
                    $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];
                    
                    if (in_array(strtolower($file_extension), $image_extensions)) {
                        // Display image
                        echo "<img src='" . htmlspecialchars($row['picture']) . "' alt='Project Image'>";
                    } else {
                        // Display file icon based on type
                        echo "<div class='file-icon'>";
                        if ($file_extension == 'pdf') {
                            echo "<img src='icons/pdf-icon.png' alt='PDF File'>";
                        } elseif (in_array($file_extension, ['doc', 'docx'])) {
                            echo "<img src='icons/doc-icon.png' alt='Document File'>";
                        } elseif ($file_extension == 'zip') {
                            echo "<img src='icons/zip-icon.png' alt='ZIP File'>";
                        } else {
                            echo "<img src='icons/file-icon.png' alt='File'>";
                        }
                        echo "</div>";
                    }
                }
                
                echo '<div class="ptoject-para">';
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                
                // If it's a downloadable file, show download link
                if (!empty($row['picture']) && !in_array(strtolower($file_extension), $image_extensions)) {
                    echo "<p>Download: <a href='" . htmlspecialchars($row['picture']) . "' download>". basename($row['picture']) ."</a></p>";
                }
                
                echo "<a href='" . htmlspecialchars($row['url_link']) . "' target='_blank'>View Project</a>";
                echo '</div>'; // Close ptoject-para
                echo '</div>'; // Close project-item
                echo '</div>'; // Close project-photo
            }
        } else {
            echo '<p class="no-projects">No projects added yet.</p>';
        }
        ?>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-section">
    <h2>Get In Touch</h2>
    <div class="contact-links">
        <?php
        $contactContent = $db->managecontact('read');
        if ($contactContent->num_rows > 0) {
            while ($row = $contactContent->fetch_assoc()) {
                echo "<a href='" . htmlspecialchars($row['url_link']) . "' target='_blank'>";
                if (!empty($row['picture'])) {
                    echo "<img src='" . htmlspecialchars($row['picture']) . "' alt='Contact Icon'>";
                }
                echo htmlspecialchars($row['title']);
                echo "</a>";
            }
        }
        ?>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <ul class="top-nav">
        <li><a href="#about">About</a></li>
        <li><a href="#experience">Experience</a></li>
        <li><a href="#projects">Projects</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
    <div>
        &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($heroContent->fetch_assoc()['title'] ?? 'Portfolio'); ?>. All rights reserved.
    </div>
</footer>

    <script src="home.js"></script>

</body>
</html>
