<?php
session_start();
if (!isset($_SESSION['email'])) {
    $_SESSION['loginMessage'] = "Please log in to access this page.";
    header("Location: ../app/Views/log_in.php");
    exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Quiz Maker</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../src/script.js" type="text/javascript"></script>
        <link rel="stylesheet" href="../src/style.css" type="text/css" />
    </head>
    <body>
        <?php include("../app/classes/header.php"); ?>
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
        <?php include("../app/classes/side_nav.php"); ?>

        <div class="container">
            <form method="post"
                action="../app/Controllers/cont_add_question.php"
                id="addQuestionForm"
                onsubmit="return validateForm()">
                <div>
                    <label for="question">Question:</label>
                    <input type="text" name="question" id="question"
                        placeholder="Enter the question text"
                        autocomplete="off" />
                    <span class="error" id="questionError"></span>
                </div>
                <div>
                    <label>Field:</label>
                    <select name="where" id="fieldSelect">
                        <option value selected>Choose a field</option>
                        <option value="mathematics">Mathematics</option>
                        <option value="physics">Physics</option>
                        <option value="biology">Biology</option>
                        <option value="chemistry">Chemistry</option>
                        <option value="technology">Technology</option>
                    </select>
                    <span class="error" id="fieldError"></span>
                </div>
                <div>
                    <label for="correctAnswer">Correct Answer:</label>
                    <input type="text" name="correctAnswer" id="correctAnswer"
                        placeholder="Enter the correct answer number"
                        autocomplete="off" />
                    <span class="error" id="correctAnswerError"></span>
                </div>
                <div class="choices" id="choices-container">
                    <label>Choices:</label>
                    <div class="choice-input" data-choice="1">
                        <span class="choice-number">1.</span>
                        <input type="text" name="choice[]" autocomplete="off" />
                        <span class="error" id="choice1Error"></span>
                    </div>
                    <div class="choice-input" data-choice="2">
                        <span class="choice-number">2.</span>
                        <input type="text" name="choice[]" autocomplete="off" />
                        <span class="error" id="choice2Error"></span>
                    </div>
                </div>
                <div class="controls">
                    <button class="add" data-action="add">Add Choice</button>
                    <button class="remove" data-action="remove">Remove Choice</button>
                </div>
                <div class="submit">
                    <input type="submit" value="Submit" />
                </div>
            </form>
            <div class="redirect-button">
                <a href="../app/Views/show_question.php">Show Questions</a>
            </div>
        </div>
    </body>
</html>