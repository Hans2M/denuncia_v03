<?php
require_once '/includes/funciones.php';

// Obtener ID de la denuncia
$id = $_GET['id'] ?? null;
$denuncia = $id ? obtenerDenunciaPorId($id) : null;

// Redirigir si no hay ID válido
if (!$denuncia) {
    header('Location: public/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Denuncia Enviada</title>
    <link rel="stylesheet" href="css/confirmacion.css">
</head>
<body>
    <div class="confirmation-container">
        <div class="confirmation-box">
            <h1>✅ Denuncia Registrada</h1>
            <p>Tu denuncia ha sido enviada correctamente.</p>
            <p class="denuncia-id">Número de seguimiento: <strong><?= $id ?></strong></p>
            
            <?php if ($denuncia['anonima']): ?>
                <div class="anonima-notice">
                    <p>Esta denuncia fue enviada de forma anónima</p>
                </div>
            <?php endif; ?>
            
            <a href="public/index.php" class="return-btn">Volver al Inicio</a>
        </div>
    </div>

    <script>
        // Redirección automática después de 5 segundos
        setTimeout(() => {
            window.location.href = 'public/index.php';
        }, 5000);
    </script>
</body>
</html>