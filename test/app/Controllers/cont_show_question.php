<?php
include_once '../classes/connect.php';
include_once '../Models/model_show_question.php';

function getData($field){
    $pdo = db_connect();
    return getQuestionsByField($pdo, $field);
}

function getAllData(){
    $pdo = db_connect();
    return getAllQuestions($pdo);
}

function printTable($field){
    $pdo = db_connect();
    displayQuestions($pdo, $field);
}
