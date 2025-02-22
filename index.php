<?php require_once('Connections/hach.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

        switch ($theType) {
            case "text":
                $theValue = $theValue != "" ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = $theValue != "" ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = $theValue != "" ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue = $theValue != "" ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = $theValue != "" ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
}
?>
<?php
if (!isset($_SESSION)) {
    session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
    $loginUsername = $_POST['username'];
    $password = $_POST['password'];
    $MM_fldUserAuthorization = "";
    $MM_redirectLoginSuccess = "mypage.php";
    $MM_redirectLoginFailed = "error.php";
    $MM_redirecttoReferrer = false;
    mysql_select_db($database_hach, $hach);

    $LoginRS__query = sprintf("SELECT username, password FROM userdata WHERE username=%s AND password=%s", GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));

    ($LoginRS = mysql_query($LoginRS__query, $hach)) or die(mysql_error());
    $loginFoundUser = mysql_num_rows($LoginRS);
    if ($loginFoundUser) {
        $loginStrGroup = "";

        if (PHP_VERSION >= 5.1) {
            session_regenerate_id(true);
        } else {
            session_regenerate_id();
        }
        $_SESSION['MM_Username'] = $loginUsername;
        $_SESSION['MM_UserGroup'] = $loginStrGroup;

        if (isset($_SESSION['PrevUrl']) && false) {
            $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
        }
        header("Location: " . $MM_redirectLoginSuccess);
    } else {
        header("Location: " . $MM_redirectLoginFailed);
    }
}
?>

<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="particles"></div>
    <div class="navbar">
        <div class="nav-links">
            <a href="about.php">About</a>
            <a href="gallery.php">Gallery</a>
            <a href="registration.php">Registration</a>
            <a href="index.php">Login</a>
        </div>
    </div>

    <div class="floating-blur blur-1"></div>
    <div class="floating-blur blur-2"></div>

    <div class="login-container">
        <h2>Login</h2>
        <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
            <div class="login-input-group">
                <input type="text" name="username" id="username" placeholder="Username" required>
                <span class="login-input-icon"><i class="fas fa-user"></i></span>
            </div>
            <div class="login-input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="login-input-icon"><i class="fas fa-lock"></i></span>
            </div>
            <input type="submit" class="login-button" name="button" id="button" value="Login">
        </form>
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
    </script>
</body>
</html>