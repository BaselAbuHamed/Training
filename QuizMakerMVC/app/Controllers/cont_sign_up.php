<?php
include_once '../classes/connect.php';
include_once '../Models/model_sign_up.php';

// Define variables and set to empty values
$username = $email = $password = $confirmPassword = "";
$usernameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";

$pdo=db_connect();

// Function to sanitize user input
function sanitizeInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate username
    if (empty($_POST["username"])) {
        $response['status'] = "error";
        $response['message'] = "Username is required";
        header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
        exit;

    } else {
        $username = sanitizeInput($_POST["username"]);
        // Check if the username is valid (e.g., alphanumeric with underscores)
        if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
            $response['status'] = "error";
            $response['message'] = "Invalid username format";
            header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
            exit;

        }
    }

    // Validate email
    if (empty($_POST["email"])) {
        $response['status'] = "error";
        $response['message'] = "Email is required";
        header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
        exit;

    } else {
        $email = sanitizeInput($_POST["email"]);
        // Check if the email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['status'] = "error";
            $response['message'] = "Invalid email format";
            header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
            exit;

        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $response['status'] = "error";
        $response['message'] = "Password is required";
        header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
        exit;

    } else {
        $password = sanitizeInput($_POST["password"]);
        // Check if the password meets the requirements (e.g., minimum length)
        if (strlen($password) <= 8) {
            $response['status'] = "error";
            $response['message'] = "Password must be at least 8 characters long";
            header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
            exit;
        }
    }

    // Validate confirm password
    if (empty($_POST["confirm_password"])) {
        $response['status'] = "error";
        $response['message'] = "Please confirm your password";
        header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
        exit;
    } else {
        $confirmPassword = sanitizeInput($_POST["confirm_password"]);
        // Check if the confirm password matches the password
        if ($confirmPassword !== $password) {
            $response['status'] = "error";
            $response['message'] = "Passwords do not match";
            header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
            exit;
        }
    }

    //CHECK IF EMAIL IS UNIQUE
    if (!validateEmail($pdo,$_POST['email'])) {

        insertUser($pdo,$username,$email,$password);

        $response['status'] = "success";
        $response['message'] = "created account successfully";
        header("Location: ../Views/sign_up.php?success_message=" . urlencode(json_encode($response)));
        //        echo json_encode($response);
        exit;

    } else {
        $response['status'] = "error";
        $response['message'] = "Email already exists";
        header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));

        //        echo json_encode($response);
        exit;

    }
}
