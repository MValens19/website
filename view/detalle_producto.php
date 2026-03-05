<?php
include '../conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $res = $conn->query("SELECT * FROM productos WHERE id = $id");
    if ($res && $res->num_rows > 0) {
        $p = $res->fetch_assoc();
    } else {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $p['titulo']; ?> - SonicMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8b5cf6',
                        darkbg: '#050a15'
                    }
                }
            }
        }
    </script>
        <link rel="icon" type="image/png" href="../img/logo.png">

    <style>
        .studio-bg {
            background: linear-gradient(rgba(5, 10, 21, 0.85), rgba(5, 10, 21, 0.95)),
                url('https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?q=80&w=2070');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>

<body class="studio-bg text-white min-h-screen font-sans">

    <nav class="p-6">
        <a href="../index.php" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition">
            <i data-lucide="arrow-left" class="w-5 h-5"></i> Volver a la librería
        </a>
    </nav>

    <main class="container mx-auto px-4 py-10">
        <div class="flex flex-col lg:flex-row gap-12 items-center lg:items-start">

            <div class="relative group w-full max-w-md">
                <div class="rounded-2xl overflow-hidden shadow-2xl border border-white/10">
                    <img src="<?php echo $p['imagen_url']; ?>" alt="Cover" class="w-full aspect-square object-cover">
                </div>

                <a href="<?php echo $p['link_descarga']; ?>" target="_blank"
                    class="absolute -bottom-6 -right-3 bg-primary hover:bg-violet-600 text-white p-6 rounded-full shadow-[0_0_30px_rgba(139,92,246,0.5)] transition-transform hover:scale-110 flex items-center justify-center">
                    <i data-lucide="download" class="w-5 h-5"></i>
                </a>

            </div>

           <div class="flex-1 flex flex-col space-y-6 text-center lg:text-left">
    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
        <span class="text-primary font-bold uppercase tracking-widest text-sm bg-primary/10 px-3 py-1 rounded-lg border border-primary/20">
            <?php echo $p['categoria']; ?>
        </span>
        
        <?php if (!empty($p['tamano'])): ?>
            <span class="inline-flex items-center gap-2 text-gray-400 font-medium text-sm bg-white/5 px-3 py-1 rounded-lg border border-white/10">
                <i data-lucide="database" class="w-4 h-4 text-gray-500"></i>
                <?php echo $p['tamano']; ?>
            </span>
        <?php endif; ?>
    </div>

    <h1 class="text-4xl md:text-6xl font-black leading-tight text-white">
        <?php echo $p['titulo']; ?>
    </h1>

    <div class="bg-black/40 backdrop-blur-md p-6 rounded-2xl border border-white/5 shadow-xl">
        <h3 class="text-gray-500 text-xs uppercase font-bold mb-3 tracking-widest flex items-center gap-2">
            <i data-lucide="align-left" class="w-3 h-3"></i> 
            Descripción del producto
        </h3>
        <p class="text-gray-200 text-lg leading-relaxed">
            <?php echo nl2br(htmlspecialchars($p['descripcion'])); ?>
        </p>
    </div>

     <div class="flex flex-wrap gap-4 justify-center lg:justify-start pt-4">
                <div class="flex items-center gap-2 text-gray-400 text-sm">
                    <i data-lucide="check-circle" class="w-4 h-4 text-green-500"></i> Descarga Gratuita
                </div>
                <div class="flex items-center gap-2 text-gray-400 text-sm">
                    <i data-lucide="shield-check" class="w-4 h-4 text-blue-500"></i> Verificado por SonicMarket
                </div>
            </div>
    </div>

            <?php if ($p['audio_url']): ?>
                <div class="bg-white/5 backdrop-blur-xl p-8 rounded-3xl border border-white/10 shadow-inner">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-primary/20 p-2 rounded-lg">
                            <i data-lucide="music" class="text-primary w-6 h-6"></i>
                        </div>
                        <h4 class="font-bold">Escuchar Demo Preview</h4>
                    </div>
                    <audio controls class="w-full h-12 accent-primary">
                        <source src="<?php echo $p['audio_url']; ?>" type="audio/mpeg">
                        Tu navegador no soporta el reproductor.
                    </audio>
                </div>
            <?php endif; ?>


        </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>