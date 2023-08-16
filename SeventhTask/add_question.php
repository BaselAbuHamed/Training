<?php
include 'classes/connect.php';
include 'classes/error_log.php';

$pdo = db_connect();

$response = array();

// Check if server request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $question = isset($_POST["question"]) ? $_POST["question"] : null;
    $correctAnswerNumber = isset($_POST["correctAnswer"]) ? $_POST["correctAnswer"] : null;
    $field = isset($_POST["where"] ) ? $_POST["correctAnswer"] : null;
    $choices = $_POST["choice"]; // Array containing the choices --> class="choice[]"

//    // Validate if fields not include in post method.
//    if ($question == null || $correctAnswerNumber == null || $field == null
//    || $choices == null ){
//        $response['status'] = "error";
//        $response['message'] = "Invalid request method";
//        echo json_encode($response);
//        exit;
//    }
    // Validate if fields is empty.
    if(empty($question) || empty($correctAnswerNumber) || empty($field) || empty($choices)){
        $response['status'] = "error";
        $response['message'] = "Please fill all fields.";
        echo json_encode($response);
        exit;
    }
    // Validate if correct answer field is numeric.
    if (!is_numeric($correctAnswerNumber)){
        $response['status'] = "error";
        $response['message'] = "Please enter number in correct answer field.";
        echo json_encode($response);
        exit;
    }
    // Validate if field select a field.
    if ($field=="Choose a field"){
        $response['status'] = "error";
        $response['message'] = "Please select a field.";
        echo json_encode($response);
        exit;
    }
    // Validate if choices is within the valid range
    if (count($choices) < 2){
        $response['status'] = "error";
        $response['message'] = "You need at least two choices.";
        echo json_encode($response);
        exit;
    }
    // Validate if correctAnswerNumber is within the valid range
    if ($correctAnswerNumber < 1 || $correctAnswerNumber > count($choices)) {
        $response['status'] = "error";
        $response['message'] = "Invalid correct answer number.";
        echo json_encode($response);
        exit; // Exit the script
    }

    // Insert question into the 'question' table
    $sql = "INSERT INTO question (question, field) VALUES (:question, :field)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':question', $question);
    $stmt->bindParam(':field', $field);

    $choiceIndex = 1; /* Used to keep track of the index of each choice being inserted.
                        If the current choice index matches the correct answer number */

    if ($stmt->execute()) {
        $questionID = $pdo->lastInsertId(); // Get ID of the last inserted question

        $correctAnswerID = null;
        foreach ($choices as $choice) {
            $sql = "INSERT INTO answers (questionID, answer) VALUES (:questionID, :answer)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':questionID', $questionID);
            $stmt->bindParam(':answer', $choice);
            if ($stmt->execute()) {
                $answerID = $pdo->lastInsertId();
                if ($correctAnswerNumber == $choiceIndex) {
                    $correctAnswerID = $answerID;
                }
                $choiceIndex++;
            }
        }

        if ($correctAnswerID !== null) {
            // Update 'correctAnswer' field in 'question' table
            $sql = "UPDATE question SET correctAnswer = :correctAnswer WHERE questionID = :questionID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':correctAnswer', $correctAnswerID);
            $stmt->bindParam(':questionID', $questionID);
            if ($stmt->execute()) {
                $response['status'] = "success";
                $response['message'] = "Question added successfully!";
            } else {
                $response['status'] = "error";
                $response['message'] = "Error updating correct answer ID.";
            }
        }
    } else {
        $response['status'] = "error";
        $response['message'] = "Error adding question.";
    }
} else {
    $response['status'] = "error";
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
?>