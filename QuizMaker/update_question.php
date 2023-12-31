<?php
include 'classes/connect.php';

$pdo = db_connect();

$response = array();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["formData"])) {
    parse_str($_POST["formData"], $formFields);

    $questionID = isset($formFields['questionID']) ? $formFields['questionID'] : null;
    $newQuestion = isset($formFields['question']) ? $formFields['question'] : null;
    $newField = isset($formFields['field']) ? $formFields['field'] : null;
    $newCorrectAnswerIndex = isset($formFields['correctAnswer']) ? $formFields['correctAnswer'] : null;

    $choiceIDs = isset($_POST["choiceIDs"]) ? $_POST["choiceIDs"] : array();
    $newChoiceIDs = isset($_POST["newChoiceIDs"]) ? $_POST["newChoiceIDs"] : array();



    try {
        // Update question and field
        updateQuestionAndField($pdo, $questionID, $newQuestion, $newField);

        // Update choices
        updateChoice($pdo, $choiceIDs, $questionID);

        // Delete choices not in the choiceIDs array
        deleteChoice($pdo, $questionID, $choiceIDs);

        // Insert new choices
        insertChoice($pdo, $questionID, $newChoiceIDs);

//        error_log(print_r($newCorrectAnswerIndex, true),3,"error_log.txt");

        // Update correct answer
        updateCorrectAnswer($pdo, $questionID, $newCorrectAnswerIndex);

        $response['status'] = "success";
        $response['message'] = "Question updated successfully!";
    } catch (PDOException $e) {
        $response['status'] = "error";
        $response['message'] = "Error updating question: " . $e->getMessage();
    }
} else {
    $response['status'] = "error";
    $response['message'] = "Invalid request method";
}

echo json_encode($response);

// Function to update question details in 'question' table
function updateQuestionAndField($pdo, $questionID, $newQuestion, $newField) {
    $nullSql = "UPDATE question SET correctAnswer = NULL WHERE questionID = :questionID";
    $nullStmt = $pdo->prepare($nullSql);
    $nullStmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
    $nullStmt->execute();

    $sql = "UPDATE question SET question = :question, field = :field WHERE questionID = :questionID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':question', $newQuestion);
    $stmt->bindParam(':field', $newField);
    $stmt->bindParam(':questionID', $questionID);
    $stmt->execute();
}
// Function to update a choice
function updateChoice($pdo, $choiceIDs, $questionID) {
    $updateFormQuery = "UPDATE answers SET answer = :answer WHERE questionID = :questionID AND answerID = :answerID";
    $stmt = $pdo->prepare($updateFormQuery);
    foreach ($choiceIDs as $choice) {
        $stmt->bindParam(':answer', $choice["value"]);
        $stmt->bindParam(':questionID', $questionID);
        $stmt->bindParam(':answerID', $choice["key"]);
        $stmt->execute();
    }
}

function deleteChoice($pdo, $questionID, $choiceIDs) {
    $sql = "DELETE FROM answers WHERE answerID = :choiceID AND questionID = :questionID";

    $existingChoiceIDs = array();
    foreach ($choiceIDs as $choice) {
        $existingChoiceIDs[]=$choice["key"];
    }

    $stmt = $pdo->prepare("SELECT answerID FROM answers WHERE questionID = :questionID");
    $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dbChoiceIDs = $row['answerID'];
        if (!in_array($dbChoiceIDs, $existingChoiceIDs)) {
            $deleteStmt = $pdo->prepare($sql);
            $deleteStmt->bindParam(':choiceID', $dbChoiceIDs, PDO::PARAM_INT);
            $deleteStmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
            $deleteStmt->execute();
        }
    }
}

// Function to insert a new choice
function insertChoice($pdo, $questionID, $newChoiceIDs) {
    $sql = "INSERT INTO answers (questionID, answer) VALUES (:questionID, :newChoice)";
    foreach ($newChoiceIDs as $choice) {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
        $stmt->bindParam(':newChoice', $choice["value"], PDO::PARAM_STR);
        $stmt->execute();
    }
}

function updateCorrectAnswer($pdo, $questionID, $fieldNumber){

    // Step 1: Get answerID for new correct answer using fieldNumber
    $choices = getQuestionChoice($pdo, $questionID);

    $fieldIndex = $fieldNumber - 1; // Assuming field numbers start from 1

    error_log(print_r($choices[$fieldIndex], true),3,"error_log.txt");

    if (isset($choices[$fieldIndex])) {
        $newCorrectAnswerID = getID($pdo, $questionID, $choices[$fieldIndex]);

        // Step 2: Update correctAnswer in question table
        $updateSql = "UPDATE question SET correctAnswer = :newCorrectAnswerID WHERE questionID = :questionID";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->bindParam(':newCorrectAnswerID', $newCorrectAnswerID, PDO::PARAM_INT);
        $updateStmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
        $updateStmt->execute();
    }
}

function getQuestionChoice($pdo, $questionID) {
    $sql = "SELECT answerID, answer FROM answers WHERE questionID = :questionID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->execute();

    $choices = array();
    $index=0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $choices[$index] = $row['answer'];
        $index++;
    }
    return $choices;
}
function getID($pdo, $questionID, $choiceText) {
    $sql = "SELECT answerID FROM answers WHERE questionID = :questionID AND answer = :choiceText";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->bindParam(':choiceText', $choiceText, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false) {
        return (int)$result['answerID'];
    }

    return -1; // Default value if not found
}