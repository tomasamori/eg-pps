<?php session_start(); ?>
<?php 

    include("../db.php");

    if(isset($_POST['career_create'])){
        $name = $_POST['name'];

        $query = "INSERT INTO career (name) VALUES ('$name')";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("La consulta ha fallado");
        }
        $_SESSION['message'] = "Carrera guardada extosamente";
        $_SESSION['message_type'] = 'success';
        header("Location: career.php");
    }

?>