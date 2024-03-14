<?php session_start(); ?>
<?php
    include("../db.php");

    if(isset($_GET['career_id'])){
        $career_id = mysqli_real_escape_string($conn, $_GET['career_id']);
        $query = "DELETE FROM career WHERE career_id = $career_id";
        $result = mysqli_query($conn, $query);
        if (!$result){
           die("Error al eliminar la carrera" . mysqli_error($conn));     
        }

        $_SESSION['message'] = 'Carrera eliminada exitosamente';
        $_SESSION['message_type'] = 'danger';
        header("Location: career.php"); 
    }