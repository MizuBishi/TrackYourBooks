<?php
define('MAGIC', 'unicorns');
include('includes/core_functions.php');

$userid = getUser();
$bookid = $_POST["bookid"];
$started = $_POST["started"];
$stopped = $_POST["stopped"];
$pages = $_POST["pages"];
$remainingPages = getBookRemainingPages($bookid);

$exceeded = false;
if ($pages > $remainingPages) {
    $exceeded = true;
    $pages = $remainingPages;
}

$query  = "
  INSERT INTO sessions (users_id, books_id, start, stop, pages)
  VALUES ($userid, $bookid, FROM_UNIXTIME($started), FROM_UNIXTIME($stopped), $pages)
";

if (mysqli_query($con, $query) === TRUE) {
    if ($exceeded) {
        header("Location: 6_DetailReading.php?bookid=$bookid&maxPages=$remainingPages");
    } else {
        header("Location: 6_DetailReading.php?bookid=$bookid");
    }
} else {
  header("Location: 6_DetailReading.php?bookid=$bookid&error=cannotAdd");
}
