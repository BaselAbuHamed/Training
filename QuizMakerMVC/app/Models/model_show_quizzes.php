<?php
function displayQuizzes($pdo) {
    $query="SELECT * FROM quizzes";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $quizzes=$stmt->fetchAll(PDO::FETCH_ASSOC);

    return $quizzes;
}