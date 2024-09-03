<?php

$message = '';

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['token'])) {
        $token = $_GET['token'];
    } else {
        header("Location: ../index.php");
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
} else {
    die ("Método de solicitud no permitido");
}

require '../db.php';

$token_hash = hash("sha256", $token);

$query = "SELECT * FROM user WHERE reset_token = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $token_hash);
$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die ("Token inválido");
}

if (strtotime($user['reset_token_expires_at']) < time()) {
    die ("El token expiró");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (strlen($_POST['password']) < 8) {
            $message = "La contraseña debe tener al menos 8 caracteres";
        } elseif (!preg_match("/[a-z]/i", $_POST['password'])) {
            $message = "La contraseña debe contener al menos una letra";
        } elseif (!preg_match("/\d/", $_POST['password'])) {
            $message = "La contraseña debe contener al menos un número";
        } elseif ($_POST['password'] !== $_POST['password_confirmation']) {
            $message = "Las contraseñas no coinciden";
        } else {
            $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $query = "UPDATE user SET password = ?, reset_token = NULL, reset_token_expires_at = NULL WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $password_hash, $user['user_id']);
            $stmt->execute();

            $message = "Contraseña restablecida exitosamente. Redirigiendo...";
        }
    }
}

?>

<?php include ('../includes/header.php') ?>

<div class="container-fluid" style="background-image: url('../img/auth-bg.jpg'); background-size: cover;">
    <div class="row justify-content-center align-items-center" style="height: 80vh;">
        <div class="col-md-3">
            <div class="card card-body shadow-lg">
                <form id="reset_password_form" action="reset_password.php" method="POST">
                    <div class="text-center">
                        <div class="fs-5 fw-bold text-center mt-2 mb-4">
                            Recuperar Contraseña
                        </div>
                    </div>
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <div class="form-group m-3 mb-0 position-relative">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Nueva Contraseña" required>
                        <button type="button" id="togglePassword" class="btn btn-sm btn-outline-secondary position-absolute border-0 rounded-circle" style="right: 10px; top: 50%; transform: translateY(-50%);">
                            <i id="toggleIcon" class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-group m-3 mb-0 position-relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirmar Contraseña" required>
                        <button type="button" id="toggleConfirmPassword" class="btn btn-sm btn-outline-secondary position-absolute border-0 rounded-circle" style="right: 10px; top: 50%; transform: translateY(-50%);">
                            <i id="toggleConfirmIcon" class="fa-regular fa-eye"></i>
                        </button>
                    </div>

                    <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty ($message)): ?>
                        <br>
                        <?php if ($message === 'Contraseña restablecida exitosamente. Redirigiendo...'): ?>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-10">
                                    <div class="alert alert-success alert-dismissible fade show mb-2" role="alert">
                                        <?= $message ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-10">
                                    <div class="alert alert-warning alert-dismissible fade show mb-2" role="alert">
                                        <?= $message ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($message === 'Contraseña restablecida exitosamente. Redirigiendo...'): ?>
                        <script>
                            setTimeout(function () {
                                window.location.href = 'login.php';
                            }, 4000);
                        </script>
                    <?php endif; ?>
                    <br>

                    <input type="submit" class="btn btn-success btn-block mx-auto d-block green-btn" name="reset_password"
                        value="Recuperar Contraseña" id="reset_password_btn">
                </form>
            </div>
        </div>
    </div>
</div>

<?php include ('../includes/footer.php') ?>

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
    const confirmPassword = document.getElementById('password_confirmation');
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