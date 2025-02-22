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

$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
  $isValid = false;

  if (!empty($UserName)) {
      $arrUsers = explode(",", $strUsers);
      $arrGroups = explode(",", $strGroups);

      if (in_array($UserName, $arrUsers)) {
          $isValid = true;
      }
      if (in_array($UserGroup, $arrGroups)) {
          $isValid = true;
      }
      if (($strUsers == "") && true) {
          $isValid = true;
      }
  }
  return $isValid;
}

$MM_restrictGoTo = "error.php";

// echo "<pre>";
// var_dump($MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup']);
// echo "</pre>";

if (!(isset($_SESSION['MM_Username']) && isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup']))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
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

$currentPage = $_SERVER["PHP_SELF"];

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

$colname_u = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_u = $_SESSION['MM_Username'];
}
mysql_select_db($database_hach, $hach);
$query_u = sprintf("SELECT * FROM userdata WHERE Username = %s", GetSQLValueString($colname_u, "text"));
$u = mysql_query($query_u, $hach) or die(mysql_error());
$row_u = mysql_fetch_assoc($u);
$totalRows_u = mysql_num_rows($u);

$maxRows_Search = 1;
$pageNum_Search = 0;
if (isset($_GET['pageNum_Search'])) {
  $pageNum_Search = $_GET['pageNum_Search'];
}
$startRow_Search = $pageNum_Search * $maxRows_Search;

$colname_Search = "1";
if (isset($_GET['Search'])) {
  $colname_Search = $_GET['Search'];
}
mysql_select_db($database_hach, $hach);
$query_Search = sprintf("SELECT * FROM userdata WHERE Username LIKE %s or Username  LIKE %s or Fn LIKE %s or Mi LIKE %s or Ln LIKE %s or Birthday LIKE %s or Contact LIKE %s or Address LIKE %s or Email LIKE %s or Usertype LIKE %s", GetSQLValueString("%" . $colname_Search . "%", "text"),GetSQLValueString("%" . $colname_Search . "%", "text"),GetSQLValueString("%" . $colname_Search . "%", "text"),GetSQLValueString("%" . $colname_Search . "%", "text"),GetSQLValueString("%" . $colname_Search . "%", "text"),GetSQLValueString("%" . $colname_Search . "%", "text"),GetSQLValueString("%" . $colname_Search . "%", "text"),GetSQLValueString("%" . $colname_Search . "%", "text"),GetSQLValueString("%" . $colname_Search . "%", "text"),GetSQLValueString("%" . $colname_Search . "%", "text"));
$query_limit_Search = sprintf("%s LIMIT %d, %d", $query_Search, $startRow_Search, $maxRows_Search);
$Search = mysql_query($query_limit_Search, $hach) or die(mysql_error());
$row_Search = mysql_fetch_assoc($Search);

if (isset($_GET['totalRows_Search'])) {
  $totalRows_Search = $_GET['totalRows_Search'];
} else {
  $all_Search = mysql_query($query_Search);
  $totalRows_Search = mysql_num_rows($all_Search);
}
$totalPages_Search = ceil($totalRows_Search/$maxRows_Search)-1;

$colname_A = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_A = $_SESSION['MM_Username'];
}
mysql_select_db($database_hach, $hach);
$query_A = sprintf("SELECT * FROM userdata WHERE Username = %s", GetSQLValueString($colname_A, "text"));
$A = mysql_query($query_A, $hach) or die(mysql_error());
$row_A = mysql_fetch_assoc($A);
$totalRows_A = mysql_num_rows($A);

$queryString_Search = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Search") == false && 
        stristr($param, "totalRows_Search") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Search = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Search = sprintf("&totalRows_Search=%d%s", $totalRows_Search, $queryString_Search);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="particles"></div>
    <div class="floating-blur blur-1"></div>
    <div class="floating-blur blur-2"></div>

    <div class="mypage-container">
        <h1>Welcome, <?php echo htmlspecialchars($row_u['username']); ?></h1>
        <div class="navbar" style="border-radius: 10px;">
          <div class="nav-links">
            <a href="profile_edit.php?id=<?php echo $row_u['Id']; ?>">Edit Profile</a>
            <a href="gallery.php">Gallery</a>
            <a href="about.php">About</a>
            <a href="<?php echo $logoutAction ?>">Log out</a>
          </div>
        </div>
        <div class="profile-info">
            <table>
                <tr><td><strong>Name:</strong></td><td><?php echo htmlspecialchars($row_u['fn']) . ' ' . htmlspecialchars($row_u['mi']) . ' ' . htmlspecialchars($row_u['ln']); ?></td></tr>
                <tr><td><strong>Email:</strong></td><td><?php echo htmlspecialchars($row_u['email']); ?></td></tr>
                <tr><td><strong>Contact:</strong></td><td><?php echo htmlspecialchars($row_u['contact']); ?></td></tr>
                <tr><td><strong>Address:</strong></td><td><?php echo htmlspecialchars($row_u['address']); ?></td></tr>
            </table>
        </div>
        <div class="search-section">
            <form action="" method="get">
                <div class="search-container">
                    <input type="text" name="Search" class="search-input" placeholder="Search...">
                    <button type="submit" class="search-btn">Search</button>
                </div>
            </form>
        </div>
        <table>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Middle Initial</th>
                <th>Last Name</th>
                <th>Birthday</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Email</th>
                <th>User Type</th>
            </tr>
            <?php do { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row_Search['Id']); ?></td>
                    <td><?php echo htmlspecialchars($row_Search['fn']); ?></td>
                    <td><?php echo htmlspecialchars($row_Search['mi']); ?></td>
                    <td><?php echo htmlspecialchars($row_Search['ln']); ?></td>
                    <td><?php echo htmlspecialchars($row_Search['birthday']); ?></td>
                    <td><?php echo htmlspecialchars($row_Search['contact']); ?></td>
                    <td><?php echo htmlspecialchars($row_Search['address']); ?></td>
                    <td><?php echo htmlspecialchars($row_Search['email']); ?></td>
                    <td><?php echo htmlspecialchars($row_Search['usertype']); ?></td>
                </tr>
            <?php } while ($row_Search = mysql_fetch_assoc($Search)); ?>
        </table>
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
<?php
mysql_free_result($u);

mysql_free_result($Search);

mysql_free_result($A);
?>
