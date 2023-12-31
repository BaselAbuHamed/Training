<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Quiz Maker</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js" type="text/javascript"></script>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
    <?php include("classes/header.php"); ?>

    <div class="container">
        <noscript>
            <div class="error-message">
                <?php
                if (isset($_GET['error_message'])) {
                    echo htmlspecialchars($_GET['error_message']);
                }
                ?>
            </div>
            <div class="success-message">
                <?php
                if (isset($_GET['success_message'])) {
                    echo htmlspecialchars($_GET['success_message']);
                }
                ?>
            </div>
        </noscript>
        <form method="post" action="add_question.php" id="addQuestionForm"  onsubmit="return validateForm()">
            <div>
                <label for="question">Question:</label>
                <input type="text" name="question" id="question" placeholder="Enter the question text"
                    autocomplete="off" />
                <span class="error" id="questionError"></span>
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
            <div>
                <label for="correctAnswer">Correct Answer:</label>
                <input type="text" name="correctAnswer" id="correctAnswer" placeholder="Enter the correct answer number"
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
                <button id="submitButton" class="submit" >Submit</button>
            </div>
        </form>
        <div class="redirect-button">
            <a href="show_question.php">Show Questions</a>
        </div>
    </div>
</body>
</html>