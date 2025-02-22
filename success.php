<?php
session_start();
if(!isset($_SESSION['MM_Username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['MM_Username'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Registration Successful</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="success.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="confetti"></div>
    
<div class="navbar">
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="gallery.php">Gallery</a>
            <a href="about.php">About</a>
            <a href="logout.php">Logout</a>
    </div>
    </div>

    <div class="container">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="success-message">
            Congratulations, <?php echo htmlspecialchars($username); ?>!! <br /> Your registration was successful.
        </div>
        <a href="mypage.php" class="button">Go to Dashboard</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confettiContainer = document.querySelector('.confetti');
            const colors = ['#2ecc71', '#27ae60', '#2980b9', '#3498db'];
            
            for (let i = 0; i < 100; i++) {
                const piece = document.createElement('div');
                piece.classList.add('confetti-piece');
                piece.style.left = Math.random() * 100 + 'vw';
                piece.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                piece.style.animationDelay = Math.random() * 5 + 's';
                piece.style.width = (Math.random() * 10 + 5) + 'px';
                piece.style.height = (Math.random() * 10 + 5) + 'px';
                confettiContainer.appendChild(piece);
            }
        });
    </script>
</body>
</html><?php
session_start();
if(!isset($_SESSION['MM_Username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['MM_Username'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Registration Successful</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="success.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="confetti"></div>
    
<div class="navbar">
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="gallery.php">Gallery</a>
            <a href="about.php">About</a>
            <a href="logout.php">Logout</a>
    </div>
    </div>

    <div class="container">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="success-message">
            Congratulations, <?php echo htmlspecialchars($username); ?>!! <br /> Your registration was successful.
        </div>
        <a href="mypage.php" class="button">Go to Dashboard</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confettiContainer = document.querySelector('.confetti');
            const colors = ['#2ecc71', '#27ae60', '#2980b9', '#3498db'];
            
            for (let i = 0; i < 100; i++) {
                const piece = document.createElement('div');
                piece.classList.add('confetti-piece');
                piece.style.left = Math.random() * 100 + 'vw';
                piece.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                piece.style.animationDelay = Math.random() * 5 + 's';
                piece.style.width = (Math.random() * 10 + 5) + 'px';
                piece.style.height = (Math.random() * 10 + 5) + 'px';
                confettiContainer.appendChild(piece);
            }
        });
    </script>
</body>
</html>