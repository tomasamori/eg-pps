<?php
session_start();
include("../db.php");
include("../includes/header.php")
?>

<style>
    body {
        background-color: #f3f5fc;
    }

    .table {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table th {
        color: white;
        background-color: #3aa661;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f3f9;
    }

    .table th,
    .table td {
        width: 33.33%;
    }

    .btn-custom {
        background-color: #3aa661;
        color: white;
        border: none;
    }
</style>

<div class="container p-4">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-4">
                Listado de PPS
            </h2>
            <div class="card card-body">
                <div class="d-flex justify-content-end mb-4">
                    <a href="../spp/spp_report.php" class="btn btn-custom">Generador de Reportes</a>
                </div>
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th>Estudiante</th>
                            <th>Organización</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
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
                 LEFT JOIN user AS mentor ON spp_user.mentor_id = mentor.user_id;
                 ";
                        $result_spp = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($result_spp)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $row['student_name'] ?></td>
                                <td class="text-center"><?php echo $row['organization_name'] ?></td>
                                <td class="text-center"><?php echo $row['status'] ?></td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['spp_id']; ?>">
                                        Detalles
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal<?php echo $row['spp_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                <strong>PPs del alumno </strong><?php echo $row['student_name'] ?>
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="border p-3 mb-3">
                                                        <h5 class="mb-3">Datos de la organización</h5>
                                                        <strong>Organización</strong><br>
                                                        <?php echo $row['organization_name'] ?><br>
                                                        <strong>Email</strong><br>
                                                        <?php echo $row['organization_email'] ?><br>
                                                        <strong>Teléfono</strong><br>
                                                        <?php echo $row['organization_phone'] ?><br>
                                                        <strong>Dirección</strong><br>
                                                        <?php echo $row['organization_address'] ?><br>
                                                        <strong>Ciudad</strong><br>
                                                        <?php echo $row['organization_city'] ?><br>
                                                        <strong>Provincia</strong><br>
                                                        <?php echo $row['organization_state'] ?><br>
                                                        <strong>Código postal</strong><br>
                                                        <?php echo $row['organization_zip'] ?><br>

                                                        <strong>Fecha de inicio</strong><br>
                                                        <?php echo $row['start_date'] ?><br>
                                                        <strong>Estado</strong><br>
                                                        <?php echo $row['status'] ?><br>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="border p-3 mb-3">
                                                        <h5 class="mb-3">Datos del alumno</h5>
                                                        <strong>Nombre</strong><br>
                                                        <?php echo $row['student_name'] ?><br>
                                                        <strong>Email</strong><br>
                                                        <?php echo $row['student_email'] ?><br>
                                                    </div>
                                                    <div class="border p-3 mb-3">
                                                        <h5 class="mb-3">Datos del Profesor</h5>
                                                        <strong>Alumno</strong><br>
                                                        <?php echo $row['supervisor_name'] ?><br>
                                                        <strong>Email</strong><br>
                                                        <?php echo $row['supervisor_email'] ?><br>
                                                    </div>
                                                    <div class="border p-3 mb-3">
                                                        <h5 class="mb-3">Datos del Responsable</h5>
                                                        <strong>Alumno</strong><br>
                                                        <?php echo $row['mentor_name'] ?><br>
                                                        <strong>Email</strong><br>
                                                        <?php echo $row['mentor_email'] ?><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php include("../includes/footer.php") ?>