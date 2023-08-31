<?php
?>
<div id="mySidenav" class="sidenav">
    <a href="/Internship/QuizMakerMVC/public/index.php" id="about">Add Question</a>
    <a href="/Internship/QuizMakerMVC/app/Views/show_question.php" id="blog">Show Question</a>
    <a href="/Internship/QuizMakerMVC/app/Views/create_quiz.php" id="projects">Create Quiz</a>
    <a href="/Internship/QuizMakerMVC/app/Views/show_quizzes.php" id="contact">Show Quizzes</a>
    <?php if (!empty($_SESSION['loginMessage'])) : ?>
        <?php $response['status'] = "error";
        $response['message'] = $_SESSION['loginMessage'] ;
        header("Location: ../Views/log_in.php?error_message=" . urlencode(json_encode($response)));
        ?>
        <?php unset($_SESSION['loginMessage']); ?>
    <?php endif; ?>
</div>