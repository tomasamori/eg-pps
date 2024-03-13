<?php session_start(); ?>
<?php
    include("../db.php");

    if(isset($_GET['user_id'])){
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
        $query = "UPDATE user SET deleted = true WHERE user_id = '$user_id';";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Error al eliminar usuario: " . mysqli_error($conn)); 
        }
        
        $_SESSION['message'] = 'Usuario eliminado exitosamente';
        $_SESSION['message_type'] = 'danger';
        header("Location: user.php"); 
    }
?>
