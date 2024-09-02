<?php
session_start();
ob_start();
include("../db.php");
include("../includes/header.php");

$year = isset($_GET['year']) ? $_GET['year'] : '';
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

function convertir_a_iso($text) {
    return iconv('UTF-8', 'ISO-8859-1', $text);
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, convertir_a_iso('PPs Asignadas'), 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFillColor(58, 166, 97);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(60, 10, convertir_a_iso('Estudiante'), 1, 0, 'C', true);
$pdf->Cell(60, 10, convertir_a_iso('Organización'), 1, 0, 'C', true);
$pdf->Cell(60, 10, convertir_a_iso('Estado'), 1, 1, 'C', true);
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

if ($status_filter == '1') {
    $query .= " AND (spp.status = 'En Curso' OR spp.status = 'Pendiente de aprobación')";
}

$result_spp = mysqli_query($conn, $query);

$pdf->SetTextColor(0, 0, 0);
while ($row = mysqli_fetch_array($result_spp)) {
    $pdf->Cell(60, 10, convertir_a_iso($row['student_name']), 1, 0, 'C');
    $pdf->Cell(60, 10, convertir_a_iso($row['organization_name']), 1, 0, 'C');
    $pdf->Cell(60, 10, convertir_a_iso($row['status']), 1, 1, 'C');
}

ob_end_clean(); 
$pdf->Output('D', convertir_a_iso('PPs_Asignadas.pdf'));
?>
