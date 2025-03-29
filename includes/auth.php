<?php
session_start();

function cargarUsuarios() {
    $ruta = '../data/usuarios.json';
    
    if (!file_exists($ruta)) {
        error_log("Error: Archivo de usuarios no encontrado en $ruta");
        return [];
    }
    
    $contenido = file_get_contents($ruta);
    if ($contenido === false) {
        error_log("Error al leer el archivo de usuarios");
        return [];
    }
    
    $usuarios = json_decode($contenido, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("Error decodificando JSON: " . json_last_error_msg());
        return [];
    }
    
    return $usuarios;
}

function login($email, $password) {
    $usuarios = cargarUsuarios();
    
    foreach ($usuarios as $usuario) {
        if ($usuario['email'] === $email) {
            if (password_verify($password, $usuario['password'])) {
                $_SESSION['encargado'] = $usuario;
                return true;
            }
            error_log("Contraseña incorrecta para $email");
            return false;
        }
    }
    
    error_log("Usuario $email no encontrado");
    return false;
}

function isLoggedIn() {
    return !empty($_SESSION['encargado']);
}

function logout() {
    unset($_SESSION['encargado']);
}

function sendRecoveryEmail($email) {
    // 1. Verificar si el email existe en tu sistema
    // 2. Generar un token único con fecha de expiración
    // 3. Guardar el token en la base de datos o archivo
    // 4. Enviar email con enlace de recuperación
    // 5. Retornar true/false según éxito
}
?>