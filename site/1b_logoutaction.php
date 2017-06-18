<?php

define('MAGIC', 'unicorns');
include('includes/core_functions.php');

logout();
header("Location: 1_login.php?message=logout");
