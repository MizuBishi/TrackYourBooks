<?php
define('MAGIC', 'unicorns');
include('includes/html_templates.php');
printHeader('Track it, evaluate it!', false, false);
?>
<form action="1a_loginaction.php" method="POST" class="class form-horizontal">
    <p class="big">Track your Books.</p>

    <?php
    if (isset($_GET["error"]) && $_GET["error"] === "mismatch") {
        showError("User do not match");
    } else if (isset($_GET["error"]) && $_GET["error"] === "missing") {
        showError("Invalid request");
    } else if (isset($_GET["error"]) && $_GET["error"] === "login") {
        showMessage("You need to log in");
    } else if (isset($_GET["message"]) && $_GET["message"] === "logout") {
        showSuccess("You are successfully logout");
    }
    ?>

    <div class="row spacer_big"></div>
    <form>
        <div class="form-group">

            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

            <div class="col-sm-8">
                <input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

            <div class="col-sm-8">
                <input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-5">
                <button type="submit" class="btn btn-default">Sign in</button>
            </div>
        </div>

    </form>

    <?php
    printFooter();
    ?>
