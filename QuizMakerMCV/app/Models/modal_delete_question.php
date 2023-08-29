<?php
function deleteQuestion($pdo,$questionID){

    $sql = "DELETE FROM question WHERE questionID = :questionID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}