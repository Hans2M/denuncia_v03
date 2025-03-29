
<?php
require_once '../../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

$denuncias = json_decode(file_get_contents('../../data/denuncias.json'), true);
$denuncia = current(array_filter($denuncias, fn($d) => $d['id'] === $_GET['id']));

if (!$denuncia) {
    header('Location: dashboard.php');
    exit;
}

// Configuración de rutas
$baseDir = __DIR__ . '/../../';
$uploadDir = $baseDir . 'data/uploads/';
$publicDir = '/app_1/data/uploads/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Denuncia #<?= htmlspecialchars($denuncia['id']) ?></title>
    <link rel="stylesheet" href="../css/ver.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <style>
        /* [Estilos anteriores se mantienen igual] */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .estado-badge {
            background: <?= $denuncia['estado'] === 'pendiente' ? '#f39c12' : ($denuncia['estado'] === 'resuelta' ? '#2ecc71' : '#e74c3c') ?>;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            margin-left: 10px;
        }

        h3 {
            color: #3498db;
            margin-top: 25px;
        }

        /* Sección de información */
        .detalle-info {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }

        .info-item strong {
            display: block;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        /* Descripción */
        .descripcion {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            white-space: pre-wrap;
        }

        /* Galería de evidencias */
        .evidencia-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .evidencia {
            background: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .evidencia:hover {
            transform: translateY(-5px);
        }

        .evidencia img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .evidencia-archivo {
            padding: 20px;
            text-align: center;
            background: #e9ecef;
        }

        .evidencia-archivo a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .evidencia-archivo a:hover {
            text-decoration: underline;
        }

        .evidencia-nombre {
            padding: 8px;
            text-align: center;
            font-size: 12px;
            background: #f9f9f9;
        }

        /* Botones */
        .btn-volver {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        .btn-volver:hover {
            background: #2980b9;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .detalle-info {
                grid-template-columns: 1fr;
            }
            
            .evidencia-container {
                grid-template-columns: 1fr;
            }
        }
        
        /* Nuevos estilos para lightbox */
        .evidencia img {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .evidencia img:hover {
            transform: scale(1.02);
        }
        
        .evidencia-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 8px;
            background: #f9f9f9;
        }
        
        .evidencia-actions a {
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
        }
        
        .evidencia-actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- [Encabezado y detalles de denuncia se mantienen igual] -->
        <h1>
            <i class="fas fa-file-alt"></i> Denuncia #<?= htmlspecialchars($denuncia['id']) ?>
            <span class="estado-badge">
                <?= ucfirst(htmlspecialchars($denuncia['estado'])) ?>
            </span>
        </h1>
        
        <div class="detalle-info">
            <div class="info-item">
                <strong><i class="fas fa-calendar-alt"></i> Fecha</strong>
                <?= htmlspecialchars($denuncia['fecha']) ?>
            </div>
            
            <div class="info-item">
                <strong><i class="fas fa-tag"></i> Tipo</strong>
                <?= ucfirst(htmlspecialchars($denuncia['tipo'])) ?>
            </div>
            
            <?php if (!$denuncia['anonima']): ?>
            <div class="info-item">
                <strong><i class="fas fa-user"></i> Contacto</strong>
                <?= isset($denuncia['contacto']) ? htmlspecialchars($denuncia['contacto']) : 'No proporcionado' ?>
            </div>
            <?php endif; ?>
        </div>
        
        <h3><i class="fas fa-align-left"></i> Descripción</h3>
        <div class="descripcion">
            <?= nl2br(htmlspecialchars($denuncia['descripcion'])) ?>
        </div>
        
        <?php if (!empty($denuncia['evidencias'])): ?>
        <h3><i class="fas fa-images"></i> Evidencias adjuntas</h3>
        <div class="evidencia-container">
            <?php 
            foreach ($denuncia['evidencias'] as $evidencia): 
                $archivo = basename($evidencia);
                $rutaCompleta = $uploadDir . $archivo;
                $rutaPublica = $publicDir . $archivo;
                
                if (!file_exists($rutaCompleta)) {
                    error_log("Archivo de evidencia no encontrado: " . $rutaCompleta);
                    continue;
                }
                
                $esImagen = preg_match('/\.(jpg|jpeg|png|gif|webp|bmp)$/i', $archivo);
                $esPDF = preg_match('/\.pdf$/i', $archivo);
            ?>
                <div class="evidencia">
                    <?php if ($esImagen): ?>
                        <a href="<?= htmlspecialchars($rutaPublica) ?>" data-lightbox="evidencias" data-title="<?= htmlspecialchars($archivo) ?>">
                            <img src="<?= htmlspecialchars($rutaPublica) ?>" alt="Evidencia de denuncia">
                        </a>
                        <div class="evidencia-actions">
                            <a href="<?= htmlspecialchars($rutaPublica) ?>" download>
                                <i class="fas fa-download"></i> Descargar
                            </a>
                            <a href="<?= htmlspecialchars($rutaPublica) ?>" target="_blank">
                                <i class="fas fa-expand"></i> Ampliar
                            </a>
                        </div>
                        <div class="evidencia-nombre"><?= htmlspecialchars($archivo) ?></div>
                    <?php elseif ($esPDF): ?>
                        <div class="evidencia-archivo">
                            <i class="fas fa-file-pdf fa-3x"></i><br>
                            <div class="evidencia-actions">
                                <a href="<?= htmlspecialchars($rutaPublica) ?>" download>
                                    <i class="fas fa-download"></i> Descargar PDF
                                </a>
                                <a href="<?= htmlspecialchars($rutaPublica) ?>" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> Abrir
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="evidencia-archivo">
                            <i class="fas fa-file-download fa-3x"></i><br>
                            <div class="evidencia-actions">
                                <a href="<?= htmlspecialchars($rutaPublica) ?>" download>
                                    <i class="fas fa-download"></i> Descargar
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <a href="dashboard.php" class="btn-volver">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>

    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        // Configuración adicional para lightbox
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Imagen %1 de %2',
            'disableScrolling': true,
            'fitImagesInViewport': true
        });
        
        // Función para descarga directa
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('download-btn')) {
                e.preventDefault();
                const link = document.createElement('a');
                link.href = e.target.closest('a').href;
                link.download = '';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        });
    </script>
</body>
</html>