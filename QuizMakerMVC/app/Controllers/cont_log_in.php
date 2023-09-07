<?php
require_once '../classes/connect.php';
require_once '../Models/model_log_in.php';
require_once '../classes/error_log.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailOrUsername = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['email'] = $emailOrUsername;

    // Check if the "Remember Me" checkbox is checked
    if (isset($_POST['remember'])) {
        // Set a cookie with the user's email/username and password (replace 3600 with the desired cookie expiration time)
        setcookie('email', $emailOrUsername, time() + 3600 * 60);
        setcookie('password', $password, time() + 3600 * 60);
    }

    // Check if the email/username and password are not empty
    if (empty($emailOrUsername) || empty($password)) {
        $response['status'] = "error";
        $response['message'] = "Please enter both email/username and password.";
        header("Location: ../Views/log_in.php?error_message=" . urlencode(json_encode($response)));
        exit;
    }

    try {
        $pdo = db_connect();

        // Attempt to log in using email/username and password
        $loginResult = login($pdo, $emailOrUsername, $password);

        if ($loginResult) {
            header("Location: ../../public/index.php");
        } else {
            $response['status'] = "error";
            $response['message'] = "Invalid email/username or password.";
            header("Location: ../Views/log_in.php?error_message=" . urlencode(json_encode($response)));
            exit;
        }
    } catch (PDOException $e) {
        // Handle any database connection errors
        die("Database Error: " . $e->getMessage());
    }
}
?>