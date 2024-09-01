<?php
session_start();
include("../db.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SESSION['role_name'] == 'Profesor') {
    function getTotalSPPs($conn)
    {
        $query = "SELECT COUNT(*) AS total FROM spp LEFT JOIN spp_user ON spp.spp_id = spp_user.spp_id WHERE spp_user.mentor_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    $spp_per_page = 6;
    $page_num = $_REQUEST['page_num'] ?? 1;
    $start = ($page_num - 1) * $spp_per_page;
    $total_spps = getTotalSPPs($conn);
    $total_pages = ceil($total_spps / $spp_per_page);

    $query = "SELECT spp.spp_id, spp.organization_name, spp.status, 
                 student.name AS student_name, 
                 student.email AS student_email, 
                 supervisor.name AS supervisor_name, 
                 supervisor.email AS supervisor_email, 
                 mentor.name AS mentor_name, 
                 mentor.email AS mentor_email
                FROM spp
                INNER JOIN spp_user ON spp.spp_id = spp_user.spp_id
                LEFT JOIN user AS student ON spp_user.student_id = student.user_id
                LEFT JOIN user AS supervisor ON spp_user.supervisor_id = supervisor.user_id
                LEFT JOIN user AS mentor ON spp_user.mentor_id = mentor.user_id
                WHERE spp_user.mentor_id = ?
                LIMIT ?, ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $_SESSION['user_id'], $start, $spp_per_page);
    $stmt->execute();
    $result_spp = $stmt->get_result();
} elseif ($_SESSION['role_name'] == 'Responsable' || $_SESSION['role_name'] == 'Administrador') {
    function getTotalSPPs($conn)
    {
        $query = "SELECT COUNT(*) AS total FROM spp";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    $spp_per_page = 6;
    $page_num = $_REQUEST['page_num'] ?? 1;
    $start = ($page_num - 1) * $spp_per_page;
    $total_spps = getTotalSPPs($conn);
    $total_pages = ceil($total_spps / $spp_per_page);

    $query = "SELECT spp.spp_id, spp.organization_name, spp.status, 
                 student.user_id AS student_id,
                 student.name AS student_name, 
                 student.email AS student_email, 
                 supervisor.name AS supervisor_name, 
                 supervisor.email AS supervisor_email,
                 mentor.user_id AS mentor_id,
                 mentor.name AS mentor_name,
                 mentor.email AS mentor_email
                FROM spp
                INNER JOIN spp_user ON spp.spp_id = spp_user.spp_id
                LEFT JOIN user AS student ON spp_user.student_id = student.user_id
                LEFT JOIN user AS supervisor ON spp_user.supervisor_id = supervisor.user_id
                LEFT JOIN user AS mentor ON spp_user.mentor_id = mentor.user_id
                LIMIT ?, ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $start, $spp_per_page);
    $stmt->execute();
    $result_spp = $stmt->get_result();
} else {
    header('Location: ../index.php');
    exit;
}

include("../includes/header.php");
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

    .pagination .page-link {
        color: white;
        background-color: #3aa661;
        border-color: #3aa661;
    }

    .pagination .page-item.active .page-link {
        color: #3aa661;
        background-color: white;
        border-color: #3aa661;
    }

    .pagination .page-link:hover {
        color: white;
        background-color: #2f8b4f;
        border-color: #2f8b4f;
    }
</style>

