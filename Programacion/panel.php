<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.html");
    exit();
}

$id = $_SESSION['usuario_id'];
$sql = "SELECT nombre FROM usuarios WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Panel Principal</title>
  <style>
    :root {
      --azul-primario: #1e3a8a;
      --azul-claro: #3b82f6;
      --azul-muy-claro: #dbeafe;
      --texto-claro: #f8fafc;
      --sombra: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f0f4f8;
    }

    .container {
      display: flex;
      flex-direction: column;
      height: 100vh;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 25px;
      background-color: var(--azul-primario);
      color: var(--texto-claro);
      box-shadow: var(--sombra);
    }

    .user-info {
      display: flex;
      align-items: center;
    }

    .profile-pic {
      width: 40px;
      height: 40px;
      background-color: white;
      border-radius: 50%;
      margin-right: 10px;
    }

    .menu-icon {
      cursor: pointer;
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .menu-icon div {
      width: 25px;
      height: 3px;
      background-color: #fff;
    }

    .main-content {
      display: flex;
      flex: 1;
    }

    .sidebar {
      width: 250px;
      background-color: var(--azul-muy-claro);
      padding: 20px;
    }

    .content {
      flex: 1;
      padding: 20px;
      background-color: #ffffff;
    }

    .function-panel {
  position: fixed;
  top: 0;
  right: 0;
  width: 300px;
  height: 100%;
  background-color: #fff;
  box-shadow: var(--sombra);
  transform: translateX(100%);
  transition: transform 0.3s ease;
  padding: 20px;
  z-index: 1001;
  overflow-y: auto;
}
.function-panel.open {
  transform: translateX(0);
}

    #overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.3);
      display: none;
      z-index: 1000;
    }

    /* Botón de registro */
    .registro-btn {
      margin: 20px;
      padding: 10px 15px;
      background-color: var(--azul-claro);
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .registro-form {
      display: none;
      padding: 20px;
      background-color: #f9f9f9;
      border: 1px solid #ccc;
      margin: 0 20px 20px;
      border-radius: 8px;
    }

    .registro-form input,
    .registro-form textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
    }

    .registro-form input[type="submit"],
    .cerrar-btn {
      background-color: var(--azul-primario);
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 5px;
      cursor: pointer;
    }

    .cerrar-btn {
      background-color: #999;
      margin-left: 10px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="header">
    <div class="user-info">
      <div class="profile-pic"></div>
      <span><?= htmlspecialchars($usuario['nombre']) ?></span>
    </div>
    <div class="menu-icon" onclick="togglePanel()">
      <div></div><div></div><div></div>
    </div>
  </div>

  

  <div class="main-content">
    <div class="content">
      <!-- Área principal -->
       <button class="registro-btn" onclick="mostrarRegistro()">Registro Datos</button>

  <div id="registroForm" class="registro-form">
    <h3>Registro de Datos del Usuario</h3>
    <form method="post" action="guardar_datos.php">
        <label>Teléfono:</label>
        <input type="text" name="telefono" required>

        <label>Gmail:</label>
        <input type="email" name="gmail" required>

        <label>Familiares:</label>
        <textarea name="familiares" rows="3"></textarea>

        <label>Datos personales:</label>
        <textarea name="datos_personales" rows="4"></textarea>

        <input type="submit" value="Guardar">
        <button type="button" class="cerrar-btn" onclick="cerrarRegistro()">Cerrar</button>
    </form>
  </div>
    </div>
    <div class="sidebar">
      <h4>Panel de tareas</h4>
      <ul>
        <li>Pendiente 1</li>
        <li>Pendiente 2</li>
        <li>Aviso importante</li>
      </ul>
    </div>
  </div>
</div>

<div id="overlay" onclick="closePanel()"></div>
<div id="functionPanel" class="function-panel">
  <h3>Índice de funcionalidades</h3>
  <ul>
    <li>Funcionalidad A</li>
    <li>Funcionalidad B</li>
    <li>Funcionalidad C</li>
  </ul>
</div>

<script>
  function togglePanel() {
    const panel = document.getElementById("functionPanel");
    const overlay = document.getElementById("overlay");
    const isOpen = panel.classList.contains("open");

    if (isOpen) {
      panel.classList.remove("open");
      overlay.style.display = "none";
    } else {
      panel.classList.add("open");
      overlay.style.display = "block";
    }
  }

  function closePanel() {
    document.getElementById("functionPanel").classList.remove("open");
    document.getElementById("overlay").style.display = "none";
  }

  function mostrarRegistro() {
    document.getElementById("registroForm").style.display = "block";
  }

  function cerrarRegistro() {
    document.getElementById("registroForm").style.display = "none";
  }
</script>

</body>
</html>
