<?php
function validateEmail($pdo,$email){
    // Check if email is unique
    $query = "SELECT * FROM user WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function validateUserName($pdo,$userName){
    // Check if user name is unique
    $query = "SELECT * FROM user WHERE userName = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userName]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insertUser($pdo, $username,$email, $password, $type ) {
    // Insert user data into the database
    // Prepare the INSERT statement
    $stmt = $pdo->prepare("INSERT INTO user (userName,  email, passward ,user_type ) VALUES (?,?,?,?)");

    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->bindParam(2, $email, PDO::PARAM_STR);
    $encryptedPassword = encryptPassword($password);
    $stmt->bindParam(3, $encryptedPassword, PDO::PARAM_STR);
    $stmt->bindParam(4, $type, PDO::PARAM_STR);

    if ($stmt->execute()) {
        return true; // Insert successful
    } else {
        return false; // Insert failed
    }
}
function encryptPassword($password) {
    // Hash the password using MD5
    return md5($password);
}