<div class="container mt-5">
    <h1 class="text-center mb-5">Prácticas Profesionales Supervisadas</h1>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover">
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
                    <?php while ($row = $result_spp->fetch_assoc()) { ?>
                        <tr class="align-middle">
                            <td class="text-center"><?php echo htmlspecialchars($row['spp_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['student_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['organization_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-end">
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal<?php echo $row['spp_id']; ?>" title="Detalles">
                                    <i class="fas fa-info-circle"></i>
                                </button>

                                <a href="../document/document.php?spp_id=<?php echo $row['spp_id']; ?>" class="btn btn-outline-secondary btn-sm" role="button" title="Documentos">
                                    <i class="fas fa-file-alt"></i>
                                </a>

                                <?php if (($_SESSION['role_name'] == 'Responsable' || $_SESSION['role_name'] == 'Administrador') && (is_null($row['mentor_id']))) : ?>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#assignMentorModal<?php echo $row['spp_id']; ?>" title="Asignar Profesor">
                                        <i class="fas fa-user-plus"></i>
                                        </a>
                                    <?php endif; ?>

                            </td>
                        </tr>

                        <div class="modal fade" id="detailModal<?php echo $row['spp_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                            <strong>PPS del alumno <?php echo htmlspecialchars($row['student_name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="border p-3 mb-3">
                                                    <h5 class="mb-3">Datos de la organización</h5>
                                                    <strong>Organización</strong><br>
                                                    <?php echo htmlspecialchars($row['organization_name'], ENT_QUOTES, 'UTF-8'); ?><br>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="border p-3 mb-3">
                                                    <h5 class="mb-3">Datos del alumno</h5>
                                                    <strong>Nombre</strong><br>
                                                    <?php echo htmlspecialchars($row['student_name'], ENT_QUOTES, 'UTF-8'); ?><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="assignMentorModal<?php echo $row['spp_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                            <strong>Asignar Profesor</strong>
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="spp_assign_mentor.php" method="POST">
                                        <div class="modal-body text-center">
                                            <input type="hidden" name="spp_id" value="<?php echo $row['spp_id']; ?>">
                                            <input type="hidden" name="supervisor_id" value="<?php echo $_SESSION['user_id']; ?>">
                                            <input type="hidden" name="page_num" value="<?php echo $page_num; ?>">
                                            <div class="form-group m-2">
                                                <select name="mentor_id" class="form-control" required>
                                                    <option value="">Seleccione un profesor</option>
                                                    <?php
                                                    $query = "SELECT role_id FROM role WHERE name = 'Profesor'";
                                                    $result_role = mysqli_query($conn, $query);
                                                    $role_prof = mysqli_fetch_assoc($result_role);

                                                    $student_id = $row['student_id'];
                                                    $query = "SELECT career_id FROM user WHERE user_id = ?";
                                                    $stmt = $conn->prepare($query);
                                                    $stmt->bind_param("i", $student_id);
                                                    $stmt->execute();
                                                    $result_career = $stmt->get_result();
                                                    $student_career = $result_career->fetch_assoc()['career_id'];

                                                    $query = "
                                                            SELECT u.user_id, u.name 
                                                            FROM user u 
                                                            LEFT JOIN (
                                                                SELECT mentor_id, COUNT(*) AS pps_count 
                                                                FROM spp_user
                                                                INNER JOIN spp ON spp_user.spp_id = spp.spp_id 
                                                                WHERE spp.status = 'En Curso' 
                                                                GROUP BY mentor_id
                                                            ) pps ON u.user_id = pps.mentor_id 
                                                            WHERE u.role_id = ? 
                                                            AND u.career_id = ? 
                                                            AND (pps.pps_count < 10 OR pps.pps_count IS NULL)";

                                                    $stmt = $conn->prepare($query);
                                                    $stmt->bind_param("ii", $role_prof['role_id'], $student_career);
                                                    $stmt->execute();
                                                    $result_mentor = $stmt->get_result();

                                                    while ($row_mentor = mysqli_fetch_assoc($result_mentor)) {
                                                    ?>
                                                        <option value="<?php echo $row_mentor['user_id']; ?>"><?php echo $row_mentor['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-success" name="spp_assign_mentor">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>



                    <?php } ?>
                </tbody>
            </table>

            <ul class="pagination justify-content-center pb-5 pt-5 mb-0">
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php if ($i == $page_num) echo 'active'; ?>">
                        <a class="page-link" href="?page_num=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>