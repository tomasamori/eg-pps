<?php session_start(); ?>
<?php
    include("../db.php");

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    
        $query = "SELECT role_id FROM role WHERE name = 'Administrador'";
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $role_admin = $row['role_id'];
        }
    
        $query = "SELECT role_id FROM user WHERE user_id = '$user_id'";
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $role_user = $row['role_id'];
        }
    
        if ($role_user !== $role_admin) {
            header("Location: ../index.php");
            exit();
        }
    } else {
        header("Location: ../auth/login.php");
        exit();
    } 

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