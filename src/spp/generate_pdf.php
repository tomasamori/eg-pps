<?php
session_start();
ob_start(); // Inicia el almacenamiento en buffer de la salida
include("../db.php");
include("../includes/header.php");

$year = isset($_GET['year']) ? $_GET['year'] : '';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'PPs Asignadas', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFillColor(58, 166, 97);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(60, 10, 'Estudiante', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Organizacion', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Estado', 1, 1, 'C', true);
$pdf->SetFont('Arial', 'B', 10);
$query = "SELECT spp.spp_id, 
            spp.organization_name, 
            spp.organization_email, 
            spp.organization_phone, 
            spp.organization_address, 
            spp.organization_city, 
            spp.organization_state, 
            spp.organization_zip, 
            spp.start_date, 
            spp.end_date, 
            spp.status, 
            student.name AS student_name, 
            student.email AS student_email, 
            supervisor.name AS supervisor_name, 
            supervisor.email AS supervisor_email, 
            mentor.name AS mentor_name, 
            mentor.email AS mentor_email
          FROM spp
          LEFT JOIN spp_user ON spp.spp_id = spp_user.spp_id
          LEFT JOIN user AS student ON spp_user.student_id = student.user_id
          LEFT JOIN user AS supervisor ON spp_user.supervisor_id = supervisor.user_id
          LEFT JOIN user AS mentor ON spp_user.mentor_id = mentor.user_id
          WHERE spp_user.mentor_id = $user_id";

if (!empty($year)) {
    $query .= " AND YEAR(spp.start_date) = $year";
}

$result_spp = mysqli_query($conn, $query);

$pdf->SetTextColor(0, 0, 0);
while ($row = mysqli_fetch_array($result_spp)) {
    $pdf->Cell(60, 10, $row['student_name'], 1, 0, 'C');
    $pdf->Cell(60, 10, $row['organization_name'], 1, 0, 'C');
    $pdf->Cell(60, 10, $row['status'], 1, 1, 'C');
}

ob_end_clean(); 
$pdf->Output('D', 'PPs_Asignadas.pdf');
?>
