<?php
session_start();
include("../db.php");

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $query = "SELECT role_id FROM role WHERE name = 'Profesor'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_admin = $row['role_id'];
    }

    $query = "SELECT role_id FROM user WHERE user_id = '$user_id'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_user = $row['role_id'];
    }

    if ($role_user !== $role_admin) {
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT spp_id FROM spp_user WHERE student_id = $user_id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $spp_id = $row['spp_id'];
    }

    $query = "SELECT role_id FROM role WHERE name = 'Profesor'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_prof = $row['role_id'];
    }

    $query = "SELECT role_id FROM role WHERE name = 'Alumno'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_student = $row['role_id'];
    }

    $query = "SELECT role_id FROM user WHERE user_id = '$user_id'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_user = $row['role_id'];
    }

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

        .green-btn {
            color: white;
            background-color: #3aa661;
            border-color: #3aa661;
        }

        .green-btn:hover {
            background-color: #49AD6D;
            border-color: #49AD6D;
        }

        .alert-fixed-top-center {
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            width: auto;
            max-width: 90%;
        }
    </style>

    <div class="container p-4">
        <h2 class="text-center mb-4"> Gestión de Documentos </h2>
        <div class="row">
            <div class="col-md-12">
                <?php if (isset($_SESSION['message'])) { ?>
                    <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show alert-fixed-top-center" role="alert">
                        <?= $_SESSION['message'] ?>
                    </div>
                <?php unset($_SESSION['message']);
                } ?>
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th>Tipo de Documento</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SESSION['role_name'] == 'Alumno') {
                            $query = "SELECT * from document WHERE spp_id='$spp_id'";
                        } elseif (isset($_GET['spp_id'])) {
                            $spp_id = $_GET['spp_id'];
                            $query = "SELECT * from document WHERE spp_id='$spp_id'";
                        } else {
                            $query = "SELECT * from document";
                        }
                        $result_docs = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($result_docs)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $row['type'] ?></td>
                                <td class="text-center"><?php echo $row['status'] ?></td>
                                <td class="text-center">
                                    <a href="../document/document_download.php?id=<?php echo $row['document_id']; ?> " style="text-decoration: none; color: inherit;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle" title="Descargar documento">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </a>

                                    <?php if ($role_student == $role_user) { ?>
                                        <a><button type="button" class="btn btn-outline-secondary btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#correctionviewModal<?php echo $row['document_id']; ?>" title="Ver correcciones">
                                                <i class="fas fa-comment"></i>
                                            </button>
                                        </a>
                                    <?php } elseif ($role_prof == $role_user) { ?>
                                        <a><button type="button" class="btn btn-outline-secondary btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#correctionModal<?php echo $row['document_id']; ?>" title="Agregar correcciones">
                                                <i class="fas fa-comment"></i>
                                            </button>
                                        </a>
                                    <?php } ?>
                                    <?php if ($role_prof == $role_user) { ?>
                                        <form action="document_aprobation.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas aprobar este documento?');">
                                            <input type="hidden" name="document_id" value="<?php echo $row['document_id']; ?>">
                                            <button type="submit" class="btn btn-outline-secondary btn-sm rounded-circle" title="Aprobar documento"
                                                <?php echo ($row['status'] === 'Aprobado') ? 'disabled' : ''; ?>>
                                                <i class="fa-solid fa-circle-check"></i>
                                            </button>
                                        </form>
                                    <?php } ?>
                                </td>
                            </tr>
                            <!--MODAL DE VISUALIZACION DE CORRECCIONES-->
                            <div class="modal fade" id="correctionviewModal<?php echo $row['document_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                <?php echo $row['type'] ?>
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php if (!empty($row['correction'])) { ?>
                                                <strong>Correcciones: </strong>
                                                <?php echo $row['correction'] ?>
                                            <?php } else { ?>
                                                <p>Aún no hay correcciones</p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--MODAL DE CORRECCIONES-->
                            <div class="modal fade" id="correctionModal<?php echo $row['document_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                <?php echo $row['type'] ?>
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="document_correction.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <input type="hidden" name="document_id" value="<?php echo $row['document_id']; ?>">
                                                    <?php if (!empty($row['correction'])) { ?>
                                                        <p>Este documento ya tiene correcciones.</p>
                                                    <?php } else { ?>
                                                        <div class="form-group m-2">
                                                            <input type="text" name="correction" class="form-control" placeholder="Correcciones" autofocus required>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                                                    <?php if (empty($row['correction'])) { ?>
                                                        <button type="submit" class="btn btn-success btn-sm" id="document_create" name="create">Guardar</button>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </tbody>
                </table>

                <br>
                <!--MODAL DE CARGAR DOCUMENTO-->
                <?php if ($role_student == $role_user) { ?>
                    <div class="text-end">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Nuevo Documento
                        </button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Documento</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="document_create.php" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="form-group m-2">
                                                <select name="type" class="form-control" required>
                                                    <option value="">Selecciona el tipo de documento</option>
                                                    <option value="Plan de trabajo">Plan de trabajo</option>
                                                    <option value="Informe semanal">Informe semanal</option>
                                                    <option value="Informe final">Informe final</option>
                                                </select>
                                            </div>
                                            <div class="form-group m-2">
                                                <input type="file" name="file" id="file" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-success btn-sm" id="document_create" name="create">Guardar</button>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>


<?php

} ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                }, 500);
            }, 3000);
        });
    });
</script>

<?php include("../includes/footer.php") ?>