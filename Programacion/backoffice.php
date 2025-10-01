<?php
require 'db.php';

if (isset($_GET['action'], $_GET['idUser'])) {
    $idUser = (int) $_GET['idUser'];
    if ($_GET['action'] === 'approve') {
        $pdo->prepare('UPDATE usuarios SET status="active" WHERE idUser=?')->execute([$idUser]);
    } elseif ($_GET['action'] === 'deny') {
        $pdo->prepare('UPDATE usuarios SET status="denied" WHERE idUser=?')->execute([$idUser]);
    }
}

$pending = $pdo->query("SELECT * FROM usuarios WHERE status='pending'")->fetchAll();
$horas = $pdo->query("SELECT w.*, u.nombre, u.idUser FROM horastrabajo w JOIN usuarios u ON u.idUser=w.user_id ORDER BY w.created_at DESC")->fetchAll();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Backoffice</title></head>
<body>
  <h1>Usuarios pendientes</h1>
  <table border="1">
    <tr><th>Cédula</th><th>Nombre</th><th>Acciones</th></tr>
    <?php foreach($pending as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p['idUser']) ?></td>
        <td><?= htmlspecialchars($p['nombre']) ?></td>
        <td>
          <a href="?action=approve&idUser=<?= $p['idUser'] ?>">Habilitar</a>
          <a href="?action=deny&idUser=<?= $p['idUser'] ?>">Denegar</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>

  <h1>Horas registradas</h1>
  <table border="1">
    <tr><th>Cédula</th><th>Nombre</th><th>Fecha</th><th>Horas</th><th>Descripción</th></tr>
    <?php foreach($horas as $h): ?>
      <tr>
        <td><?= htmlspecialchars($h['idUser']) ?></td>
        <td><?= htmlspecialchars($h['nombre']) ?></td>
        <td><?= htmlspecialchars($h['work_date']) ?></td>
        <td><?= htmlspecialchars($h['horas']) ?></td>
        <td><?= htmlspecialchars($h['descripcion']) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
