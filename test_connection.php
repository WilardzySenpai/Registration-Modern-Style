<?php
$hostname_hach = "sql210.infinityfree.com"; // Your database hostname
$database_hach = "if0_38263092_hach"; // Your database name
$username_hach = "if0_38263092"; // Your database username
$password_hach = "hachwampi"; // Hosting account password

$hach = mysql_pconnect($hostname_hach, $username_hach, $password_hach) or trigger_error(mysql_error(),E_USER_ERROR);

// Check connection
if (!$hach) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>