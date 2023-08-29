<?php
?>
<div id="mySidenav" class="sidenav">
    <a href="/Internship/test/public/index.php" id="about">Add Question</a>
    <a href="/Internship/test/app/Views/show_question.php" id="blog">Show Question</a>
    <a href="#" id="projects">Create Quiz</a>
    <a href="#" id="contact">Contact</a>
    <?php if (!empty($_SESSION['loginMessage'])) : ?>
        <?php $response['status'] = "error";
        $response['message'] = $_SESSION['loginMessage'] ;
        header("Location: ../Views/log_in.php?error_message=" . urlencode(json_encode($response)));
        ?>
        <?php unset($_SESSION['loginMessage']); ?>
    <?php endif; ?>
</div>