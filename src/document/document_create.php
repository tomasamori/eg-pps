<?php session_start(); ?>
<?php

include("../db.php");

if (isset($_SESSION['user_id'])) { 
    $user_id = $_SESSION['user_id'];
    $query = "SELECT spp_id FROM spp_user WHERE student_id = $user_id";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $spp_id = $row['spp_id'];
        }

    if (isset($_POST['create'])) {
    extract($_POST);
    $type = $_POST['type'];

    if ($type === 'Informe semanal') {
        $query = "SELECT COUNT(*) AS count FROM document WHERE type = 'Informe semanal' AND spp_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $spp_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $file_number = $row['count'] + 1;

        $file_name = "{$spp_id}_{$type}_{$file_number}.pdf";
    } else {
        // Forma el nombre del archivo para otros tipos de documentos
        $file_name = "{$spp_id}_{$type}.pdf";
    }

    // Definir la carpeta de destino
    $destination_folder = "../document/files/";

    // Obtener el nombre y la extensión del archivo
    $user_file = basename($_FILES["file"]["name"]);
    $extension = strtolower(pathinfo($user_file, PATHINFO_EXTENSION));

    // Validar la extensión del archivo
    if ($extension == "pdf") {

        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $destination_folder . $file_name)) {

            // Insertar la información del archivo en la base de datos
            $sql = "INSERT INTO document (path, type, spp_id) VALUES ('$file_name', '$type', '$spp_id')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<script language='JavaScript'>
                alert('Archivo Subido');
                window.location.assign('document.php');
                </script>";
            } else {
                echo "<script language='JavaScript'>
                alert('Error al subir el archivo');
                
                </script>";
            }
        } else {
            echo "<script language='JavaScript'>
            alert('Error al subir el archivo. ');
            
            </script>";
        }
    } else {
        echo "<script language='JavaScript'>
        alert('Solo se permiten archivos PDF, DOC y DOCX.');
       
        </script>";
    }
}
}
?>
