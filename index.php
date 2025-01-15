<?php
require_once 'connection/db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>
    <link rel="stylesheet" href="home.css">
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
    <!-- <img src="me.jpeg" alt="Afomiya Mesfin"> -->
    <?php
    $heroContent = $db->managehero('read');
    if ($heroContent->num_rows > 0) {
        while ($row = $heroContent->fetch_assoc()) {
            echo "<img src='" . htmlspecialchars($row['picture']) . "' alt='hero Picture'>";
    
        }
    }
    ?>
  </div>
  <div class="header-content">
    <!-- <h1>Hello, I'm <span style="color: #3b6d91;">A</span>fomiya Mesfin</h1>
    <p>Web Designer</p> -->
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
        <button><a href="#contact">contact info</a></button>
      </div>
  </div>
 
</header>

<section id="about" class="about-section">
<h2>About Me</h2>
<?php
    $aboutContent = $db->manageAbout('read');
    if ($aboutContent->num_rows > 0) {
        while ($row = $aboutContent->fetch_assoc()) {
            echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
    
        }
    }
    ?>
    <div class="container1">
        <div class="profile-photo">
            <!-- <img src="me2.jpg"  class="profile-photo">  -->
            <?php
    $aboutContent = $db->manageAbout('read');
    if ($aboutContent->num_rows > 0) {
        while ($row= $aboutContent->fetch_assoc()) {
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
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
           
        }
    }
    ?>
    </div>

    </div>
</section>

<!-- Experience Section -->
<h2 class="experience-head"  id="experience">Experience</h2>
<section id="experience" class="experience-section">
<div class="container">
        <!-- <h3>frontend development</h3>
        <p><span>HTML</span>: intermediate</p>
        <p><span>CSS</span>: intermediate</p>
        <p><span>JavaScript</span>: basic</p> -->
        <?php
    $experienceContent = $db->manageExperience('read');
    if ($experienceContent->num_rows > 0) {
        while ($row = $experienceContent->fetch_assoc()) {
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
           
        }
    }
    ?>  
      
    </div>
    <!-- <div class="container"> -->
        <!-- <h3>Backend development</h3>
        <p><span>PHP</span>: basic</p>
        <p><span>C#</span>: basic</p> -->
        <!-- <?php
    $experienceContent = $db->manageExperience('read');
    if ($experienceContent->num_rows > 0) {
        while ($row = $experienceContent->fetch_assoc()) {
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
           
        }
    }
    ?>
    </div> -->
   
</section>

<!-- Projects Section -->
<div class="project-head" id="projects"> <h2>Projects</h2></div>
<section id="projects" class="projects-section">
     
<div class="container1">
        <div class="project-photo">
            <!-- <img src="mind.avif">  
            <div class="ptoject-para"><h4>Mindful Moments</h4><p>Will provide the website link soon.</p></div> -->
            <?php
    $projectContent = $db->manageProject('read');
    if ($projectContent->num_rows > 0) {
        while ($row = $projectContent->fetch_assoc()) {
           
            if (!empty($row['picture'])) {
                echo "<img src='" . htmlspecialchars($row['picture']) . "' alt='Project Picture'>";
                
            }
            
        }
    }
    ?>
     <div class="ptoject-para">
              <?php
    $projectContent = $db->manageProject('read');
    if ($projectContent->num_rows > 0) {
        while ($row = $projectContent->fetch_assoc()) {
           
              echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<a href='" . htmlspecialchars($row['url_link']) . "' target='_blank'>View Project</a>";
           
        }
    }
    ?></div>
        </div>
        
    </div>
   
     
</section>
<section id="contact" class="contact-section">
    <h2>Contact Me</h2>
    <div class="contact-links">
        <!-- <a href="mailto:afomiyamesfin@gmail.com">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z"/></svg>
            afomiyamesfin@gmail.com
        </a>

        <a href="https://www.linkedinmobileapp.com/\?trk\=qrcode-onboarding" target="_parent">
            <img src="linkedin.png">
            LinkedIn 
        </a> -->
        <?php
    $contactContent = $db->managecontact('read');
    if ($contactContent->num_rows > 0) {
        while ($row = $contactContent->fetch_assoc()) {
           
              echo "<a href='" . htmlspecialchars($row['url_link']) . "' target='_blank'> <img src='" . htmlspecialchars($row['picture']) . "' alt='Project Picture'><p>" . htmlspecialchars($row['title']) . "</p>
              </a>";
           
           
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
</footer>
<div class="footer">
    &copy; 2024 Afomiya Mesfin. All rights reserved.
</div>

    <script src="home.js"></script>

</body>
</html>