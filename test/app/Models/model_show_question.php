<?php
include '../classes/error_log.php';

/*for selecting all data from data base*/
function getAllQuestions($pdo) {
    $sql = "SELECT q.questionID, q.question, q.field,q.correctAnswer, a.answer
            FROM question q
            LEFT JOIN answers a ON q.correctAnswer = a.answerID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*take the question field and select all the data about it from the database*/
function getQuestionsByField($pdo, $field) {
    $sql = "SELECT q.questionID, q.question,q.field ,q.correctAnswer, a.answer
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
    $index = 1;
    echo '<table>';
    echo '<tr><th>Question Number</th><th>Question</th><th>Correct Answer</th><th></th><th></th><th></th></tr>';
    foreach ($questions as $row) {
        echo '<tr id="questionRow_' . $row['questionID'] . '">';
        $questionID = isset($row['questionID']) ? $row['questionID'] : 'N/A';
        echo '<td>' . $index . '</td>';
        echo '<td>' . htmlspecialchars($row['question']) . '</td>';
        echo '<td>' . getCorrectAnswer($pdo, $row['correctAnswer']) . '</td>';
        echo '<td><a id="showQuestion" href="../Views/view_question.php?questionID=' . htmlspecialchars($questionID) . '">View</a></td>';
        echo '<td><a id="updateQuestion" href="../Views/edit_question.php?questionID=' . htmlspecialchars($questionID) . '">Edit</a></td>';
        echo '<td>';
        echo '<div class="delete_button">';
        echo '<form action="../Controllers/cont_delete_question.php" method="post">';
        echo '<input type="hidden" name="questions" class="questions" value="' . htmlspecialchars($row['field']) . '" />';
        echo '<input type="hidden" name="questionID" class="questionID" value="' . htmlspecialchars($questionID) . '" />';
        echo '<button class="deleteQuestion" type="submit" name="delete" >Delete</button>';
        echo '</form>';
        echo '</div>';
        echo '</td>';
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