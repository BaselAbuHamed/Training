<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['email'])) {
    header("Location: log_in.php");
    exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Quiz Maker</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../src/script.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../../src/style.css" type="text/css" />
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
    $success_message = json_decode(urldecode($_GET['success_message']), true);
    $status = $success_message['status'];
    $message = $success_message['message'];

    echo '<div class="success-message">';
    echo '<span class="closeBtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
    echo htmlspecialchars($message);
    echo '</div>';
}
?>

<?php include("../classes/side_nav.php"); ?>

<div class="quiz-form">
    <div class="tittle">
        <h1>Create a Quiz</h1>
    </div>
    <form id="quizForm" action="display_quiz.php" method="post">
        <div class="num_field">
            <input type="number" id="numQuestions" name="numQuestions" min="1" placeholder="Enter Number Of Question">
            <select class="where" name="where" id="fieldSelect">
                <option value="" selected>Choose a field</option>
                <option value="mathematics">Mathematics</option>
                <option value="physics">Physics</option>
                <option value="biology">Biology</option>
                <option value="chemistry">Chemistry</option>
                <option value="technology">Technology</option>
            </select>
        </div>
        <input type="submit" value="Create Quiz" />
    </form>
</div>
</body>
</html>