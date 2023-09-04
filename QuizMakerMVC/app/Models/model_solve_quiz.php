<?php
function questionID($pdo,$quiz_id){
    $query = "SELECT qq.questionID
                  FROM quizzes q 
                  JOIN quiz_questions qq 
                  ON q.quizID = qq.quizID 
                  WHERE q.quizID = :quizID";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quizID', $quiz_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getQuizName($pdo,$quiz_id){
    $getQuizName="SELECT quizName FROM quizzes where quizID= :quizID";

    $name = $pdo->prepare($getQuizName);
    $name->bindParam(':quizID', $quiz_id, PDO::PARAM_INT);
    $name->execute();
    $quizName = $name->fetchAll(PDO::FETCH_ASSOC);

    return $quizName;
}


