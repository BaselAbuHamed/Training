<?php
session_start();
include_once '../classes/error_log.php';
include_once '../classes/connect.php';
include '../Models/model_save_quiz.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pdo=db_connect();
    $userID=$_SESSION['userID'];
    $quizName = isset($_POST["quiz-name"]) ? $_POST["quiz-name"] : null;
    $questions = isset($_POST["questions"]) ? $_POST["questions"] : array();

    logError($quizName);
    saveQuiz($pdo,$userID,$quizName,$questions);
}
