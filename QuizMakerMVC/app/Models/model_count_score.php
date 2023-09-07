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

