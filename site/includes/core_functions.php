<?php
session_start();
defined('MAGIC') || die('you cannot access this file directly.');

$con  = openMysqlConnection();

function openMysqlConnection() {

  $con = mysqli_connect("127.0.0.1", "trackit", "trackit", "Trackit") or die("Error" . mysqli_error($con));
  mysqli_set_charset($con, 'utf8');
  return $con;
}

function getAllOtherBooks() {
  global $con;

  $userid = getUser();
  $query = "
    SELECT id, title, author, year, pages FROM books
    WHERE id NOT IN (
      SELECT books_id FROM users_books WHERE users_id=$userid
    )
  ";
  $result = mysqli_query($con, $query);

  return $result;
}

function getMyCurrentBooks() {
  global $con;

  $userid = getUser();
  $query = "
  SELECT * FROM (
    SELECT
      COALESCE(MAX(s.start), NOW()) AS started,
      coalesce(SUM(s.pages), 0) AS pagesRead,
      b.author AS author, b.title AS title, b.year AS year, b.pages as pagesTotal, b.id as id,
      ub.finished AS finished
    FROM users_books AS ub
    INNER JOIN books AS b ON b.id = ub.books_id
    LEFT JOIN sessions AS s USING(users_id,books_id)
    WHERE ub.finished IS NULL AND ub.users_id=$userid
    GROUP BY author, title, year, pagesTotal, finished
  ) AS x WHERE pagesRead<pagesTotal
  ORDER BY started DESC, author  ";

  $result = mysqli_query($con, $query);

  return $result;
}

function getMyFinishedBooks() {
  global $con;

  $userid = getUser();
  $query = "
  SELECT * FROM (
    SELECT
      SUM(s.pages) AS pagesRead,
      b.author AS author, b.title AS title, b.year AS year, b.pages as pagesTotal, b.id as id,
      ub.finished AS finished
    FROM sessions AS s
    INNER JOIN books AS b ON b.id = s.books_id
    INNER JOIN users_books AS ub USING(users_id,books_id)
    WHERE ub.finished IS NULL AND s.users_id=$userid
    GROUP BY author, title, year, pagesTotal, finished
  ) AS x WHERE pagesRead>=pagesTotal
  ";

  $result = mysqli_query($con, $query);

  return $result;
}

function getMyCancelledBooks() {
  global $con;

  $userid = getUser();
  $query = "
    SELECT
      SUM(s.pages) AS pagesRead, #s.pages AS pages,
      b.author AS author, b.title AS title, b.year AS year, b.pages as pagesTotal, b.id as id,
      ub.finished AS finished
    FROM sessions AS s
    INNER JOIN books AS b ON b.id = s.books_id
    INNER JOIN users_books AS ub USING(users_id,books_id)
    WHERE s.users_id=$userid AND ub.finished IS NOT NULL
    GROUP BY author, title, year, pagesTotal, finished
  ";

  $result = mysqli_query($con, $query);

  return $result;
}

function getAllMyBooks() {
  global $con;

  $query = "
    SELECT b.id AS id, b.author AS author, b.title AS title, b.year AS year, ub.added AS added
    FROM users_books AS ub
    INNER JOIN books AS b ON b.id = ub.books_id
    WHERE ub.users_id=".getUser()."
    ORDER BY added DESC
  ";

  $result = mysqli_query($con, $query);

  return $result;
}

function getBook($bookid) {
  global $con;

  $query = "
    SELECT id, title, author, year, pages
    FROM books WHERE id=$bookid
  ";
  $result = mysqli_query($con, $query);

  return $result;
}

function getMyBook($bookid) {
  global $con;

  $userid = getUser();
  $query = "SELECT finished, comment FROM users_books WHERE users_id=$userid AND books_id=$bookid";
  return mysqli_query($con, $query);
}

function getBookReadPages($bookid) {
  global $con;

  $userid = getUser();
  $query = "SELECT SUM(pages) as pagesRead FROM sessions WHERE users_id=$userid AND books_id=$bookid";
  $result = mysqli_query($con, $query);

  return (int) mysqli_fetch_object($result)->pagesRead;
}

function getBookRemainingPages($bookid) {
    global $con;

    $userid = getUser();
    $query = "
        SELECT b.pages - coalesce(sum(s.pages),0) AS remainingPages
        FROM sessions AS s
        JOIN books AS b on s.books_id = b.id
        WHERE s.users_id=$userid and s.books_id=$bookid
    ";
    $result = mysqli_query($con, $query);

    return (int) mysqli_fetch_object($result)->remainingPages;
}

function getSessionsForBook($bookid) {
  global $con;

  $userid = getUser();
  $query = "SELECT start, stop, pages FROM sessions WHERE users_id=$userid AND books_id=$bookid";

  $result = mysqli_query($con, $query);

  return $result;
}


function getAllGenres() {
    return array(
        'Novel',
        'Classic',
        'New Publication',
        'Nonfiction Book',
        'Crime',
        'Erotica',
        'Art',
        'Comic'
    );
}

function getGenresForUser() {
    global $con;

    $userid = getUser();
    $query = "
        SELECT b.genre as genre, count(*) as count
        FROM users_books AS ub
        INNER JOIN books AS b ON b.id = ub.books_id
        WHERE ub.users_id=$userid
        GROUP BY b.genre
    ";

    $result = mysqli_query($con, $query);

    return $result;
}

function getPagesAndSeconds($start, $stop) {
    global $con;

    $userid = getUser();
    $query = "
        SELECT sum(UNIX_TIMESTAMP(stop) - UNIX_TIMESTAMP(start)) AS seconds, sum(pages) AS pages
        FROM sessions
        WHERE users_id=$userid
         AND start >= '$start'
         AND stop  <= '$stop'
    ";

    $result = mysqli_query($con, $query);

    return $result;
}

function login($id) {
  $_SESSION['trackit_userid']=$id;
}

function getUser() {
  return $_SESSION['trackit_userid'];
}

function checkLogin() {
  if (!isset($_SESSION["trackit_userid"])) {
    header("Location: 1_login.php?error=login");

  }
}

function logout() {
  unset ($_SESSION['trackit_userid']);
}

?>
