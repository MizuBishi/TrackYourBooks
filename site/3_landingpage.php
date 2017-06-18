<?php
define('MAGIC', 'unicorns');
include('includes/core_functions.php');
include('includes/html_templates.php');
checkLogin();
printHeader('My Books.', false, true);

if (isset($_GET["error"]) && $_GET["error"] === "cannotChoose") {
    showError('Cannot add book to database.');
}
?>


<script type="text/javascript">
    $(function () {
        $('#add-new').click(function () {
            location.href = '4_chooseABook.php';
        });
        $('#show-eval').click(function () {
            location.href = '8_Evaluation.php';
        });
        $('#search').click(function () {
            filterTable($('#filter').val());
        });
        $('#filter').keypress(function (e) {
            if (e.which == 13) {
                filterTable($('#filter').val());
            }
        });
        $('#filter').keyup(function (e) {
            filterTable($('#filter').val());
        });
    });
</script>
<div class="row spacer_big"></div>
<div class="row">
    <div class="col-md-12">
        <input type="text" class="form-control" placeholder="Search" id="filter"/>
    </div>
</div>

<div class="row spacer"></div>
<div class="button">
    <button class="btn btn-default" type="button" id="add-new">Add Book</button>
    <button class="btn btn-default" type="button" id="show-eval">
        <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
        Show Evaluation
    </button>
</div>
<div class="row spacer"></div>
<div class="bs-example">
    <table id="example" class="table table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr class="tblHeader">
            <th>Title &amp; Author</th>
            <th>Year</th>
            <th>Pages</th>
        </tr>
        </thead>
        <tbody>

        <?php $books = getMyCurrentBooks(); ?>
        <?php while ($book = mysqli_fetch_object($books)): ?>
            <tr>
                <td>
                    <a href="6_DetailReading.php?bookid=<?php echo $book->id; ?>">
                        <b><?php echo $book->title; ?></b>,
                        <?php echo $book->author; ?>
                    </a>
                </td>
                <td>
                    <?php echo $book->year; ?>
                </td>
                <td>
                    <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>

                    <?php echo $book->pagesRead . '/' . $book->pagesTotal; ?>
                </td>
            </tr>
        <?php endwhile; ?>

        <?php $books = getMyFinishedBooks(); ?>
        <?php while ($book = mysqli_fetch_object($books)): ?>
            <tr>
                <td>
                    <a href="6_DetailReading.php?bookid=<?php echo $book->id; ?>">
                        <b><?php echo $book->title; ?></b>,
                        <?php echo $book->author; ?>
                    </a>
                </td>
                <td>

                    <?php echo $book->year; ?>
                </td>
                <td>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    <?php echo $book->pagesRead . '/' . $book->pagesTotal; ?>

                </td>
            </tr>
        <?php endwhile; ?>

        <?php $books = getMyCancelledBooks(); ?>
        <?php while ($book = mysqli_fetch_object($books)): ?>
            <tr>

            <td>
                    <a href="6_DetailReading.php?bookid=<?php echo $book->id; ?>">
                        <b><?php echo $book->title; ?></b>,
                        <?php echo $book->author; ?>
                    </a>
                </td>
                <td>
                    <?php echo $book->year; ?>
                </td>
                <td>
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>

                    cancelled
                </td>
            </tr>
        <?php endwhile; ?>

        </tbody>
    </table>
</div>

<?php printFooter(); ?>
