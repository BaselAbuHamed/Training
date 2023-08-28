<?php
session_start();
function login($pdo,$email,$password)
{
    // Prepare the SQL statement
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);

    // Execute the query
    $stmt->execute();

    // Fetch the user record
    $user = $stmt->fetch();

    // Verify the password
    if ($user && isset($user[3]) && md5($password) == $user[3]) {
        // Password is correct, store user information in session
        $_SESSION['userID'] = $user[0];
        $_SESSION['email'] = $user[2];
        $_SESSION['username'] = $user[1];

        // Redirect to the home page or any other page you desire
        return true;
        exit();
    }
    return false;
}
