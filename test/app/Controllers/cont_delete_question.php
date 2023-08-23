<?php
include_once '../classes/connect.php';
include_once '../classes/error_log.php';
include_once '../Models/modal_delete_question.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = db_connect();
    $questionID = $_POST["questionID"];
    $questions=$_POST["questions"];

    if (deleteQuestion($pdo,$questionID)) {
        $response['status'] = "success";
        $response['message'] = "Question deleted successfully.";
        $encodedResponse = urlencode(json_encode($response));
        $redirectURL = "../Views/show_question.php?subject=".$questions ."&questionID=" . htmlspecialchars($questionID) . "&success_message=" . $encodedResponse;
    } else {
        $response['status'] = "error";
        $response['message'] = "Error updating question.";
        $encodedResponse = urlencode(json_encode($response));
        $redirectURL = "../Views/show_question.php?subject=".$questions ."&questionID=" . htmlspecialchars($questionID) . "&error_message=" . $encodedResponse;
        //        echo json_encode($response);
    }
    header("Location: " . $redirectURL);
}
