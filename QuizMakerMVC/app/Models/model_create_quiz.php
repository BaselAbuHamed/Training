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

function displayQuestion($pdo, $questions,$show) {

    echo '<div class="container-quiz">';
    echo '<form method="post" action="../Controllers/cont_save_quiz.php">';
    echo '<input type="text" name="quiz-name" placeholder="Enter Quiz Name"/>';

    foreach ($questions as $question) {
        $questionID = ($show==1) ? $question['questionID'] : $question;
        $token=($show==1) ? 1 : 0;
        echo '<input type="hidden" name="token" value="' . $token . '" />';

        echo '<div class="question-design">';
        echo '<label for="question">Question:</label>';
        echo '<div class="question">';
        echo '<input type="text" name="questions[' . htmlspecialchars($questionID) . ']" value="' . htmlspecialchars($questionID) . '" readonly />';
        echo '</div>';

        $query = "SELECT * FROM answers WHERE questionID = :questionID ORDER BY RAND()";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':questionID', $questionID, PDO::PARAM_INT);
        $stmt->execute();
        $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<label id="choice" for="choices">Choices:</label>';
        echo '<div class="choices" id="choices-container">';
        foreach ($answers as $index => $answer) {

            $answerValue = htmlspecialchars($answer['answer']);
            $choiceName = "answers[$questionID]";

            echo '<div class="choice-input" data-choice="' . ($index + 1) . '">';
            echo '<input type="radio" name="' . $choiceName . '" value="' . $answerValue . '" style="display: none;"/>';
            echo '<span class="Q">' . $answerValue . '</span>';
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

function displayQuestionsOnly($pdo, $quizName, $questions,$quiz_id) {
    $name = json_decode($quizName, true);

    echo print_r($name,true);
    echo '<div class="container-quiz">';
    echo '<form method="post" action="../Controllers/cont_count_score.php">';
    echo '<div class="title">';
    echo '<input type="text" name="quiz-name" value="' . htmlspecialchars($name[0]['quizName']) . '" readonly />';
    echo '<input type="hidden" name="quiz_id" value="'.$quiz_id.'" />';
    echo '</div>';

    foreach ($questions as $question) {
        $questionID = $question['questionID'];

        echo '<div class="question-design">';
        echo '<label for="question">Question:</label>';
        echo '<div class="question">';
        $questionText = getQuestion($pdo, $questionID)[0]['question'];
        echo '<input type="text" name="questions[' . htmlspecialchars($questionID) . ']" value="' . htmlspecialchars($questionText) . '" readonly />';
        echo '</div>';

        $query = "SELECT * FROM answers WHERE questionID = :questionID ORDER BY RAND()";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':questionID', $questionID, PDO::PARAM_INT);
        $stmt->execute();
        $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<label id="choice" for="choices">Choices:</label>';
        echo '<div class="choices" id="choices-container">';
        foreach ($answers as $answer) {

            $answerValue = htmlspecialchars($answer['answer']);
            $answerID="answersIDs[". $answer['answerID'] ."]";
            $choiceName = "answers[" . $questionID . "]";

            echo '<div class="choice-input" data-choice="' . $answerID . '">';

            echo '<input type="hidden" name="'.$answerID.'"/>';

            echo '<input type="radio" name="' . $choiceName .
                    '" value="' . $answer['answerID'] .
                '" data-choice="' . $answer['answerID'] . '" />';

            echo '<span class="Q">' . $answerValue . '</span>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    }

    echo '<div class="submit">';
    echo '<input type="submit" value="Submit" />';
    echo '</div>';
    echo '</form>';
    echo '</div>';
}
function getQuestion($pdo,$questionID){
    $query="SELECT question FROM question WHERE questionID= :questionID";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':questionID', $questionID, PDO::PARAM_INT);
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result ;
}