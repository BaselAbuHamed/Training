<?php
//session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['username']);
$username = '';

if ($isLoggedIn) {
    // Retrieve the username from the session
    $username = $_SESSION['username'];
}

// Logout functionality
if (isset($_GET['logout'])) {
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header("Location: ../../public/index.php");
    exit;
}
?>

<div class="menu_bar">
    <div class="logo">
        <img src="/QuizMakerMCV/src/images/quiz_logo.png" alt="Logo" width="100px" height="100px"/>
    </div>
    <div class="app-name">
        <p>Quiz
            <span>Maker</span>
        </p>
    </div>
    <div class="log_out">
        <?php if ($isLoggedIn) : ?>
            <a href="?logout=true">Log out</a>
        <?php endif; ?>
    </div>
</div>
