<?php
include 'classes/connect.php';
$pdo = db_connect();

/*take the question field and select all the data about it from the database*/
function getQuestionsByField($pdo, $field) {
    $sql = "SELECT q.questionID, q.question, q.correctAnswer, a.answer
            FROM question q
            LEFT JOIN answers a ON q.correctAnswer = a.answerID
            WHERE q.field = :field";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':field', $field, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*After selecting the questions, pass it to this function to display the data
 in a table and two buttons per row one for updating the data and another
 for deleting the data from the database*/
function displayQuestions($pdo, $questions) {

    $index=1;
    echo '<table>';
    echo '<tr><th>Question Number</th><th>Question</th><th>Correct Answer</th><th></th><th></th></tr>';
    foreach ($questions as $row) {
        echo '<tr id="questionRow_' . $row['questionID'] . '">';
        $questionID = isset($row['questionID']) ? $row['questionID'] : 'N/A';
        echo '<td>' . $index . '</td>';
        echo '<td>' . htmlspecialchars($row['question']) . '</td>';
        echo '<td>' . getCorrectAnswer($pdo, $row['correctAnswer']) . '</td>';
        echo '<td><a id="showQuestion" href="view_question.php?questionID=' . htmlspecialchars($questionID) . '">View</a></td>';
        echo '<td><a id="updateQuestion" href="edit_question.php?questionID=' . htmlspecialchars($questionID) . '">Edit</a></td>';
        echo '<td><button class="deleteQuestion" onclick="deleteQuestion(' . htmlspecialchars($questionID) . ')">Delete</button></td>';
        echo '</tr>';
        $index++;
    }
    echo '</table>';
}

/*select correct answer from answer table using answer id*/
function getCorrectAnswer($pdo, $answerID) {
    $sql = "SELECT answer FROM answers WHERE answerID = :answerID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':answerID', $answerID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return isset($result['answer']) ? htmlspecialchars($result['answer']) : 'N/A';
}

/*for selecting all data from data base*/
function getAllQuestions($pdo) {
    $sql = "SELECT q.questionID, q.question, q.correctAnswer, a.answer
            FROM question q
            LEFT JOIN answers a ON q.correctAnswer = a.answerID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Quiz Questions and Correct Answers</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="script.js" type="text/javascript"></script>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<?php include("classes/header.php"); ?>
    <div class="tab">
        <div class="containerTabs">
            <button class="tablinks" onclick="openQuestions(event, 'mathematics')"  id="defaultOpen">Mathematics</button>
            <button class="tablinks" onclick="openQuestions(event, 'physics')">Physics</button>
            <button class="tablinks" onclick="openQuestions(event, 'biology')">Biology</button>
            <button class="tablinks" onclick="openQuestions(event, 'technology')">Technology</button>
            <button class="tablinks" onclick="openQuestions(event, 'chemistry')">Chemistry</button>
            <button class="tablinks" onclick="openQuestions(event, 'allQuestion')">All Question</button>
        </div>
        <div id="mathematics" class="tabcontent">
            <?php
        $questions = getQuestionsByField($pdo, 'mathematics');
        displayQuestions($pdo, $questions);
        ?>
        </div>
        <div id="physics" class="tabcontent">
            <?php
        $questions = getQuestionsByField($pdo, 'physics');
        displayQuestions($pdo, $questions);
        ?>
        </div>
        <div id="biology" class="tabcontent">
            <?php
        $questions = getQuestionsByField($pdo, 'biology');
        displayQuestions($pdo, $questions);
        ?>
        </div>
        <div id="technology" class="tabcontent">
            <?php
        $questions = getQuestionsByField($pdo, 'technology');
        displayQuestions($pdo, $questions);
        ?>
        </div>
        <div id="chemistry" class="tabcontent">
            <?php
        $questions = getQuestionsByField($pdo, 'chemistry');
        displayQuestions($pdo, $questions);
        ?>
        </div>
        <div id="allQuestion" class="tabcontent">
            <?php
        $questions = getAllQuestions($pdo);
        displayQuestions($pdo, $questions);
        ?>
        </div>
    </div>
</body>
</html>