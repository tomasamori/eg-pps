<?php session_start(); ?>
<?php 
    include("../db.php");
    if(isset($_POST['pps_create'])){
        $organization_name = $_POST['organization_name'];
        $organization_email = $_POST['organization_email'];
        $organization_phone = $_POST['organization_phone'];
        $organization_address = $_POST['organization_address'];
        $organization_city = $_POST['organization_city'];
        $organization_state = $_POST['organization_state'];
        $organization_zip = $_POST['organization_zip'];
        $start_date = date('Y-m-d');
        $status = "Pendiente de aprobación";
        $organization_contact = $_POST['organization_contact'];

        $sql = "INSERT INTO spp (organization_name, organization_email, organization_phone, organization_address, organization_city, organization_state, organization_zip, start_date, status, organization_contact) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssisss', $organization_name, $organization_email, $organization_phone, $organization_address, $organization_city, $organization_state, $organization_zip, $start_date, $status, $organization_contact);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'PPS registrada exitosamente. Redirigiendo...';
            header("Location: spp.php");
        } else {
            $message = 'Hubo un problema al crear tu PPS';
        }
    }
