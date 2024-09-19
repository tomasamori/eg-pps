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

<div class="container mt-5">
    <h1 class="text-center mb-5">Portal Administrativo</h1>
    <div class="row">

        <div class="col-md-3 mb-4">
            <a href="../user/user.php" class="tile no-underline text-dark" role="button">
                <i class="fa-solid fa-users me-2"></i>
                <div>
                    <h5>Usuarios</h5>
                    <p></p>
                </div>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a class="tile no-underline text-dark" href="../career/career.php" role="button">
                <i class="fa-solid fa-graduation-cap me-2"></i>
                <div>
                    <h5>Carreras</h5>
                    <p></p>
                </div>
            </a>
        </div>

    </div>
</div>

<?php include('../includes/footer.php'); ?>