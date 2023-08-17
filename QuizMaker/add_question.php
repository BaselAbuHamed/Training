<?php
include 'classes/connect.php';
include 'classes/error_log.php';

$pdo = db_connect();
$response = array();

// Check if server request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $question = isset($_POST["question"]) ? $_POST["question"] : null;
    $correctAnswerNumber = isset($_POST["correctAnswer"]) ? $_POST["correctAnswer"] : null;
    $field = isset($_POST["where"]) ? $_POST["where"] : null;
    $choices = isset($_POST["choice"]) ? $_POST["choice"] : array();

    // Validate if fields are empty.
    if (empty($question) || empty($correctAnswerNumber) || empty($field) || empty($choices)) {
        $response['status'] = "error";
        $response['message'] = "Please fill all fields.";
        echo json_encode($response);
        exit;
    }

    // Validate if correct answer field is numeric.
    if (!is_numeric($correctAnswerNumber)) {
        $response['status'] = "error";
        $response['message'] = "Please enter a number in the correct answer field.";
        echo json_encode($response);
        exit;
    }

    // Validate if field is selected.
    if ($field == "Choose a field") {
        $response['status'] = "error";
        $response['message'] = "Please select a field.";
        echo json_encode($response);
        exit;
    }

    // Validate if at least two choices are provided.
    if (count($choices) < 2) {
        $response['status'] = "error";
        $response['message'] = "You need at least two choices.";
        echo json_encode($response);
        exit;
    }

    // Validate if correctAnswerNumber is within the valid range.
    if ($correctAnswerNumber < 1 || $correctAnswerNumber > count($choices)) {
        $response['status'] = "error";
        $response['message'] = "Invalid correct answer number.";
        echo json_encode($response);
        exit;
    }

    // Insert question into the 'question' table
    $sql = "INSERT INTO question (question, field) VALUES (:question, :field)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':question', $question, PDO::PARAM_STR);
    $stmt->bindParam(':field', $field, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $questionID = $pdo->lastInsertId();

        foreach ($choices as $index => $choice) {
            $sql = "INSERT INTO answers (questionID, answer) VALUES (:questionID, :answer)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
            $stmt->bindParam(':answer', $choice, PDO::PARAM_STR);
            if ($stmt->execute()) {
                if ($correctAnswerNumber == ($index + 1)) {
                    $correctAnswerID = $pdo->lastInsertId();
                }
            }
        }

        if (isset($correctAnswerID)) {
            $sql = "UPDATE question SET correctAnswer = :correctAnswer WHERE questionID = :questionID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':correctAnswer', $correctAnswerID, PDO::PARAM_INT);
            $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
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