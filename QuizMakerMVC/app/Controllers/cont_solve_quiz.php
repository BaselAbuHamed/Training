<?php

require_once '../classes/connect.php';
require_once '../Models/model_create_quiz.php';
require_once '../Models/model_solve_quiz.php';
function quiz($quiz_id){
    $pdo = db_connect();

    displayQuestionsOnly($pdo, json_encode(getQuizName($pdo,$quiz_id)),questionID($pdo,$quiz_id),$quiz_id);
}


