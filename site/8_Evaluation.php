<?php
define('MAGIC', 'unicorns');
include('includes/core_functions.php');
include('includes/html_templates.php');
printHeader('Evaluation.');


$currentBooks = getMyCurrentBooks();
$finishedBooks = getMyFinishedBooks();
$cancelledBooks = getMyCancelledBooks();

$numCurrentBooks = $currentBooks->num_rows;
$numFinishedBooks = $finishedBooks->num_rows;
$numCancelledBooks = $cancelledBooks->num_rows;
$numTotal = $numCurrentBooks + $numFinishedBooks + $numCancelledBooks;

$percentCurrentBooks = (int)(100 * $numCurrentBooks / $numTotal);
$percentFinishedBooks = (int)(100 * $numFinishedBooks / $numTotal);
$percentCancelledBooks = (int)(100 * $numCancelledBooks / $numTotal);

$startDate = "2000-00-00 00:00";
if (isset($_GET['startDate'])) {
    $startDate = $_GET['startDate'];
}
$stopDate = "3000-00-00 00:00";
if (isset($_GET['stopDate'])) {
    $stopDate = $_GET['stopDate'];
}

$pagesAndSeconds = mysqli_fetch_object(getPagesAndSeconds($startDate, $stopDate));

?>
<p>Get an Overview of your Reading Behaviour.</p>

<script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker({
                    format: "YYYY-MM-DD HH:mm",
                });
                $('#datetimepicker2').datetimepicker({
                    format: "YYYY-MM-DD HH:mm",
                });
                $("#datetimepicker1").on("dp.change", function (e) {
                    $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
                });
                $("#datetimepicker2").on("dp.change", function (e) {
                    $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
                });

                var stateData = [
                    {
                        value: <?php echo $numFinishedBooks; ?>,
                        color:"#AEC1AB",
                        highlight: "#AEC1AB",
                        label: "Finished"
                    },
                    {
                        value: <?php echo $numCancelledBooks; ?>,
                        color: "#EFBDBC",
                        highlight: "#EFBDBC",
                        label: "Cancelled"
                    },
                    {
                        value: <?php echo $numCurrentBooks; ?>,
                        color: "#A5828C",
                        highlight: "#A5828C",
                        label: "Current"
                    }
                ];

                var genreData = [
                    <?php $i = 0; ?>
                    <?php $colors = array('#A5828C', '#AEC1AB', '#F1ECD4', '#D7D5C2', '#F2C9C3', '#F2A4B2', '#A5828C', '#AEC1AB', '#F1ECD4', '#EFBDBC'); ?>
                    <?php $genresForUser = getGenresForUser(); ?>
                    <?php #while($row = mysqli_fetch_object($genresForUser)): ?>
                    <?php while($row = mysqli_fetch_assoc($genresForUser)): ?>
                    {
                        value: <?php echo $row['count']; ?>,
                        color:"<?php echo $colors[$i]; ?>",
                        highlight: "<?php echo $colors[$i]; ?>",
                        label: "<?php echo $row['genre']; ?>"
                        <?php $i = ($i + 1) % count($colors); ?>
                    },
                    <?php endwhile; ?>
                ];

                var options = {
                    //Boolean - Show a backdrop to the scale label
                    scaleShowLabelBackdrop : true,

                    //String - The colour of the label backdrop
                    scaleBackdropColor : "rgba(255,255,255,0.75)",

                    // Boolean - Whether the scale should begin at zero
                    scaleBeginAtZero : true,

                    //Number - The backdrop padding above & below the label in pixels
                    scaleBackdropPaddingY : 2,

                    //Number - The backdrop padding to the side of the label in pixels
                    scaleBackdropPaddingX : 2,

                    //Boolean - Show line for each value in the scale
                    scaleShowLine : false,

                    //Boolean - Stroke a line around each segment in the chart
                    segmentShowStroke : false,

                    //String - The colour of the stroke on each segement.
                    segmentStrokeColor : "#fff",

                    //Number - The width of the stroke value in pixels
                    segmentStrokeWidth : 2,

                    //Number - Amount of animation steps
                    animationSteps : 50,

                    //String - Animation easing effect.
                    animationEasing : "easeInOutQuad",

                    //Boolean - Whether to animate the rotation of the chart
                    animateRotate : true,

                    //Boolean - Whether to animate scaling the chart from the centre
                    animateScale : false,

                    //String - A legend template
                    legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"

                };
                $("#leftDoughnut").height($("#leftDoughnut").width())
                $("#rightDoughnut").height($("#rightDoughnut").width())
                var ctx1 = $("#leftDoughnut").get(0).getContext("2d");
                var ctx2 = $("#rightDoughnut").get(0).getContext("2d");
                new Chart(ctx1).Doughnut(stateData, options);
                new Chart(ctx2).Doughnut(genreData, options);
            });
        </script>



<div class="row">
    <div class="col-xs-6">
        <h3>State</h3>
        <canvas id="leftDoughnut" style="width:100%"></canvas>
    </div>
    <div class="col-xs-6">
        <h3>Genres</h3>
        <canvas id="rightDoughnut" style="width:100%"></canvas>
    </div>
</div>


<div class="row spacer"></div>


<div class="bs-example">
    <form>
        <div class="row spacer"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <label>from:</label>

                <div class="form-group">
                    <div class="input-group date" id="datetimepicker1">
                        <input type="text" class="form-control" name="startDate"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <label>to:</label>

                <div class="form-group">
                    <div class="input-group date" id="datetimepicker2">
                        <input type="text" class="form-control" name="stopDate"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <input type="submit" class="btn" value="Filter by date"/>
            </div>
        </div>
    </form>
</div>

<div class="row spacer"></div>
<div class="row spacer"></div>

<?php if ($pagesAndSeconds->pages): ?>

<div class="row">
    <div class="col-xs-12">
        <div class="form-group">

            <table id="example" class="table table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Pages</th>
                    <th>Time</th>
                    <th>Reading Speed</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $pagesAndSeconds->pages; ?></td>
                    <td><script type="text/javascript">document.write(formatSeconds(<?php echo $pagesAndSeconds->seconds; ?>));</script></td>
                    <td><?php echo round($pagesAndSeconds->pages / ($pagesAndSeconds->seconds/3600)); ?> pages/h</td>
                </tr>
                </tbody>
            </table>

        </div>

    </div>
</div>

<?php else: ?>
    <?php showMessage("No data available for specified range"); ?>
<?php endif; ?>



<?php
printFooter();
?>
