<?php
include_once '../Controllers/cont_show_question.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['email'])) {
    $_SESSION['loginMessage'] = "Please log in to access this page.";
    header("Location: log_in.php");
    exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Quiz Questions and Correct Answers</title>
    <script
        src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet"
          href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
<?php include("../classes/side_nav.php"); ?>

<div class="tab">
    <div class="containerTabs">
        <a class="tabLinks" href="#mathematics" id="defaultOpen">Mathematics</a>
        <a class="tabLinks" href="#physics">Physics</a>
        <a class="tabLinks" href="#biology">Biology</a>
        <a class="tabLinks" href="#technology">Technology</a>
        <a class="tabLinks" href="#chemistry">Chemistry</a>
        <a class="tabLinks" href="#allQuestion">All Question</a>
    </div>
    <div id="mathematics" class="tabContent">
        <?php
        $field = getData("mathematics");
        if (empty($field)){
            echo '<div class="tittle">';
            echo "<h1>no question</h1>";
            echo '</div>';
        }else{
            printTable($field);
        }
        ?>
    </div>
    <div id="physics" class="tabContent">
        <?php
        $field = getData("physics");
        if (empty($field)){
            echo '<div class="tittle">';
            echo "<h1>no question</h1>";
            echo '</div>';
        }else{
            printTable($field);
        }
        ?>
    </div>
    <div id="biology" class="tabContent">
        <?php
        $field = getData("biology");
        if (empty($field)){
            echo '<div class="tittle">';
            echo "<h1>no question</h1>";
            echo '</div>';
        }else{
            printTable($field);
        }
        ?>
    </div>
    <div id="technology" class="tabContent">
        <?php
        $field = getData("technology");
        if (empty($field)){
            echo '<div class="tittle">';
            echo "<h1>no question</h1>";
            echo '</div>';
        }else{
            printTable($field);
        }
        ?>
    </div>
    <div id="chemistry" class="tabContent">
        <?php
        $field = getData("chemistry");
        if (empty($field)){
            echo '<div class="tittle">';
            echo "<h1>no question</h1>";
            echo '</div>';
        }else{
            printTable($field);
        }
        ?>
    </div>
    <div id="allQuestion" class="tabContent">
        <?php
        $field = getAllData();
        if (empty($field)){
            echo '<div class="tittle">';
            echo "<h1>no question</h1>";
            echo '</div>';
        }else{
            printTable($field);
        }
        ?>
    </div>
</div>
</body>
</html>