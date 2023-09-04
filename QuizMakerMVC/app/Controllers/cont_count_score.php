<?php
require_once '../classes/connect.php';
require_once '../Models/model_count_score.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $questions = $_POST['questions'];
    $userAnswers = $_POST["answers"];

    if (empty($userAnswers)){
        $response['status'] = "error";
        $response['message'] = "Please solve all question.";
        header("Location: ../Views/solve_quiz.php?quiz_id=43&error_message=" . urlencode(json_encode($response)));
        exit;
    }

    $pdo = db_connect();

    // Calculate the score
    $score = calculateScore($pdo, array_keys($questions), $userAnswers);

    echo '<div class="tittle">';
    echo "Your Score: " . $score ."/". count($questions) .".";
    echo '</div>';
}


