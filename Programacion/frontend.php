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
    $stmt = $pdo->prepare('INSERT INTO horastrabajo (user_id, work_date, horas, descripcion) VALUES (?,?,?,?)');
    $stmt->execute([$_SESSION['user_id'], $date, $hours, $description]);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Menú Lateral con Logo y Perfil</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; }

    /* Barra superior */
    .navbar{
      background-color: rgb(0, 162, 255); color: white; padding: 1rem;
      display:flex; justify-content:center; align-items:center; position:relative;
    }
    .logo img{ width:150px; height:100px; object-fit:contain; }

    /* Menú hamburguesa a la izquierda */
    .menu-icon{
      position:absolute; left:1rem;
      font-size:28px; cursor:pointer;
    }

    /* Foto de perfil a la derecha */
    .profile-pic{
      position:absolute; right:1rem;
      width:40px; height:40px; border-radius:50%; object-fit:cover;
      border:2px solid white; cursor:pointer;
    }

    /* Sidebar (a la izquierda) */
    .sidebar{
      position:fixed; top:0; left:-250px; width:250px; height:100%;
      background: rgb(0, 162, 2553); padding-top:60px; transition:left 0.3s ease-in-out;
      display:flex; flex-direction:column;
      z-index:1001;
    }
    .sidebar a{
      padding:15px; text-decoration:none; color:white; display:block;
      border-bottom:1px solid #555;
      transition: background 0.25s ease, padding-left 0.25s ease;
      cursor:pointer;
    }
    .sidebar a:hover{
      background:#1e90ff;
      padding-left:25px;
    }
    .sidebar.active{ left:0; }

    /* Overlay */
    .overlay{
      position:fixed; top:0; left:0; width:100%; height:100%;
      background:rgba(0,0,0,0.5); display:none;
      z-index:1000;
    }
    .overlay.active{ display:block; }
  </style>
</head>
<body> 
  <div class="navbar">
    <!-- Menú hamburguesa a la izquierda -->
    <span class="menu-icon" onclick="toggleMenu()">&#9776;</span>

    <!-- Logo centrado -->
    <div class="logo"><img src="image.png" alt="Logo"></div>

    <!-- Foto perfil a la derecha -->
    <img src="perfil.jpg" alt="Perfil" class="profile-pic">
  </div>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <a href="#">comprobantes</a>
   <button type="button" onclick="document.getElementById('jornadaModal').style.display='block'">
  Jornadas
</button>

<div id="jornadaModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
background:rgba(0,0,0,0.6);">
  <div style="background:#fff; margin:5% auto; padding:20px; width:400px; border-radius:10px;">
    <h1><?php echo htmlspecialchars($_SESSION['nombre']); ?></h1>
    <form method="post">
      <label>Fecha<br><input type="date" name="work_date" required></label><br>
      <label>Horas trabajadas<br><input type="number" name="horas" step="0.1" required></label><br>
      <label>Descripción<br><textarea name="descripcion"></textarea></label><br>
      <button type="submit">Registrar</button>
      <button type="button" onclick="document.getElementById('jornadaModal').style.display='none'">
        Cerrar
      </button>
    </form>
  </div>
</div>

    <a href="#">actas</a>
  </div>

  <!-- Fondo oscuro -->
  <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

  <script>
    function toggleMenu() {
      document.getElementById("sidebar").classList.toggle("active");
      document.getElementById("overlay").classList.toggle("active");
    }
  </script>
</body>
</html>
