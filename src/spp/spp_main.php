<?php
session_start();
include("../db.php");
include("../includes/header.php")
?>
<div class="container p-4 bg-light">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-body">
                <h2 class="text-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-clipboard2-pulse-fill" viewBox="0 0 16 16">
                        <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5" />
                        <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5M9.98 5.356 11.372 10h.128a.5.5 0 0 1 0 1H11a.5.5 0 0 1-.479-.356l-.94-3.135-1.092 5.096a.5.5 0 0 1-.968.039L6.383 8.85l-.936 1.873A.5.5 0 0 1 5 11h-.5a.5.5 0 0 1 0-1h.191l1.362-2.724a.5.5 0 0 1 .926.08l.94 3.135 1.092-5.096a.5.5 0 0 1 .968-.039Z" />
                    </svg>
                    Mis PPs
                </h2>
                <table class="table">
                    
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
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
                        COALESCE(supervisor.name, 'SIN ASIGNAR') AS supervisor_name, 
                        COALESCE(supervisor.email, 'SIN ASIGNAR') AS supervisor_email, 
                        COALESCE(mentor.name, 'SIN ASIGNAR') AS mentor_name, 
                        COALESCE(mentor.email, 'SIN ASIGNAR') AS mentor_email
                        FROM spp
                                LEFT JOIN spp_user ON spp.spp_id = spp_user.spp_id
                                LEFT JOIN user AS student ON spp_user.student_id = student.user_id
                                LEFT JOIN user AS supervisor ON spp_user.supervisor_id = supervisor.user_id
                                LEFT JOIN user AS mentor ON spp_user.mentor_id = mentor.user_id";
                                
                    // En caso de que el usuario esté logueado, se le muestran determinadas spp de acuerdo a su ROL
                    if (isset($_SESSION['user_id'])) {
                        $user_id= $_SESSION['user_id'];
                        $stmt = $conn->prepare('SELECT name FROM role WHERE role_id = ?');
                        $stmt->bind_param('i', $_SESSION['role_id']); // 'i' indica que el valor es un entero
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $results = $result->fetch_assoc();
                        $role_name = $results['name'];
                        
                        switch ($role_name) {
                            case 'Alumno':
                                $query.=" WHERE spp_user.student_id = '$user_id'";
                                break;
                            case 'Profesor':
                                $query.=" WHERE spp_user.mentor_id = '$user_id'";
                                break;
                            case 'Responsable':
                                $query .= "WHERE spp.status = 'unasigned' OR spp_user.supervisor_id = '$user_id'";
                                break;
                            default:
                                break;
                        }
                    }

                        $result_spp = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($result_spp)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $row['spp_id'] ?></td>
                                <td class="text-center"><?php echo $row['student_name'] ?></td>
                                <td class="text-center"><?php echo $row['organization_name'] ?></td>
                                <td class="text-center"><?php echo $row['status'] ?></td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['spp_id']; ?>">
                                        Detalles
                                    </button>
                                    <?php 
                                        
                                    if($role_name = 'Responsable' && $row['status'] = 'unasigned'): ?>
                                        
                                        <!-- solo aparecera este boton si el usuario es un Responsable' -->
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['spp_id']; ?>">Asignar Prof.</button>
                                    <?php endif; ?>
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
                <!-- En caso de que el usuario no tenga ninguna SPP creada asociada a su ID -->
                <?php if ($result_spp && mysqli_num_rows($result_spp) === 0): ?>
                    <div class="container mt-4">
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center">
                                <button class="btn btn-primary btn-lg btn-block" onclick="window.location.href = 'spp.php'">Nueva Solicitud</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php include("../includes/footer.php") ?>