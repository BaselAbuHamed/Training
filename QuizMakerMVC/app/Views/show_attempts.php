<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Controllers/cont_show_attempts.php';

// Check if the user is logged in (you can implement your own authentication logic)
if (!isset($_SESSION['email'])) {
    $_SESSION['loginMessage'] = "Please log in to access this page.";
    header("Location: log_in.php");
    exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Previous Quiz Attempts</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../src/script.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../../src/style.css" type="text/css" />
</head>
<body>
<?php include("../classes/header.php"); ?>
<?php
if (isset($_SESSION['user_type']) && $_SESSION['user_type']!="student") {
    include("../classes/side_nav.php");
}
?>

<div class="container_previousAttempts">
    <div class="tittle">
        <h1>Quiz Attempts Details</h1>
    </div>
        <?php printAttempts($_GET['id']) ?>
    <div class="back">
        <?php
        echo '<a id="backTo" href="./previous_attempts.php?quiz_id=' . htmlspecialchars($_GET['quiz_id']) . '">back</a>';
        ?>
    </div>
</div>
</body>
</html>
