<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Controllers/cont_edit_question.php';
require_once '../classes/error_log.php';

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
        <title>Edit Question</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
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

        <div class="container-edit">
            <div class="tittle">
                <h1>Edit Question</h1>
            </div>
            <form action="../Controllers/cont_update_question.php" id="updateQuestionForm" method="post" onsubmit="updateForm()">

                    <label for="question">Question:</label>
                    <input type="hidden" name="questionID" value="<?php echo getQuestionID(); ?>" />

                <div>
                    <input type="text" name="question" id="question" value="<?php echo htmlspecialchars(getDetails()['question']); ?>" />
                    <span class="error" id="questionError"></span>
                </div>
                <div>
                    <label for="correctAnswer">Correct Answer:</label>
                    <input type="text" name="correctAnswer" id="<?php echo htmlspecialchars(getDetails()['correctAnswer']);?>" value="<?php echo getCorrectAnswerIndex() !== null ? getCorrectAnswerIndex()+1 : ''; ?>" />
                    <span class="error" id="correctAnswerError"></span>
                </div>
                <div>
                    <label for="field">Field:</label>
                    <select name="field" id="field" required>
                        <option value="mathematics" <?php if
                        (htmlspecialchars(getDetails()['field']) ===
                            'mathematics') echo 'selected'; ?>>Mathematics</option>
                        <option value="physics" <?php if
                        (htmlspecialchars(getDetails()['field']) === 'physics')
                            echo 'selected'; ?>>Physics</option>
                        <option value="biology" <?php if
                        (htmlspecialchars(getDetails()['field']) === 'biology')
                            echo 'selected'; ?>>Biology</option>
                        <option value="chemistry" <?php if
                        (htmlspecialchars(getDetails()['field']) === 'chemistry')
                            echo 'selected'; ?>>Chemistry</option>
                        <option value="technology" <?php if
                        (htmlspecialchars(getDetails()['field']) ===
                            'technology') echo 'selected'; ?>>Technology</option>
                    </select>
                </div>
                <div>
                    <label>Choices:</label>
                    <div class="choices" id="choices-container">
                        <?php foreach (getChoices() as $index => $choice) : ?>
                            <?php $answerID = getAnsID($choice); ?>
                            <div class="choice-input" data-choice=<?php echo $index+1?>>
                                <label><?php echo $index + 1; ?>.</label>
                                <input type="text" id="<?php echo $answerID; ?>"
                                       name="choice[<?php echo $answerID; ?>]"
                                       value="<?php echo htmlspecialchars($choice); ?>" />
                                <span class="error"></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>



                <div class="controls">
                    <button class="add" data-action="add">Add Choice</button>
                    <button class="remove" data-action="remove">Remove Choice</button>
                </div>
                <input type="hidden" name="hiddenData" id="hiddenData" />
                <div class="submit">
                    <input type="submit" value="Update" />
                </div>
            </form>
            <div class="back">
                <?php
                echo '<a id="backTo" href="./show_question.php#' . getDetails()['field'] . '">back</a>';
                ?>
            </div>
        </div>
    </body>
</html>