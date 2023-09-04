<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../classes/connect.php';
require_once '../classes/error_log.php';
require_once '../Models/modal_delete_question.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = db_connect();
    $questionID = $_POST["questionID"];
    $questions=$_POST["questions"];

    deleteQuestion($pdo,$questionID);

}
