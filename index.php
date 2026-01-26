<?php
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SonicMarket - Recursos Musicales</title>
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
                        cardbg: '#1e293b',
                    }
                }
            }
        }
    </script>
    <style>
        .hero-bg {
            background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.9)), url('https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?q=80&w=2070');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-darkbg text-white font-sans antialiased pb-24">

    <nav class="fixed w-full z-50 bg-darkbg/90 backdrop-blur border-b border-gray-800">
        <div class="w-full px-6 md:px-10">
            <div class="flex justify-between items-center h-16">
                <div class="text-2xl font-bold tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-primary to-purple-400">
                    SonicMarket
                </div>

                <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-400">
                    <a href="#" class="hover:text-white transition">Samples</a>
                    <a href="#" class="hover:text-white transition">Presets</a>
                    <a href="#" class="hover:text-white transition">Cursos</a>
                    <a href="login.php" class="bg-primary hover:bg-violet-600 text-white px-4 py-2 rounded-full font-bold shadow-lg hover:shadow-primary/50 transition">Iniciar Sesión</a>
                </div>

                <div class="md:hidden flex items-center">
                    <button onclick="toggleMenu()" class="text-gray-300 hover:text-white focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-cardbg border-b border-gray-700 absolute w-full left-0 shadow-2xl">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="#" class="block px-3 py-3 rounded-md text-base font-medium text-white hover:bg-gray-700 border-b border-gray-700">Samples</a>
                <a href="#" class="block px-3 py-3 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 border-b border-gray-700">Presets</a>
                <a href="#" class="block px-3 py-3 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Cursos</a>
                <a href="login.php" class="block px-3 py-3 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Iniciar Sesión</a>
            </div>
        </div>
    </nav>

    <header class="hero-bg h-[65vh] flex flex-col justify-center items-center text-center px-4 pt-16">
        <h1 class="text-4xl md:text-7xl font-extrabold mb-6 tracking-tight">
            Encuentra tu <span class="text-primary">sonido</span>
        </h1>
        <p class="text-gray-300 text-lg md:text-xl mb-10 max-w-2xl">
            Descargas directas y gratuitas para productores modernos.
        </p>

        <div class="relative w-full max-w-2xl group">
            <div class="absolute inset-y-0 left-0 flex items-center pl-6 pointer-events-none">
                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" id="searchInput" onkeyup="filtrarProductos()" class="w-full p-5 pl-14 text-base text-gray-900 border-none rounded-full bg-white/95 backdrop-blur focus:bg-white focus:ring-4 focus:ring-primary/50 shadow-2xl outline-none transition" placeholder="Busca 'Drums', 'Piano', 'Techno'...">
        </div>

        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <button onclick="filtrarTag('')" class="flex items-center gap-2 px-5 py-2 rounded-full border border-gray-600 bg-black/40 backdrop-blur hover:bg-white hover:text-black transition font-medium group">
                <i data-lucide="layout-grid" class="w-5 h-5"></i> Ver todo
            </button>
            <button onclick="filtrarTag('Secuencias')" class="flex items-center gap-2 px-5 py-2 rounded-full border border-gray-600 bg-black/40 backdrop-blur hover:border-primary hover:text-primary transition font-medium group">
                <i data-lucide="audio-waveform" class="w-5 h-5 group-hover:text-primary"></i> Secuencias
            </button>
            <button onclick="filtrarTag('Drums')" class="flex items-center gap-2 px-5 py-2 rounded-full border border-gray-600 bg-black/40 backdrop-blur hover:border-primary hover:text-primary transition font-medium group">
                <i data-lucide="drum" class="w-5 h-5 group-hover:text-primary"></i> Drums
            </button>
            <button onclick="filtrarTag('Pianos')" class="flex items-center gap-2 px-5 py-2 rounded-full border border-gray-600 bg-black/40 backdrop-blur hover:border-primary hover:text-primary transition font-medium group">
                <i data-lucide="piano" class="w-5 h-5 group-hover:text-primary"></i> Pianos
            </button>
            <button onclick="filtrarTag('Synth')" class="flex items-center gap-2 px-5 py-2 rounded-full border border-gray-600 bg-black/40 backdrop-blur hover:border-primary hover:text-primary transition font-medium group">
                <i data-lucide="keyboard-music" class="w-5 h-5 group-hover:text-primary"></i> Synth
            </button>
            <button onclick="filtrarTag('FX / Plugins')" class="flex items-center gap-2 px-5 py-2 rounded-full border border-gray-600 bg-black/40 backdrop-blur hover:border-primary hover:text-primary transition font-medium group">
                <i data-lucide="cable" class="w-5 h-5 group-hover:text-primary"></i> FX / Plugins
            </button>
        </div>

    </header>

    <main class="w-full px-6 md:px-10 py-16">
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
            <h2 class="text-3xl font-bold border-l-4 border-primary pl-4">Últimos Agregados</h2>
            <p class="text-gray-400 text-sm">Mostrando contenido reciente</p>
        </div>

        <div id="gridProductos" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-6">

            <?php
            $sql = "SELECT * FROM productos ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="group bg-cardbg rounded-xl overflow-hidden hover:-translate-y-2 transition duration-300 shadow-lg hover:shadow-primary/20 producto-item flex flex-col h-full border border-gray-800 hover:border-primary/30">

                        <div class="relative overflow-hidden h-48 flex-shrink-0">
                            <a href="/view/detalle_producto.php?id=<?php echo $row['id']; ?>" class="block w-full h-full">
                                <img src="<?php echo $row['imagen_url']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="Cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center backdrop-blur-[2px]">
                                    <span class="bg-white/10 text-white text-xs font-bold px-4 py-2 rounded-full border border-white/20">Ver detalles</span>
                                </div>
                            </a>

                            <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <?php if (!empty($row['audio_url'])): ?>
                                    <button onclick="reproducirDemo(<?php echo htmlspecialchars(json_encode($row['titulo'])); ?>, '<?php echo $row['categoria']; ?>', '<?php echo $row['audio_url']; ?>')"
                                        class="bg-primary text-white p-3 rounded-full hover:scale-110 transition shadow-lg shadow-primary/50">
                                        <i data-lucide="play" class="w-5 h-5 fill-current"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="p-4 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <p class="text-primary text-[10px] font-bold uppercase tracking-wider border border-primary/30 px-2 py-0.5 rounded tag-categoria">
                                    <?php echo $row['categoria']; ?>
                                </p>
                            </div>

                            <a href="detalles.php?id=<?php echo $row['id']; ?>" class="block group/link">
                                <h3 class="text-base font-bold text-white mb-2 titulo-prod truncate group-hover/link:text-primary transition-colors" title="<?php echo $row['titulo']; ?>">
                                    <?php echo $row['titulo']; ?>
                                </h3>
                                <p class="text-gray-400 text-xs mb-4 line-clamp-2 flex-grow">
                                    <?php echo $row['descripcion']; ?>
                                </p>
                            </a>

                            <div class="mt-auto pt-3 border-t border-gray-700/50">
                                <a href="<?php echo $row['link_descarga']; ?>" target="_blank" class="flex justify-center items-center gap-2 w-full bg-gray-800 hover:bg-primary text-white py-2 rounded-lg transition text-xs font-bold uppercase tracking-wide group-hover:bg-primary">
                                    <i data-lucide="download" class="w-4 h-4"></i>
                                    Descargar
                                </a>
                            </div>
                        </div>
                    </div>

            <?php
                }
            } else {
                echo "<div class='col-span-full text-center text-gray-500 py-20 bg-cardbg rounded-xl border border-dashed border-gray-700'>
                <i data-lucide='search-x' class='w-12 h-12 mx-auto mb-4 opacity-20'></i>
                <p class='text-xl'>No se encontraron productos.</p>
              </div>";
            }
            ?>
        </div>
    </main>

    <div id="audioPlayer" class="fixed bottom-0 left-0 w-full bg-darkbg/95 backdrop-blur border-t border-gray-700 p-3 transform translate-y-full transition-transform duration-500 z-50 shadow-[0_-5px_30px_rgba(0,0,0,0.5)]">
        <div class="w-full px-6 md:px-10 flex items-center justify-between gap-4">
            <div class="flex items-center gap-4 w-1/2 md:w-1/3">
                <div class="h-12 w-12 bg-gray-800 rounded overflow-hidden flex items-end justify-center pb-1 gap-1 flex-shrink-0">
                    <div class="w-1 bg-primary animate-pulse h-1/2"></div>
                    <div class="w-1 bg-primary animate-pulse h-3/4"></div>
                    <div class="w-1 bg-primary animate-pulse h-1/3"></div>
                </div>
                <div class="overflow-hidden">
                    <h4 id="playerTitle" class="text-white font-bold text-sm truncate">Selecciona un track</h4>
                    <p id="playerCat" class="text-primary text-xs uppercase">...</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button id="mainPlayBtn" class="bg-white text-black rounded-full p-3 hover:scale-105 transition shadow shadow-white/20">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
                    </svg>
                </button>
            </div>

            <div class="w-1/2 md:w-1/3 flex justify-end">
                <button onclick="cerrarPlayer()" class="text-gray-500 hover:text-red-500 transition p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        function toggleMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }

        function filtrarProductos() {
            const input = document.getElementById('searchInput').value.toUpperCase();
            const cards = document.getElementsByClassName('producto-item');
            for (let i = 0; i < cards.length; i++) {
                let titulo = cards[i].querySelector('.titulo-prod').innerText;
                let tag = cards[i].querySelector('.tag-categoria').innerText;
                if (titulo.toUpperCase().indexOf(input) > -1 || tag.toUpperCase().indexOf(input) > -1) {
                    cards[i].style.display = "";
                } else {
                    cards[i].style.display = "none";
                }
            }
        }

        function filtrarTag(categoria) {
            document.getElementById('searchInput').value = categoria;
            filtrarProductos();
        }
    </script>

    <script>
        // --- LÓGICA DE AUDIO REAL ---
        let playerVisible = false;
        let currentAudio = new Audio(); // Creamos el objeto de audio HTML5
        let isPlaying = false;

        function reproducirDemo(titulo, categoria, urlAudio) {
            const player = document.getElementById('audioPlayer');
            const playBtnIcon = document.getElementById('mainPlayBtn');

            // 1. Actualizamos Textos
            document.getElementById('playerTitle').innerText = titulo;
            document.getElementById('playerCat').innerText = categoria;

            // 2. Mostramos el reproductor si está oculto
            if (!playerVisible) {
                player.classList.remove('translate-y-full');
                playerVisible = true;
            }

            // 3. Lógica de reproducción
            // Si el audio que queremos tocar es diferente al que ya está cargado
            if (currentAudio.src !== urlAudio && currentAudio.src !== window.location.href + urlAudio) {
                currentAudio.src = urlAudio; // Cargamos la nueva canción
                currentAudio.play();
                isPlaying = true;
            } else {
                // Si es la misma canción, alternamos Pausa/Play
                if (currentAudio.paused) {
                    currentAudio.play();
                    isPlaying = true;
                } else {
                    currentAudio.pause();
                    isPlaying = false;
                }
            }
            actualizarIcono();
        }

        // Control del botón Play/Pause grande del reproductor flotante
        document.getElementById('mainPlayBtn').addEventListener('click', function() {
            if (currentAudio.src) {
                if (currentAudio.paused) {
                    currentAudio.play();
                    isPlaying = true;
                } else {
                    currentAudio.pause();
                    isPlaying = false;
                }
                actualizarIcono();
            }
        });

        function actualizarIcono() {
            const btn = document.getElementById('mainPlayBtn');
            if (isPlaying) {
                // Icono de Pausa
                btn.innerHTML = '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>';
            } else {
                // Icono de Play
                btn.innerHTML = '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>';
            }
        }

        function cerrarPlayer() {
            document.getElementById('audioPlayer').classList.add('translate-y-full');
            currentAudio.pause(); // Detener música al cerrar
            isPlaying = false;
            actualizarIcono();
        }
    </script>
            <script>
            lucide.createIcons();
        </script>

</body>

</html>