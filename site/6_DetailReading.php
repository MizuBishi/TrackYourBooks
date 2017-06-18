<?php
define('MAGIC', 'unicorns');
include('includes/core_functions.php');
include('includes/html_templates.php');
printHeader('Detail Reading.');

$bookid = $_GET["bookid"];
$book = mysqli_fetch_object(getBook($bookid));
$myBook = mysqli_fetch_object(getMyBook($bookid));
$bookReadPages = getBookReadPages($bookid);
$sessions = getSessionsForBook($bookid);

$pagesPercent = (int) (100*$bookReadPages/$book->pages);

if (isset($_GET["error"]) && $_GET["error"] === "cannotAdd") {
    showError('Cannot add book to database.');
}
if (isset($_GET["maxPages"])) {
    $maxPages = $_GET["maxPages"];
    showMessage("Cannot read more pages than $maxPages.");
}
?>

<script type="text/javascript">
$(function() {
  $('#start-book').click(function() {
    location.href = '7_TrackReading.php?bookid=' + <?php echo $bookid; ?>;
  });
  $('#finish-book').click(function() {
    location.href = '6a_FinishBook.php?bookid=' + <?php echo $bookid; ?>;
  });
});
</script>

<?php renderBookTitle($book); ?>
<div class="row spacer"></div>

<div class="row">
  <div class="col-lg-8">
    <div class="progress">
      <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
           style="width: <?php echo $pagesPercent; ?>%; min-width:2em;">
        <p><?php echo $pagesPercent; ?>%</p>
      </div>
    </div>
  </div>
</div>
<div class="row spacer"></div>



<?php if ($myBook->finished !== NULL) { ?>
    <h4>Cancelled book because:</h4>
    <p><?php echo $myBook->comment; ?></p>
<?php } else if ($bookReadPages < $book->pages) { ?>
  <div class="button">
    <button class="btn btn-default" type="button" id="start-book">Start Reading</button>
  </div>
<?php } ?>





<div class="row spacer"></div>

<div class="bs-example">
  <label>History</Label>
  <table id="example" class="table table-bordered" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Pages</th>
      </tr>
      <tbody>
        <?php while($session = mysqli_fetch_object($sessions)): ?>
          <tr>
            <td>
              <?php echo substr($session->start, 0, 10); ?>
            </td>
            <td>
              <?php echo substr($session->start, 11, 5).'-'.substr($session->stop, 11, 5); ?>
            </td>
            <td>
              <?php echo $session->pages; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php if ($myBook->finished === NULL && $bookReadPages < $book->pages) { ?>

        <div class="button">
          <button class="btn btn-default" type="button" id="finish-book">Finish this Book</button>
        </div>
    <?php } ?>

  </div>
  <?php
  printFooter();
  ?>
