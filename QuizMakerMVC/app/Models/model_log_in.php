<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function login($pdo, $emailOrUsername, $password) {
    // Prepare the SQL statement to select user by email or username
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :emailOrUsername OR username = :emailOrUsername");
    $stmt->bindParam(':emailOrUsername', $emailOrUsername);

    // Execute the query
    $stmt->execute();

    // Fetch the user record
    $user = $stmt->fetch();

    // Verify the password
    if ($user && isset($user[3]) && md5($password) == $user[4]) {
        // Password is correct, store user information in session
        $_SESSION['userID'] = $user[0];
        $_SESSION['user_type'] = $user[1];
        $_SESSION['userName'] = $user[2];
        $_SESSION['email'] = $user[3];

        return true;
        exit();
    }
    return false;
}
?>


    }
    return false;
}
