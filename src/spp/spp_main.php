<?php
session_start();
include("../db.php");

$query = "SELECT spp.spp_id, 
                spp.organization_name, 
                spp.organization_email, 
                spp.organization_phone, 
                spp.organization_address, 
                spp.organization_city, 
                spp.organization_state, 
                spp.organization_zip, 
                spp.organization_contact,
                spp.start_date, 
                spp.end_date, 
                spp.status, 
                student.name AS student_name, 
                student.email AS student_email, 
                COALESCE(supervisor.name, 'Sin Asignar') AS supervisor_name, 
                COALESCE(supervisor.email, 'Sin Asignar') AS supervisor_email, 
                COALESCE(mentor.name, 'Sin Asignar') AS mentor_name, 
                COALESCE(mentor.email, 'Sin Asignar') AS mentor_email
            FROM spp
            LEFT JOIN spp_user ON spp.spp_id = spp_user.spp_id
            LEFT JOIN user AS student ON spp_user.student_id = student.user_id
            LEFT JOIN user AS supervisor ON spp_user.supervisor_id = supervisor.user_id
            LEFT JOIN user AS mentor ON spp_user.mentor_id = mentor.user_id";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare('SELECT name FROM role WHERE role_id = ?');
    $stmt->bind_param('i', $_SESSION['role_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_assoc();
    $role_name = $results['name'];

    switch ($role_name) {
        case 'Alumno':
            $query .= " WHERE spp_user.student_id = '$user_id'";
            break;
        case 'Profesor':
            $query .= " WHERE spp_user.mentor_id = '$user_id'";
            break;
        case 'Responsable':
            $query .= " WHERE spp.status = 'unasigned' OR spp_user.supervisor_id = '$user_id'";
            break;
        default:
            break;
    }
}

$result_spp = mysqli_query($conn, $query);

include("../includes/header.php");
?>

<?php
$spp_id = null;
$organization_name = $organization_email = $organization_phone = $organization_address = $organization_city = $organization_state = $organization_zip = $organization_contact = $start_date = $spp_status = $supervisor_name = $supervisor_email = $mentor_name = $mentor_email = '';

if ($role_name == 'Alumno') :
    if (mysqli_num_rows($result_spp) > 0) {
        $row = mysqli_fetch_assoc($result_spp);
        $spp_id = $row['spp_id'];
        $organization_name = $row['organization_name'];
        $organization_email = $row['organization_email'];
        $organization_phone = $row['organization_phone'];
        $organization_address = $row['organization_address'];
        $organization_city = $row['organization_city'];
        $organization_state = $row['organization_state'];
        $organization_zip = $row['organization_zip'];
        $organization_contact = $row['organization_contact'];
        $start_date = $row['start_date'];
        $spp_status = $row['status'];
        $supervisor_name = $row['supervisor_name'];
        $supervisor_email = $row['supervisor_email'];
        $mentor_name = $row['mentor_name'];
        $mentor_email = $row['mentor_email'];
    }

?>

    <style>
        body {
            background-color: #f3f5fc;
        }

        .tile {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 180px;
            border-radius: 10px;
            background: #ffffff;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: center;
            padding: 20px;
            overflow: hidden;
            /* Evita que el contenido se salga del tile */
        }

        /* Clase adicional para tiles clickeables */
        .tile.clickable {
            cursor: pointer;
        }

        .tile.clickable:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .tile h5 {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 10px 0;
            /* Ajuste del margen para evitar desbordamiento */
            text-align: center;
        }

        .tile p {
            font-size: 0.9rem;
            color: #6c757d;
            text-align: center;
            margin: 5px 0;
            /* Ajuste para mantener separación entre elementos */
        }

        .tile i {
            font-size: 20px;
            color: #3aa661;
            margin-bottom: 10px;
            /* Espacio entre el ícono y el encabezado */
        }

        /* Ajuste específico para pantallas entre 768px y 992px */
        @media (min-width: 768px) and (max-width: 992px) {
            .tile {
                padding: 15px;
                /* Ajuste de padding para pantallas medianas */
            }

            .tile i {
                display: none;
            }
        }
    </style>

    <div class="container mt-5">
        <h1 class="text-center mb-5">Prácticas Profesionales Supervisadas</h1>
        <div class="row">
            <div class="col-md-4 mb-4">
                <?php if ($spp_id != null) : ?>
                    <div class="tile clickable" data-bs-toggle="modal" data-bs-target="#startRequest">
                        <h5><i class="fa-solid fa-file-alt me-2"></i>Solicitud de Inicio</h5>
                        <p>Completá la Solicitud de Inicio para indicar los datos esenciales y empezar tus PPS.</p>
                    </div>
                <?php else : ?>
                    <div class="tile clickable" onclick="location.href='./spp.php';">
                        <h5><i class="fa-solid fa-file-alt me-2"></i>Solicitud de Inicio</h5>
                        <p>Completá la Solicitud de Inicio para indicar los datos esenciales y empezar tus PPS.</p>
                        <div class="badge">Nueva</div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4 mb-4">
                <?php if ($spp_id != null) : ?>
                    <div class="tile clickable" onclick="location.href='../document/document.php';">
                        <h5><i class="fa-solid fa-tasks me-2"></i>Documentos</h5>
                        <p>Subí todos los documentos necesarios para tu Práctica Profesional Supervisada en este espacio.</p>
                    </div>
                <?php else : ?>
                    <div class="tile" data-bs-toggle="modal" data-bs-target="#alertModal">
                        <h5><i class="fa-solid fa-tasks me-2"></i>Documentos</h5>
                        <p>Subí todos los documentos necesarios para tu Práctica Profesional Supervisada en este espacio.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4 mb-4">
                <?php if ($spp_id != null) : ?>
                    <div class="tile clickable" onclick="location.href='./spp_info.php';">
                        <h5><i class="fa-solid fa-circle-info me-2"></i>Información sobre Documentos</h5>
                        <p>Este espacio te guía sobre los requisitos, plazos y tipos de documentos que debes cargar.</p>
                    </div>
                <?php else : ?>
                    <div class="tile" data-bs-toggle="modal" data-bs-target="#alertModal">
                        <h5><i class="fa-solid fa-circle-info me-2"></i>Información sobre Documentos</h5>
                        <p>Este espacio te guía sobre los requisitos, plazos y tipos de documentos que debes cargar.</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <?php if (isset($_SESSION['message'])) { ?>
            <div class="d-flex flex-column align-items-center">
                <div class="alert alert-success alert-dismissible fade show mt-4 text-center" role="alert">
                    <?= $_SESSION['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <?php unset($_SESSION['message']);
            ?>
        <?php } ?>

    </div>

    <div class="modal fade" id="startRequest" tabindex="-1" aria-labelledby="startRequestLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #3aa661; color: white;">
                    <h5 class="modal-title" id="startRequestLabel">Solicitud de Inicio</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row">

                                    <dt class="col-sm-6">Nombre de la Organización:</dt>
                                    <dd class="col-sm-6"><?php echo htmlspecialchars($organization_name); ?></dd>

                                    <dt class="col-sm-6">Email:</dt>
                                    <dd class="col-sm-6"><?php echo htmlspecialchars($organization_email); ?></dd>

                                    <dt class="col-sm-6">Teléfono:</dt>
                                    <dd class="col-sm-6"><?php echo htmlspecialchars($organization_phone); ?></dd>

                                    <dt class="col-sm-6">Dirección:</dt>
                                    <dd class="col-sm-6"><?php echo htmlspecialchars($organization_address); ?></dd>

                                    <dt class="col-sm-6">Localidad:</dt>
                                    <dd class="col-sm-6"><?php echo htmlspecialchars($organization_city); ?></dd>

                                    <dt class="col-sm-6">Provincia:</dt>
                                    <dd class="col-sm-6"><?php echo htmlspecialchars($organization_state); ?></dd>

                                    <dt class="col-sm-6">Código Postal:</dt>
                                    <dd class="col-sm-6"><?php echo htmlspecialchars($organization_zip); ?></dd>

                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row">

                                    <dt class="col-sm-6">Persona de Contacto:</dt>
                                    <dd class="col-sm-6"><?php echo htmlspecialchars($organization_contact); ?></dd>

                                    <dt class="col-sm-6">Estado:</dt>
                                    <dd class="col-sm-6"><?php echo htmlspecialchars($spp_status); ?></dd>

                                    <dt class="col-sm-6">Nombre del Responsable:</dt>
                                    <dd class="col-sm-6"><?php echo htmlspecialchars($supervisor_name); ?></dd>

                                    <dt class="col-sm-6">Email del Responsable:</dt>
                                    <dd class="col-sm-6"><?php echo htmlspecialchars($supervisor_email); ?></dd>

                                    <dt class="col-sm-6">Nombre del Profesor:</dt>
                                    <dd class="col-sm-6"><?php echo htmlspecialchars($mentor_name); ?></dd>

                                    <dt class="col-sm-6">Email del Profesor:</dt>
                                    <dd class="col-sm-6"><?php echo htmlspecialchars($mentor_email); ?></dd>

                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de alerta -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #3aa661; color: #fff;">
                    <h5 class="modal-title" id="alertModalLabel">Aviso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Todavía no tienes una PPS en curso. Debes completar la solicitud de inicio.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

<?php else : ?>

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
                            <?php while ($row = mysqli_fetch_array($result_spp)) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['spp_id'] ?></td>
                                    <td class="text-center"><?php echo $row['student_name'] ?></td>
                                    <td class="text-center"><?php echo $row['organization_name'] ?></td>
                                    <td class="text-center"><?php echo $row['status'] ?></td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['spp_id']; ?>">
                                            Detalles
                                        </button>
                                        <?php if ($role_name == 'Responsable' && $row['status'] == 'Sin Asignar') : ?>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['spp_id']; ?>">Asignar Prof.</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <div class="modal fade" id="startRequest<?php echo $row['spp_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                            <strong>Fecha de finalización</strong><br>
                                                            <?php echo $row['end_date'] ?><br>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="border p-3 mb-3">
                                                            <h5 class="mb-3">Datos de contacto</h5>
                                                            <strong>Supervisor</strong><br>
                                                            <?php echo $row['supervisor_name'] ?><br>
                                                            <strong>Email del supervisor</strong><br>
                                                            <?php echo $row['supervisor_email'] ?><br>
                                                            <strong>Profesor guía</strong><br>
                                                            <?php echo $row['mentor_name'] ?><br>
                                                            <strong>Email del profesor guía</strong><br>
                                                            <?php echo $row['mentor_email'] ?><br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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

<?php endif; ?>


<!-- /*
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
                        <?php while ($row = mysqli_fetch_array($result_spp)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $row['spp_id'] ?></td>
                                <td class="text-center"><?php echo $row['student_name'] ?></td>
                                <td class="text-center"><?php echo $row['organization_name'] ?></td>
                                <td class="text-center"><?php echo $row['status'] ?></td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['spp_id']; ?>">
                                        Detalles
                                    </button>
                                    <?php if ($role_name == 'Responsable' && $row['status'] == 'Sin Asignar') : ?>
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['spp_id']; ?>">Asignar Prof.</button>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <div class="modal fade" id="startRequest<?php echo $row['spp_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                        <strong>Fecha de finalización</strong><br>
                                                        <?php echo $row['end_date'] ?><br>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="border p-3 mb-3">
                                                        <h5 class="mb-3">Datos de contacto</h5>
                                                        <strong>Supervisor</strong><br>
                                                        <?php echo $row['supervisor_name'] ?><br>
                                                        <strong>Email del supervisor</strong><br>
                                                        <?php echo $row['supervisor_email'] ?><br>
                                                        <strong>Profesor guía</strong><br>
                                                        <?php echo $row['mentor_name'] ?><br>
                                                        <strong>Email del profesor guía</strong><br>
                                                        <?php echo $row['mentor_email'] ?><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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

                                    */-->

<?php include("../includes/footer.php"); ?>