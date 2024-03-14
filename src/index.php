<?php session_start(); ?>
<?php include("includes/header.php") ?>

    <h1>
        <?php
            echo "Hola Mundo";
        ?>
    </h1>
    <a href="user/user.php">CRUD User</a>
    <br>
    <a href="career/career.php">CRUD Career</a>
<?php include("includes/footer.php") ?>