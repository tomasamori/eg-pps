<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    session_start();
    
    if (isset($_SESSION["user_id"])) {
        require_once __DIR__ . '/../db.php';

        $query = "UPDATE notification SET status = 'Leída' WHERE receiver_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_SESSION["user_id"]);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
        $stmt->close();
        $conn->close();
    }
} else {
    header("Location: ../index.php");
    exit();
}

?>
