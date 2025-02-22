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
    <title>Gallery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    <div class="gallery-container">
        <div class="img-container">
            <img src="Genshin-Impact-Raiden-Shogun-ascension-talent-level-up-materials.png" alt="Raiden Shogun"
                class="gallery-image">
            <div class="img-overlay">
                <div class="text-container">
                    <h3 class="img-title">Raiden Shogun</h3>
                    <p class="img-description">The Electro Archon of Inazuma</p>
                </div>
            </div>
        </div>
        <div class="img-container">
            <img src="1fea453339bfacd9685407b8ea28d48e_8163987363370130800.jpg" alt="Raiden" class="gallery-image">
            <div class="img-overlay">
                <div class="text-container">
                    <h3 class="img-title">Raiden Ei</h3>
                    <p class="img-description">The true form of the Electro Archon</p>
                </div>
            </div>
        </div>
        <div class="img-container">
            <img src="deq6rs3-8af9d71d-f1ef-4723-9ef8-72561e511f79.png" alt="Shogun" class="gallery-image">
            <div class="img-overlay">
                <div class="text-container">
                    <h3 class="img-title">The Shogun</h3>
                    <p class="img-description">The puppet created by Ei</p>
                </div>
            </div>
        </div>
        <div class="img-container">
            <img src="fe040a7d28184bab091c74cb59ce62d8.jpg" alt="mommy" class="gallery-image">
            <div class="img-overlay">
                <div class="text-container">
                    <h3 class="img-title">Musou no Hitotachi</h3>
                    <p class="img-description">The ultimate technique</p>
                </div>
            </div>
        </div>
    </div>
    <script>

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