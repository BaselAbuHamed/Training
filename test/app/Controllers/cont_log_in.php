<?php
// Include necessary files
session_start();
include_once '../classes/connect.php';
include_once '../Models/model_log_in.php';

// Check if the user clicked on the logout link on the index.php page
if (isset($_GET['logout'])) {
    // Destroy the session
    session_destroy();
    // Redirect back to the index.php page
    header("Location: ../../public/index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['email'] = $email;

    // Check if the "Remember Me" checkbox is checked
    if (isset($_POST['remember'])) {
        // Set a cookie with the user's email and password (replace 3600 with the desired cookie expiration time)
        setcookie('email', $email, time() + 3600 * 60);
        setcookie('password', $password, time() + 3600 * 60);
    }

    // Check if the email and password are not empty
    if (empty($email) || empty($password)) {
        $response['status'] = "error";
        $response['message'] = "Please enter both email and password.";
        header("Location: ../Views/log_in.php?error_message=" . urlencode(json_encode($response)));
        exit();
    } else {
        // Validate the email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['status'] = "error";
            $response['message'] = "Invalid email format.";
            header("Location: ../Views/log_in.php?error_message=" . urlencode(json_encode($response)));
            exit();
        } else {
            try {
                // Establish a database connection using db_connect() function
                $pdo = db_connect();

                // Call the login() function and handle the result
                $loginResult = login($pdo, $email, $password);

                if ($loginResult) {
                    // Successful login, redirect to dashboard or appropriate page
                    header("Location: ../../public/index.php");
                } else {
                    // Invalid email or password
                    $response['status'] = "error";
                    $response['message'] = "Invalid email or password.";
                    header("Location: ../Views/log_in.php?error_message=" . urlencode(json_encode($response)));
                }
                exit();
            } catch (PDOException $e) {
                // Handle any database connection errors
                die("Database Error: " . $e->getMessage());
            }
        }
    }
}