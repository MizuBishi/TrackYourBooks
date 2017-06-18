<?php
define('MAGIC', 'unicorns');
include('includes/core_functions.php');
include('includes/html_templates.php');
printHeader('Choose a Book.');

if (isset($_GET["error"]) && $_GET["error"] === "cannotAdd") {
  showError('Cannot add book to database.');
}
?>

<script type="text/javascript">
    $(function() {
        $('#add-new').click(function() {
            location.href = '5_addNewBook.php';
        });
        $('#search').click(function() {
            filterTable($('#filter').val());
        });
        $('#filter').keypress(function(e) {
            if (e.which == 13) {
                filterTable($('#filter').val());
            }
        });
        $('#filter').keyup(function(e) {
            filterTable($('#filter').val());
        });
    });
</script>


<p>Choose an existing book or add a new one.</p>
<div class="bs-example">
  <table id="example" class="table table-bordered" cellspacing="0" width="100%">
      <div class="row">
          <div class="col-md-12">
              <div id="custom-search-input">
                  <input type="text" class="form-control" placeholder="Search" id="filter"/>
            <span class="input-group-btn">

            </span>
              </div>

          </div>
      </div>
      <div class="row spacer"></div>

      <div class="button">
          <button class="btn btn-default" type="button" id="add-new">Add new Book</button>
      </div>
    <div class="row spacer"></div>
    <thead>
    <tr class="tblHeader">
        <th>Title &amp; Author</th>
        <th>Year</th>
      </tr>
    </thead>
    <tbody>
      <?php $books = getAllOtherBooks(); ?>
      <?php while ($book = mysqli_fetch_object($books)): ?>
      <tr>
        <td>
          <a href="4a_bookChosen.php?bookid=<?php echo $book->id; ?>">
            <?php echo $book->title; ?>,
            <?php echo $book->author; ?>
          </a>
        </td>
        <td>
          <?php echo $book->year; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php
printFooter();
?>
