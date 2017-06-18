<?php
define('MAGIC', 'unicorns');
include('includes/core_functions.php');
include('includes/html_templates.php');
printHeader('Track Reading.');

$bookid = $_GET["bookid"];
$book = mysqli_fetch_object(getBook($bookid));
?>

<script type="text/javascript">
    var intervalId;
    $(function () {
        var started = getSeconds();
        $('#stop-reading').click(function () {
            $('#stop-reading').hide();
            clearInterval(intervalId);
            $('#finishSession').show();
            $('[name=started]').val(started);
            $('[name=stopped]').val(getSeconds());
            $('[name=bookid]').val(<?php echo $bookid; ?>);
        });
        function updateTimer() {
            var delta = getSeconds() - started;
            $('#runningTime').text(formatSeconds(delta));
        }

        intervalId = setInterval(updateTimer, 1000);
        updateTimer();
    });
</script>




<div class="row">
    <div class="col-xs-12">
        <?php renderBookTitle($book); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <span class="timer" id="runningTime"></span>
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <button id="stop-reading" type="submit" class="btn btn-default">Stop</button>
    </div>
</div>


<form method="post" action="7a_addSession.php"  id="finishSession" style="display:none">
    <input type=hidden name=started>
    <input type=hidden name=stopped>
    <input type=hidden name=bookid>

    <div class="row">
        <div class="col-xs-12">
            Number of pages:
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <input name="pages" class="form-control" name="pages" id="finishSession" placeholder="Pages">
        </div>
    </div>
    <div class="row spacer"></div>
    <div class="row">
        <div class="col-xs-12">
            <button id="stop-reading" type="submit" class="btn btn-default">Submit</button>
        </div>
    </div>

</form>

<?php
printFooter();
?>
