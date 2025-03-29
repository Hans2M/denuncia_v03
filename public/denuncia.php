<?php
require_once '../includes/funciones.php';



// Procesar envío de formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'tipo' => $_POST['tipo'],
        'descripcion' => $_POST['descripcion'],
        'anonima' => ($_POST['form_type'] === 'anonima'),
        'nombre' => $_POST['nombre'] ?? null,
        'contacto' => $_POST['contacto'] ?? null,
        'evidencias' => []
    ];

    // Procesar imágenes
    if (!empty($_FILES['evidencias'])) {
        $uploadDir = '../data/uploads/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);

        foreach ($_FILES['evidencias']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['evidencias']['error'][$key] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['evidencias']['name'][$key], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;
                move_uploaded_file($tmpName, $uploadDir . $filename);
                $datos['evidencias'][] = $filename;
            }
        }
    }

    $id = guardarDenuncia($datos);
    header("Location: ./index.php?id=$id");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Denuncia</title>
    <link rel="stylesheet" href="css/denuncia.css">
</head>
<body>
    <div class="form-container">
        <h1>Realizar Denuncia</h1>
        
        <div class="form-selector">
            <button class="selector-btn active" data-form="personal">Con Datos Personales</button>
            <button class="selector-btn" data-form="anonima">Anónima</button>
        </div>

        <!-- Formulario con Datos Personales -->
        <form id="form-personal" class="denuncia-form active" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="form_type" value="personal">
            
            <div class="form-section">
                <h2>Tus Datos</h2>
                <div class="form-group">
                    <label>Nombre (opcional)</label>
                    <input type="text" name="nombre">
                </div>
                <div class="form-group">
                    <label>Correo/Teléfono (opcional)</label>
                    <input type="text" name="contacto">
                </div>
            </div>

            <div class="form-section">
                <h2>Detalles de la Denuncia</h2>
                <div class="form-group">
                    <label>Tipo de denuncia*</label>
                    <select name="tipo" required>
                        <option value="acoso">Acoso Sexual</option>
                        <option value="discriminacion">Discriminación</option>
                        <option value="violencia">Violencia</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Descripción detallada*</label>
                    <textarea name="descripcion" required></textarea>
                </div>
            </div>

            <div class="form-section">
                <h2>Evidencias</h2>
                <div class="form-group">
                    <label>Subir archivos (Máx. 5MB c/u)</label>
                    <input type="file" name="evidencias[]" multiple accept="image/*,.pdf,.doc,.docx">
                </div>
            </div>

            <button type="submit" class="submit-btn">Enviar Denuncia</button>
        </form>

        <!-- Formulario Anónimo -->
        <form id="form-anonima" class="denuncia-form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="form_type" value="anonima">
            
            <div class="form-section">
                <h2>Denuncia Anónima</h2>
                <p class="anonima-warning">⚠️ Tu identidad no será registrada</p>
            </div>

            <div class="form-section">
                <h2>Detalles de la Denuncia</h2>
                <div class="form-group">
                    <label>Tipo de denuncia*</label>
                    <select name="tipo" required>
                        <option value="acoso">Acoso Sexual</option>
                        <option value="discriminacion">Discriminación</option>
                        <option value="violencia">Violencia</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Descripción detallada*</label>
                    <textarea name="descripcion" required></textarea>
                </div>
            </div>

            <div class="form-section">
                <h2>Evidencias</h2>
                <div class="form-group">
                    <label>Subir archivos (Máx. 5MB c/u)</label>
                    <input type="file" name="evidencias[]" multiple accept="image/*,.pdf,.doc,.docx">
                </div>
            </div>

            <button type="submit" class="submit-btn">Enviar Denuncia Anónima</button>
        </form>
    </div>

    <script src="js/denuncia.js"></script>


</body>
</html>