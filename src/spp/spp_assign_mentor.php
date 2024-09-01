<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['spp_assign_mentor'])) {
    $spp_id = $_POST['spp_id'];
    $mentor_id = $_POST['mentor_id'];
    $supervisor_id = $_POST['supervisor_id'];

    $query = "SELECT student_id FROM spp_user WHERE spp_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $spp_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $student_id = $row['student_id'];

    if (!empty($spp_id) && !empty($mentor_id) && !empty($student_id)) {
        assignMentor($conn, $spp_id, $mentor_id, $student_id, $supervisor_id);

        header("Location: ../spp/spp_list.php?page_num=$_POST[page_num]");
        exit();
    } else {
        echo "Error: faltan datos para asignar el profesor.";
    }
}

function assignMentor($conn, $spp_id, $mentor_id, $student_id, $supervisor_id) {
    $query = "UPDATE spp_user SET mentor_id = ?, supervisor_id = ? WHERE spp_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $mentor_id, $supervisor_id, $spp_id);
    $stmt->execute();

    $query = "UPDATE spp SET status = 'En Curso' WHERE spp_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $spp_id);
    $stmt->execute();

    $query = "INSERT INTO notification (sender_id, receiver_id, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $message = "Se te ha asignado como profesor de una PPS";
    $sender_id = 1;
    $stmt->bind_param("iis", $sender_id, $mentor_id, $message);
    $stmt->execute();

    $query = "INSERT INTO notification (sender_id, receiver_id, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $message = "Se te ha asignado un profesor para tu PPS";
    $stmt->bind_param("iis", $sender_id, $student_id, $message);
    $stmt->execute();
}
?>
