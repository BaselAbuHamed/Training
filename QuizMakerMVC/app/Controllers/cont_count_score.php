<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../classes/connect.php';
require_once '../Models/model_count_score.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $questions = $_POST['questions'];
    $userAnswers = $_POST["answers"];
    $quizID=$_POST['quiz_id'];
    $userID=$_SESSION['userID'];

    if (empty($userAnswers)){
        $response['status'] = "error";
        $response['message'] = "Please solve all question.";
        header("Location: ../Views/solve_quiz.php?quiz_id=43&error_message=" . urlencode(json_encode($response)));
        exit;
    }

    $pdo = db_connect();

    echo print_r($userAnswers,true);
    echo print_r(array_keys($questions),true);

    // Calculate the score
    $score = calculateScore($pdo, array_keys($questions), $userAnswers);

    echo '<div class="tittle">';
    echo "Your Score: " . $score ."/". count($questions) .".";
    echo '</div>';

    saveScore($pdo,$score,$userID,$quizID,array_keys($questions),$userAnswers);
}

function saveScore($pdo,$score,$userID,$quizID,$questions,$userAnswers){

    $query="INSERT INTO user_score (quizID,userID,score)
            VALUES (:quizID ,:userID ,:score)";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quizID', $quizID, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':score', $score, PDO::PARAM_INT);

    $stmt->execute();

    $userScoreID=$pdo->lastInsertId();

    foreach ($questions as $question) {
        $questionID = $question;

        $query="INSERT INTO `previous_attempts`(`userScoreID`, `questionID`, `answerID`) 
                VALUES (:userScoreID,:questionID,:answerID)";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':userScoreID', $userScoreID, PDO::PARAM_INT);
        $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
        $stmt->bindParam(':answerID', $userAnswers[$questionID], PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Record inserted successfully.";
        } else {
            echo "Error inserting record: " . $stmt->errorInfo()[2];
        }
    }




}

//function savePreviousAtt($pdo,$question,$answer,){{
//
//}




