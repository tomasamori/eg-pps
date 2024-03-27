<?php include ("../includes/header.php") ?>

<?php
$message = '';
$email = isset ($_POST['email']) ? $_POST['email'] : '';

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

require '../db.php';

$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$query = "SELECT email FROM user WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $query = "UPDATE user SET reset_token = ?, reset_token_expires_at = ? WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $token_hash, $expiry, $email);
    $stmt->execute();

    $mail = require '../mailer.php';

    $mail->setFrom($_ENV['MAILER_FROM_ADDRESS'], $_ENV['MAILER_FROM_NAME']);
    $mail->addAddress($email);
    $mail->Subject = 'Restablecer contraseña';
    if ($_ENV['ENVIRONMENT'] === 'development') {
        $mail->Body = <<<END

        Click <a href="http://{$_ENV['DEV_HOST']}/auth/reset_password.php?token=$token">aquí</a> para restablecer tu contraseña.

        END;
    } else {
        $mail->Body = <<<END

        Click <a href="http://{$_ENV['PRODUCTION_HOST']}/auth/reset_password.php?token=$token">aquí</a> para restablecer tu contraseña.

        END;
    }


    try {
        $mail->send();
    } catch (Exception $e) {
        $message = "No se pudo enviar el correo electrónico. Error: {$mail->ErrorInfo}";
        exit;
    }

    $message = "Se ha enviado un correo electrónico con instrucciones para restablecer la contraseña.";
} else {
    $message = "Se ha enviado un correo electrónico con instrucciones para restablecer la contraseña."; // For security reasons, we don't want to reveal if an email exists in the database
}
?>

<div class="container-fluid" style="background-image: url('../img/auth-bg.jpg'); background-size: cover;">
    <div class="row justify-content-center align-items-center" style="height: 80vh;">
        <div class="col-md-3">
            <div class="card card-body shadow-lg">
                <form id="reset_password_form" action="forgot_password.php" method="POST">
                    <div class="text-center">
                        <img src="../img/utn-logo.png" alt="Logo UTN" class="navbar-brand-img mt-4 mb-4 img-fluid"
                            style="max-height: 70px;">
                    </div>
                    <div class="form-group m-2">
                        <input type="email" name="email" class="form-control" placeholder="Ingrese su Email" autofocus
                            required>
                    </div>

                    <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty ($message)): ?>
                        <br>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-10">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= $message ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <input type="submit" class="btn btn-success btn-block mx-auto d-block mt-4" name="reset_password"
                        value="Recuperar Contraseña" id="reset_password_btn">
                </form>
            </div>
        </div>
    </div>
</div>

<?php include ("../includes/footer.php") ?>

<script>
    document.getElementById("reset_password_form").addEventListener("submit", function () {
        document.getElementById("reset_password_btn").disabled = true;
    });
</script>