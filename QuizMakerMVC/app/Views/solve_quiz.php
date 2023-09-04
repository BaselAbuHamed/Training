<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../classes/connect.php';
require_once '../Controllers/cont_solve_quiz.php';

$pdo = db_connect();
if (!isset($_SESSION['email'])) {
    header("Location: log_in.php");
    exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Show Question</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../../src/style.css" type="text/css" />
    <script src="../../src/script.js" type="text/javascript"></script>

</head>
<body>
<?php include("../classes/header.php"); ?>
<?php
if (isset($_GET['error_message'])) {
    $error_message = json_decode(urldecode($_GET['error_message']), true);
    $status = $error_message['status'];
    $message = $error_message['message'];
    echo '<div class="error-message" id="hidden">';
    echo '<span class="closeBtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
    echo htmlspecialchars($message);
    echo '</div>';
}
?>
<?php
if (isset($_GET['success_message'])) {
    $success_message = json_decode(urldecode($_GET['error_message']), true);
    $status = $success_message['status'];
    $message = $success_message['message'];
    echo '<div class="success_message" id="hidden">';
    echo '<span class="closeBtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
    echo htmlspecialchars($message);
    echo '</div>';
}
?>
<?php include("../classes/side_nav.php"); ?>

    <?php
    if (isset($_GET['quiz_id'])) {
        $quiz_id = $_GET['quiz_id'];
        quiz($quiz_id);
    }
    ?>
</body>
</html>
