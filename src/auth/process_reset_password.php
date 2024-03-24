<?php

$token = $_POST['token'];

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

if (strlen($_POST['password']) < 8) {
    die("La contraseña debe tener al menos 8 caracteres");
}

if ( ! preg_match("/[a-z]/i", $_POST['password'])) {
    die("La contraseña debe contener al menos una letra");
}

if ( ! preg_match("/\d/", $_POST['password'])) {
    die("La contraseña debe contener al menos un número");
}

if ($_POST['password'] !== $_POST['password_confirmation']) {
    die("Las contraseñas no coinciden");
}

$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "UPDATE user SET password = ?, reset_token = NULL, reset_token_expires_at = NULL WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $password_hash, $user['user_id']);
$stmt->execute();

echo "Contraseña restablecida";