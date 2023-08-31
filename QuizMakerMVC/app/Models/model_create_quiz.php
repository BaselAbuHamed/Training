<?php
//include '../classes/error_log.php';

function SelectQuestionByField($pdo, $numberQuestion, $field) {
    $query = "SELECT * FROM question WHERE field = :field ORDER BY RAND() LIMIT :limit";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':field', $field, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $numberQuestion, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function displayQuestion($pdo, $questions) {
    echo '<div class="container-quiz">';
    echo '<form method="post" action="../Controllers/cont_save_quiz.php">';
    echo '<input type="text" name="quiz-name" placeholder="Enter Quiz Name"/>';

    foreach ($questions as $question) {
        echo '<div class="question-design">';
        echo '<label for="question">Question:</label>';
        echo '<div class="question">';
        echo '<input type="text" name="questions[' . htmlspecialchars($question['questionID']) . ']" value="' . htmlspecialchars($question['question']) . '"readonly />';
        echo '</div>';

        $query = "SELECT * FROM answers WHERE questionID = :questionID ORDER BY RAND()";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':questionID', $question['questionID'], PDO::PARAM_INT);
        $stmt->execute();
        $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<label id="choice" for="choices">Choices:</label>';
        echo '<div class="choices" id="choices-container">';
        foreach ($answers as $index => $answer) {
            echo '<div class="choice-input" data-choice="' . ($index + 1) . '">';
            echo '<input type="radio" name="answers[' . $question['questionID'] . ']" value="' . htmlspecialchars($answer['answer']) . '" />';
            echo '<span class="Q">' . htmlspecialchars($answer['answer']) . '</span>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    }

    echo '<div class="submit">';
    echo '<input type="submit" value="Save Quiz" />';
    echo '</div>';
    echo '</form>';
    echo '</div>';
}


