<?php session_start(); ?>
<?php
include("../db.php");
if (isset($_POST['document_id'])) {
    $document_id = $_POST['document_id'];
    $stmt = $conn->prepare("UPDATE document SET status = 'Aprobado' WHERE document_id = ?");
    $stmt->bind_param("i", $document_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Documento aprobado';
        $_SESSION['message_type'] = 'success';

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

        // Insertar la notificación en la tabla notification
        $query = "INSERT INTO notification (sender_id, receiver_id, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $message = "El documento de tipo '$type' asociado a tu PPS con número de identificación $spp_id fue aprobado";
        $sender_id = 3;
        $stmt->bind_param("iis", $sender_id, $student_id, $message);
        $stmt->execute();

        header("Location: ../document/document.php?&spp_id=$spp_id");
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
