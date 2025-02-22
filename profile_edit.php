<?php require_once('Connections/hach.php'); ?>
<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, private");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

if (!isset($_SESSION['MM_Username'])) {
    header("Location: error.php");
    exit;
}

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
<?php
if (!isset($_SESSION['MM_Username'])) {
    header("Location: error.php");
    exit;
}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
    if (PHP_VERSION < 6) {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
    }

    $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

    switch ($theType) {
        case "text":
            $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;    
        case "long":
        case "int":
            $theValue = ($theValue != "") ? intval($theValue) : "NULL";
            break;
        case "double":
            $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
            break;
        case "date":
            $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;
        case "defined":
            $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
            break;
    }
    return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// Handle form submission
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $updateSQL = sprintf("UPDATE userdata SET 
        username=%s, 
        password=%s, 
        fn=%s, 
        mi=%s, 
        ln=%s, 
        birthday=%s, 
        contact=%s, 
        address=%s, 
        email=%s, 
        usertype=%s 
        WHERE Id=%s",
        GetSQLValueString($_POST['username'], "text"),
        GetSQLValueString($_POST['password'], "text"),
        GetSQLValueString($_POST['fn'], "text"),
        GetSQLValueString($_POST['mi'], "text"),
        GetSQLValueString($_POST['ln'], "text"),
        GetSQLValueString($_POST['birthday'], "text"),
        GetSQLValueString($_POST['contact'], "text"),
        GetSQLValueString($_POST['address'], "text"),
        GetSQLValueString($_POST['email'], "text"),
        GetSQLValueString($_POST['usertype'], "int"),
        GetSQLValueString($_POST['Id'], "int"));

    mysql_select_db($database_hach, $hach);
    $Result1 = mysql_query($updateSQL, $hach) or die(mysql_error());

    header("Location: mypage.php");
    exit;
}

// Get user data
mysql_select_db($database_hach, $hach);
$query_user = sprintf("SELECT * FROM userdata WHERE username = %s", 
    GetSQLValueString($_SESSION['MM_Username'], "text"));
$result_user = mysql_query($query_user, $hach) or die(mysql_error());
$row_user = mysql_fetch_assoc($result_user);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="styles.css" rel="stylesheet" type="text/css" />
    <style>
        form {
            display: grid;
            gap: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;

            width: 120px;
        }

        .input-group {
            position: relative;
            width: 100%;

            display: flex;
            align-items: center;
            gap: 10px;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #ff3b3b;
        }

        input[type="password"] {
            line-height: 1;
        }

        input[readonly] {
            background: rgba(255, 255, 255, 0.02);
            cursor: not-allowed;
            opacity: 0.7;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #ff3b3b;
            box-shadow: 0 0 15px rgba(255, 59, 59, 0.2);
        }

        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, #ff3b3b, #ff5757);
            border: none;
            border-radius: 50px;
            color: white;
            font-size: 16px;
            font-weight: 500;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 59, 59, 0.3);
        }
    </style>
</head>

<body>
    <div class="particles"></div>
    <div class="floating-blur blur-1"></div>
    <div class="floating-blur blur-2"></div>

    <div class="navbar">
        <div class="nav-links">
            <a href="mypage.php">Home</a>
            <a href="gallery.php">Gallery</a>
            <a href="about.php">About</a>
            <a href="<?php echo $logoutAction ?>">Logout</a>
        </div>
    </div>

    <div class="edit-container">
        <h2>Edit Your Profile</h2>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
            <input type="hidden" name="Id" value="<?php echo $row_user['Id']; ?>" />
            <input type="hidden" name="MM_update" value="form1" />

            <div class="input-group">
                <label for="username">Username</label>
                <input name="username" type="text"
                    value="<?php echo htmlentities($row_user['username'], ENT_COMPAT, 'utf-8'); ?>" id="username" 
                    readonly />
            </div>

            <div class="input-group">
                <label for="password" class="password">Password</label>
                <input type="password" name="password"
                    value="<?php echo htmlentities($row_user['password'], ENT_COMPAT, 'utf-8'); ?>" id="password" />
                <i class="fas fa-eye password-toggle" id="togglePassword"></i>
            </div>

            <div class="input-group">
                <label for="fn">First Name</label>
                <input type="text" name="fn" value="<?php echo htmlentities($row_user['fn'], ENT_COMPAT, 'utf-8'); ?>"
                    id="fn" />
            </div>

            <div class="input-group">
                <label for="mi">Middle Initial</label>
                <input type="text" name="mi" value="<?php echo htmlentities($row_user['mi'], ENT_COMPAT, 'utf-8'); ?>"
                    id="mi" />
            </div>

            <div class="input-group">
                <label for="ln">Last Name</label>
                <input type="text" name="ln" value="<?php echo htmlentities($row_user['ln'], ENT_COMPAT, 'utf-8'); ?>"
                    id="ln" />
            </div>

            <div class="input-group">
                <label for="birthday">Birthday</label>
                <input type="text" name="birthday"
                    value="<?php echo htmlentities($row_user['birthday'], ENT_COMPAT, 'utf-8'); ?>" id="birthday" />
            </div>

            <div class="input-group">
                <label for="contact">Contact</label>
                <input type="text" name="contact"
                    value="<?php echo htmlentities($row_user['contact'], ENT_COMPAT, 'utf-8'); ?>" id="contact" />
            </div>

            <div class="input-group">
                <label for="address">Address</label>
                <input type="text" name="address"
                    value="<?php echo htmlentities($row_user['address'], ENT_COMPAT, 'utf-8'); ?>" id="address" />
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" name="email"
                    value="<?php echo htmlentities($row_user['email'], ENT_COMPAT, 'utf-8'); ?>" id="email" />
            </div>

            <div class="input-group">
                <label for="usertype">Usertype</label>
                <input type="text" name="usertype"
                    value="<?php echo htmlentities($row_user['usertype'], ENT_COMPAT, 'utf-8'); ?>" id="usertype"
                    readonly />
            </div>

            <input type="submit" value="Update Profile" />
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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

        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
<?php mysql_free_result($result_user); ?>