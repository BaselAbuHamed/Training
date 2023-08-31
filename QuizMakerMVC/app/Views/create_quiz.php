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
<?php include("../classes/side_nav.php"); ?>

<div class="quiz-form">
    <div class="title">
        <h1>Create a Quiz</h1>
    </div>
    <form id="quizForm" method="post" >
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
            <span class="error" id="fieldError"></span>
        </div>
        <input type="submit" value="Create Quiz" onsubmit="generateQuiz()" />
    </form>
</div>
<div id="questionsContainer"></div>
</body>
</html>