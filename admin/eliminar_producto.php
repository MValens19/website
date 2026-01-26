<?php
session_start();
include '../conexion.php'; // Salimos de /admin para conectar

// Seguridad
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // 1. OBTENER RUTAS DE ARCHIVOS PARA BORRARLOS FÍSICAMENTE
    $consulta = $conn->query("SELECT imagen_url, audio_url FROM productos WHERE id = $id");
    
    if ($consulta && $consulta->num_rows > 0) {
        $producto = $consulta->fetch_assoc();
        
        // Borrar imagen si es un archivo local (no un link externo)
        if (!filter_var($producto['imagen_url'], FILTER_VALIDATE_URL)) {
            $ruta_img = "../" . $producto['imagen_url'];
            if (file_exists($ruta_img)) { unlink($ruta_img); }
        }

        // Borrar audio si es un archivo local
        if (!filter_var($producto['audio_url'], FILTER_VALIDATE_URL)) {
            $ruta_audio = "../" . $producto['audio_url'];
            if (file_exists($ruta_audio)) { unlink($ruta_audio); }
        }

        // 2. BORRAR REGISTRO DE LA BASE DE DATOS
        $sql = "DELETE FROM productos WHERE id = $id";
        
        if ($conn->query($sql) === TRUE) {
            // Éxito: Volvemos al admin con un mensaje
            header("Location: admin.php?eliminado=1");
        } else {
            echo "Error al eliminar: " . $conn->error;
        }
    } else {
        echo "El producto no existe.";
    }
} else {
    header("Location: admin.php");
}
?>