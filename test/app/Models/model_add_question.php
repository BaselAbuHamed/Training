<?php

function insertQuestion($pdo,$question,$field,$choices,$correctAnswerNumber)
{
    // Insert question into the 'question' table
    $sql = "INSERT INTO question (question, field) VALUES (:question, :field)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':question', $question, PDO::PARAM_STR);
    $stmt->bindParam(':field', $field, PDO::PARAM_STR);
    insertChoices($pdo, $stmt->execute(), $choices, $correctAnswerNumber);
    return $stmt;
}

function insertChoices($pdo,$flag,$choices,$correctAnswerNumber){
    if ($flag) {
        $questionID = $pdo->lastInsertId();

        foreach ($choices as $index => $choice) {
            $sql = "INSERT INTO answers (questionID, answer) VALUES (:questionID, :answer)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
            $stmt->bindParam(':answer', $choice, PDO::PARAM_STR);
            if ($stmt->execute()) {
                if ($correctAnswerNumber == ($index + 1)) {
                    $correctAnswerID = $pdo->lastInsertId();
                    updateAnswerIndex($pdo,$questionID,$correctAnswerID);
                }
            }
        }
    }
}

function updateAnswerIndex($pdo,$questionID,$correctAnswerID){
    if (isset($correctAnswerID)) {
        $sql = "UPDATE question SET correctAnswer = :correctAnswer WHERE questionID = :questionID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':correctAnswer', $correctAnswerID, PDO::PARAM_INT);
        $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
        $stmt->execute();
    }
}
