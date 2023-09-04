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
        echo '<a class="quiz-button" href="../Views/solve_quiz.php?quiz_id=' . $quiz['quizID'] . '">Solve Quiz</a>';
        echo '</div>';
    endforeach;
    echo '</ul>';
}