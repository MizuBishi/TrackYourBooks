<?php

defined('MAGIC') || die('you cannot access this file directly.');

function printHeader($title, $show_home = TRUE, $show_logout = FALSE, $show_stats = FALSE)
{
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <script src="js/jquery-1.11.3.min.js"></script>

        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="bootstrap/js/ie-emulation-modes-warning.js"></script>

        <script src="components/datetimepicker/moment.js"></script>
        <script src="components/datetimepicker/transition.js"></script>
        <script src="components/datetimepicker/collapse.js"></script>
        <script src="components/datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <link href="components/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
        <script src="js/chartjs.js"></script>

        <script src="js/core_functions.js"></script>

        <title><?php echo $title ?></title>

        <!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">

    </head>
    <body>
    <div class="container">

    <div class="pull-right">
        <div class="row spacer"></div>

        <?php if ($show_home): ?>
            <a href="3_landingpage.php">
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
            </a>
        <?php endif; ?>

        <?php if ($show_stats): ?>
            <a href="8_Evaluation.php">
                <span class="glyphicon glyphicon-signal" aria-hidden="true"></span>
            </a>
        <?php endif; ?>

        <?php if ($show_logout): ?>
            <a href="1b_logoutaction.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        <?php endif; ?>
    </div>

    <h1><?php echo $title ?></h1>
<?php
}


function printFooter()
{
    ?>
    </div>
    </body>
    </html>
<?php
}

function renderBookTitle($book)
{
    echo "<h4>$book->title by $book->author, $book->year</h4>";
}

function showMessage($message)
{
    echo "<div class=\"alert alert-info\" role=\"alert\">$message</div>";
}

function showError($message)
{
    echo "<div class=\"alert alert-danger\" role=\"alert\">
<span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span><span class=\"sr-only\">Fehler:</span> $message</div>";
}

function showSuccess($message)
{
    echo "<div class=\"alert alert-success\" role=\"alert\">
<span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span><span class=\"sr-only\">Fehler:</span> $message</div>";
}

//neu hinzugefügt für die Meldung wenn mehr Seiten als maximale Seiten eingegeben wurden
function errorPages($message)
{
    echo "<div class=\"alert alert-danger\" role=\"alert\">
<span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span><span class=\"sr-only\">Fehler:</span> $message</div>";
}