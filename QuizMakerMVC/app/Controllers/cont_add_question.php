<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../classes/connect.php';
require_once '../Models/model_add_question.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$pdo = db_connect();
$response = array();

// Check if server request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $question = isset($_POST["question"]) ? $_POST["question"] : null;
    $correctAnswerNumber = isset($_POST["correctAnswer"]) ? $_POST["correctAnswer"] : null;
    $field = isset($_POST["where"]) ? $_POST["where"] : null;
    $choices = isset($_POST["choice"]) ? $_POST["choice"] : array();
    $userID=$_SESSION['userID'];
    // Validate if fields are empty.
    if (empty($question) || empty($correctAnswerNumber) || empty($field) || empty($choices)) {
        $response['status'] = "error";
        $response['message'] = "Please fill all fields.";
        header("Location: ../../public/index.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
        exit;
    }

    $allNotNull = true;
    foreach ($choices as $choiceID) {
        if (empty($choiceID)) {
            $allNotNull = false;
            break; // No need to continue checking if one value is null
        }
    }
    if (!$allNotNull) {
        $response['status'] = "error";
        $response['message'] = "Please enter all choices fields.";
        header("Location: ../../public/index.php?error_message=" . urlencode(json_encode($response)));
        exit;
    }

    // Validate if correct answer field is numeric.
    if (!is_numeric($correctAnswerNumber)) {
        $response['status'] = "error";
        $response['message'] = "Please enter a number in the correct answer field.";
        header("Location: ../../public/index.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
        exit;
    }

//    // Validate if field is selected.
//    if ($field == "Choose a field") {
//        $response['status'] = "error";
//        $response['message'] = "Please select a field.";
//        header("Location: ../../public/index.php?error_message=" . urlencode(json_encode($response)));
////        echo json_encode($response);
//        exit;
//    }

    // Validate if at least two choices are provided.
    if (count($choices) < 2) {
        $response['status'] = "error";
        $response['message'] = "You need at least two choices.";
        header("Location: ../../public/index.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
        exit;
    }

    // Validate if correctAnswerNumber is within the valid range.
    if ($correctAnswerNumber < 1 || $correctAnswerNumber > count($choices)) {
        $response['status'] = "error";
        $response['message'] = "Invalid correct answer number.";
        header("Location: ../../public/index.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
        exit;
    }

    if(insertQuestion($pdo,$question,$field,$choices,$correctAnswerNumber,$userID)){
        $response['status'] = "success";
        $response['message'] = "The question has been added successfully";
        header("Location: ../../public/index.php?success_message=" . urlencode(json_encode($response)));
    }else{
        $response['status'] = "error";
        $response['message'] = "Error adding question.";
        header("Location: ../../public/index.php?error_message=" . urlencode(json_encode($response)));
    }
}else {
    $response['status'] = "error";
    $response['message'] = "Invalid request method";
    header("Location: ../../public/index.php?error_message=" . urlencode(json_encode($response)));
}

