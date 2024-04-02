<?php

session_start();

if (isset ($_SESSION['user_id'])) {
    header('Location: ../index.php');
}

require '../db.php';

if (!empty ($_POST['email']) && !empty ($_POST['password'])) {
    $stmt = $conn->prepare('SELECT user_id, email, role_id, password FROM user WHERE email = ?');
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_assoc();

    $message = '';

    if ($results && password_verify($_POST['password'], $results['password'])) {
        $_SESSION['user_id'] = $results['user_id'];
        $_SESSION['role_id'] = $results['role_id'];
        header("Location: ../index.php");
    } else {
        $message = 'Credenciales inválidas';
    }
}

include ('../includes/header.php'); ?>

<?php if (!empty ($message)): ?>
    <p>
        <?= $message ?>
    </p>
<?php endif; ?>


<div class="container-fluid" style="background-image: url('../img/auth-bg.jpg'); background-size: cover;">
    <div class="row justify-content-center align-items-center" style="height: 80vh;">
        <div class="col-md-3">
            <div class="card card-body shadow-lg">
                <form action="login.php" method="POST">
                    <div class="text-center">
                        <img src="../img/utn-logo.png" alt="Logo UTN" class="navbar-brand-img mt-4 mb-4 img-fluid" style="max-height: 70px;">
                    </div>
                    <div class="form-group m-2">
                        <input type="email" name="email" class="form-control" placeholder="Email" autofocus required>
                    </div>
                    <div class="form-group m-2">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    </div>
                    <a class="ms-3 fs-6 fst-italic" href="forgot_password.php">Olvidé mi contraseña</a>
                    <input type="submit" class="btn btn-success btn-block mx-auto d-block mt-4" name="login" value="Ingresar">
                </form>
            </div>
        </div>
    </div>
</div>

<?php include ('../includes/footer.php'); ?>