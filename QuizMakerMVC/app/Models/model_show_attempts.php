<?php

function getPreviousAttempts($pdo,$userScoreID){
    $query = "SELECT question.question, question.questionID , answers.answer ,question.correctAnswer
          FROM previous_attempts
          JOIN question ON previous_attempts.questionID = question.questionID
          JOIN answers ON previous_attempts.answerID = answers.answerID
          WHERE previous_attempts.userScoreID = :userScoreID";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userScoreID', $userScoreID, PDO::PARAM_INT);
    $stmt->execute();
    $attemptsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $attemptsData;
}
