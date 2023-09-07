<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../classes/connect.php';
require_once '../Models/model_show_attempts.php';
require_once '../Models/model_edit_question.php';


function printAttempts($userScoreID) {
    $pdo = db_connect();
    $attemptsData = getPreviousAttempts($pdo, $userScoreID);

    echo '<table>
            <thead>
                <tr>
                    <th>Question</th>
                    <th>User Selection</th>
                    <th>Correct Answer</th>
                </tr>
            </thead>
            <tbody>';

    // Loop through each attempt in $attemptsData and display it in the table.
    foreach ($attemptsData as $attempt) {
        echo '<tr>
                <td>' . htmlspecialchars($attempt['question']) . '</td>
                <td>' . htmlspecialchars($attempt['answer']) . '</td>
                <td>' . getCorrectAnswerValue(
                $pdo,
                htmlspecialchars($attempt['questionID']),
                htmlspecialchars($attempt['correctAnswer'])
            ) . '</td>
              </tr>';
    }
    echo '</tbody>
        </table>';
}