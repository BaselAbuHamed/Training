<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../classes/connect.php';
require_once '../Models/model_count_score.php';
require_once '../classes/error_log.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize the quiz ID and user ID
    $quizID = isset($_POST['quiz_id']) ? intval($_POST['quiz_id']) : 0;
    $userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : 0;

    // Retrieve questions and user answers from the AJAX POST data
    $questions = isset($_POST['questions']) ? $_POST['questions'] : [];
    $userAnswers = isset($_POST['answers']) ? $_POST['answers'] : [];

    // Check if userAnswers is empty or incomplete
    if (empty($userAnswers) || count($userAnswers) < count($questions)) {
        $response['status'] = "error";
        $response['message'] = "Please solve all questions.";
        echo json_encode($response);
        exit;
    }

    $pdo = db_connect();

    // Calculate the score
    $score = calculateScore($pdo, array_keys($questions), $userAnswers);

    saveScore($pdo, $score, $userID, $quizID, array_keys($questions), $userAnswers);

    $response['status'] = "success";
    $response['message'] = "Your score: " . $score . "/" . count($questions);
    $response['header'] = "/Internship/QuizMakerMVC/app/Views/previous_attempts.php?quiz_id=" . $quizID . "&success_message=" . urlencode(json_encode($response));
    echo json_encode($response);
}

function saveScore($pdo, $score, $userID, $quizID, $questions, $userAnswers) {
    $query = "INSERT INTO user_score (quizID, userID, score, date)
          VALUES (:quizID, :userID, :score, :date)";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quizID', $quizID, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':score', $score, PDO::PARAM_INT);
    $date= date('Y-m-d');
    $stmt->bindParam(':date',$date);

    $stmt->execute();

    $userScoreID = $pdo->lastInsertId();

    foreach ($questions as $question) {
        $questionID = $question;

        $query = "INSERT INTO `previous_attempts`(`userScoreID`, `questionID`, `answerID`) 
                VALUES (:userScoreID, :questionID, :answerID)";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':userScoreID', $userScoreID, PDO::PARAM_INT);
        $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
        $stmt->bindParam(':answerID', $userAnswers[$questionID], PDO::PARAM_INT);
        $stmt->execute();
    }
    return true;
}