<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$mensaje = '';
$tipo = 'erro';

// Verificar columna 'password'
$check = $pdo->query("SHOW COLUMNS FROM usuarios LIKE 'password'")->fetch();
if (!$check) {
    die("Error: falta la columna 'password'. Ejecuta: ALTER TABLE usuarios ADD COLUMN password VARCHAR(255) NOT NULL;");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha_atual = $_POST['senha_atual'] ?? '';
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirmar = $_POST['confirmar_senha'] ?? '';

    if ($nova_senha !== $confirmar) {
        $mensaje = "As senhas não coincidem.";
    } elseif (strlen($nova_senha) < 6) {
        $mensaje = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        $stmt = $pdo->prepare("SELECT password FROM usuarios WHERE idUser = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if ($user && password_verify($senha_atual, $user['password'])) {
            $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE usuarios SET password = ? WHERE idUser = ?");
            $stmt->execute([$hash, $userId]);

            $mensaje = "Senha alterada com sucesso!";
            $tipo = 'sucesso';
        } else {
            $mensaje = "Senha atual incorreta.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 420px;
        }
        h4 {
            text-align: center;
            color: #1a3d7c;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }
        button {
            width: 100%;
            background: #007bff;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }
        button:hover { background: #0056b3; }
        .alert {
            padding: 12px;
            border-radius: 6px;
            margin: 15px 0;
            text-align: center;
            font-weight: 500;
        }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .back {
            text-align: center;
            margin-top: 20px;
        }
        .back a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 16px;
            border: 1px solid #007bff;
            border-radius: 6px;
            display: inline-block;
            transition: 0.3s;
        }
        .back a:hover {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<div class="card">
    <h4>Alterar Senha</h4>

    <?php if ($mensaje): ?>
        <div class="alert <?= $tipo === 'sucesso' ? 'success' : 'danger' ?>">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="password" name="senha_atual" placeholder="Senha atual" required autocomplete="current-password">
        <input type="password" name="nova_senha" placeholder="Nova senha (mín. 6)" required minlength="6" autocomplete="new-password">
        <input type="password" name="confirmar_senha" placeholder="Confirmar nova senha" required minlength="6" autocomplete="new-password">
        <button type="submit">Atualizar Senha</button>
    </form>

    <div class="back">
        <!-- CAMBIA 'configuracoes.php' POR EL NOMBRE REAL DE TU ARCHIVO -->
        <a href="perfil.php">Voltar às Configurações</a>
    </div>
</div>

</body>
</html>
