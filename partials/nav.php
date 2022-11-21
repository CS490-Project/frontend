<?php if (is_logged_in()): ?> 
<nav class="topnav">
    <?php if (user_is_teacher()): ?> 
        <a href="<?= getURL("teacher/teacher_add_question.php"); ?>">Add Question</a>
        <a href="<?= getURL("teacher/teacher_create_exam.php"); ?>">Make Exam</a>
        <a href="<?= getURL("teacher/teacher_grade_exams.php"); ?>">Grade Exams</a>
        <!--<a href="teacher_release_exam.php">Release Exams</a>-->
        
    <?php endif; ?>
    <?php if (user_is_student()): ?> 
        <a href="<?= getURL("student/student_get_ungraded_exams.php"); ?>">Take Exam</a>
        <a href="<?= getURL("student/student_get_graded_exams.php"); ?>">Graded Exams</a>
    <?php endif; ?>
    <a href="<?= getURL("logout.php"); ?>">Logout</a>   
</nav>
<?php endif; ?>