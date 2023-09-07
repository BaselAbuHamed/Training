<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Controllers/cont_view_question.php';


if (!isset($_SESSION['email'])) {
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
    <?php include("../classes/side_nav.php"); ?>

    <div class="container-show">
            <input type="hidden" name="questionID" value="<?php echo getQuestionID(); ?>" />
        <label for="question">Question:</label>
        <div class="Question">
                <label id="Q"><?php echo htmlspecialchars(getDetails()['question']); ?></label>
            </div>
        <label id="choice" for="choices">Choices:</label>
        <div class="choices" id="choices-container">
                <?php foreach (getChoices() as $index => $choice) : ?>
                    <div class="choice-input" data-choice=<?php echo $index+1?>>
                            <input type="radio" name="choice[]" value="<?php echo $choice ?>" />
                            <span class="Q"><?php echo $choice ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <div class="controls">
            <?php
            echo '<a id="updateQuestion" href="./edit_question.php?questionID=' .  getQuestionID() . '">Edit</a>';
            echo '<button class="deleteQuestion" onclick="deleteQuestion(' . getQuestionID() . ',\'' . getDetails()['field'] . '\')">Delete</button>';
            ?>
        </div>
            <div class="back">
                <?php echo '<a id="backTo" href="./show_question.php#' . getDetails()['field'] . '">back</a>'; ?>
            </div>
    </div>
</body>
</html>