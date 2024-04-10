<?php
include "../db.php";

$id = $_GET['id'];

$sql = "SELECT * FROM document WHERE document_id = '$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $file = $row['path']; 
    $file_path = "../document/files/" . $file;

    // Verificar que el archivo exista en el servidor
    if (file_exists($file_path)) {
        // Enviar el archivo al navegador
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        readfile($file_path);
    } else {
        echo "El archivo no existe en el servidor.";
    }
} else {
    echo "El archivo no se encontró en la base de datos.";
}
?>
