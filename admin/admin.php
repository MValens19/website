<?php
session_start();
include '../conexion.php';

// Seguridad: Si no es admin, fuera
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Lógica del Buscador
$where = "";
if (isset($_GET['busqueda'])) {
    $b = $conn->real_escape_string($_GET['busqueda']);
    $where = "WHERE titulo LIKE '%$b%' OR categoria LIKE '%$b%'";
}

$sql = "SELECT * FROM productos $where ORDER BY id DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - SonicMarket</title>
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

<body class="bg-darkbg text-white min-h-screen">

    <nav class="bg-cardbg border-b border-gray-700 px-6 py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <span class="font-bold text-primary text-xl">SonicPanel</span>
                <a href="index.php" target="_blank" class="text-sm text-gray-400 hover:text-white flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Ver Web
                </a>
            </div>

            <div class="flex items-center gap-4 w-full md:w-auto">
                <form action="" method="GET" class="relative w-full md:w-64">
                    <input type="text" name="busqueda" placeholder="Buscar producto..." class="w-full bg-darkbg border border-gray-600 rounded-full py-2 px-4 pl-10 text-sm focus:border-primary outline-none">
                    <svg class="w-4 h-4 text-gray-500 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </form>
                <a href="../logout.php" class="text-red-400 hover:text-red-300 font-bold text-sm">Salir</a>
            </div>
        </div>
    </nav>


    <main class="max-w-7xl mx-auto px-6 py-8">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-lg font-bold">Mis Productos (<?php echo $resultado->num_rows; ?>)</h1>

            <a href="agregar_producto.php" class="bg-primary hover:bg-violet-600 text-white px-6 py-3 rounded-lg font-bold shadow-lg hover:shadow-primary/50 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Producto
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            <?php if ($resultado->num_rows > 0): ?>
                <?php while ($row = $resultado->fetch_assoc()): ?>

                    <div class="bg-cardbg rounded-xl overflow-hidden border border-gray-700 hover:border-gray-500 transition group relative">
                        <div class="h-40 overflow-hidden relative">
                            <img src="<?php echo $row['imagen_url']; ?>" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition">
                            <span class="absolute top-2 right-2 bg-black/70 text-primary text-xs font-bold px-2 py-1 rounded border border-gray-600">
                                <?php echo $row['categoria']; ?>
                            </span>
                        </div>

                        <div class="p-4">
                            <h3 class="font-bold text-white truncate text-lg" title="<?php echo $row['titulo']; ?>">
                                <?php echo $row['titulo']; ?>
                            </h3>
                            <p class="text-gray-400 text-xs mt-1 truncate">
                                Audio: <?php echo $row['audio_url'] ? 'Sí' : 'No'; ?>
                            </p>
                            <p class="text-gray-500 text-xs mt-2">
                                ID: #<?php echo $row['id']; ?> | Subido: <?php echo date("d/m/y", strtotime($row['fecha_subida'])); ?>
                            </p>

                            <div class="flex gap-2 mt-4 pt-3 border-t border-gray-700">
                                <a href="editar_productos.php?id=<?php echo $row['id']; ?>"
                                    class="flex-1 text-xs bg-gray-700 hover:bg-gray-600 py-2 rounded text-gray-300 text-center flex items-center justify-center gap-1 transition">
                                    <i data-lucide="pencil" class="w-3 h-3"></i> Editar
                                </a>

                                <button onclick="confirmarBorrado(<?php echo $row['id']; ?>)"
                                    class="flex-1 text-xs bg-red-900/30 hover:bg-red-600 text-red-400 hover:text-white py-2 rounded border border-red-900/50 transition duration-300 flex items-center justify-center gap-1">
                                    <i data-lucide="trash-2" class="w-3 h-3"></i> Borrar
                                </button>
                            </div>

                            <script>
                                function confirmarBorrado(id) {
                                    if (confirm("¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.")) {
                                        window.location.href = "eliminar_producto.php?id=" + id;
                                    }
                                }
                                // Inicializar iconos de Lucide
                                lucide.createIcons();
                            </script>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-20 text-gray-500">
                    <p class="text-xl">No se encontraron productos.</p>
                    <p>¡Dale al botón de "Nuevo Producto" para empezar!</p>
                </div>
            <?php endif; ?>

        </div>
    </main>

</body>

</html>