<?php

// To get question details
function getQuestionTitle($pdo, $questionID) {
    $sql = "SELECT question FROM question WHERE questionID = :questionID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// To get question choices
function getQuestionChoices($pdo, $questionID) {
    $sql = "SELECT answer FROM answers WHERE questionID = :questionID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->execute();

    $choices = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $choices[] = $row['answer'];
    }
    return $choices;
}
?>