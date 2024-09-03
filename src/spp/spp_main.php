<?php

session_start();

include("../db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SESSION['role_name'] == 'Responsable' || $_SESSION['role_name'] == 'Profesor' || $_SESSION['role_name'] == 'Administrador') {
    header("Location: ./spp_list.php");
    exit();
}

if ($_SESSION['role_name'] == 'Alumno') {

    $user_id = $_SESSION['user_id'];

    $query = "SELECT
                spp.spp_id,
                spp.organization_name,
                spp.organization_email,
                spp.organization_phone,
                spp.organization_address,
                spp.organization_city,
                spp.organization_state,
                spp.organization_zip,
                spp.organization_contact,
                spp.start_date,
                spp.status,
                COALESCE(supervisor.name, 'Sin Asignar') AS supervisor_name,
                COALESCE(supervisor.email, 'Sin Asignar') AS supervisor_email,
                COALESCE(mentor.name, 'Sin Asignar') AS mentor_name,
                COALESCE(mentor.email, 'Sin Asignar') AS mentor_email
            FROM spp
            LEFT JOIN spp_user ON spp.spp_id = spp_user.spp_id
            LEFT JOIN user AS supervisor ON spp_user.supervisor_id = supervisor.user_id
            LEFT JOIN user AS mentor ON spp_user.mentor_id = mentor.user_id
            WHERE spp_user.student_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result_spp = $stmt->get_result();

    $spp_id = null;
    $organization_name = $organization_email = $organization_phone = $organization_address = $organization_city = $organization_state = $organization_zip = $organization_contact = $start_date = $spp_status = $supervisor_name = $supervisor_email = $mentor_name = $mentor_email = '';

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
} else {
    header("Location: ../index.php");
    exit();
}

include("../includes/header.php"); ?>

<div class="container mt-5">
    <h1 class="text-center mb-5">Prácticas Profesionales Supervisadas</h1>
    <div class="row">
        <div class="col-md-4 mb-4">
            <?php if ($spp_id != null) : ?>
                <div class="tile-spp-main clickable" data-bs-toggle="modal" data-bs-target="#startRequest">
                    <h5><i class="fa-solid fa-file-alt me-2"></i>Solicitud de Inicio</h5>
                    <p>Completá la Solicitud de Inicio para indicar los datos esenciales y empezar tus PPS.</p>
                </div>
            <?php else : ?>
                <div class="tile-spp-main clickable" onclick="location.href='./spp.php';">
                    <h5><i class="fa-solid fa-file-alt me-2"></i>Solicitud de Inicio</h5>
                    <p>Completá la Solicitud de Inicio para indicar los datos esenciales y empezar tus PPS.</p>
                    <div class="badge">Nueva</div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4 mb-4">
            <?php if ($spp_id != null && $mentor_name != 'Sin Asignar') : ?>
                <div class="tile-spp-main clickable" onclick="location.href='../document/document.php';">
                    <h5><i class="fa-solid fa-tasks me-2"></i>Documentos</h5>
                    <p>Subí todos los documentos necesarios para tu Práctica Profesional Supervisada en este espacio.</p>
                </div>
            <?php elseif ($mentor_name == 'Sin Asignar') : ?>
                <div class="tile-spp-main" data-bs-toggle="modal" data-bs-target="#professorAlertModal">
                    <h5><i class="fa-solid fa-tasks me-2"></i>Documentos</h5>
                    <p>Subí todos los documentos necesarios para tu Práctica Profesional Supervisada en este espacio.</p>
                </div>
            <?php else : ?>
                <div class="tile-spp-main" data-bs-toggle="modal" data-bs-target="#alertModal">
                    <h5><i class="fa-solid fa-tasks me-2"></i>Documentos</h5>
                    <p>Subí todos los documentos necesarios para tu Práctica Profesional Supervisada en este espacio.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4 mb-4">
            <?php if ($spp_id != null) : ?>
                <div class="tile-spp-main clickable" onclick="location.href='./spp_info.php';">
                    <h5><i class="fa-solid fa-circle-info me-2"></i>Información sobre Documentos</h5>
                    <p>Este espacio te guía sobre los requisitos, plazos y tipos de documentos que debes cargar.</p>
                </div>
            <?php else : ?>
                <div class="tile-spp-main" data-bs-toggle="modal" data-bs-target="#alertModal">
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

<div class="modal fade" id="professorAlertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3aa661; color: #fff;">
                <h5 class="modal-title" id="alertModalLabel">Aviso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Todavía no tienes un profesor asignado a tu PPS. Se te enviará una notificación cuando se te asigne uno.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>