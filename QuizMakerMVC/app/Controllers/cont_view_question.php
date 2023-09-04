<?php
require_once '../classes/connect.php';
require_once '../Models/model_view_question.php';

function getDetails(){
    $pdo = db_connect();
    return getQuestionTitle($pdo, getQuestionID());
}

function getChoices(){
    $pdo = db_connect();
    return getQuestionChoices($pdo, getQuestionID());
}

function getQuestionID(){
    if (isset($_GET['questionID'])) {
        return $_GET['questionID'];
    }
}
