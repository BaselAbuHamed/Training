<?php
require_once '../classes/connect.php';
require_once '../Models/model_previous_attempts.php';

//using this function to print previous attempts for student
function printPreviousAttempts($userID, $quizID) {
    // Establish a database connection using a function called db_connect().
    $pdo = db_connect();

    // Retrieve previous quiz attempts data for the given user and quiz ID using a function called getPreviousAttempts().
    $attempts = getPreviousAttempts($pdo, $userID, $quizID);

    // Start an HTML table to display the previous attempts.
    echo '<table>
            <thead>
                <tr>
                    <th>Date Attempted</th>
                    <th>Score</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';

    // Loop through each attempt in $attempts and display it in the table.
    foreach ($attempts as $attempt) {
        echo '<tr>
                <td>' . htmlspecialchars($attempt['date']) . '</td>
                <td>' . htmlspecialchars($attempt['score']) . '</td>
                <td><a class="show_attempts" href="./show_attempts.php?id=' . htmlspecialchars($attempt['userScoreID']) . '&quiz_id=' . $quizID . '">Show Attempts</a></td>
              </tr>';
    }

    // Close the table.
    echo '</tbody>
        </table>';
}

//using this function to print all previous attempts for
function printAllPreviousAttempts($quizID) {
    // Establish a database connection using a function called db_connect().
    $pdo = db_connect();

    // Retrieve previous quiz attempts data for the given user and quiz ID using a function called getPreviousAttempts().
    $attempts = getALlPreviousAttempts($pdo, $quizID);

    // Start an HTML table to display the previous attempts.
    echo '<table>
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Date Attempted</th>
                    <th>Score</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';

    // Loop through each attempt in $attempts and display it in the table.
    foreach ($attempts as $attempt) {
        echo '<tr>
                <td>' . htmlspecialchars($attempt['userName']) . '</td>
                <td>' . htmlspecialchars($attempt['date']) . '</td>
                <td>' . htmlspecialchars($attempt['score']) . '</td>
                <td><a class="show_attempts" href="./show_attempts.php?id=' . htmlspecialchars($attempt['userScoreID']) . '&quiz_id=' . $quizID . '">Show Attempts</a></td>
              </tr>';
    }

    // Close the table.
    echo '</tbody>
        </table>';
}