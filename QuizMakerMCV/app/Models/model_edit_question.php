<?php
require_once '../classes/error_log.php';

//to get choice id from answers table
function getAnswerID($pdo, $questionID, $choiceText) {
    $sql = "SELECT answerID FROM answers WHERE questionID = :questionID AND answer = :choiceText";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->bindParam(':choiceText', $choiceText, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
//    logError($result['answerID']);


    if ($result !== false && isset($result['answerID'])) {

        return (int)$result['answerID'];
    }

    return -1; // Default value if not found or empty result
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
// To get question details
function getAllQuestionDetails($pdo, $questionID) {
    $sql = "SELECT question, correctAnswer, field FROM question WHERE questionID = :questionID";
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
