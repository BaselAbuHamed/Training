<?php
include_once '../Controllers/cont_view_question.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Show Question</title>
    <link rel="stylesheet" href="../../src/style.css" type="text/css" />
</head>
<body>
    <?php include("../classes/header.php"); ?>
    <div class="container-show">
        <form action="#" id="updateQuestionForm" method="post">
            <input type="hidden" name="questionID" value="<?php echo getQuestionID(); ?>" />
            <label for="question">Question:</label>
            <label class="Q"><?php echo htmlspecialchars(getDetails()['question']); ?></label>
            <label id="choice" for="choices">Choices:</label>
            <div class="choices" id="choices-container">
                <?php foreach (getChoices() as $index => $choice) : ?>
                    <div class="choice-input" data-choice=<?php echo $index+1?>>
                        <label>
                            <input type="radio" name="choice[]" value="<?php echo $choice ?>" />
                            <span class="Q"><?php echo $choice ?></span><br>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="back">
                <a id="backTo" href="show_question.php">back</a>
            </div>
        </form>
    </div>
</body>
</html>