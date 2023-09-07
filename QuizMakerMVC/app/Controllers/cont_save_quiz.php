<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../classes/error_log.php';
require_once '../classes/connect.php';
require_once '../Models/model_save_quiz.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = db_connect();

    // Check if the user is logged in
    if (!isset($_SESSION['userID'])) {
        exit("User not logged in");
    }

    $userID = $_SESSION['userID'];
    $quizName = isset($_POST["quiz-name"]) ? $_POST["quiz-name"] : null;
    $questions = isset($_POST["questions"]) ? $_POST["questions"] : array();

    saveQuiz($pdo, $userID, $quizName, $questions);

    $response['status'] = "success";
    $response['message'] = "The question has been added successfully";

    // Determine where to redirect based on the token value
    if ($_POST['token'] == "1") {
        header("Location: ../Views/create_quiz_random.php?success_message=" . urlencode(json_encode($response)));
    } else {
        header("Location: ../Views/create_quiz_by_user.php?success_message=" . urlencode(json_encode($response)));
    }
    exit();
}
?>