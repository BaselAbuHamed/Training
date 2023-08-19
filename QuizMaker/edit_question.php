<?php
include 'classes/connect.php';
$pdo = db_connect();

$questionDetails = array();
$choices = array();

if (isset($_GET['questionID'])) {
    $questionID = $_GET['questionID'];

    //call function and save return value in variables
    $questionDetails = getQuestionDetails($pdo, $questionID);
    $choices = getQuestionChoices($pdo, $questionID);
    $correctAnswerIndex = getCorrectAnswerIndex($pdo, $questionID, $questionDetails['correctAnswer']);
}

//to get question details
function getQuestionDetails($pdo, $questionID) {
    $sql = "SELECT question, correctAnswer, field FROM question WHERE questionID = :questionID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//to get question choices
function getQuestionChoices($pdo, $questionID) {
    $sql = "SELECT answer FROM answers WHERE questionID = :questionID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->execute();

    $choices = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $choices[] = $row['answer'];
    }

    return $choices;
}

//to get choice id from answers table
function getAnswerID($pdo, $questionID, $choiceText) {
    $sql = "SELECT answerID FROM answers WHERE questionID = :questionID AND answer = :choiceText";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->bindParam(':choiceText', $choiceText, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false && isset($result['answerID'])) {
        return (int)$result['answerID'];
    }

    return -1; // Default value if not found or empty result
}
//get index for correct answer from array of choices
function getCorrectAnswerIndex($pdo, $questionID, $correctAnswerID) {
    $correctAnswerValue = getCorrectAnswerValue($pdo, $questionID, $correctAnswerID);
    $choices = getQuestionChoices($pdo, $questionID);

    return array_search($correctAnswerValue, $choices);
}

//get answer
function getCorrectAnswerValue($pdo, $questionID, $correctAnswerID) {
    $sql = "SELECT answer FROM answers WHERE questionID = :questionID AND answerID = :answerID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->bindParam(':answerID', $correctAnswerID, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['answer'];
    }

    return null;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Edit Question</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="script.js" type="text/javascript"></script>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<?php include("classes/header.php"); ?>
<div class="container-edit">
    <h1>Edit Question</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?questionID=" . $questionID); ?>" id="updateQuestionForm" method="post">
        <input type="hidden" name="questionID" value="<?php echo $questionID; ?>" />
        <label for="question">Question:</label>
        <input type="text" name="question" id="question" value="<?php echo htmlspecialchars($questionDetails['question']); ?>" />
        <span class="error" id="questionError"></span>
        <label for="correctAnswer">Correct Answer:</label>
        <input type="text" name="correctAnswer" id="<?php echo $questionDetails['correctAnswer'] ?>"
               value="<?php echo $correctAnswerIndex !== null ? $correctAnswerIndex+1 : ''; ?>"/>
        <span class="error" id="correctAnswerError"></span>
        <label for="field">Field:</label>
        <select name="field" id="field" required>
            <option value="mathematics" <?php if ($questionDetails['field'] === 'mathematics') echo 'selected'; ?>>Mathematics</option>
            <option value="physics" <?php if ($questionDetails['field'] === 'physics') echo 'selected'; ?>>Physics</option>
            <option value="biology" <?php if ($questionDetails['field'] === 'biology') echo 'selected'; ?>>Biology</option>
            <option value="chemistry" <?php if ($questionDetails['field'] === 'chemistry') echo 'selected'; ?>>Chemistry</option>
            <option value="technology" <?php if ($questionDetails['field'] === 'technology') echo 'selected'; ?>>Technology</option>
        </select>
        <label>Choices:</label>
        <div class="choices" id="choices-container">
        <?php foreach ($choices as $index => $choice) : ?>
            <?php $answerID = getAnswerID($pdo, $questionID, $choice); ?>
                <div class="choice-input" data-choice=<?php echo $index+1?>>
                <label><?php echo $index + 1; ?>.</label>
                <input type="text" id="<?php echo $answerID; ?>" name="choice[<?php echo $index; ?>]"
                       value="<?php echo htmlspecialchars($choice); ?>" />
                    <span class="error"></span>
                </div>
        <?php endforeach; ?>
        </div>
        <div class="controls">
            <button class="add" data-action="add">Add Choice</button>
            <button class="remove" data-action="remove">Remove Choice</button>
        </div>
        <div class="submit">
            <input type="button" value="Update" onclick="updateForm();"/>
        </div>
    </form>
</div>
</body>
</html>