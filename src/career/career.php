<?php
session_start();
include('../db.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $query = "SELECT role_id FROM role WHERE name = 'Administrador'";
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

include('../includes/header.php');

$results_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $results_per_page;

$query = "SELECT COUNT(*) AS total FROM career";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$total_results = $row['total'];
$total_pages = ceil($total_results / $results_per_page);

$query = "SELECT * FROM career ORDER BY career.career_id ASC LIMIT $start_from, $results_per_page";
$result_career = mysqli_query($conn, $query);
?>

<div class="container p-4">
    <div class="position-relative mb-4">
        <a href="../crud/crud.php" class="btn btn-outline-secondary position-absolute start-0">
            Volver
        </a>
        <div class="d-flex justify-content-center">
            <h1 class="m-0">Gestión de Carreras</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show alert-fixed crud-alert crud-alert-fixed" role="alert">
                    <?= $_SESSION['message'] ?>
                </div>
            <?php unset($_SESSION['message']);
            } ?>
            <div class="card crud-card text-center">
                <div class="card-header crud-card-header">
                    Nueva Carrera
                </div>
                <div class="card-body">
                    <form action="career_create.php" method="POST">
                        <div class="form-group m-2">
                            <input type="text" name="name" class="form-control" placeholder="Nombre de la carrera" required>
                        </div>
                        <br>
                        <input type="submit" class="btn btn-success green-btn btn-block mx-auto d-block" name="career_create" value="Crear Carrera">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Nombre de la Carrera</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($result_career)) { ?>
                        <tr class="text-center">
                            <td><?php echo $row['career_id'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td class="text-center">
                                <a href="career_update.php?career_id=<?php echo $row['career_id'] ?>" class="btn btn-outline-secondary btn-sm rounded-circle" role="button">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="career_delete.php?career_id=<?php echo $row['career_id'] ?>" class="btn btn-outline-danger btn-sm rounded-circle" role="button" onclick="return confirm('¿Estás seguro de que deseas eliminar esta carrera?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1) { ?>
                        <li class="page-item"><a class="page-link" href="career_management.php?page=<?php echo $page - 1; ?>">Anterior</a></li>
                    <?php } ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                            <a class="page-link" href="career_management.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>

                    <?php if ($page < $total_pages) { ?>
                        <li class="page-item"><a class="page-link" href="career_management.php?page=<?php echo $page + 1; ?>">Siguiente</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.classList.remove('show');
                alert.classList.add('fade');
            }, 3000);
        });
    });
</script>

<?php include("../includes/footer.php") ?>