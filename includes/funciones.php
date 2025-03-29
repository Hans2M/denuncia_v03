<?php
function guardarDenuncia($datos) {
    $archivo = '../data/denuncias.json';
    $denuncias = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];
    
    $nuevaDenuncia = [
        'id' => uniqid(),
        'fecha' => date('Y-m-d H:i:s'),
        'estado' => 'pendiente',
        ...$datos
    ];
    
    $denuncias[] = $nuevaDenuncia;
    file_put_contents($archivo, json_encode($denuncias, JSON_PRETTY_PRINT));
    
    return $nuevaDenuncia['id'];
}

function obtenerDenuncias() {
    $archivo = '../data/denuncias.json';
    return file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];
}
function obtenerDenunciaPorId($id) {
    $archivo = '../data/denuncias.json';
    if (!file_exists($archivo)) return null;
    
    $denuncias = json_decode(file_get_contents($archivo), true);
    foreach ($denuncias as $denuncia) {
        if ($denuncia['id'] === $id) {
            return $denuncia;
        }
    }
    return null;
}

?>

