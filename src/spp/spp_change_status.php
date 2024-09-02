<?php
session_start();
include("../db.php");

if (!isset($_SESSION['role_name']) || ($_SESSION['role_name'] !== 'Profesor' && $_SESSION['role_name'] !== 'Responsable')) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['spp_id'], $_GET['status']) && !empty($_GET['spp_id']) && !empty($_GET['status'])) {
    $spp_id = mysqli_real_escape_string($conn, $_GET['spp_id']);
    $new_status = mysqli_real_escape_string($conn, $_GET['status']);
    $page_num = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;

    if (isset($_GET['student_id'], $_GET['mentor_id'], $_GET['supervisor_id'])) {
        $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);
        $mentor_id = mysqli_real_escape_string($conn, $_GET['mentor_id']);
        $supervisor_id = mysqli_real_escape_string($conn, $_GET['supervisor_id']);

        if ($new_status === 'Pendiente de Aprobación' || $new_status === 'Aprobada') {
            $sql = "UPDATE spp SET status = ? WHERE spp_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_status, $spp_id);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "El estado de la PPS ha sido actualizado exitosamente";

                $query = "INSERT INTO notification (sender_id, receiver_id, message) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                $message = "El estado de tu PPS ha sido actualizado a $new_status";
                $sender_id = 1;
                $stmt->bind_param("iis", $sender_id, $student_id, $message);
                $stmt->execute();
                $stmt->close();

                $receiver_id = ($new_status === 'Pendiente de Aprobación') ? $supervisor_id : $mentor_id;
                $message = "Se ha marcado la PPS $spp_id como $new_status";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
                $stmt->execute();
                $stmt->close();
            } else {
                $_SESSION['error_message'] = "Error al actualizar el estado de la PPS: " . mysqli_error($conn);
            }
            
            header("Location: spp_list.php?page_num=$page_num");
            exit();
        } else {
            $_SESSION['error_message'] = "Parámetros inválidos para actualizar el estado de la PPS.";
            header("Location: ../index.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Parámetros faltantes.";
        header("Location: spp_list.php?page_num=$page_num");
        exit();
    }

    mysqli_close($conn);
} else {
    $_SESSION['error_message'] = "Parámetros incompletos.";
    header("Location: ../index.php");
    exit();
}
