<?php
define('MAGIC', 'unicorns');
include('includes/core_functions.php');
include('includes/html_templates.php');
printHeader('Finish this Book.');

$bookid = $_GET["bookid"];
$book = mysqli_fetch_object(getBook($bookid));

?>

<?php renderBookTitle($book); ?>

<div class="row spacer"></div>

<form action="6b_doFinishBook.php" method="post">
    <label>Note</label>
    <textarea name="comment" class="form-control" rows="3" placeholder="Too boring? Why you do not want to finish this book?"></textarea>
    <input type=hidden name=bookid value=<?php echo $bookid; ?>>
    <div class="row spacer"></div>
    <div class="form-group">
            <button type="submit" class="btn btn-default">Save</button>
    </div>
</form>

<?php
printFooter();
?>


