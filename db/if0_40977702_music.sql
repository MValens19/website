-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql303.infinityfree.com
-- Tiempo de generación: 26-01-2026 a las 14:24:55
-- Versión del servidor: 11.4.9-MariaDB
-- Versión de PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `if0_40977702_music`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `audio_url` varchar(255) DEFAULT NULL,
  `link_descarga` varchar(255) DEFAULT NULL,
  `fecha_subida` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `titulo`, `categoria`, `descripcion`, `imagen_url`, `audio_url`, `link_descarga`, `fecha_subida`) VALUES
(8, 'Keyzone Classic', 'Pianos', 'Keyzone Classic es un sample basado en:\r\n\r\n    Piano from Keyzone 1.\r\n    Yamaha Grand Piano.\r\n    Steinway Grand Piano.\r\n    Basic Electric Piano.\r\n    Rhodes Piano.\r\n', '../uploads/6977ac18478c0_img_keyzone.png', '', 'https://plugins4free.com/plugin/2848/', '2026-01-26 10:02:00'),
(4, 'GR-8 Synth', 'Synth', 'GR-8 es un sintetizador analógico virtual de 8 voces con efectos incorporados y un arpegiador.\r\n\r\nCaracterísticas:\r\n\r\n - Arpeggiator : 5 Modos (Arriba, Abajo, Alt 1, Alt 2, Aleatorio), 4 Octaves Range.\r\n - Modos de voz: Mono, Unison (8 voces), Chord (4 notas estéreo), Poly (8 voces).\r\n - Efectos de voz: Deslizado, Legato, Desatún de voz, Estéreo de voz extendido.\r\n - Osciladores : OSC 1 (Tri, Sierra, Pulso, Cuadrado), OSC 2 (Seno, Sierra, Pulso, Ruido).\r\n - Efectos del oscilador: Modulación cruzada (FM), Modulación de ancho de pulso        (PWM), Sincronización.\r\n- Filtros : Paso alto no resonante, paso bajo resonante (12, 18 o 24 dB/octava).\r\n- Modulación : Ganadora de paso, Rueda Mod, LFO, 2 Sobres.\r\n- EffectsEfectos: EQ, Distorsión, Phaser, Coro/Flanger, Retardo, Reverberación.\r\n- Presets : 128.\r\n', 'https://static.kvraudio.com/i/b/gr-8-synth2x.1733660429.jpg', '', 'https://www.kvraudio.com/product/gr-8-by-phuturetone', '2026-01-26 08:23:10'),
(3, 'MI GOZO BARAK - SECUENCIA', 'Secuencias', 'Secuencia con todo el Multitrack en formato .wav\r\nSe puede utilizar en cualquier daw', 'https://i.ytimg.com/vi/IxD3JiOo9DY/sddefault.jpg?v=63536d8c', 'https://youtu.be/IxD3JiOo9DY?si=M3X99ehGUYGx-Za-', 'https://drive.google.com/drive/folders/1MJTVH6Ede3eKWfQIGtylRRv0Iy-zw5J2', '2026-01-24 13:51:22'),
(5, 'Piano One', 'Pianos', 'Piano One, el modelado híbrido gratuito Concierto de Yamaha Grand.\r\n\r\nEl sonido del piano One proviene de la grand de conciertos Yamaha C7, un verdadero caballo de batalla en el mundo del piano profesional, que aparece en famosos escenarios de conciertos, en competiciones internacionales y en prestigiosos eventos musicales de todo el mundo.', '../uploads/69779c14d7011_img_piano1.png', '', 'https://plugins4free.com/plugin/1100/', '2026-01-26 08:53:40'),
(6, 'MT Power Drum Kit 2', 'Drums', 'MT Power Drum Kit 2 se lanzó en 2012, pero recientemente se convirtió en freeware. Es un plugin gratuito para batería acústica con mezclador integrado y una colección de grooves que puedes usar para crear canciones.\r\n\r\nPersonalmente no suena como bateria grabada en studio pero me suele recordar a baterias comprimidas de los 80\'s', '../uploads/69779ebb15933_img_mt-power-drum-kit-free.jpg', '', 'https://www.powerdrumkit.com/download76187.php', '2026-01-26 09:04:58'),
(7, 'Medley Alabanzas - Joel Batz', 'Secuencias', 'Secuencia con multitrack \r\nLink de descarga es directo de Google drive\r\nContiene:\r\n- Bass\r\n- Click\r\n- Drums\r\n- GTR\r\n- Guide\r\n- Keys\r\n- Lead\r\n- Synths\r\n- Brass', 'https://i.ytimg.com/vi/d95cewrKp0U/maxresdefault.jpg', '', 'https://drive.google.com/drive/folders/1Mc8f9G33qd3wNYVIwIQtqLq2FB4UzP1I', '2026-01-26 09:31:58'),
(9, 'DPiano-A', 'Pianos', 'piano eléctrico con preajustes poco duros, pero se pueden suavizar fácilmente, y sus volúmenes deben ser rechazados por su GUI muy intuitiva. Lo superpuse con DDX10 Digital FM Synthesizer de Dead Duck Software', '../uploads/6977af91e0205_img_piano.webp', '', 'https://plugins4free.com/plugin/2812/', '2026-01-26 10:16:49'),
(10, 'Matt Tytel', 'Synth', 'Matt Tytel ha lanzado Vital , un sintetizador de tabla de ondas de deformación espectral gratuito en formatos de complemento VST , VST3, AU y LV2 para estaciones de trabajo de audio digital en Windows, macOS y Linux.\r\n\r\nVital está disponible en cuatro ediciones con diferentes precios:\r\n\r\n    Vital Basic – Gratis\r\n    Vital Plus – $25\r\n    Vital Pro – $80\r\n    Suscripción Vital – $5 al mes\r\n\r\nLa funcionalidad principal es la misma en las cuatro ediciones de Vital. Esto significa que puedes crear los mismos sonidos con Vital Basic (gratis) y Vital Pro (80 $).', '../uploads/6977b3125f163_img_vital-synthesizer-1200x703.png', '', 'https://vital.audio/', '2026-01-26 10:31:46'),
(11, 'Ambient Reverb 4.0', 'FX / Plugins', 'El Reverberbio Ambiental es un Reverberación algorítmica.\r\n\r\nEstá destinado en primer lugar para la operación con material de sonido en un género ambiental, aunque con éxito se puede aplicar también en otros estilos musicales y las direcciones.\r\n\r\nLa característica distintiva de este plug-in es el amplio rango de tiempo de reverberación (hasta 100 segundos) que permite recibir tipos de reverberación, diferentes caracteres, y también una oportunidad en un sentido literal para congelar sonidos, al mismo tiempo para recibir almohadillas de sonido interesantes, como Frippertronics. El reverberador de Ambient Rever» funciona por el principio de la reverberación algorítmica con el cálculo de suficientes reflejos de sonido en el tiempo, permitiendo recibir una reverberación realista sin efecto de granularidad.\r\n\r\n    16 preajustes de fábrica.\r\n    Ecualizador paramétrico de 2 bandas.\r\n    Indicador y botones del nivel de entrada/salida.\r\n    Carga baja de la CPU/FPU.\r\n', 'https://media.plugins4free.com/img/Ambient-Reverb_2.jpg', '', 'https://plugins4free.com/plugin/2870/', '2026-01-26 10:35:37'),
(12, 'Dexed VST 0.9.6 Windows', 'Synth', 'Si está buscando un plugin de sintetizador VST tan bueno como DX7, Dexed VST Synth viene con 32 presets de fábrica gratuitos, definitivamente un gran plugin VST para agregar a la biblioteca de su productor.\r\n\r\nDexed VST es muy único, viene con 32 algoritmos diferentes que generarán 32 salidas diferentes de 1 sonido.', 'https://musictech.com/wp-content/uploads/2019/10/FM-synthesis-basics-DX7-plug-in-Dexed@2000x1500.jpg', '', 'https://www.producersbuzz.com/download/dexed-vst-0-9-6-windows/#unlock', '2026-01-26 10:59:55'),
(13, 'Steven Slate Batería Gratis', 'Drums', 'El VST gratuito de Steven Slate cumple a la perfección. Suena increíblemente sólido y realista, ofrece 3 presets listos para mezclar y permite la máxima personalización de tus sonidos. Con esta batería, estás listo para cualquier género musical.', '../uploads/6977be70dff4c_img_ssd_5_free_-_drum_kit_acoustic_1024x1024.jpg', '', 'https://stevenslatedrums.com/ssd5/', '2026-01-26 11:20:16');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
