<?php 
session_start();
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

if (isset($_POST['create'])) {
    extract($_POST);
    $correction = $_POST['correction'];
    $document_id = $_POST['document_id']; 

    // Actualizar la corrección en el documento
    $sql = "UPDATE document SET correction = ? WHERE document_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $correction, $document_id);
    $result = $stmt->execute();

    if ($result) {
        // Obtener el spp_id y el tipo de documento para la notificación
        $query = "SELECT spp_id, type FROM document WHERE document_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $document_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $spp_id = $row['spp_id'];
        $type = $row['type'];

        // Obtener el ID del estudiante asociado al spp_id
        $query = "SELECT student_id FROM spp_user WHERE spp_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $spp_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $student_id = $row['student_id'];

        // Obtener el correo electrónico del estudiante
        $sql = "SELECT email FROM user WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $student_id);
        $stmt->execute();
        $user_result = $stmt->get_result();
        $user_row = $user_result->fetch_assoc();
        $student_email = $user_row['email'];

        // Insertar la notificación en la tabla notification
        $query = "INSERT INTO notification (sender_id, receiver_id, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $message = "Se ha agregado una corrección al documento de tipo '$type' asociado a tu PPS con número de identificación $spp_id";
        $sender_id = 3; 
        $stmt->bind_param("iis", $sender_id, $student_id, $message);
        $stmt->execute();

        // Enviar correo electrónico con la notificación
        $mail = require '../mailer.php';
        $mail->setFrom($_ENV['MAILER_FROM_ADDRESS'], $_ENV['MAILER_FROM_NAME']);
        $mail->addAddress($student_email);
        $mail->Subject = 'Nueva corrección en tu documento';

        $mail->Body = <<<END
        <html>
        <body>
            <p>Hola,</p>
            <p>Se ha agregado una nueva corrección al documento de tipo '$type' asociado a tu PPS con número de identificación $spp_id.</p>
        </body>
        </html>
        END;

        try {
            $mail->send();
            echo "<script language='JavaScript'>
            alert('Corrección registrada, notificación y correo enviados');
            window.location.assign('document.php?&spp_id=$spp_id');
            </script>";
        } catch (Exception $e) {
            echo "<script language='JavaScript'>
            alert('Corrección registrada pero no se pudo enviar el correo electrónico. Error: {$mail->ErrorInfo}');
            window.location.assign('document.php');
            </script>";
        }

    } else {
        echo "<script language='JavaScript'>
        alert('Error al cargar la corrección');
        </script>";
    }
}
?>
