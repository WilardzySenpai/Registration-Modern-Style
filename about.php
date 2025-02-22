<?php require_once('Connections/hach.php'); ?>
<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, private");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
    $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
    $_SESSION['MM_Username'] = NULL;
    $_SESSION['MM_UserGroup'] = NULL;
    $_SESSION['PrevUrl'] = NULL;
    unset($_SESSION['MM_Username']);
    unset($_SESSION['MM_UserGroup']);
    unset($_SESSION['PrevUrl']);
    
    $logoutGoTo = "index.php";
    if ($logoutGoTo) {
        header("Location: $logoutGoTo");
        exit;
    }
}
?>

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>About</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="navbar">
        <div class="nav-links">
            <a href="about.php">About</a>
            <a href="gallery.php">Gallery</a>
            <?php if(isset($_SESSION['MM_Username'])): ?>
                <a href="mypage.php">Home</a>
            <?php else: ?>
                <a href="registration.php">Registration</a>
            <?php endif; ?>
            <?php if(isset($_SESSION['MM_Username'])): ?>
                <a href="<?php echo $logoutAction ?>">Logout</a>
            <?php else: ?>
                <a href="index.php">Login</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="floating-blur blur-1"></div>
    <div class="floating-blur blur-2"></div>

    <div class="about-container">
        <div class="about-content">
            <p class="about-header">About Our Project</p>
            <p>Welcome to our Programming Project Website! This website is developed as part of our Grade 12 M. Dell TVL ICT curriculum at Batasan Hills National High School. Our goal is to apply our skills in web development, database management, and user authentication by creating a fully functional system with login, registration, profile editing, and data handling.
            Through this project, we aim to enhance our understanding of front-end and back-end development, improve our problem-solving abilities, and prepare ourselves for real-world IT applications.
            Developed by:
            Willard Paluga (Hachiki) and Team</p>
            <br>
            <p class="quote">With self-discipline most anything is possible.</p>
            <p class="author">- Theodore Roosevelt</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const particlesContainer = document.querySelector('.particles');
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + 'vw';
                particle.style.animationDelay = Math.random() * 4 + 's';
                particle.style.opacity = Math.random();
                particlesContainer.appendChild(particle);
            }
        });

        window.addEventListener('beforeunload', function (e) {
            if (hasUnsavedChanges) {
                e.preventDefault();
                e.returnValue = '';
            } else {
                fetch('logout.php', {
                    method: 'POST',
                    credentials: 'same-origin'
                });
            }
        });

        window.addEventListener('unload', function () {
            navigator.sendBeacon('logout.php');
        });
    </script>
</body>

</html>