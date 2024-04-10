<?php session_start(); ?>
<?php

include("../db.php");

if (isset($_POST['create'])) {
    extract($_POST);
    $correction = $_POST['correction'];
    $document_id = $_POST['document_id']; 
    $sql = "UPDATE document SET correction = '$correction' WHERE document_id = '$document_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script language='JavaScript'>
        alert('Correccion registrada');
        window.location.assign('document.php');
        </script>";
    } else {
        echo "<script language='JavaScript'>
        alert('Error al cargar la correccion');
        </script>";
    }
} ?>