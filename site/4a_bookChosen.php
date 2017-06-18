<?php

define('MAGIC', 'unicorns');
include('includes/core_functions.php');

checkLogin();

$userid = getUser();
$bookid = $_GET["bookid"];
$query = "
  INSERT INTO users_books (users_id, books_id, added)
  VALUES ($userid, $bookid, NOW());
";

if (mysqli_query($con, $query) === TRUE) {
  header("Location: 3_landingpage.php");
} else {
  header("Location: 3_landingpage.php?error=cannotChoose");
}
