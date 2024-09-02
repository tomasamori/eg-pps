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

if (isset($_POST['user_create'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $career_id = $_POST['career_id'];
    $role_id = $_POST['role_id'];

    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $query = "SELECT email FROM user WHERE email = ? AND deleted != 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $_POST['email']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $_SESSION['message'] = ' El correo electrónico ya está registrado';
            $_SESSION['message_type'] = 'warning';
            header("Location: user.php");
        } else {
            if (strlen($_POST['password']) < 8 || !preg_match('/[a-zA-Z]/', $_POST['password']) || !preg_match('/\d/', $_POST['password'])) {
                $_SESSION['message'] = 'La contraseña debe tener al menos 8 caracteres y contener al menos 1 letra y 1 número';
                $_SESSION['message_type'] = 'warning';
                header("Location: user.php");
            } else {
                $sql = "INSERT INTO user (email, password, name, career_id, role_id) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $stmt->bind_param('ssssi', $_POST['email'], $hashed_password, $_POST['name'], $_POST['career_id'], $role_id);
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Usuario guardado exitosamente';
                    $_SESSION['message_type'] = 'success';
                    header("Location: user.php");
                } else {
                    $message = 'Hubo un problema al crear tu cuenta';
                }
            }
        }
    }
} ?>  