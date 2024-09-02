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

include('../includes/header.php'); ?>

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

    .card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        color: white;
        background-color: #3aa661;
        font-family: 'Arial', sans-serif;
        font-weight: bold;
        padding: 7px;
    }

    .btn-success {
        background-color: #3aa661;
        border-color: #3aa661;
    }

    .btn-success:hover {
        background-color: #339a4e;
        border-color: #339a4e;
    }

    .alert {
        opacity: 1;
        transition: opacity 0.5s ease-out;
        text-align: center;
    }

    .alert-fixed {
        position: fixed;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1050;
        width: auto;
        max-width: 80%;
    }
</style>

<div class="container p-4">
    <h1 class="text-center mb-5">Gestión de Carreras</h1>
    <div class="row">
        <div class="col-md-3">
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show alert-fixed" role="alert">
                    <?= $_SESSION['message'] ?>
                </div>
            <?php unset($_SESSION['message']);;
            } ?>
            <div class="card text-center">
            <div class="card-header">
                    Nueva Carrera
                </div>
            <div class="card-body">
                <form action="career_create.php" method="POST">
                    <div class="form-group m-2">
                        <input type="text" name="name" class="form-control" placeholder="Nombre de la carrera" required>
                    </div>
                    <br>
                    <input type="submit" class="btn btn-success btn-block mx-auto d-block" name="career_create" value="Crear Carrera">
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
                    <?php
                    $query = "SELECT * FROM career";
                    $result_career = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result_career)) { ?>
                        <tr class="text-center">
                            <td><?php echo $row['career_id'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td class="text-center">
                                <a href="career_update.php?career_id=<?php echo $row['career_id'] ?>" class="btn btn-primary" role="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                                    </svg>
                                </a>
                                <a href="career_delete.php?career_id=<?php echo $row['career_id'] ?>" class="btn btn-danger" role="button" onclick="return confirm('¿Estás seguro de que deseas eliminar esta carrera?');">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

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