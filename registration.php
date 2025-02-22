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

if (!function_exists("GetSQLValueString")) {
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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO userdata (Id, username, password, fn, ln, mi, birthday, address, email, contact, usertype) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Id'], "int"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['fn'], "text"),
                       GetSQLValueString($_POST['ln'], "text"),
                       GetSQLValueString($_POST['mi'], "text"),
                       GetSQLValueString($_POST['birthday'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['contact'], "text"),
                       GetSQLValueString(0, "int"));
					   
  mysql_select_db($database_hach, $hach);
  $Result1 = mysql_query($insertSQL, $hach) or die(mysql_error());
  
    $_SESSION['MM_Username'] = $_POST['username'];
    $_SESSION['MM_UserGroup'] = 'default';

  $insertGoTo = "success.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="styles.css" rel="stylesheet" type="text/css" />
    <style>
        input {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #ff3b3b;
            box-shadow: 0 0 15px rgba(255, 59, 59, 0.2);
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        input[type="submit"] {
            background: linear-gradient(45deg, #ff3b3b, #ff5757);
            color: white;
            padding: 15px;
            border: none;
            border-radius: 50px;
            font-weight: 500;
            font-size: 16px;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 59, 59, 0.3);
        }

        .reg-error-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(12px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: fadeInReg 0.3s ease-out;
        }

        .reg-error-message {
            background: linear-gradient(145deg, rgba(255, 59, 59, 0.95), rgba(200, 30, 30, 0.95));
            padding: 2.5rem 4rem;
            border-radius: 20px;
            text-align: center;
            color: white;
            max-width: 800px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3),
                        0 0 0 1px rgba(255, 255, 255, 0.1);
            transform: translateY(0);
            animation: slideUpReg 0.4s ease-out;
        }

        .reg-error-message h2 {
            font-size: 28px;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .reg-error-message p {
            font-size: 18px;
            margin-bottom: 1.5rem;
            line-height: 1.6;
            opacity: 0.9;       
        }

        .reg-error-message a {
            display: inline-block;
            padding: 12px 32px;
            background: white;
            color: #ff3b3b;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .reg-error-message a:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.95);
        }

        .reg-error-buttons a{
            margin: 10px;
        }

        @keyframes fadeInReg {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUpReg {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reg-password-container {
            position: relative;
            width: 100%;

        }

        .reg-password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: rgba(255, 255, 255, 0.5);
            transition: color 0.3s ease;
        }

        .reg-password-toggle:hover {
            color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>

<body>
    <?php if(isset($_SESSION['MM_Username'])): ?>
    <div class="reg-error-overlay">
        <div class="reg-error-message">
            <h2 class="reg-error-message-header">Access Denied</h2>
            <p class="reg-error-message-par">You cannot create a new account while logged in.</p>
            <p class="reg-error-message-par">Please log out first if you want to register a new account.</p>
            <div class="reg-error-buttons">
                <a href="<?php echo $logoutAction ?>">Logout</a>
                <a href="mypage.php">Home</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="particles"></div>
    <div class="navbar">
        <div class="nav-links">
            <a href="about.php">About</a>
            <a href="gallery.php">Gallery</a>
            <a href="registration.php">Registration</a>
            <?php if(isset($_SESSION['MM_Username'])): ?>
                <a href="<?php echo $logoutAction ?>">Logout</a>
            <?php else: ?>
                <a href="index.php">Login</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="floating-blur blur-1"></div>
    <div class="floating-blur blur-2"></div>

    <div class="reg-container">
        <h2>Form</h2>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
            <div class="reg-input-container">
                <input type="text" name="username" placeholder="Username" required />
            </div>
            <div class="reg-input-container">
                <div class="reg-password-container">
                    <input type="password" name="password" placeholder="Password" id="password" required />
                    <i class="fas fa-eye reg-password-toggle" id="togglePassword"></i>
                </div>
            </div>
            <div class="reg-input-container">
                <input type="text" name="fn" placeholder="First Name" required />
            </div>
            <div class="reg-input-container">
                <input type="text" name="ln" placeholder="Last Name" required />
            </div>
            <div class="reg-input-container">
                <input type="text" name="mi" placeholder="Middle Initial" required />
            </div>
            <div class="reg-input-container">
                <input type="text" name="birthday" id="birthday" placeholder="MM/DD/YYYY" 
                        pattern="(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/\d{4}" 
                        title="Please enter a valid date in MM/DD/YYYY format" 
                        required 
                        oninput="formatBirthday(this)" 
                        maxlength="10" 
                    />
            </div>
            <div class="reg-input-container">
                <input type="text" name="address" placeholder="Address" required />
            </div>
            <div class="reg-input-container">
                <input type="email" name="email" placeholder="Email" required />
            </div>
            <div class="reg-input-container">
                <input type="text" name="contact" placeholder="Contact" required />
            </div>
            <!-- <div class="reg-input-container">
                <input type="text" name="usertype" placeholder="User Type" required />
            </div> -->
            <input type="hidden" name="MM_insert" value="form1" />
            <input type="submit" value="Register" />
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

        function formatBirthday(input) {
            let value = input.value.replace(/\D/g, '');
            let formatted = '';

            if (value.length > 4) {
                formatted = value.substring(0, 2) + '/' + value.substring(2, 4) + '/' + value.substring(4, 8);
            } else if (value.length > 2) {
                formatted = value.substring(0, 2) + '/' + value.substring(2, 4);
            } else {
                formatted = value;
            }
            input.value = formatted;
        }
        
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