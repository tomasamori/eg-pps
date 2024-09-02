<?php session_start(); ?>
<?php
include("../db.php"); 

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $query = "SELECT role_id FROM role WHERE name = 'Profesor'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_mentor = $row['role_id'];
    }

    $query = "SELECT role_id FROM user WHERE user_id = '$user_id'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_user = $row['role_id'];
    }

    if ($role_user !== $role_mentor) {
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_POST['document_id'])) {
    $document_id = $_POST['document_id'];
    $stmt = $conn->prepare("UPDATE document SET status = 'Aprobado' WHERE document_id = ?");
    $stmt->bind_param("i", $document_id);
    if ($stmt->execute()) {     
        $_SESSION['message'] = 'Documento aprobado';
        $_SESSION['message_type'] = 'success';
        header("Location: ../document/document.php");
    } else {
        $_SESSION['message'] = 'Error al aprobar el documento';
        $_SESSION['message_type'] = 'danger';
        header("Location: ../document/document.php");
    }
} else {

    $_SESSION['message'] = 'ID de documento no especificado';
    $_SESSION['message_type'] = 'danger';
    header("Location: ../document/document.php");
}
