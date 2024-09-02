<?php 
session_start();
include("../db.php");

if (isset($_POST['create'])) {
    extract($_POST);
    $correction = $_POST['correction'];
    $document_id = $_POST['document_id']; 
    
    // Actualizar la corrección en el documento
    $sql = "UPDATE document SET correction = '$correction' WHERE document_id = '$document_id'";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        // Obtener el spp_id y el tipo de documento para la notificación
        $query = "SELECT spp_id, type FROM document WHERE document_id = $document_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $spp_id = $row['spp_id'];
        $type = $row['type'];

        // Obtener el ID del estudiante asociado al spp_id
        $query = "SELECT student_id FROM spp_user WHERE spp_id = $spp_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $student_id = $row['student_id'];

        // Insertar la notificación en la tabla notification
        $query = "INSERT INTO notification (sender_id, receiver_id, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $message = "Se ha agregado una corrección al documento de tipo '$type' asociado a tu PPS con número de identificación $spp_id";
        $sender_id = 3;  
        $stmt->bind_param("iis", $sender_id, $student_id, $message);
        $stmt->execute();

        // Mensaje de éxito
        echo "<script language='JavaScript'>
        alert('Corrección registrada y notificación enviada');
        window.location.assign('document.php');
        </script>";
    } else {
        // Mensaje de error
        echo "<script language='JavaScript'>
        alert('Error al cargar la corrección');
        </script>";
    }
}
?>
