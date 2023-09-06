<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email'])) {
    $_SESSION['loginMessage'] = "Please log in to access this page.";
    header("Location: log_in.php");
    exit();
}
if (isset($_SESSION['user_type'])&&$_SESSION['user_type']=="student") {
    header("Location: /Internship/QuizMakerMVC/app/Views/show_quizzes.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Quiz Questions and Correct Answers</title>
    <script
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet"
          href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="../../src/script.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../../src/style.css" type="text/css" />
</head>
<body>
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
    $success_message = json_decode(urldecode($_GET['success_message']), true);
    $status = $success_message['status'];
    $message = $success_message['message'];

    echo '<div class="success-message">';
    echo '<span class="closeBtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
    echo htmlspecialchars($message);
    echo '</div>';
}
?>

<?php include("../classes/header.php"); ?>

<?php include("../classes/side_nav.php"); ?>

<div class="create-quiz-container">
    <a href="/Internship/QuizMakerMVC/app/Views/create_quiz_random.php" id="create_user" >Create Quiz by random question</a>
    <a href="/Internship/QuizMakerMVC/app/Views/create_quiz_by_user.php" id="create_random">Create Quiz by user select</a>
</div>
</body>
</html>