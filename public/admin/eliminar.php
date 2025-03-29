<?php
require_once '../../includes/auth.php';
require_once '../../includes/funciones.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    exit('Método no permitido');
}

$id = $_GET['id'] ?? null;
if (!$id) {
    http_response_code(400);
    exit('ID de denuncia no proporcionado');
}

$denuncias = json_decode(file_get_contents('../../data/denuncias.json'), true);
$nuevasDenuncias = array_filter($denuncias, fn($d) => $d['id'] !== $id);

if (count($nuevasDenuncias) === count($denuncias)) {
    http_response_code(404);
    exit('Denuncia no encontrada');
}

// Guardar el archivo actualizado
if (file_put_contents('../../data/denuncias.json', json_encode(array_values($nuevasDenuncias)))) {
    http_response_code(200);
    exit();
} else {
    http_response_code(500);
    exit('Error al guardar los cambios');
}