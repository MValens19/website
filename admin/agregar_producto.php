<?php
session_start();
include '../conexion.php';

// Seguridad: Si no está logueado, fuera
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$mensaje = "";

// PROCESAR EL FORMULARIO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $link_descarga = $conn->real_escape_string($_POST['link_descarga']);

    // Carpeta para los audios
    $directorio = "../uploads/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // --- 1. PROCESAR IMAGEN (Prioridad: LINK) ---
    $imagen_final = "https://via.placeholder.com/800x600?text=Sin+Imagen";

    if (!empty($_POST['imagen_url'])) {
        $imagen_final = $conn->real_escape_string($_POST['imagen_url']);
    } elseif (isset($_FILES['imagen_archivo']) && $_FILES['imagen_archivo']['error'] == 0) {
        $nombre_img = uniqid() . "_img_" . basename($_FILES["imagen_archivo"]["name"]);
        if (move_uploaded_file($_FILES["imagen_archivo"]["tmp_name"], $directorio . $nombre_img)) {
            $imagen_final = $directorio . $nombre_img;
        }
    }

    // --- 2. PROCESAR AUDIO (Prioridad: UPLOAD) ---
    $audio_final = "";

    if (isset($_FILES['audio_archivo']) && $_FILES['audio_archivo']['error'] == 0) {
        $nombre_audio = uniqid() . "_demo_" . basename($_FILES["audio_archivo"]["name"]);
        if (move_uploaded_file($_FILES["audio_archivo"]["tmp_name"], $directorio . $nombre_audio)) {
            $audio_final = $directorio . $nombre_audio;
        }
    } elseif (!empty($_POST['audio_url'])) {
        $audio_final = $conn->real_escape_string($_POST['audio_url']);
    }

    // INSERTAR EN BASE DE DATOS
    $sql = "INSERT INTO productos (titulo, categoria, descripcion, imagen_url, audio_url, link_descarga) 
            VALUES ('$titulo', '$categoria', '$descripcion', '$imagen_final', '$audio_final', '$link_descarga')";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php?exito=1");
        exit;
    } else {
        $mensaje = "Error en base de datos: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto - SonicPanel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#8b5cf6',
                        darkbg: '#0f172a',
                        cardbg: '#1e293b'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-darkbg text-white min-h-screen pb-20">

    <nav class="border-b border-gray-700 p-4 mb-8 bg-cardbg sticky top-0 z-10">
        <div class="max-w-3xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-primary">Nuevo Recurso</h1>
            <a href="admin.php" class="text-gray-400 hover:text-white text-sm font-medium flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Cancelar y Volver
            </a>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4">

        <?php if ($mensaje) echo "<div class='bg-red-500/20 text-red-300 p-4 rounded-lg mb-6 border border-red-500'>$mensaje</div>"; ?>

       <form method="POST" enctype="multipart/form-data" class="bg-cardbg p-6 md:p-8 rounded-xl border border-gray-700 shadow-2xl space-y-8">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-bold text-gray-300 mb-2">Título del Producto</label>
            <input type="text" name="titulo" class="w-full bg-darkbg border border-gray-600 rounded-lg p-3 focus:border-primary outline-none transition" placeholder="Titulo..." required>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-300 mb-2">Categoría</label>
            <select name="categoria" class="w-full bg-darkbg border border-gray-600 rounded-lg p-3 focus:border-primary outline-none transition cursor-pointer">
                <option value="Secuencias">Secuencias</option>
                <option value="Drums">Drums</option>
                <option value="Pianos">Pianos</option>
                <option value="Synth">Synth / Presets</option>
                <option value="Brass">Brass</option>
                <option value="FX / Plugins">FX (Efectos) / Plugins</option>
                <option value="Cursos">Cursos</option>
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-300 mb-2">Descripción</label>
        <textarea name="descripcion" rows="3" class="w-full bg-darkbg border border-gray-600 rounded-lg p-3 focus:border-primary outline-none transition" placeholder="Describe brevemente el contenido..."></textarea>
    </div>

    <hr class="border-gray-700">

    <div>
        <label class="block text-sm font-bold text-primary mb-2 flex items-center gap-2">
            <i data-lucide="image" class="w-5 h-5"></i>
            Imagen de Portada
        </label>
        <input type="url" name="imagen_url" placeholder="Pega aquí el link de la imagen (Ej: https://imgur.com/...)" class="w-full bg-darkbg border border-gray-600 rounded-lg p-3 focus:border-primary outline-none mb-2">

        <details class="text-xs text-gray-500">
            <summary class="cursor-pointer hover:text-gray-300">¿Prefieres subir un archivo?</summary>
            <input type="file" name="imagen_archivo" accept="image/*" class="mt-2 block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-gray-700 file:text-white hover:file:bg-gray-600">
        </details>
    </div>

    <div class="bg-darkbg/50 p-4 rounded-lg border border-dashed border-gray-600">
        <label class="block text-sm font-bold text-primary mb-2 flex items-center gap-2">
            <i data-lucide="music" class="w-5 h-5"></i>
            Audio Demo (Preview)
        </label>
        <p class="text-xs text-gray-400 mb-3">Sube un MP3 corto (Recomendado: menos de 2MB) a la carpeta <b>/uploads</b>.</p>

        <input type="file" name="audio_archivo" accept="audio/*" class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-primary file:text-white file:font-bold hover:file:bg-violet-600 cursor-pointer">

        <div class="mt-4 pt-2 border-t border-gray-700">
            <input type="url" name="audio_url" placeholder="O pega un link de audio externo..." class="w-full bg-transparent border border-gray-600 rounded p-2 text-xs focus:border-gray-400 outline-none">
        </div>
    </div>

    <hr class="border-gray-700">

    <div>
        <label class="block text-sm font-bold text-green-400 mb-2 flex items-center gap-2">
            <i data-lucide="link" class="w-5 h-5"></i>
            Link de Descarga (El producto real)
        </label>
        <input type="url" name="link_descarga" class="w-full bg-darkbg border border-green-900/50 text-green-100 rounded-lg p-3 focus:border-green-500 outline-none transition" placeholder="https://drive.google.com/file/d/..." required>
    </div>

    <button type="submit" class="w-full bg-gradient-to-r from-primary to-purple-600 hover:from-purple-600 hover:to-primary text-white font-bold py-4 rounded-xl shadow-lg transform hover:scale-[1.01] transition duration-300 flex justify-center items-center gap-2">
        <i data-lucide="send" class="w-6 h-6"></i>
        Publicar Producto
    </button>

    <script>
        lucide.createIcons();
    </script>
</form>

        <div class="h-20"></div>
    </main>
</body>

</html>