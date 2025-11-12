<?php
// =============================================================
// BACKEND: PROCESAMIENTO DEL CAMBIO DE CONTRASEÑA
// =============================================================

// Detener el script si no se accede mediante POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Redirigir de vuelta al formulario si no hay datos POST
    header("Location: frontend.php?error=no_post");
    exit;
}

// --- 1. Configuración de la Base de Datos ---
// **ACTUALIZA ESTAS CREDENCIALES CON LAS TUYAS**
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');      // Corregido: SOLO 'define'
define('DB_PASSWORD', '');          // Contraseña vacía por defecto en XAMPP
define('DB_NAME', 'cooperativas');

// --- 2. Conexión a la Base de Datos ---
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    header("Location: frontend.php?error=db_connect");
    exit;
}

// --- 3. Obtención y Sanitización de Variables ---
// Nota: En un sistema de producción, el idUser debe venir de la sesión, no del POST.
$idUser = filter_input(INPUT_POST, 'idUser', FILTER_SANITIZE_NUMBER_INT);
$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

// 4. Validación de Contraseñas
if (empty($idUser) || empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    header("Location: frontend.php?error=pass_campos_vacios");
    exit;
}

if ($newPassword !== $confirmPassword) {
    header("Location: frontend.php?error=pass_mismatch");
    exit;
}

// Se recomienda un mínimo de 8 caracteres para la nueva contraseña
if (strlen($newPassword) < 8) {
    header("Location: frontend.php?error=pass_corta");
    exit;
}

// --- 5. Obtener el HASH Almacenado y Verificar Contraseña Actual ---

// a. Prepara la consulta para obtener el hash
$sql_select = "SELECT password_hash FROM usuarios WHERE idUser = ?";
if ($stmt = $conn->prepare($sql_select)) {
    $stmt->bind_param("i", $idUser);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $stmt->close();
        $conn->close();
        header("Location: frontend.php?error=user_not_found");
        exit;
    }

    $usuario = $result->fetch_assoc();
    $hashAlmacenado = $usuario['password_hash'];
    $stmt->close();

    // b. Verificar la contraseña actual
    if (!password_verify($currentPassword, $hashAlmacenado)) {
        $conn->close();
        header("Location: frontend.php?error=current_pass_incorrect");
        exit;
    }

} else {
    $conn->close();
    header("Location: frontend.php?error=sql_prepare_select");
    exit;
}

// --- 6. Crear Nuevo HASH y Actualizar la Base de Datos ---

// Generar un nuevo hash seguro para la nueva contraseña
$newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

// a. Prepara la consulta para actualizar el hash
$sql_update = "UPDATE usuarios SET password_hash = ? WHERE idUser = ?";
if ($stmt = $conn->prepare($sql_update)) {
    $stmt->bind_param("si", $newPasswordHash, $idUser);

    if ($stmt->execute()) {
        // Éxito: Redirigir con mensaje de éxito
        header("Location: frontend.php?status=pass_success");
    } else {
        // Error en la ejecución del UPDATE
        header("Location: frontend.php?error=pass_update_fail");
    }
    $stmt->close();
} else {
    // Error en la preparación del UPDATE
    header("Location: frontend.php?error=sql_prepare_update");
}

$conn->close();
exit;

?>