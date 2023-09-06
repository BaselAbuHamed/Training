
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Quiz Maker</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../src/script.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../../src/style.css" type="text/css" />
</head>
<body>
<?php include("../classes/header.php"); ?>

<?php
if (isset($_GET['error_message'])) {
    $error_message = json_decode(urldecode($_GET['error_message']), true);
    $status = $error_message['status'];
    $message = htmlspecialchars($error_message['message']);

    echo '<div class="error-message" id="hidden">';
    echo '<span class="closeBtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
    echo $message;
    echo '</div>';
}
?>

<?php
if (isset($_GET['success_message'])) {
    $success_message = json_decode(urldecode($_GET['success_message']), true);
    $status = $success_message['status'];
    $message = htmlspecialchars($success_message['message']);

    echo '<div class="success-message">';
    echo '<span class="closeBtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
    echo $message;
    echo '</div>';
}
?>

<div class="signup_container">
    <form action="../Controllers/cont_sign_up.php" method="post">
        <div class="tittle">
            <h2>Sign Up</h2>
        </div>
        <div class="registration-section">
            <?php
            $userName = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';
            ?>
            <input type="text" name="username" id="username"
                   class="registration-input" placeholder="User Name"
                   value="<?php echo $userName; ?>"
            />
        </div>
        <div class="registration-section">
            <?php
            $email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '';
            ?>
            <input type="text" name="email" id="email"
                   class="registration-input" placeholder="Email"
                   value="<?php echo $email; ?>"
            />
        </div>
        <div class="type-account">
            <?php
            $stuChecked = "";
            $teaChecked = "";

            if(isset($_SESSION['selected_type']) && !empty($_SESSION['selected_type'])) {
                if ($_SESSION['selected_type'] == "student") {
                    $stuChecked = "checked";
                } else if ($_SESSION['selected_type'] == "teacher") {
                    $teaChecked = "checked";
                }
            }
            ?>
            <label>Account type:</label>
            <div class="type">
                <input type="radio" name="type" id="teacher" class="registration-input" value="teacher" <?php echo $teaChecked; ?> />
                <label for="teacher">Teacher</label>
                <input type="radio" name="type" id="student" class="registration-input" value="student" <?php echo $stuChecked; ?> />
                <label for="student">Student</label>
            </div>
        </div>
        <div class="registration-section">
            <?php
            $password = isset($_SESSION['password']) ? htmlspecialchars($_SESSION['password']) : '';
            ?>
            <input type="password" name="password" id="password"
                   class="registration-input"
                   placeholder="Password" value="<?php echo $password; ?>"
            />
        </div>
        <div class="registration-section">
            <?php
            $confirmPassword = isset($_SESSION['confirm_password']) ? htmlspecialchars($_SESSION['confirm_password']) : '';
            ?>
            <input type="password" name="confirm_password"
                   id="confirm_password" class="registration-input"
                   placeholder="Confirm password" value="<?php echo $confirmPassword; ?>"
            />
        </div>
        <div class="submit">
            <input type="submit" value="Sign Up" />
        </div>
        <div class="registration-section">
            <a href="./log_in.php">Log In</a>
        </div>
    </form>
</div>
</body>
</html>