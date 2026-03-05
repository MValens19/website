<?php
// 1. LÓGICA DE PROCESAMIENTO (Lo que ya tenías)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}

$mensaje = "";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $res = $conn->query("SELECT * FROM productos WHERE id = $id");
    if ($res && $res->num_rows > 0) {
        $p = $res->fetch_assoc();
    } else {
        die("Error: El producto no existe.");
    }
} else {
    header("Location: admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $link_descarga = $conn->real_escape_string($_POST['link_descarga']);
    $directorio_subida = "../uploads/";
    $ruta_bd = "uploads/";
    $tamano = !empty($_POST['tamano']) ? $conn->real_escape_string($_POST['tamano']) : NULL;

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



    $sql = "UPDATE productos SET titulo='$titulo', categoria='$categoria', descripcion='$descripcion', 
        imagen_url='$imagen_final', audio_url='$audio_final', tamano='$tamano', 
        link_descarga='$link_descarga' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>window.location.href='admin.php?editado=1';</script>";
        exit;
    } else {
        $mensaje = "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - SonicMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
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
        <link rel="icon" type="image/png" href="../img/logo.png">

</head>

<body class="bg-darkbg text-white min-h-screen p-4 md:p-8">

    <div class="max-w-full mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl md:text-2xl font-bold flex items-center gap-3">
                    <i data-lucide="pencil-line" class="text-primary w-5 h-5"></i> Editar Producto
                </h1>
                <p class="text-gray-400 text-sm mt-1">ID del recurso: #<?php echo $id; ?></p>
            </div>
            <a href="admin.php" class="bg-gray-800 hover:bg-gray-700 px-6 py-3 rounded-xl text-sm font-medium transition flex items-center gap-2 shadow-lg">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Volver al panel de control
            </a>
        </div>

        <?php if ($mensaje) echo "<p class='bg-red-500/20 text-red-400 p-4 rounded-xl mb-6 border border-red-500/50'>$mensaje</p>"; ?>

        <form method="POST" enctype="multipart/form-data" class="bg-cardbg p-6 md:p-10 rounded-3xl border border-gray-700 shadow-2xl space-y-8">

            <input type="hidden" name="imagen_actual" value="<?php echo $p['imagen_url']; ?>">
            <input type="hidden" name="audio_actual" value="<?php echo $p['audio_url']; ?>">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                <div class="space-y-6">
                    <h2 class="text-lg font-semibold text-gray-300 border-l-4 border-primary pl-3">Información General</h2>

                    <?php
                        // Lógica para separar el tamaño actual (ej: "1.5 GB")
                        $val_num = "";
                        $val_unit = "MB";
                        if (!empty($p['tamano'])) {
                            $partes = explode(" ", $p['tamano']);
                            $val_num = $partes[0];
                            $val_unit = isset($partes[1]) ? $partes[1] : "MB";
                        }
                        ?>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Título</label>
                            <input type="text" name="titulo" value="<?php echo htmlspecialchars($p['titulo']); ?>" class="w-full bg-darkbg border border-gray-600 rounded-xl p-4 focus:border-primary outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Categoría</label>
                            <select name="categoria" class="w-full bg-darkbg border border-gray-600 rounded-xl p-4 focus:border-primary outline-none cursor-pointer">
                                <option value="Secuencias" <?php if ($p['categoria'] == 'Secuencias') echo 'selected'; ?>>Secuencias</option>
                                <option value="Drums" <?php if ($p['categoria'] == 'Drums') echo 'selected'; ?>>Drums</option>
                                <option value="Pianos" <?php if ($p['categoria'] == 'Pianos') echo 'selected'; ?>>Pianos</option>
                                <option value="Synth" <?php if ($p['categoria'] == 'Synth') echo 'selected'; ?>>Synth / Presets</option>
                                <option value="Software" <?php if ($p['categoria'] == 'Software') echo 'selected'; ?>>Software</option>
                                <option value="FX / Plugins" <?php if ($p['categoria'] == 'FX / Plugins') echo 'selected'; ?>>FX / Plugins</option>
                                <option value="Brass" <?php if ($p['categoria'] == 'Brass') echo 'selected'; ?>>Brass</option>
                                <option value="Cursos" <?php if ($p['categoria'] == 'Cursos') echo 'selected'; ?>>Cursos</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Tamaño del Archivo</label>
                            <div class="flex gap-2">
                                <select id="edit_unidad" class="bg-darkbg border border-gray-600 rounded-xl p-4 focus:border-primary outline-none text-sm">
                                    <option value="MB" <?php if ($val_unit == 'MB') echo 'selected'; ?>>MB</option>
                                    <option value="GB" <?php if ($val_unit == 'GB') echo 'selected'; ?>>GB</option>
                                </select>
                                <input type="number" id="edit_num" step="0.1" min="0" value="<?php echo $val_num; ?>" placeholder="0.0" class="w-full bg-darkbg border border-gray-600 rounded-xl p-4 focus:border-primary outline-none transition">
                                <input type="hidden" name="tamano" id="edit_tamano_final" value="<?php echo $p['tamano']; ?>">
                            </div>
                        </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Descripción Detallada</label>
                    <textarea name="descripcion" rows="10" class="w-full bg-darkbg border border-gray-600 rounded-xl p-4 focus:border-primary outline-none transition resize-none"><?php echo htmlspecialchars($p['descripcion']); ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-green-400 mb-2 flex items-center gap-2">
                        <i data-lucide="link" class="w-4 h-4"></i> Link de Descarga (Google Drive, Mega, etc.)
                    </label>
                    <input type="url" name="link_descarga" value="<?php echo $p['link_descarga']; ?>" class="w-full bg-darkbg border border-green-900/30 text-green-100 rounded-xl p-4 focus:border-green-500 outline-none transition" required>
                </div>
                
    <div class="pt-6 border-t border-gray-700 flex flex-col md:flex-row gap-4">
        <button type="submit" class="flex-1 bg-primary hover:bg-violet-600 text-white font-extrabold py-5 rounded-2xl shadow-lg shadow-primary/20 transition-all transform hover:scale-[1.01] active:scale-[0.98] flex justify-center items-center gap-3 text-lg">
            <i data-lucide="save" class="w-6 h-6"></i> Actualizar Producto
        </button>
        <a href="admin.php" class="md:w-1/4 bg-gray-800 hover:bg-red-500/20 hover:text-red-400 text-gray-400 font-bold py-5 rounded-2xl transition-all text-center">
            Descartar
        </a>
    </div>
            </div>

            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-gray-300 border-l-4 border-primary pl-3">Multimedia y Preview</h2>

                <div class="bg-darkbg/50 p-6 rounded-2xl border border-gray-700">
                    <label class="block text-sm font-bold text-primary mb-4 flex items-center gap-2 uppercase tracking-wider">
                        <i data-lucide="image" class="w-5 h-5"></i> Miniatura Actual
                    </label>

                    <div class="flex flex-col xl:flex-row gap-6 items-center">
                        <div class="w-full xl:w-64 h-64 rounded-xl overflow-hidden border-2 border-gray-600 shadow-2xl flex-shrink-0">
                            <img id="preview-img" src="../<?php echo $p['imagen_url']; ?>"
                                class="w-full h-full object-cover"
                                onerror="this.src='<?php echo $p['imagen_url']; ?>'">
                        </div>

                        <div class="flex-1 w-full space-y-4">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">URL de la imagen</label>
                                <input type="url" name="imagen_url" id="imagen_url_input"
                                    value="<?php echo (strpos($p['imagen_url'], 'http') === 0) ? $p['imagen_url'] : ''; ?>"
                                    class="w-full bg-darkbg border border-gray-600 rounded-lg p-3 text-sm focus:border-primary outline-none transition">
                            </div>
                            <div class="relative">
                                <p class="text-xs text-gray-500 mb-2 italic text-center xl:text-left">O sube un archivo local:</p>
                                <input type="file" name="imagen_archivo" accept="image/*"
                                    class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-gray-700 file:text-white hover:file:bg-gray-600 cursor-pointer">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="bg-darkbg/50 p-6 rounded-2xl border border-dashed border-gray-600">
                    <label class="block text-sm font-bold text-primary mb-4 flex items-center gap-2 uppercase tracking-wider">
                        <i data-lucide="music" class="w-5 h-5"></i> Audio Demo
                    </label>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Link de Audio Externo</label>
                            <input type="url" name="audio_url"
                                value="<?php echo (strpos($p['audio_url'], 'http') === 0) ? $p['audio_url'] : ''; ?>"
                                class="w-full bg-darkbg border border-gray-600 rounded-lg p-3 text-sm focus:border-primary outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">O subir nuevo MP3</label>
                            <input type="file" name="audio_archivo" accept="audio/*"
                                class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-primary file:text-white file:font-bold hover:file:bg-violet-600 cursor-pointer">
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-black/40 rounded-xl border border-gray-800">
                        <p class="text-[10px] text-gray-500 mb-2 uppercase font-bold">Reproductor de Previsualización</p>
                        <audio controls class="w-full h-10 accent-primary">
                            <source src="../<?php echo $p['audio_url']; ?>" type="audio/mpeg">
                            <source src="<?php echo $p['audio_url']; ?>" type="audio/mpeg">
                        </audio>
                    </div>
                </div>
            </div>
    </div>

    </form>
    </div>

    <script>
        lucide.createIcons();
        // Lógica para sincronizar los campos de tamaño en la edición
        const editNum = document.getElementById('edit_num');
        const editUnit = document.getElementById('edit_unidad');
        const editFinal = document.getElementById('edit_tamano_final');

        function sincronizarTamano() {
            if (editNum.value && editNum.value > 0) {
                editFinal.value = editNum.value + ' ' + editUnit.value;
            } else {
                editFinal.value = ''; // Se enviará como NULL en el PHP
            }
        }

        editNum.addEventListener('input', sincronizarTamano);
        editUnit.addEventListener('change', sincronizarTamano);
    </script>
</body>

</html>