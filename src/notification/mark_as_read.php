<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    
    if (isset($_SESSION["user_id"])) {
        if (isset($_POST["notification_id"])) {
            require_once __DIR__ . '/../db.php';

            $sql = "UPDATE notification SET status = 'Leída' WHERE notification_id = ? AND receiver_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $_POST["notification_id"], $_SESSION["user_id"]);

            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "Error al marcar la notificación como leída. Por favor, inténtalo de nuevo más tarde.";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Error: ID de notificación no especificado.";
        }
    } else {
        echo "Error: Usuario no autenticado.";
    }
} else {
    header("Location: ../index.php");
}
