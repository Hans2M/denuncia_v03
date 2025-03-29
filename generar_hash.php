<?php
// Archivo temporal generar_hash.php - ¡ELIMÍNALO después de usarlo!
$contraseña = "r2GDj9q3"; // Cambia esta contraseña por la que quieras usar
$hash = password_hash($contraseña, PASSWORD_BCRYPT);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Generador de Hash</title>
</head>
<body>
    <h1>Hash generado</h1>
    <p><strong>Contraseña original:</strong> <?= htmlspecialchars($contraseña) ?></p>
    <p><strong>Hash para usuarios.json:</strong> <?= $hash ?></p>
    <p style="color: red; font-weight: bold;">¡Recuerda eliminar este archivo después!</p>
</body>
</html>