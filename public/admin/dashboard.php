<?php
require_once '../../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

$denuncias = json_decode(file_get_contents('../../data/denuncias.json'), true);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Encargado</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>
            <span>Denuncias Recibidas</span>
            <span id="total-denuncias">Total: <?= count($denuncias) ?></span>
        </h1>
        
        <table class="denuncias-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($denuncias as $denuncia): ?>
                <tr>
                    <td><?= htmlspecialchars($denuncia['id']) ?></td>
                    <td><?= ucfirst(htmlspecialchars($denuncia['tipo'])) ?></td>
                    <td><?= htmlspecialchars($denuncia['fecha']) ?></td>
                    <td>
                        <span class="estado-badge estado-<?= htmlspecialchars(strtolower($denuncia['estado'])) ?>">
                            <?= htmlspecialchars($denuncia['estado']) ?>
                        </span>
                    </td>
                    <td class="acciones-cell">
                        <a href="ver.php?id=<?= $denuncia['id'] ?>" class="btn btn-ver">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <a href="#" class="btn btn-eliminar" onclick="confirmarEliminar('<?= $denuncia['id'] ?>')">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </a>
                        <a href="#" class="btn btn-enviar" onclick="mostrarModalCompartir('<?= $denuncia['id'] ?>')">
                            <i class="fas fa-share-alt"></i> Enviar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <a href="../index.php" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>
    </div>
    
    <!-- Modal para compartir -->
    <div id="modalCompartir" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Compartir Denuncia</h2>
            <p id="denuncia-info"></p>
            <div class="social-share">
                <a href="#" id="share-facebook" class="social-icon facebook" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" id="share-twitter" class="social-icon twitter" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" id="share-whatsapp" class="social-icon whatsapp" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="#" id="share-email" class="social-icon email" target="_blank">
                    <i class="fas fa-envelope"></i>
                </a>
            </div>
        </div>
    </div>
    
    <script>
        // Funcionalidad para eliminar denuncias
        function confirmarEliminar(idDenuncia) {
            if (confirm(`¿Está seguro que desea eliminar la denuncia ${idDenuncia}?`)) {
                fetch(`eliminar.php?id=${idDenuncia}`, {
                    method: 'DELETE'
                })
                .then(response => {
                    if (response.ok) {
                        alert('Denuncia eliminada correctamente');
                        location.reload();
                    } else {
                        alert('Error al eliminar la denuncia');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar la denuncia');
                });
            }
        }
        
        // Funcionalidad para compartir
        let modal = document.getElementById("modalCompartir");
        let span = document.getElementsByClassName("close")[0];
        
        function mostrarModalCompartir(idDenuncia) {
            // Obtener datos de la denuncia (simulado - en realidad deberías hacer una petición AJAX)
            let denuncia = {
                id: idDenuncia,
                tipo: document.querySelector(`tr td:first-child:contains('${idDenuncia}')`).nextElementSibling.textContent,
                fecha: document.querySelector(`tr td:first-child:contains('${idDenuncia}')`).nextElementSibling.nextElementSibling.textContent,
                estado: document.querySelector(`tr td:first-child:contains('${idDenuncia}')`).nextElementSibling.nextElementSibling.nextElementSibling.textContent.trim()
            };
            
            document.getElementById("denuncia-info").textContent = `Denuncia ${denuncia.id}: ${denuncia.tipo} (${denuncia.estado}) - ${denuncia.fecha}`;
            
            // Configurar enlaces de compartir
            const baseUrl = window.location.origin;
            const shareText = `Denuncia ${denuncia.id}: ${denuncia.tipo} (Estado: ${denuncia.estado}) - ${denuncia.fecha}`;
            const shareUrl = `${baseUrl}/ver.php?id=${denuncia.id}`;
            
            document.getElementById("share-facebook").href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}&quote=${encodeURIComponent(shareText)}`;
            document.getElementById("share-twitter").href = `https://twitter.com/intent/tweet?text=${encodeURIComponent(shareText)}&url=${encodeURIComponent(shareUrl)}`;
            document.getElementById("share-whatsapp").href = `https://wa.me/?text=${encodeURIComponent(`${shareText} ${shareUrl}`)}`;
            document.getElementById("share-email").href = `mailto:?subject=Denuncia ${denuncia.id}&body=${encodeURIComponent(`${shareText}\n\nVer más detalles: ${shareUrl}`)}`;
            
            modal.style.display = "block";
        }
        
        span.onclick = function() {
            modal.style.display = "none";
        }
        
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        
        // Polyfill para :contains selector
        document.querySelectorAll = document.querySelectorAll || function(selectors) {
            let style = document.createElement('style'), elements = [], element;
            document.documentElement.firstChild.appendChild(style);
            document._qsa = [];
            
            style.styleSheet.cssText = selectors + '{x-qsa:expression(document._qsa && document._qsa.push(this))}';
            window.scrollBy(0, 0);
            style.parentNode.removeChild(style);
            
            return document._qsa;
        };
    </script>
</body>
</html>