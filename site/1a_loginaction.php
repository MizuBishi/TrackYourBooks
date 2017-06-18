
<?php

define('MAGIC', 'unicorns');
include('includes/core_functions.php');


if(!isset($_POST["email"]) || !isset($_POST["password"]))  {
  header("Location: 1_login.php?error=missing");
  exit();
}

$email = $_POST["email"];
$password = $_POST["password"];

$query = "SELECT id, username, email, password FROM Users WHERE email = '$email'";

$res = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($res);
if ($row === NULL) {
  header("Location: 1_login.php?error=mismatch");
} else if ($row["password"] !== $password) {
  header("Location: 1_login.php?error=mismatch");
} else {
  //successfull login
  //save user insesssion
  login($row["id"]);
  header("Location: 3_landingpage.php");
}

/* assoc gibt ein assoziatives Array zurück
*/
?>
