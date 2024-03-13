<?php session_start(); ?>
<?php

    include("../db.php");

    if(isset($_POST['user_create'])){
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $name = $_POST['name'];
        $career_id = $_POST['career_id'];

        $query = "INSERT INTO user (email, password, name, career_id, role_id) VALUES ('$email', '$password', '$name', '$career_id', '2')";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("La consulta ha fallado.");
        } 

        $_SESSION['message'] = 'Usuario guardado exitosamente.';
        $_SESSION['message_type'] = 'success';
        header("Location: user.php");
    }

?>