<?php
session_start();
include("../db.php");
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
    
    </style>

    <div class="container p-4">
    <h2 class="text-center mb-4"> Gestión de Documentos </h2>
        <div class="row">
            <div class="col-md-12">

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
                            if ($role_student == $role_user) {
                                $query = "SELECT * from document WHERE spp_id='$spp_id'";
                            } elseif ($role_prof == $role_user) {
                                $query = "SELECT * from document INNER JOIN spp_user su ON '$user_id' = su.mentor_id";
                            }
                            $result_docs = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_array($result_docs)) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['type'] ?></td>
                                    <td class="text-center"><?php echo $row['status'] ?></td>
                                    <td class="text-center">
                                        <a href="../document/document_download.php?id=<?php echo $row['document_id']; ?> " style="text-decoration: none; color: inherit;">
                                            <button title="Descargar documento" class="btn bnt-secondary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                                                </svg>
                                            </button>
                                        </a>

                                        <?php if ($role_student == $role_user) { ?>
                                            <a><button class="btn bnt-secondary" data-bs-toggle="modal" data-bs-target="#correctionviewModal<?php echo $row['document_id']; ?>" title="Ver correcciones">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-journal-check" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                                        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                                                        <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                                                    </svg>
                                                </button>
                                            </a>
                                        <?php } elseif ($role_prof == $role_user) { ?>
                                            <a><button class="btn bnt-secondary" data-bs-toggle="modal" data-bs-target="#correctionModal<?php echo $row['document_id']; ?>" title="Agregar correcciones">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-journal-check" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                                        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                                                        <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                                                    </svg>
                                                </button>
                                            </a>
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

} else { ?>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <h1>Debe iniciar sesión para continuar</h1>
        <img src="../img/notFound.png" alt="Imagen" class="img-fluid">
    </div>
<?php
}
include("../includes/footer.php") ?>