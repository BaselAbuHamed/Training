<?php
session_start();

if (isset($_POST['addChoice'])) {
    if (!isset($_SESSION['choiceCount'])) {
        $_SESSION['choiceCount'] = 2;
    } else {
        $_SESSION['choiceCount']++;
    }
} elseif (isset($_POST['removeChoice'])) {
    if (isset($_SESSION['choiceCount']) && $_SESSION['choiceCount'] > 2) {
        $_SESSION['choiceCount']--;
    }
}
function generateChoices() {
    if (isset($_SESSION['choiceCount'])) {
        for ($i = 1; $i <= $_SESSION['choiceCount']; $i++) {
            echo '<div class="choice-input">';
            echo '<span class="choice-number">' . $i . '.</span>';
            echo '<input type="text" name="choice[]" autocomplete="off"/>';
            echo '<span class="error"></span>';
            echo '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Quiz Maker</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/script.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/style.css" type="text/css"/>
</head>
<body>
<?php include("classes/header.php"); ?>
<div class="container">
    <form method="post" id="addQuestionForm" onsubmit="return validateForm()">
        <div>
            <label for="question">Question:</label>
            <input type="text" name="question" id="question" placeholder="Enter the question text"
                   autocomplete="off" />
            <span class="error" id="questionError"></span>
        </div>
        <div>
            <label for="correctAnswer">Correct Answer:</label>
            <input type="text" name="correctAnswer" id="correctAnswer" placeholder="Enter the correct answer number"
                   autocomplete="off" />
            <span class="error" id="correctAnswerError"></span>
        </div>
        <div>
            <label>Field:</label>
            <select name="where" id="fieldSelect">
                <option value="" selected>Choose a field</option>
                <option value="mathematics">Mathematics</option>
                <option value="physics">Physics</option>
                <option value="biology">Biology</option>
                <option value="chemistry">Chemistry</option>
                <option value="technology">Technology</option>
            </select>
            <span class="error" id="fieldError"></span>
        </div>
        <div class="choices" id="choices-container">
            <label>Choices:</label>
            <label>Choices:</label>
            <?php generateChoices(); ?>
        </div>
        <div class="controls">
            <button class="add" name="addChoice">Add Choice</button>
            <button class="remove" name="removeChoice">Remove Choice</button>
        </div>
        <div class="submit">
            <button id="submitButton" class="submit" onclick="submitForm()">Submit</button>
        </div>
    </form>
    <div class="redirect-button">
        <a href="show_question.php">Show Questions</a>
    </div>
</div>
</body>
</html>

<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--    <title>Dynamic Choices</title>-->
<!--</head>-->
<!--<body>-->
<!--<form method="post">-->
<!--    <div class="choices" id="choices-container">-->
<!--        <label>Choices:</label>-->
<!--        --><?php //generateChoices(); ?>
<!--    </div>-->
<!--    <div class="controls">-->
<!--        <button class="add" name="addChoice">Add Choice</button>-->
<!--    </div>-->
<!--    <input type="submit" name="submitForm" value="Submit">-->
<!--</form>-->
<!--</body>-->
<!--</html>-->