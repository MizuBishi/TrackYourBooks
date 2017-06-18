<?php

define('MAGIC', 'unicorns');
include('includes/core_functions.php');

checkLogin();

$title  = $_POST["title"];
$author = $_POST["author"];
$year   = $_POST["year"];
$pages  = $_POST["pages"];
$genre  = $_POST["genre"];
$query  = "
  INSERT INTO Books (title, author, year, pages, genre)
  VALUES ('$title', '$author', '$year', '$pages', '$genre')
";

if (mysqli_query($con, $query) === TRUE) {
  header("Location: 4_chooseABook.php");
} else {
  header("Location: 4_chooseABook.php?error=cannotAdd");
}
