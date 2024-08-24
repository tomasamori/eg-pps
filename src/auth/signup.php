<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require '../db.php';

$message = '';

$emailValue = isset($_POST['email']) ? $_POST['email'] : '';
$passwordValue = isset($_POST['password']) ? $_POST['password'] : '';
$confirmPasswordValue = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
$nameValue = isset($_POST['name']) ? $_POST['name'] : '';
$careerIdValue = isset($_POST['career_id']) ? $_POST['career_id'] : '';

if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
    $query = "SELECT email FROM user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $message = 'El correo electrónico ya está registrado';
    } else {
        if (strlen($_POST['password']) < 8 || !preg_match('/[a-zA-Z]/', $_POST['password']) || !preg_match('/\d/', $_POST['password'])) {
            $message = 'La contraseña debe tener al menos 8 caracteres y contener al menos 1 letra y 1 número';
        } elseif ($_POST['password'] !== $_POST['confirm_password']) {
            $message = 'Las contraseñas no coinciden';
        } else {
            $query = "SELECT role_id FROM role WHERE name = 'Alumno'";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $role_id = $row['role_id'];

                $sql = "INSERT INTO user (email, password, name, career_id, role_id) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);

                $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                $stmt->bind_param('ssssi', $_POST['email'], $hashed_password, $_POST['name'], $_POST['career_id'], $role_id);

                if ($stmt->execute()) {
                    $message = 'Usuario creado exitosamente. Redirigiendo...';
                } else {
                    $message = 'Hubo un problema al crear tu cuenta';
                }
            } else {
                $message = 'No se encontró el rol "Alumno"';
            }
        }
    }
}

include('../includes/header.php'); ?>

<style>
    .green-btn {
        color: white;
        background-color: #3aa661;
        border-color: #3aa661;
    }

    .green-btn:hover {
        background-color: #49AD6D;
        border-color: #49AD6D;
    }

    .no-underline {
        text-decoration: none;
    }
</style>

<div class="container-fluid" style="background-image: url('../img/auth-bg.jpg'); background-size: cover;">
    <div class="row justify-content-center align-items-center mt-2 mb-2" style="min-height: 80vh;">
        <div class="col-md-3">
            <div class="card card-body text-center shadow-lg">
                <form action="signup.php" method="POST">
                    <div class="fs-5 fw-bold text-center mt-2 mb-4">
                        Crear un Usuario
                    </div>
                    <div class="form-group m-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" autofocus required
                            value="<?php echo $emailValue; ?>">
                    </div>
                    <div class="form-group m-3 mb-0 position-relative">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required value="<?php echo $passwordValue; ?>">
                        <button type="button" id="togglePassword" class="btn btn-sm btn-outline-secondary position-absolute border-0 rounded-circle" style="right: 10px; top: 50%; transform: translateY(-50%);">
                            <i id="toggleIcon" class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-group m-3 mb-0 position-relative">
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Repetir Contraseña" required value="<?php echo $confirmPasswordValue; ?>">
                        <button type="button" id="toggleConfirmPassword" class="btn btn-sm btn-outline-secondary position-absolute border-0 rounded-circle" style="right: 10px; top: 50%; transform: translateY(-50%);">
                            <i id="toggleConfirmIcon" class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-group m-3">
                        <input type="text" name="name" class="form-control" placeholder="Nombre y Apellido" required
                            value="<?php echo $nameValue; ?>">
                    </div>
                    <?php
                    $query = "SELECT * FROM career";
                    $result_career = mysqli_query($conn, $query);
                    ?>
                    <div class="form-group m-3 mb-0">
                        <select name="career_id" class="form-control" required>
                            <option value="">Seleccione una carrera</option>
                            <?php while ($row = mysqli_fetch_assoc($result_career)) { ?>
                                <option value="<?php echo $row['career_id']; ?>" <?php if ($row['career_id'] == $careerIdValue)
                                                                                        echo 'selected'; ?>>
                                    <?php echo $row['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php if (!empty($message)): ?>
                        <br>
                        <?php if ($message === 'Usuario creado exitosamente. Redirigiendo...'): ?>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-10">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?= $message ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-10">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <?= $message ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($message === 'Usuario creado exitosamente. Redirigiendo...'): ?>
                        <script>
                            setTimeout(function() {
                                window.location.href = 'login.php';
                            }, 4000);
                        </script>
                    <?php endif; ?>
                    <div class="form-group m-3">
                        <input type="submit" class="btn green-btn d-block w-100" name="signup" value="Registrarse">
                    </div>
                    <div class="text-center mb-3">
                        <p class="fs-6 mb-0">¿Ya tienes una cuenta? <a class="no-underline" href="login.php">Ingresar</a></p>
                    </div>
                </form>
            </div>
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

    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPassword = document.getElementById('confirm_password');
    const toggleConfirmIcon = document.getElementById('toggleConfirmIcon');

    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);

        if (type === 'password') {
            toggleConfirmIcon.classList.remove("fa-eye-slash");
            toggleConfirmIcon.classList.add("fa-eye");
        } else {
            toggleConfirmIcon.classList.remove("fa-eye");
            toggleConfirmIcon.classList.add("fa-eye-slash");
        }
    });
</script>

<?php include('../includes/footer.php'); ?>