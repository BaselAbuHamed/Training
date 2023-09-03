
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
            $message = $error_message['message'];

            echo '<div class="error-message" id="hidden">';
            echo '<span class="closeBtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
            echo htmlspecialchars($message);
            echo '</div>';
        }
        ?>
        <?php
        if (isset($_GET['success_message'])) {
            $success_message = json_decode(urldecode($_GET['success_message']), true);
            $status = $success_message['status'];
            $message = $success_message['message'];

            echo '<div class="success-message">';
            echo '<span class="closeBtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
            echo htmlspecialchars($message);
            echo '</div>';
        }
        ?>
        <?php include("../classes/side_nav.php"); ?>
        <div class="signup_container">
            <form action="../Controllers/cont_sign_up.php" method="post">
                <div class="tittle">
                    <h2>Sign Up</h2>
                </div>
                <div class="registration-section">
                    <input type="text" name="username" id="username"
                        class="registration-input" placeholder="User Name" />
                </div>
                <div class="registration-section">
                    <input type="text" name="email" id="email"
                        class="registration-input" placeholder="Email" />
                </div>
                <div class="registration-section">
                    <input type="password" name="password" id="password"
                        class="registration-input"
                        placeholder="Password" />
                </div>
                <div class="registration-section">
                    <input type="password" name="confirm_password"
                        id="confirm_password" class="registration-input"
                        placeholder="Confirm password" />
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