<?php
include '../classes/connect.php';
include '../Models/model_create_quiz.php';
include '../classes/error_log.php';


$pdo = db_connect();

//// Check if server request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $field = isset($_POST["where"]) ? $_POST["where"] : null;
    $numberQuestion = isset($_POST["numQuestions"]) ? $_POST["numQuestions"] : null;

    $questions = SelectQuestionByField($pdo,$numberQuestion , $field);
    displayQuestion($pdo,$questions);
}