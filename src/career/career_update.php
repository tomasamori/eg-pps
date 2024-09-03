<?php session_start(); ?>
<?php
include("../db.php");

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

if (isset($_GET['career_id'])) {
    $career_id = $_GET['career_id'];
    $query = "SELECT * FROM career WHERE career_id = $career_id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $name = $row['name'];
    }
}

if (isset($_POST['update'])) {
    $career_id = $_GET['career_id'];
    $name = $_POST['name'];

    $query = "UPDATE career SET name='$name' WHERE career_id = $career_id";
    mysqli_query($conn, $query);

    $_SESSION['message'] = 'Carrera editada exitosamente';
    $_SESSION['message_type'] = 'success';
    header("Location: career.php");
}
?>

<?php include("../includes/header.php") ?>
<div class="container-fluid" style="background-image: url('../img/auth-bg.jpg'); background-size: cover;">
    <div class="row justify-content-center align-items-center" style="height: 80vh;">
        <div class="col-md-4 mx-auto">
            <div class="card card-green text-center">
                <div class="card-header card-header-green">
                    Editar Carrera
                </div>
                <div class="card-body">
                    <form action="career_update.php?career_id=<?php echo $_GET['career_id']; ?>" method="POST">
                        <div class="form-group m-2">
                            <input type="text" name="name" value="<?php echo $name ?>" class="form-control" placeholder="Actualizar nombre de la Carrera" required>
                        </div>
                        <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                            <a href="./career.php" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button class="btn btn-success green-btn" name="update">
                                Editar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php") ?>