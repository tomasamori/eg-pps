<?php
include "../db.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $query = "SELECT role_id FROM role WHERE name = 'Administrador'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_admin = $row['role_id'];
    }

    $query = "SELECT role_id FROM role WHERE name = 'Profesor'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_mentor = $row['role_id'];
    }

    $query = "SELECT role_id FROM role WHERE name = 'Alumno'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_student = $row['role_id'];
    }

    $query = "SELECT role_id FROM role WHERE name = 'Responsable'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_supervisor = $row['role_id'];
    }

    $query = "SELECT role_id FROM user WHERE user_id = '$user_id'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_user = $row['role_id'];
    }

    if ($role_user !== $role_admin || $role_user !== $role_mentor || $role_user !== $role_student || $role_user !== $role_supervisor) {
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM document WHERE document_id = '$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $file = $row['path']; 
    $file_path = "../document/files/" . $file;

    // Verificar que el archivo exista en el servidor
    if (file_exists($file_path)) {
        // Enviar el archivo al navegador
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        readfile($file_path);
    } else {
        echo "El archivo no existe en el servidor.";
    }
} else {
    echo "El archivo no se encontró en la base de datos.";
}
?>
