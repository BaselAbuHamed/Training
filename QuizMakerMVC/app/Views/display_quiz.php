<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../classes/connect.php';
require_once '../Models/model_create_quiz.php';

if (!isset($_SESSION['email'])) {
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

<?php include("../classes/side_nav.php"); ?>

<?php
$pdo = db_connect();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(!isset($_POST["selected_questions"])){

        // Validate 'where' field
        $field = isset($_POST["where"]) ? trim($_POST["where"]) : null;
        if (empty($field)) {
            $response['status'] = "error";
            $response['message'] = "Please enter a value for 'where' field.";
            header("Location: create_quiz_random.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
            exit;
        }

        // Validate 'numQuestions' field
        $numberQuestion = isset($_POST["numQuestions"]) ? intval($_POST["numQuestions"]) : null;
        if ($numberQuestion <= 0) {
            $response['status'] = "error";
            $response['message'] = "Number of questions must be a positive integer.";
            header("Location: create_quiz_random.php?error_message=" . urlencode(json_encode($response)));
//        echo json_encode($response);
            exit;
        }

        $questions = SelectQuestionByField($pdo, $numberQuestion, $field);
        displayQuestion($pdo, $questions,1);

    }else{
        $choices =  $_POST["selected_questions"];
        displayQuestion($pdo,$choices,0);
    }
}
?>
</body>
</html>