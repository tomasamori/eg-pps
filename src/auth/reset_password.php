<?php

$token = $_GET['token'];

require '../db.php';

$token_hash = hash("sha256", $token);

$query = "SELECT * FROM user WHERE reset_token = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $token_hash);
$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("Token inválido");
}

if (strtotime($user['reset_token_expires_at']) < time()) {
    die("El token expiró");
}

echo "Token válido";

?>

<?php include('../includes/header.php') ?>

<h1>Restablecer contraseña</h1>

<form action="process_reset_password.php" method="post">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <label for="password">Nueva contraseña</label>
    <input type="password" name="password" id="password">
    <label for="password_confirmation">Confirmar contraseña</label>
    <input type="password" name="password_confirmation" id="password_confirmation">
    <button type="submit">Restablecer contraseña</button>
</form>

<?php include('../includes/footer.php') ?>