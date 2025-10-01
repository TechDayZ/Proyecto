<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db.php';

$full_name = trim($_POST['nombre'] ?? '');
$idUser = trim($_POST['idUser'] ?? '');
$password = $_POST['password'] ?? '';

if (!$full_name || !$idUser || !$password) {
    die('Faltan campos obligatorios.');
}

// Si tu idUser en la BD es entero, valida:
if (!ctype_digit($idUser)) {
    die('La cédula/ID debe ser numérica.');
}

$hash = password_hash($password, PASSWORD_DEFAULT);

// Forma correcta: si quieres insertar el status manualmente, usa la cadena literal 'pending' (no como placeholder).
// Aquí uso 3 placeholders (nombre, idUser, password_hash) y status 'pending' literal.
$stmt = $pdo->prepare('INSERT INTO usuarios (nombre, idUser, password_hash, status) VALUES (?,?,?, \'pending\')');
try {
    $stmt->execute([$full_name, (int)$idUser, $hash]);
    $_SESSION['message'] = 'Registro enviado. Espera habilitación en backoffice.';
} catch (Exception $e) {
    // mensaje de error amigable + log si quieres
    $_SESSION['message'] = 'Error en registro: ' . $e->getMessage();
}
header('Location: loadingpage.php');
exit;
?>
