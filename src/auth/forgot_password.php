<?php include("../includes/header.php") ?>

<?php
$message = '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

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
                <form id="reset_password_form" action="forgot_password.php" method="POST">
                    <div class="text-center">
                        <div class="fs-5 fw-bold text-center mt-2 mb-4">
                            Recuperar Contraseña
                        </div>
                    </div>

                    <?php if ($_SERVER["REQUEST_METHOD"] !== "POST"): ?>
                        <div class="form-group m-2">
                            <input type="email" name="email" class="form-control" placeholder="Ingrese su Email" autofocus required>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <a class="fs-6 no-underline" href="login.php">Volver</a>
                        </div>
                        <input type="submit" class="btn btn-success btn-block mx-auto d-block mt-3 green-btn" name="reset_password" value="Recuperar Contraseña" id="reset_password_btn">
                    <?php endif; ?>

                    <?php if (!empty($message) && $_SERVER["REQUEST_METHOD"] === "POST"): ?>
                        <div class="row d-flex flex-column align-items-center text-center">
                            <div class="col-md-10">
                                <div class="alert alert-success alert-dismissible fade show mb-2 text-center" role="alert">
                                    <?= $message ?>
                                </div>
                                <a href="../index.php" class="fs-6 no-underline">Volver</a>
                            </div>
                        </div>
                    <?php endif; ?>

                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php") ?>

<script>
    document.getElementById("reset_password_form").addEventListener("submit", function() {
        document.getElementById("reset_password_btn").disabled = true;
    });
</script>