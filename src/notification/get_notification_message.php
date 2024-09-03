<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION['user_id'])) {
        if (isset($_POST["notification_id"])) {
            require_once __DIR__ . '/../db.php';

            $sql = "SELECT message FROM notification WHERE notification_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_POST["notification_id"]);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo $row["message"];
            } else {
                echo "Error: Notificación no encontrada.";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Error: ID de notificación no especificado.";
        }
    }
} else {
    echo "Error: Método de solicitud no válido.";
}
