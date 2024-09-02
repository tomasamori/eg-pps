<?php session_start();
include("../db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $query = "SELECT role_id FROM role WHERE name = 'Alumno'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_student = $row['role_id'];
    }

    $query = "SELECT role_id FROM user WHERE user_id = '$user_id'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_user = $row['role_id'];
    }

    if ($role_user !== $role_student) {
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_POST['organization_name']) && isset($_POST['organization_email']) && isset($_POST['organization_phone']) && isset($_POST['organization_address']) && isset($_POST['organization_city']) && isset($_POST['organization_state']) && isset($_POST['organization_zip']) && isset($_POST['organization_contact'])) {
    $organization_name = $_POST['organization_name'];
    $organization_email = $_POST['organization_email'];
    $organization_phone = $_POST['organization_phone'];
    $organization_address = $_POST['organization_address'];
    $organization_city = $_POST['organization_city'];
    $organization_state = $_POST['organization_state'];
    $organization_zip = $_POST['organization_zip'];
    $organization_contact = $_POST['organization_contact'];
    $start_date = date('Y-m-d');
    $status = "Sin Asignar";

    $sql = "INSERT INTO spp (organization_name, organization_email, organization_phone, organization_address, organization_city, organization_state, organization_zip, organization_contact, start_date, status) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssisss', $organization_name, $organization_email, $organization_phone, $organization_address, $organization_city, $organization_state, $organization_zip, $organization_contact, $start_date, $status);
    if ($stmt->execute()) {
        $spp_id = mysqli_insert_id($conn);
        $user_id = $_SESSION['user_id'];
        $query = "INSERT INTO spp_user (spp_id, student_id) VALUES ('$spp_id', '$user_id')";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die('Hubo un problema al crear tu PPS');
        } else {
            $_SESSION['message'] = 'Solicitud de PPS registrada exitosamente con número de identificación ' . $spp_id . '';

            $query = "SELECT role_id FROM role WHERE name = 'Responsable'";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $supervisor_role = $stmt->get_result();
            $supervisor_role_id = $supervisor_role->fetch_assoc()['role_id'];
            
            $query = "SELECT user.user_id FROM user WHERE user.role_id = " . $supervisor_role_id . " AND user.career_id = (SELECT u.career_id FROM user u WHERE u.user_id = " . $user_id .")";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $supervisor_list = $stmt->get_result();
            
            for ($i = 0; $i < $supervisor_list->num_rows; $i++) {
                $supervisor = $supervisor_list->fetch_assoc();
                $supervisor_id = $supervisor['user_id'];
                $query = "INSERT INTO notification (sender_id, receiver_id, message) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                $message = "Se ha registrado una nueva solicitud de PPS con número de identificación $spp_id";
                $sender_id = 1;
                $stmt->bind_param("iis", $sender_id, $supervisor_id, $message);
                $stmt->execute();
            }

            header("Location: spp.php");
        }
    } else {
        $message = 'Hubo un problema al crear tu PPS';
    }
}
