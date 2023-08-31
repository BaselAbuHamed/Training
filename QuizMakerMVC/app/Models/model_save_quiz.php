<?php

function saveQuiz($pdo,$userID,$quizName,$questions){
        // Insert the quiz response into the database
        $query = "INSERT INTO quizzes (userID, quizName) VALUES (:user_id, :quiz_name)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':quiz_name', $quizName, PDO::PARAM_STR);
        $stmt->execute();

        $quizID= $pdo->lastInsertId();

        saveQuestions($pdo,$quizID,$questions);
}

function saveQuestions($pdo,$quizID,$questions){

    $keys = array_keys($questions);

    foreach ($keys as $index){
        $query="INSERT INTO quiz_questions (quizID,questionID) VALUES (:quiz_id , :question_id)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':quiz_id', $quizID, PDO::PARAM_INT);
        $stmt->bindParam(':question_id', $index, PDO::PARAM_INT);
        $stmt->execute();
    }
}
