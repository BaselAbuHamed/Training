<?php
require_once '../classes/connect.php';
require_once '../Models/model_show_quizzes.php';

$pdo = db_connect();

$quizzes = displayQuizzes($pdo);

if (empty($quizzes)){
    echo '<p>No quizzes available.</p>';
}

else{
    echo '<ul class="quiz-grid">';
    foreach ($quizzes as $quiz):
        echo '<div class="quiz-design">';
        echo '<span>' . htmlspecialchars($quiz['quizName']) . '</span>';
        echo '<label >High Score:</label>';
        echo '<span>' . getHighestScore($quiz['quizID']) . '</span>';
        echo '<a class="quiz-button" href="../Views/solve_quiz.php?quiz_id=' . $quiz['quizID'] . '">Solve Quiz</a>';
        echo '</div>';
    endforeach;
    echo '</ul>';
}

function getHighestScore($quizID) {
    $pdo = db_connect();
    // Define the SQL query to retrieve the highest score for a specific quiz
    $query = "SELECT MAX(score) AS highest_score 
              FROM user_score 
              WHERE quizID = :quizID AND userID = :userID";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($query);

    // Bind the quizID parameter
    $stmt->bindParam(':quizID', $quizID, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);


    // Execute the query
    if ($stmt->execute()) {
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a result was found
        if ($result && isset($result['highest_score'])) {
            return $result['highest_score'];
        } else {
            return "try attempt quiz"; // No score found for the specified quiz
        }
    } else {
        // Handle the error if the query execution fails
        return false;
    }
}