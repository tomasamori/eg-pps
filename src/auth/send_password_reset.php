<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

require '../db.php';

$email = $_POST['email'];

$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$query = "SELECT email FROM user WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result && $result->num_rows > 0) {
    $query = "UPDATE user SET reset_token = ?, reset_token_expires_at = ? WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $token_hash, $expiry, $email);
    $stmt->execute();

    $mail = require '../mailer.php';

    $mail->setFrom($_ENV['MAILER_FROM_ADDRESS'], $_ENV['MAILER_FROM_NAME']);
    $mail->addAddress($email);
    $mail->Subject = 'Restablecer contraseña';
    $mail->Body = <<<END

    Click <a href="http://{$_ENV['DEV_HOST']}/auth/reset_password.php?token=$token">aquí</a> para restablecer tu contraseña.

    END;

    try {
        $mail->send();
    } catch (Exception $e) {
        echo "No se pudo enviar el correo electrónico. Error: {$mail->ErrorInfo}";
        exit;
    }

    echo "Se ha enviado un correo electrónico con instrucciones para restablecer la contraseña.";
} else {
    echo "Se ha enviado un correo electrónico con instrucciones para restablecer la contraseña."; // For security reasons, we don't want to reveal if an email exists in the database
}

