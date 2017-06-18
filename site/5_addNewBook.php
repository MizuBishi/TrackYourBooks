<?php
define('MAGIC', 'unicorns');
include('includes/core_functions.php');
include('includes/html_templates.php');
printHeader('Add new Book.');
?>

<form action="5a_bookAdded.php" method="post">
    <div class="row spacer_big"></div>
    <div class="form-horizontal">
        <div class="form-group">
            <label for="inputText" class="col-sm-2 control-label">Title</label>

            <div class="col-sm-10">
                <input type="text" name="title" class="form-control" id="" value="" placeholder="Title">
            </div>
        </div>
        <div class="form-group">
            <label for="inputText" class="col-sm-2 control-label">Author</label>

            <div class="col-sm-10">
                <input type="text" name="author" class="form-control" id="" value="" placeholder="Author">
            </div>
        </div>
        <div class="form-group">
            <label for="inputText" class="col-sm-2 control-label">Year</label>

            <div class="col-sm-10">
                <input type="id" name="year" class="form-control" id="" value="" placeholder="Year">
            </div>
        </div>
        <div class="form-group">
            <label for="inputText" class="col-sm-2 control-label">Pages</label>

            <div class="col-sm-10">
                <input type="id" name="pages" class="form-control" id="" value="" placeholder="Number">
            </div>
        </div>
        <div class="row">
            <label for="inputText" class="col-sm-2 control-label">Genre</label>

            <div class="col-sm-10">
                <select name="genre" class="form-control">
                    <?php foreach(getAllGenres() as $genre): ?>
                    <option><?php echo $genre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row spacer"></div>

        <div class="row">
            <div class="col-sm-offset-2 col-sm-5">
                <button type="submit" class="btn btn-default">Save</button>
            </div>
        </div>
    </div>



</form>

<?php
printFooter();
?>
