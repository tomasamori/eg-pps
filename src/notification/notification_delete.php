<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_POST["notification_id"])) {

    require_once __DIR__ . '/../db.php';

    $notificationId = $_POST["notification_id"];

    $sql = "SELECT * FROM notification WHERE notification_id = ? AND receiver_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $notificationId, $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $sql_delete = "UPDATE notification SET deleted = 1 WHERE notification_id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $notificationId);

        if ($stmt_delete->execute()) {
            echo "success";
        } else {
            echo "error: Hubo un error al eliminar la notificación";
        }

        $stmt_delete->close();
    } else {
        echo "error: No tienes permiso para eliminar esta notificación";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "error: No se proporcionó el ID de la notificación";
}
?>
