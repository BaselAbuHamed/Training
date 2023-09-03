<?php
include_once '../classes/connect.php';
include_once '../classes/error_log.php';
include_once '../Models/model_update_question.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $questionID = isset($_POST['questionID']) ? $_POST['questionID'] : null;
    $newQuestion = isset($_POST['question']) ? $_POST['question'] : null;
    $newField = isset($_POST['field']) ? $_POST['field'] : null;
    $newCorrectAnswerIndex = isset($_POST['correctAnswer']) ? $_POST['correctAnswer'] : null;
    $choiceIDs = isset($_POST["choice"]) ? $_POST["choice"] : array();
    $hiddenData = isset($_POST['hiddenData']) ? $_POST['hiddenData'] : null;


    if ($newQuestion==null){
        $response['status'] = "error";
        $response['message'] = "Please enter a question field.";
        $encodedResponse = urlencode(json_encode($response));
        $redirectURL = "../Views/edit_question.php?questionID=" . htmlspecialchars($questionID) . "&error_message=" . $encodedResponse;
        header("Location: " . $redirectURL);//        echo json_encode($response);
        exit;
    }
    if ($newCorrectAnswerIndex==null){
        $response['status'] = "error";
        $response['message'] = "Please enter a correct answer number field.";
        $encodedResponse = urlencode(json_encode($response));
        $redirectURL = "../Views/edit_question.php?questionID=" . htmlspecialchars($questionID) . "&error_message=" . $encodedResponse;
        header("Location: " . $redirectURL);//        echo json_encode($response);
        exit;
    }

    $allNotNull = true;
    foreach ($choiceIDs as $choiceID) {
        if (empty($choiceID)) {
            $allNotNull = false;
            break; // No need to continue checking if one value is null
        }
    }
    if (!$allNotNull) {
        $response['status'] = "error";
        $response['message'] = "Please enter all choices fields.";
        $encodedResponse = urlencode(json_encode($response));
        $redirectURL = "../Views/edit_question.php?questionID=" . htmlspecialchars($questionID) . "&error_message=" . $encodedResponse;
        header("Location: " . $redirectURL);//        echo json_encode($response);
        exit;
    }

    // Validate if correct answer field is numeric.
    if (!is_numeric($newCorrectAnswerIndex)) {
        $response['status'] = "error";
        $response['message'] = "Please enter a number in the correct answer field.";
        $encodedResponse = urlencode(json_encode($response));
        $redirectURL = "../Views/edit_question.php?questionID=" . htmlspecialchars($questionID) . "&error_message=" . $encodedResponse;
        header("Location: " . $redirectURL);//        echo json_encode($response);
        exit;
    }

    // Validate if field is selected.
    if ($newField == "Choose a field") {
        $response['status'] = "error";
        $response['message'] = "Please select a field.";
        $encodedResponse = urlencode(json_encode($response));
        $redirectURL = "../Views/edit_question.php?questionID=" . htmlspecialchars($questionID) . "&error_message=" . $encodedResponse;
        header("Location: " . $redirectURL);//        echo json_encode($response);
        exit;
    }

    // Validate if at least two choices are provided.
    if (count($choiceIDs) < 2) {
        $response['status'] = "error";
        $response['message'] = "You need at least two choices.";
        $encodedResponse = urlencode(json_encode($response));
        $redirectURL = "../Views/edit_question.php?questionID=" . htmlspecialchars($questionID) . "&error_message=" . $encodedResponse;
        header("Location: " . $redirectURL);//        echo json_encode($response);
        exit;
    }

    // Validate if correctAnswerNumber is within the valid range.
    if ($newCorrectAnswerIndex < 1 || $newCorrectAnswerIndex > count($choiceIDs)) {
        $response['status'] = "error";
        $response['message'] = "Invalid correct answer number.";
        $encodedResponse = urlencode(json_encode($response));
        $redirectURL = "../Views/edit_question.php?questionID=" . htmlspecialchars($questionID) . "&error_message=" . $encodedResponse;
        header("Location: " . $redirectURL);//        echo json_encode($response);
        exit;
    }
    try {
        $pdo = db_connect();

        updateQuestionAndField($pdo, $questionID, $newQuestion, $newField);
        updateChoice($pdo, $choiceIDs, $questionID);
        if(isset($hiddenData)) {
            $data = json_decode($hiddenData, true);

            $choiceIDs = $data['choiceIDs'];
            $newChoiceIDs = $data['newChoiceIDs'];

            logError(print_r($choiceIDs,true));
            logError(print_r($newChoiceIDs,true));

            deleteChoice($pdo, $questionID, $choiceIDs);
            insertChoice($pdo, $questionID, $newChoiceIDs);
        }

        updateCorrectAnswer($pdo, $questionID, $newCorrectAnswerIndex);

        $response['status'] = "success";
        $response['message'] = "Question updated successfully!";
        $encodedResponse = urlencode(json_encode($response));
        $redirectURL = "../Views/edit_question.php?questionID=" . htmlspecialchars($questionID) . "&success_message=" . $encodedResponse;
        header("Location: " . $redirectURL);

    } catch (PDOException $e) {
        $response['status'] = "error";
        $response['message'] = "Error updating question: " . $e->getMessage();
        $encodedResponse = urlencode(json_encode($response));
        $redirectURL = "../Views/edit_question.php?questionID=" . htmlspecialchars($questionID) . "&error_message=" . $encodedResponse;
        header("Location: " . $redirectURL);//        echo json_encode($response);
    }
}
