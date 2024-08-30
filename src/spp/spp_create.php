<?php session_start();
include("../db.php");
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
            header("Location: spp.php");
        }
    } else {
        $message = 'Hubo un problema al crear tu PPS';
    }
}
