<?php
define('MAGIC', 'unicorns');
include('includes/core_functions.php');

$userid = getUser();
$bookid = $_POST["bookid"];
$comment = $_POST["comment"];

$userid = getUser();
$query  = "
  UPDATE users_books SET finished=NOW(),comment='$comment'
  WHERE users_id=$userid AND books_id=$bookid;
";

if (mysqli_query($con, $query) === TRUE) {
  header("Location: 3_landingpage.php?bookid=$bookid");
} else {
  header("Location: 3_landingpage.php?bookid=$bookid&error=cannotFinish");
}
