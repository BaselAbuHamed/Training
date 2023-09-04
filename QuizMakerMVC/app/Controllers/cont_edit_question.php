<?php
require_once '../classes/connect.php';
require_once '../classes/error_log.php';
require_once '../Models/model_edit_question.php';

function getQuestionID(){
    if (isset($_GET['questionID'])) {
        return $_GET['questionID'];
    }
}

function getDetails(){
    $pdo = db_connect();
    return getAllQuestionDetails($pdo, getQuestionID());
}

function getChoices(){
    $pdo = db_connect();
    return getQuestionChoices($pdo, getQuestionID());
}

//get index for correct answer from array of choices
function getCorrectAnswerIndex() {
    $pdo = db_connect();
    $correctAnswerValue = getCorrectAnswerValue($pdo, getQuestionID(), getDetails()['correctAnswer']);
    $choices = getQuestionChoices($pdo, getQuestionID());

    return array_search($correctAnswerValue, $choices);
}

function getAnsID($choice){
    $pdo = db_connect();
    return getAnswerID($pdo, getQuestionID(), $choice);
}

