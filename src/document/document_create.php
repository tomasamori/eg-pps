<?php session_start(); ?>
<?php

include("../db.php");

if (isset($_POST['create'])) {
    extract($_POST);
    $type = $_POST['type'];

    // Definir la carpeta de destino
    $destination_folder = "../document/files/";

    // Obtener el nombre y la extensión del archivo
    $file_name = basename($_FILES["file"]["name"]);
    $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Validar la extensión del archivo
    if ($extension == "pdf" || $extension == "doc" || $extension == "docx") {

        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $destination_folder . $file_name)) {

            // Insertar la información del archivo en la base de datos
            $sql = "INSERT INTO document (path, type, spp_id) VALUES ('$file_name', '$type', '7')";
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

?>
