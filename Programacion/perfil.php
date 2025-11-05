<?php
session_start();
require 'db.php';

if (!isset($_SESSION['idUser'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['idUser'];

// Generar CSRF Token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Cargar datos del usuario
$stmt = $pdo->prepare("SELECT nombre, email, telefono, foto_perfil FROM usuarios WHERE idUser = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$mensaje = '';
$tipo = '';

// === ACTUALIZAR DATOS ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'], $_POST['csrf_token'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $mensaje = "Token inválido.";
        $tipo = "erro";
    } else {
        $nome = trim($_POST['nome']);
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
        $telefone = trim($_POST['telefone']);

        if (!$email) {
            $mensaje = "Email inválido.";
            $tipo = "erro";
        } else {
            $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, email = ?, telefono = ? WHERE idUser = ?");
            $stmt->execute([$nome, $email, $telefone, $userId]);

            $mensaje = "Dados atualizados com sucesso!";
            $tipo = "sucesso";

            // Recargar datos
            $stmt = $pdo->prepare("SELECT nombre, email, telefono, foto_perfil FROM usuarios WHERE idUser = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();
        }
    }
}

// === SUBIR FOTO ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'], $_POST['csrf_token'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $mensaje = "Token inválido.";
        $tipo = "erro";
    } else {
        $foto = $_FILES['foto'];
        $pasta = 'uploads/';

        if (!is_dir($pasta)) mkdir($pasta, 0755, true);

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $foto['tmp_name']);
        finfo_close($finfo);

        $ext = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $allowed_mime = ['image/jpeg', 'image/png', 'image/gif'];
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (
            in_array($mime, $allowed_mime) &&
            in_array($ext, $allowed_ext) &&
            $foto['size'] <= 2 * 1024 * 1024 &&
            $foto['error'] === UPLOAD_ERR_OK
        ) {
            $nomeFoto = "perfil_{$userId}_" . uniqid() . ".$ext";

            // Eliminar foto anterior
            if (!empty($user['foto_perfil']) && $user['foto_perfil'] !== 'default_user.png') {
                $antiga = $pasta . $user['foto_perfil'];
                if (file_exists($antiga)) @unlink($antiga);
            }

            if (move_uploaded_file($foto['tmp_name'], $pasta . $nomeFoto)) {
                $stmt = $pdo->prepare("UPDATE usuarios SET foto_perfil = ? WHERE idUser = ?");
                $stmt->execute([$nomeFoto, $userId]);

                $mensaje = "Foto atualizada com sucesso!";
                $tipo = "sucesso";

                // Recargar foto
                $stmt = $pdo->prepare("SELECT foto_perfil FROM usuarios WHERE idUser = ?");
                $stmt->execute([$userId]);
                $user = array_merge($user, $stmt->fetch());
            } else {
                $mensaje = "Erro ao salvar imagem.";
                $tipo = "erro";
            }
        } else {
            $mensaje = "Arquivo inválido, muito grande ou com erro.";
            $tipo = "erro";
        }
    }

    // Regenerar token
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações</title>
    <style>
        :root {
            --primary: #007bff;
            --success: #28a745;
            --danger: #dc3545;
            --bg: #f8f9fc;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            background: var(--bg);
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        h2, h3 { color: #003366; text-align: center; margin-top: 0; }
        .profile-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-img {
            width: 120px; height: 120px;
            border-radius: 50%;
            border: 4px solid var(--primary);
            object-fit: cover;
            cursor: pointer;
            transition: 0.3s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .profile-img:hover { transform: scale(1.08); }
        input[type="text"], input[type="email"], input[type="tel"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
        }
        button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            transition: 0.3s;
        }
        button:hover { background: #0056b3; }
        form { margin-bottom: 30px; }
        .msg {
            padding: 14px;
            border-radius: 6px;
            margin: 15px 0;
            text-align: center;
            font-weight: 500;
            animation: fade 0.4s ease;
        }
        .sucesso { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .erro { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        @keyframes fade { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .btn-link { color: var(--primary); text-decoration: none; font-size: 14px; }
        .btn-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <h2>Configurações do Usuário</h2>

    <!-- Foto de Perfil -->
    <div class="profile-section">
        <form method="POST" enctype="multipart/form-data" id="fotoForm">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <img src="uploads/<?= htmlspecialchars($user['foto_perfil'] ?: 'default_user.png') ?>" 
                 alt="Foto de perfil" class="profile-img" 
                 onclick="document.getElementById('fileInput').click();">
            <input type="file" name="foto" id="fileInput" accept="image/*" style="display:none;" 
                   onchange="this.form.submit();">
        </form>
    </div>

    <!-- Mensaje -->
    <?php if ($mensaje): ?>
        <div class="msg <?= $tipo ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <!-- Formulario Datos -->
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <label>Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($user['nombre']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Telefone:</label>
        <input type="tel" name="telefone" value="<?= htmlspecialchars($user['telefono']) ?>">

        <button type="submit" name="update_profile">Salvar Alterações</button>
    </form>

    <!-- Cambiar Contraseña -->
    <form method="POST" action="alterar_senha.php">
    <h3>Alterar Senha</h3>
    <input type="password" name="senha_atual" placeholder="Senha atual" required>
    <input type="password" name="nova_senha" placeholder="Nova senha (mín. 6)" required minlength="6">
    <input type="password" name="confirmar_senha" placeholder="Confirmar nova senha" required minlength="6">
    <button type="submit">Atualizar Senha</button>
</form>
</form>
</div>

<script>
    // Desaparecer mensaje
    document.querySelectorAll('.msg').forEach(msg => {
        setTimeout(() => {
            msg.style.transition = 'opacity 0.5s';
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 500);
        }, 3000);
    });
</script>

</body>
</html>
