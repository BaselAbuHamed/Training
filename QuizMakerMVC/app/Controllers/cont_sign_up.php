<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../classes/connect.php';
require_once '../Models/model_sign_up.php';

$pdo=db_connect();

// Function to sanitize user input
function sanitizeInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $_SESSION['username'] = isset($_POST["username"]) ? $_POST["username"] : null;
    $_SESSION['email']  = isset($_POST["email"]) ? $_POST["email"] : null;
    $_SESSION['selected_type'] = isset($_POST["type"]) ? $_POST["type"] : null;
    $_SESSION['password'] = isset($_POST["password"]) ? $_POST["password"] : null;
    $_SESSION['confirm_password']=isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : null;

    // Validate if username empty
    if (empty($_POST["username"])) {
        $response['status'] = "error";
        $response['message'] = "Username is required";
        header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
        exit;

    }
    //validate if username write with correct format
    else {
        $username = sanitizeInput($_POST["username"]);
        // Check if the username is valid (e.g., alphanumeric with underscores)
        if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
            $response['status'] = "error";
            $response['message'] = "Invalid username format";
            header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
            exit;
        }
    }

    // Validate if email empty
    if (empty($_POST["email"])) {
        $response['status'] = "error";
        $response['message'] = "Email is required";
        header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
        exit;

    }
    //validate if email write with correct format
    else {
        $email = sanitizeInput($_POST["email"]);
        // Check if the email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['status'] = "error";
            $response['message'] = "Invalid email format";
            header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
            exit;
        }
    }

    // Validate if password empty
    if (empty($_POST["password"])) {
        $response['status'] = "error";
        $response['message'] = "Password is required";
        header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
        exit;
    }
    //validate if length for password is correct
    else {
        $password = sanitizeInput($_POST["password"]);
        // Check if the password meets the requirements (e.g., minimum length)
        if (strlen($password) <= 8) {
            $response['status'] = "error";
            $response['message'] = "Password must be at least 8 characters long";
            header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
            exit;
        }
    }

    // Check if either 'teacher' or 'student' radio button is selected
    if (isset($_POST["type"]) && ($_POST["type"] == "teacher" || $_POST["type"] == "student")) {
        $selectedType = $_POST["type"];
    } else {
        $response['status'] = "error";
        $response['message'] = "Please select an account type (Teacher or Student).";
        header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
        exit;
    }
    // Validate if confirm password is empty
    if (empty($_POST["confirm_password"])) {
        $response['status'] = "error";
        $response['message'] = "Please confirm your password";
        header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
        exit;
    }
    //validate if password is match
    else {
        $confirmPassword = sanitizeInput($_POST["confirm_password"]);
        // Check if the confirm password matches the password
        if ($confirmPassword !== $password) {
            $response['status'] = "error";
            $response['message'] = "Passwords do not match";
            header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
            exit;
        }
    }

    //CHECK IF user name IS UNIQUE
    if (!validateUserName($pdo,$username)){
        //CHECK IF EMAIL IS UNIQUE
        if (!validateEmail($pdo,$_POST['email'])) {

            insertUser($pdo,$username,$email,$password,$selectedType);

            unset($_SESSION['username']);
            unset($_SESSION['email']);
            unset($_SESSION['selected_type']);
            unset($_SESSION['password']);
            unset($_SESSION['confirm_password']);

            $response['status'] = "success";
            $response['message'] = "created account successfully";
            header("Location: ../Views/log_in.php?success_message=" . urlencode(json_encode($response)));
        } else {
            $response['status'] = "error";
            $response['message'] = "Email already exists";
            header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
        }
    }else {
        $response['status'] = "error";
        $response['message'] = "user name already exists";
        header("Location: ../Views/sign_up.php?error_message=" . urlencode(json_encode($response)));
    }
    exit;
}
