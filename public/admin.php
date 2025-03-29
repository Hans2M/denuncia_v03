<?php
require_once '../includes/funciones.php';
$denuncias = obtenerDenuncias();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel de Denuncias</title>
</head>
<body>
    <h1>Denuncias Recientes</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Fecha</th>
        </tr>
        <?php foreach ($denuncias as $d): ?>
        <tr>
            <td><?= $d['id'] ?></td>
            <td><?= ucfirst($d['tipo']) ?></td>
            <td><?= substr($d['descripcion'], 0, 50) ?>...</td>
            <td><?= $d['fecha'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>