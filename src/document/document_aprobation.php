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
