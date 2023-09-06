<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../classes/connect.php';
require_once '../Models/model_count_score.php';
require_once '../classes/error_log.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $questions = $_POST['questions'];
    $userAnswers = $_POST["answers"];
    $quizID=$_POST['quiz_id'];
    $userID=$_SESSION['userID'];

    logError(print_r($questions,true));
    logError(print_r($userAnswers,true));


    if (empty($userAnswers)){
        $response['status'] = "error";
        $response['message'] = "Please solve all question.";
        $_SESSION['user_answers'] = $userAnswers;

        header("Location: ../Views/solve_quiz.php?quiz_id=" . $quizID . "&error_message=" . urlencode(json_encode($response)));
        exit;
    }
    if (count($userAnswers) < count($questions)){
        $response['status'] = "error";
        $response['message'] = "Please solve all question.";
        $_SESSION['user_answers'] = $userAnswers;
        header("Location: ../Views/solve_quiz.php?quiz_id=" . $quizID . "&error_message=" . urlencode(json_encode($response)));
        exit;
    }


    $pdo = db_connect();


    // Calculate the score
    $score = calculateScore($pdo, array_keys($questions), $userAnswers);

    echo '<div class="tittle">';
    echo "Your Score: " . $score ."/". count($questions) .".";
    echo '</div>';

    saveScore($pdo,$score,$userID,$quizID,array_keys($questions),$userAnswers);

    unset($_SESSION['user_answers']);

    $response['status'] = "success";
    $response['message'] = "your scour." . $score . "/" . count($questions);
    header("Location: ../Views/solve_quiz.php?quiz_id=" . $quizID . "&success_message=" . urlencode(json_encode($response)));
    exit;
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
        $stmt->execute();
    }
}
