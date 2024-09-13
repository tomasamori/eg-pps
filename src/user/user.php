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

$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

$query_count = "SELECT COUNT(*) AS total FROM user WHERE deleted=0";
$result_count = mysqli_query($conn, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_users = $row_count['total'];
$total_pages = ceil($total_users / $items_per_page);

$query = "SELECT user.user_id, user.email, user.password, user.name, career.name AS career_name, role.name AS role_name 
          FROM user 
          INNER JOIN career ON user.career_id = career.career_id 
          INNER JOIN role ON user.role_id = role.role_id 
          WHERE user.deleted=0
          ORDER BY user.user_id ASC 
          LIMIT $offset, $items_per_page";
$result_users = mysqli_query($conn, $query);
?>

<div class="container mt-5">
    <div class="position-relative mb-4">
        <a href="../crud/crud.php" class="btn btn-outline-secondary position-absolute start-0">
            Volver
        </a>
        <div class="d-flex justify-content-center">
            <h1 class="m-0">Gestión de Usuarios</h1>
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
                <div class="card-header crud-card-header">Nuevo Usuario</div>
                <div class="card-body">
                    <form action="user_create.php" method="POST">
                        <div class="form-group m-2">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
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
                    <?php while ($row = mysqli_fetch_array($result_users)) { ?>
                        <tr>
                            <td><?php echo $row['user_id'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['career_name'] ?></td>
                            <td><?php echo $row['role_name'] ?></td>
                            <td class="text-center">
                                <a href="user_update.php?user_id=<?php echo $row['user_id'] ?>&page=<?php echo $page?>" class="btn btn-outline-secondary btn-sm rounded-circle" role="button">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="user_delete.php?user_id=<?php echo $row['user_id'] ?>&page=<?php echo $page?>" class="btn btn-outline-danger btn-sm rounded-circle" role="button" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <nav class="mt-4" aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Anterior</a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Siguiente</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>

<?php include('../includes/footer.php'); ?>