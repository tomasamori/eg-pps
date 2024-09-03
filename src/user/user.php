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
    <h1 class="text-center mb-5">Gestión de Usuarios</h1>
    <div class="row">
        <div class="col-md-3">
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show alert-fixed crud-alert crud-alert-fixed" role="alert">
                    <?= $_SESSION['message'] ?>
                </div>
            <?php unset($_SESSION['message']);;
            } ?>
            <div class="card crud-card text-center">
                <div class="card-header crud-card-header">
                    Nuevo Usuario
                </div>
                <div class="card-body">
                    <form action="user_create.php" method="POST">
                        <div class="form-group m-2">
                            <input type="email" name="email" class="form-control" placeholder="Email" autofocus required>
                        </div>
                        <div class="form-group m-2 position-relative">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
                            <button type="button" id="togglePassword" class="btn btn-sm btn-outline-secondary position-absolute border-0 rounded-circle" style="right: 10px; top: 50%; transform: translateY(-50%);">
                                <i id="toggleIcon" class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-group m-2">
                            <input type="text" name="name" class="form-control" placeholder="Nombre y Apellido" required>
                        </div>
                        <?php
                        $query = "SELECT * FROM career";
                        $result_career = mysqli_query($conn, $query);
                        ?>
                        <div class="form-group m-2">
                            <select name="career_id" class="form-control" required>
                                <option value="">Selecciona una carrera</option>
                                <?php while ($row = mysqli_fetch_assoc($result_career)) { ?>
                                    <option value="<?php echo $row['career_id']; ?>"><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php
                        $query = "SELECT * FROM role";
                        $result_role = mysqli_query($conn, $query);
                        ?>
                        <div class="form-group m-2">
                            <select name="role_id" class="form-control" required>
                                <option value="">Seleccione un rol</option>
                                <?php while ($row = mysqli_fetch_assoc($result_role)) { ?>
                                    <option value="<?php echo $row['role_id']; ?>"><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <br>
                        <input type="submit" class="btn btn-success green-btn btn-block mx-auto d-block" name="user_create" value="Guardar Usuario">
                    </form>
                </div>
            </div>


        </div>
        <div class="col-md-9">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Email</th>
                        <th>Nombre y Apellido</th>
                        <th>Carrera</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT user.user_id, user.email, user.password, user.name, career.name AS career_name, role.name AS role_name FROM user INNER JOIN career ON user.career_id = career.career_id INNER JOIN role ON user.role_id = role.role_id WHERE user.deleted=0";
                    $result_users = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result_users)) { ?>
                        <tr>
                            <td><?php echo $row['user_id'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['career_name'] ?></td>
                            <td><?php echo $row['role_name'] ?></td>
                            <td class="text-center">
                                <a href="user_update.php?user_id=<?php echo $row['user_id'] ?>" class="btn btn-primary" role="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                                    </svg>
                                </a>
                                <a href="user_delete.php?user_id=<?php echo $row['user_id'] ?>" class="btn btn-danger" role="button" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
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
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        if (type === 'password') {
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        } else {
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        }
    });

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