<?php
// 1. ACTIVAR ERRORES PARA VER QUÉ PASA
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// 2. RUTA CORREGIDA: Salimos de /admin para buscar conexion.php en la raíz
include '../conexion.php'; 

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$mensaje = "";

// 3. OBTENER DATOS DEL PRODUCTO
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Ahora $conn ya no será NULL porque el include de arriba funciona
    $res = $conn->query("SELECT * FROM productos WHERE id = $id");
    
    if ($res && $res->num_rows > 0) {
        $p = $res->fetch_assoc();
    } else {
        die("Error: El producto con ID $id no existe.");
    }
} else {
    header("Location: admin.php");
    exit;
}

// 4. PROCESAR LA EDICIÓN
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $link_descarga = $conn->real_escape_string($_POST['link_descarga']);
    
    // Ruta para subir archivos: Volvemos atrás para llegar a /uploads
    $directorio_subida = "../uploads/"; 
    
    // Ruta que guardaremos en la BD (sin los puntos, para que index.php la lea bien)
    $ruta_bd = "uploads/";

    $imagen_final = $_POST['imagen_actual'];
    if (!empty($_POST['imagen_url'])) {
        $imagen_final = $conn->real_escape_string($_POST['imagen_url']);
    } elseif (isset($_FILES['imagen_archivo']) && $_FILES['imagen_archivo']['error'] == 0) {
        $nombre_img = uniqid() . "_img_" . basename($_FILES["imagen_archivo"]["name"]);
        if (move_uploaded_file($_FILES["imagen_archivo"]["tmp_name"], $directorio_subida . $nombre_img)) {
            $imagen_final = $ruta_bd . $nombre_img;
        }
    }

    $audio_final = $_POST['audio_actual'];
    if (isset($_FILES['audio_archivo']) && $_FILES['audio_archivo']['error'] == 0) {
        $nombre_audio = uniqid() . "_demo_" . basename($_FILES["audio_archivo"]["name"]);
        if (move_uploaded_file($_FILES["audio_archivo"]["tmp_name"], $directorio_subida . $nombre_audio)) {
            $audio_final = $ruta_bd . $nombre_audio;
        }
    } elseif (!empty($_POST['audio_url'])) {
        $audio_final = $conn->real_escape_string($_POST['audio_url']);
    }

    $sql = "UPDATE productos SET 
            titulo = '$titulo', 
            categoria = '$categoria', 
            descripcion = '$descripcion', 
            imagen_url = '$imagen_final', 
            audio_url = '$audio_final', 
            link_descarga = '$link_descarga' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Usamos JS para redireccionar y evitar problemas de headers en InfinityFree
        echo "<script>window.location.href='admin.php?editado=1';</script>";
        exit;
    } else {
        $mensaje = "Error al actualizar: " . $conn->error;
    }
}
?>