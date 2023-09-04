<?php
function calculateScore($pdo,$questions,$userAnswers) {

    $score = 0;

    foreach ($questions as $question) {
        $questionID = $question;

        $correctAnswerID = getCorrectAnswerID($pdo, $questionID);

        if ($correctAnswerID == $userAnswers[$questionID]) {
            $score++;
        }
    }

    return $score;
}

// Helper function to get the correct answer ID for a question
function getCorrectAnswerID($pdo, $questionID) {

    $query = "SELECT correctAnswer FROM question WHERE questionID = :questionID";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->execute();
    $correctAnswer = $stmt->fetch(PDO::FETCH_ASSOC);

    return $correctAnswer['correctAnswer'];
}

function saveScore($pdo,$score,$userID,$quizID){

    $query="INSERT INTO user_score (quizID,userID,score)
            VALUES (:quizID ,:userID ,:score)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quizID', $quizID, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':score', $score, PDO::PARAM_INT);

    $stmt->execute();
}
