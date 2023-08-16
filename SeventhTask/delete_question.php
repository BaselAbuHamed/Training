<?php
include 'classes/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["questionID"])) {
    $pdo = db_connect();
    $questionID = $_POST["questionID"];

    // Perform the deletion query
    $sql = "DELETE FROM question WHERE questionID = :questionID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Question deleted successfully.";
    } else {
        echo "Error deleting question.";
    }
}
?>