
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Quiz Maker</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../../src/script.js" type="text/javascript"></script>
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

        <div class="login-container">
            <form action="../Controllers/cont_log_in.php" method="post">
                <div class="login-form">
                    <div class="tittle">
                        <h2>Log In</h2>
                    </div>
                    <div class="form-group">
                        <input type="text" name="email" placeholder="Email / User Name"
                            value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password"
                            placeholder="Password"
                            value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember Me</label>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Log In">
                    </div>
                    <div class="form-group">
                        <a href="./sign_up.php">Sign Up</a>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>