<?php
session_start(); // Start or resume the session

// Check if the user is logged in (you can implement your own authentication logic)
//if (!isset($_SESSION['user_id'])) {
//    header("Location: login.php"); // Redirect to the login page if not logged in
//    exit;
//}

// Include your database connection code here (e.g., $pdo)

// Retrieve previous quiz attempts for the logged-in user
$userID = $_SESSION['user_id'];
$query = "SELECT quizzes.quizName, quiz_attempts.date_attempted, quiz_attempts.score
          FROM quiz_attempts
          JOIN quizzes ON quiz_attempts.quizID = quizzes.quizID
          WHERE quiz_attempts.userID = :userID
          ORDER BY quiz_attempts.date_attempted DESC";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->execute();
$attempts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Previous Quiz Attempts</title>
    <!-- Add your CSS styling here -->
</head>
<body>
<h1>Previous Quiz Attempts</h1>

<?php if (empty($attempts)): ?>
    <p>No previous quiz attempts found.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Quiz Name</th>
            <th>Date Attempted</th>
            <th>Score</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($attempts as $attempt): ?>
            <tr>
                <td><?= htmlspecialchars($attempt['quizName']) ?></td>
                <td><?= htmlspecialchars($attempt['date_attempted']) ?></td>
                <td><?= htmlspecialchars($attempt['score']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>