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

    if(isset($_POST['career_create'])){
        $name = $_POST['name'];

        if (!empty($_POST['name'])) {
            $query = "SELECT name FROM career WHERE name = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $_POST['name']);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result && $result->num_rows > 0) {
                $_SESSION['message'] = 'La carrera ya existe';
                $_SESSION['message_type'] = 'warning';
                header("Location: career.php");
            } else {


        $sql = "INSERT INTO career (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $_POST['name']);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Carrera guardada exitosamente';
            $_SESSION['message_type'] = 'success';
            header("Location: career.php");
        } else {
            $message = 'Hubo un problema al crear la carrera';
        }
    }
    }}
?>