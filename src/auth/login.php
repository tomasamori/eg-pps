<?php

session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require '../db.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $stmt = $conn->prepare('SELECT user_id, email, role_id, password FROM user WHERE email = ?');
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_assoc();

    if ($results && password_verify($_POST['password'], $results['password'])) {
        $_SESSION['user_id'] = $results['user_id'];
        $_SESSION['role_id'] = $results['role_id'];
        header("Location: ../index.php");
        exit;
    } else {
        $message = "Credenciales inválidas";
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
    <div class="row justify-content-center align-items-center" style="height: 80vh;">
        <div class="col-md-3">
            <div class="card card-body shadow-lg">
                <form action="login.php" method="POST">
                    <div class="fs-5 fw-bold text-center mt-2 mb-4">
                        Inicio de Sesión
                    </div>
                    <div class="form-group m-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" autofocus required>
                    </div>
                    <div class="form-group m-3 mb-0 position-relative">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
                        <button type="button" id="togglePassword" class="btn btn-sm btn-outline-secondary position-absolute border-0 rounded-circle" style="right: 10px; top: 50%; transform: translateY(-50%);">
                            <i id="toggleIcon" class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <div class="text-center mt-2">
                        <a class="fs-6 no-underline" href="forgot_password.php">Restablecer contraseña</a>
                    </div>
                    <div class="form-group m-3">
                        <input type="submit" class="btn green-btn d-block w-100" name="login" value="Ingresar">
                    </div>
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
                            <?= $message ?>
                        </div>
                    <?php endif; ?>
                    <div class="text-center mb-3">
                        <p class="fs-6 mb-0">¿No tienes una cuenta? <a class="no-underline" href="signup.php">Regístrate aquí</a></p>
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
</script>

<?php include('../includes/footer.php'); ?>