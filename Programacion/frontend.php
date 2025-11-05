<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die('Acceso denegado');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['work_date'] ?? '';
    $hours = $_POST['horas'] ?? 0;
    $description = $_POST['descripcion'] ?? '';

    try {
        $stmt = $pdo->prepare('INSERT INTO horastrabajo (user_id, work_date, horas, descripcion) VALUES (?, ?, ?, ?)');
        $stmt->execute([$_SESSION['user_id'], $date, $hours, $description]);
        $_SESSION['mensaje'] = "✅ Jornada registrada correctamente";
        $_SESSION['tipo'] = "exito";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $_SESSION['mensaje'] = "⚠️ Ya tienes una jornada registrada en esa fecha.";
            $_SESSION['tipo'] = "advertencia";
        } else {
            $_SESSION['mensaje'] = "❌ Error al registrar la jornada.";
            $_SESSION['tipo'] = "error";
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$stmt = $pdo->prepare("SELECT foto_perfil FROM usuarios WHERE idUser = ?");
$stmt->execute([$_SESSION['user_id']]);
$foto = $stmt->fetchColumn() ?: 'default.jpg';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>fronted</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; background: #f5f6f8; }
    .navbar {
      background-color: rgb(0, 162, 255);
      color: white;
      padding: 0.8rem 1rem;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      height: 80px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .menu-icon {
      position: absolute; 
      left: 1rem;
      font-size: 28px; 
      cursor: pointer;
    }
    .logo img {
      width: 150px;
      height: auto;
      object-fit: contain;
    }
    .profile-pic, .profile-default {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      width: 50px;
      height: 50px;
      border-radius: 50%;
      border: 2px solid white;
      cursor: pointer;
    }

    .profile-pic {
      object-fit: cover;
    }

    .profile-default {
      background: radial-gradient(circle at 50% 35%, white 25%, transparent 26%), 
              radial-gradient(circle at 50% 75%, white 40%, transparent 41%), 
              #999;
      background-repeat: no-repeat;
      background-size: 70% 70%, 90% 90%;
      background-position: center;
    }

    .sidebar {
      position: fixed;
      top: 0; 
      left: -250px;
      width: 250px; 
      height: 100%;
      background: rgb(0, 162, 255);
      padding-top: 60px; 
      transition: left 0.3s ease-in-out;
      display: flex; 
      flex-direction: column;
      z-index: 1001;
    } 

    .sidebar.active { left: 0; }
    
    .sidebar a, .jornadasb {
      padding: 15px;
      text-decoration: none;
      color: white;
      display: block;
      border-bottom: 1px solid #555;
      background: none;
      border: none;
      text-align: left;
      cursor: pointer;
      font: inherit;
      transition: background 0.25s ease, padding-left 0.25s ease;
    }
    .sidebar a:hover, .jornadasb:hover {
      background: #1e90ff;
      padding-left: 25px;
    }
    .overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      display: none;
      z-index: 1000;
    }
    .overlay.active { display: block; }
    #jornadaModal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
      z-index: 2000;
    }
    .modal-content {
      background: #fff;
      margin: 5% auto;
      padding: 20px;
      width: 400px;
      border-radius: 10px;
      text-align: center;
    }
    #modalMsg {
      position: fixed; 
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
      display: flex; 
      justify-content: center; 
      align-items: center;
      z-index: 3000;
    }
    #modalMsg .msg-box {
      background: #fff;
      padding: 25px 40px;
      border-radius: 10px;
      text-align: center;
      max-width: 400px;
    }
    #modalMsg button {
      margin-top: 15px; 
      padding: 10px 20px;
      border: none; 
      background: #007bff; 
      color: #fff;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <span class="menu-icon" onclick="toggleMenu()">&#9776;</span>
    <div class="logo"><img src="logo.png" alt="Logo"></div>
    <a href="perfil.php">
  <?php if ($foto !== 'default.jpg'): ?>
    <img src="uploads/<?php echo htmlspecialchars($foto); ?>" alt="Perfil" class="profile-pic">
  <?php else: ?>
    <div class="profile-default"></div>
  <?php endif; ?>
</a>
  </div>

  <div class="sidebar" id="sidebar">
    <a href="#">Comprobantes</a>
    <button class="jornadasb" type="button" onclick="document.getElementById('jornadaModal').style.display='block'">
      Jornadas
    </button>
    <a href="#">Actas</a>
  </div>

  <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

  <div id="jornadaModal">
    <div class="modal-content">
      <h1><?php echo htmlspecialchars($_SESSION['nombre']); ?></h1>
      <form method="post">
        <label>Fecha<br><input type="date" name="work_date" required></label><br>
        <label>Horas trabajadas<br><input type="number" name="horas" step="0.1" required></label><br>
        <label>Descripción<br><textarea name="descripcion"></textarea></label><br>
        <button type="submit">Registrar</button>
        <button type="button" onclick="document.getElementById('jornadaModal').style.display='none'">Cerrar</button>
      </form>
    </div>
  </div>

  <?php if (isset($_SESSION['mensaje'])): ?>
  <div id="modalMsg">
    <div class="msg-box">
      <h2 style="color:
        <?php echo $_SESSION['tipo'] === 'exito' ? 'green' :
                ($_SESSION['tipo'] === 'advertencia' ? 'orange' : 'red'); ?>">
        <?php echo $_SESSION['mensaje']; ?>
      </h2>
      <button onclick="cerrarModalMsg()">Cerrar</button>
    </div>
  </div>
  <?php unset($_SESSION['mensaje'], $_SESSION['tipo']); endif; ?>

  <script>
    function toggleMenu() {
      document.getElementById("sidebar").classList.toggle("active");
      document.getElementById("overlay").classList.toggle("active");
    }
    function cerrarModalMsg() {
      document.getElementById('modalMsg').style.display = 'none';
    }
  </script>
</body>
</html>
