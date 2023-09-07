<?php

function getPreviousAttempts($pdo,$userID,$quizID){

    $query = "SELECT user_score.userScoreID, user_score.score, user_score.date
              FROM user_score
              WHERE user_score.userID = :userID AND user_score.quizID = :quizID
              ORDER BY user_score.date DESC";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':quizID', $quizID, PDO::PARAM_INT);

    $stmt->execute();
    $attempts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $attempts;
}

function getAllPreviousAttempts($pdo, $quizID) {
    $query = "SELECT user.userName, user_score.userScoreID, user_score.score, user_score.date
              FROM user_score
              INNER JOIN user ON user_score.userID = user.userID
              WHERE user_score.quizID = :quizID
              ORDER BY user_score.date DESC";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quizID', $quizID, PDO::PARAM_INT);

    $stmt->execute();
    $attempts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $attempts;
}
