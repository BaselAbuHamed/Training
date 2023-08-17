<?php
include_once 'classes/connect.php';
$pdo = db_connect();

$questionDetails = array();
$choices = array();

if (isset($_GET['questionID'])) {
    $questionID = $_GET['questionID'];

    // Call function and save return value in variables
    $questionDetails = getQuestionDetails($pdo, $questionID);
    $choices = getQuestionChoices($pdo, $questionID);
}

// To get question details
function getQuestionDetails($pdo, $questionID) {
    $sql = "SELECT question FROM question WHERE questionID = :questionID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// To get question choices
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Show Question</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
    <?php include("classes/header.php"); ?>
    <div class="container-show">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?questionID=" . $questionID); ?>" id="updateQuestionForm" method="post">
            <input type="hidden" name="questionID" value="<?php echo $questionID; ?>" />
            <label for="question">Question:</label>
            <label class="Q"><?php echo htmlspecialchars($questionDetails['question']); ?></label>
            <label id="choice" for="choices">Choices:</label>
            <div class="choices" id="choices-container">
                <?php foreach ($choices as $index => $choice) : ?>
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