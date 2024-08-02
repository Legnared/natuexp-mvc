-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-07-2024 a las 23:21:23
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `natuexp_com`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `activo`) VALUES
(1, 'Extracto/Elixir', 1),
(2, 'Cápsulas', 1),
(3, 'Café', 1),
(4, 'Crema', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorys`
--

CREATE TABLE `categorys` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorys`
--

INSERT INTO `categorys` (`id`, `nombre`) VALUES
(1, 'Conferencias'),
(2, 'Talleres');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `nombre_paciente` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos_paciente` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `paciente_id`, `fecha`, `hora`, `nombre_paciente`, `apellidos_paciente`, `descripcion`) VALUES
(1, 1, '2024-07-22', '10:00:00', 'Ángel Guillermo', 'Hernández Zambrano', 'Revisión');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_medica`
--

CREATE TABLE `citas_medica` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` enum('Masculino','Femenino') COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_hora` datetime NOT NULL,
  `motivo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_consulta` enum('General','Especialista','Urgencias') COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_seguro` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aceptar_terminos` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `citas_medica`
--

INSERT INTO `citas_medica` (`id`, `nombre`, `fecha_nacimiento`, `sexo`, `telefono`, `email`, `direccion`, `fecha_hora`, `motivo`, `tipo_consulta`, `numero_seguro`, `aceptar_terminos`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'Ángel Guillermo Hernandez Zambrano', '1993-01-29', 'Masculino', '4432183103', 'angelguillermohernandezz@gmail.com', 'Acuitzeramo 12 Morelia Michoacán 58337', '2024-07-30 12:00:00', 'test', 'General', '1515151515151', 0, '2024-07-30 16:18:36', '2024-07-30 16:18:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asunto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `creado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `nombre`, `email`, `asunto`, `mensaje`, `creado`) VALUES
(1, 'Ángel Guillermo', 'angelguillermohernandezz@gmail.com', 'hola', 'test', '2024-07-31 01:25:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `c_terapia_alternativa`
--

CREATE TABLE `c_terapia_alternativa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `edad` varchar(15) NOT NULL,
  `sexo` char(10) NOT NULL,
  `peso` varchar(10) NOT NULL,
  `estatura` varchar(10) NOT NULL,
  `diabetes` char(10) NOT NULL,
  `cancer` char(10) NOT NULL,
  `obesidad` char(10) NOT NULL,
  `depresion` char(10) NOT NULL,
  `infarto` char(10) NOT NULL,
  `estrinido` char(10) NOT NULL,
  `alergia` char(10) NOT NULL,
  `gastritis` char(10) NOT NULL,
  `artritis` char(10) NOT NULL,
  `chatarra` char(10) NOT NULL,
  `fumador` char(10) NOT NULL,
  `bebedor` char(10) NOT NULL,
  `cirujias` char(10) NOT NULL,
  `embarazos` char(10) NOT NULL,
  `abortos` char(10) NOT NULL,
  `expediente_file` varchar(255) NOT NULL,
  `oximetro` varchar(15) NOT NULL,
  `presion` varchar(15) NOT NULL,
  `glucosa` varchar(15) NOT NULL,
  `unas` varchar(15) NOT NULL,
  `sintoma_diagnostico` text NOT NULL,
  `r_corazon` text NOT NULL,
  `r_rinon` text NOT NULL,
  `r_cerebro` text NOT NULL,
  `r_estomago` text NOT NULL,
  `r_huesos` text NOT NULL,
  `tratamiento` text NOT NULL,
  `estatus` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_eliminacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `url_avance` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `c_terapia_alternativa`
--

INSERT INTO `c_terapia_alternativa` (`id`, `nombre`, `apellidos`, `edad`, `sexo`, `peso`, `estatura`, `diabetes`, `cancer`, `obesidad`, `depresion`, `infarto`, `estrinido`, `alergia`, `gastritis`, `artritis`, `chatarra`, `fumador`, `bebedor`, `cirujias`, `embarazos`, `abortos`, `expediente_file`, `oximetro`, `presion`, `glucosa`, `unas`, `sintoma_diagnostico`, `r_corazon`, `r_rinon`, `r_cerebro`, `r_estomago`, `r_huesos`, `tratamiento`, `estatus`, `fecha_creacion`, `fecha_modificacion`, `fecha_eliminacion`, `usuario_id`, `url_avance`) VALUES
(1, 'Ángel Guillermo', 'Hernández Zambrano', '31 años', 'Masculino', '94 kgs', '1.79 mts', 'NA', 'NA', 'NA', 'YES', 'NO', 'YES', 'NO', 'YES', 'NO', 'YES', 'NO', 'NO', 'YES', 'NO', 'NO', '44c35165af3eb753b2477d499acbb0d6.pdf', '98', '170/90', 'Normal', 'Con Hongos', 'Dolor de estomago y color irritado', 'NA', 'NA', 'NA', 'NA', 'NA', 'Usaras Elixires', 1, '2024-06-17 21:40:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '4a5bc6dc039ad598dfb0423f968eee20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias`
--

CREATE TABLE `dias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dias`
--

INSERT INTO `dias` (`id`, `nombre`) VALUES
(1, 'Viernes'),
(2, 'Sábado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especie`
--

CREATE TABLE `especie` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `bre_descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `especie`
--

INSERT INTO `especie` (`id`, `nombre`, `bre_descripcion`) VALUES
(1, 'Hongos basidiomicetos (Basidiomycota)', 'Desarrollan setas (basidiocarpos), de las cuales nacen las esporas reproductivas del hongo.'),
(2, 'Hongos ascomicetos (Ascomycota).', 'En lugar de setas tienen ascos, células sexuales productoras de esporas.'),
(3, 'Hongos glomeromicetos (Glomeromycota)', 'Son micorrizas, o sea, uniones simbióticas entre un hongo y las raíces de una planta. El hongo otorga nutrientes y agua, y las raíces aportan carbohidratos y vitaminas que el hongo no puede sintetizar.'),
(4, 'Hongos zigomicetos (Zygomycota).', 'Son mohos que forman zigosporas, es decir, esporas capaces de soportar condiciones adversas durante mucho tiempo hasta que finalmente puedan germinar.'),
(5, 'Hongos quitridiomicetos (Chytridiomycota)', 'Son hongos microscópicos y primitivos, generalmente acuáticos, que se reproducen por esporas flageladas (zoosporas).');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `disponibles` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `dia_id` int(11) NOT NULL,
  `hora_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `nombre`, `descripcion`, `disponibles`, `category_id`, `dia_id`, `hora_id`, `medico_id`) VALUES
(1, ' La importancia de los alimentos y como escoger los correctos', 'Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 50, 1, 1, 6, 20),
(2, ' Introducción a el Origen de las Setas Milenarias y el Impacto en la Salud.', 'Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 40, 1, 1, 1, 21),
(3, ' Setas Milenarias', 'Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 50, 1, 1, 4, 19),
(4, ' El Daño de los alimentos & impacto en nuestras Familias.', 'Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 50, 2, 1, 3, 21),
(5, ' Ganoderma Lucidum - Seta del Emperador HAN', 'Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 50, 2, 1, 2, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horas`
--

CREATE TABLE `horas` (
  `id` int(11) NOT NULL,
  `hora` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `horas`
--

INSERT INTO `horas` (`id`, `hora`) VALUES
(1, '10:00 - 10:55'),
(2, '11:00 - 11:55'),
(3, '12:00 - 12:55'),
(4, '13:00 - 13:55'),
(5, '16:00 - 16:55'),
(6, '17:00 - 17:55'),
(7, '18:00 - 18:55'),
(8, '19:00 - 19:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `apellido` varchar(40) DEFAULT NULL,
  `ciudad` varchar(20) DEFAULT NULL,
  `pais` varchar(20) DEFAULT NULL,
  `imagen` varchar(32) DEFAULT NULL,
  `tags` varchar(120) DEFAULT NULL,
  `redes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`id`, `nombre`, `apellido`, `ciudad`, `pais`, `imagen`, `tags`, `redes`) VALUES
(19, ' Ricardo', 'Silva', 'Mexico', 'Mexico', 'e7893c7b7f21216a072ba9c50443029c', 'Cirujano,Partero', '{\"facebook\":\"\",\"twitter\":\"\",\"youtube\":\"\",\"instagram\":\"\",\"tiktok\":\"\",\"github\":\"\"} '),
(20, ' Angel', 'Hernández', 'Mexico', 'Mexico', '5ed87ef9e67c16471d17d6a5ceadbbdb', 'Partero,Traumatologo', '{\"facebook\":\"\",\"twitter\":\"\",\"youtube\":\"\",\"instagram\":\"\",\"tiktok\":\"\",\"github\":\"\"} '),
(21, ' Jimena Cortez', 'Gonzalez Lopez', 'Mexico', 'Morelia', '7c14ad1e12a816013f0e6bf6fb7f293d', 'Cirujana,Partera,Cirujana', '{\"facebook\":\"\",\"twitter\":\"\",\"youtube\":\"\",\"instagram\":\"\",\"tiktok\":\"\",\"github\":\"\"}'),
(22, ' Valdovinos', 'Nicolai', 'Mexico', 'DF', '4e132dfb1d5c6d66a3c4a6f0b4b7b8c6', 'Cirujano,Partero', '{\"facebook\":\"\",\"twitter\":\"\",\"youtube\":\"\",\"instagram\":\"\",\"tiktok\":\"\",\"github\":\"\"} '),
(23, ' Morelos', 'Pavon', 'Mexico', 'Morelia', '83c9377d4e9e115806d649df228de2d6', 'Cardiologo,Partero', '{\"facebook\":\"\",\"twitter\":\"\",\"youtube\":\"\",\"instagram\":\"\",\"tiktok\":\"\",\"github\":\"\"} '),
(24, ' Nicolas Copernico', 'Gonzales', 'Moreli', 'México', '94bfeea58cdf26c21395418ba153b9a9', 'Cirujano,Oncología', '{\"facebook\":\"\",\"twitter\":\"\",\"youtube\":\"\",\"instagram\":\"\",\"tiktok\":\"\",\"github\":\"\"} '),
(25, ' Sofia', 'Gonzales', 'Morelia', 'México', '9ec0c6adccc4740c1fb0129a294ccef3', 'OncoloGA,Partera,Cirujana', '{\"facebook\":\"\",\"twitter\":\"\",\"youtube\":\"\",\"instagram\":\"\",\"tiktok\":\"\",\"github\":\"\"} ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacient`
--

CREATE TABLE `pacient` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `apellidos` varchar(90) NOT NULL,
  `edad` varchar(50) NOT NULL,
  `motivo_consulta` text NOT NULL,
  `tratamiento_sujerido` text NOT NULL,
  `tiempo_tratamiento_clinico` varchar(250) NOT NULL,
  `tiempo_tratamiento_sujerido` varchar(250) NOT NULL,
  `dosis_tratamiento` text NOT NULL,
  `expediente_file` varchar(250) NOT NULL,
  `genero` char(9) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `url_avance` varchar(120) NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_eliminacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `n_calle_avenida` varchar(60) NOT NULL,
  `n_exterior` varchar(10) NOT NULL,
  `n_interior` varchar(10) NOT NULL,
  `colonia_barrio` varchar(30) NOT NULL,
  `municipio_delegacion` varchar(30) NOT NULL,
  `estado_provincia` varchar(30) NOT NULL,
  `cp` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edad` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motivo_consulta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tratamiento_sujerido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tiempo_tratamiento_clinico` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnostico` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tiempo_tratamiento_sujerido` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dosis_tratamiento` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `expediente_file` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexo_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `url_avance` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_eliminacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `n_calle_avenida` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `n_exterior` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `n_interior` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `colonia_barrio` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipio_delegacion` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_provincia` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `presion_arterial` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel_azucar` decimal(5,2) DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `estatura` decimal(5,2) DEFAULT NULL,
  `temperatura` decimal(10,2) DEFAULT NULL,
  `diabetes` tinyint(1) DEFAULT 0,
  `cancer` tinyint(1) DEFAULT 0,
  `obesidad` tinyint(1) DEFAULT 0,
  `infartos` tinyint(1) DEFAULT 0,
  `alergias` tinyint(1) DEFAULT 0,
  `depresion` tinyint(1) DEFAULT 0,
  `artritis` tinyint(1) DEFAULT 0,
  `estrenimiento` tinyint(1) DEFAULT 0,
  `gastritis` tinyint(1) DEFAULT 0,
  `comida_chatarra` tinyint(1) DEFAULT 0,
  `fumas` tinyint(1) DEFAULT 0,
  `bebes` tinyint(1) DEFAULT 0,
  `cirugias` tinyint(1) DEFAULT 0,
  `embarazos` tinyint(1) DEFAULT 0,
  `abortos` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombre`, `apellidos`, `edad`, `motivo_consulta`, `tratamiento_sujerido`, `tiempo_tratamiento_clinico`, `diagnostico`, `observaciones`, `tiempo_tratamiento_sujerido`, `dosis_tratamiento`, `expediente_file`, `sexo_id`, `usuario_id`, `url_avance`, `estatus`, `fecha_creacion`, `fecha_modificacion`, `fecha_eliminacion`, `n_calle_avenida`, `n_exterior`, `n_interior`, `colonia_barrio`, `municipio_delegacion`, `estado_provincia`, `cp`, `fecha_nacimiento`, `presion_arterial`, `nivel_azucar`, `peso`, `estatura`, `temperatura`, `diabetes`, `cancer`, `obesidad`, `infartos`, `alergias`, `depresion`, `artritis`, `estrenimiento`, `gastritis`, `comida_chatarra`, `fumas`, `bebes`, `cirugias`, `embarazos`, `abortos`) VALUES
(1, 'Ángel Guillermo', 'Hernández Zambrano', '31', 'REVISION', 'NA', '1 año', 'Tiene Colón Irritado', 'Se dara tratamiento', '1 año', '30 gotas por la mañana y por la noche, 2 capsulas de Papaína - 20 minutos antes de cada comida.', '163bcef3fb4d13e907d4fc57e920f15f.pdf', 1, 2, '8c1c205c158c2efbd44176381e3f25d5', 1, '2024-07-11 03:53:56', '2024-07-19 04:32:36', '0000-00-00 00:00:00', 'Zamora', '549', '549', 'Molino de Parras', 'Michoacán', 'Morelia', '58010', '1993-01-29', '120/80', '6.20', '94.00', '1.79', '36.50', 0, 0, 0, 0, 0, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0),
(2, 'Ángel Guillermo', 'Hernández Zambrano', '31', 'NA', 'NA', '1 año', '', '', '1 año', '30 gotas por la mañana y por la noche, 2 capsulas de Papaína - 20 minutos antes de cada comida.', '0f00b4374cb3f4dd57105d3ef8ac6c65.pdf', 1, 1, '', 1, '2024-07-11 04:00:19', '2024-07-11 04:00:19', '0000-00-00 00:00:00', 'Zamora', '549', '549', 'Molino de Parras', 'Michoacán', 'Morelia', '58010', '1993-01-29', '120/80', '6.20', '94.00', '1.78', '36.50', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'Ángel Guillermo', 'Hernández Zambrano', '31', 'NA', 'NA', '1 año', '', '', '1 año', ' Los elixires se deben consumir 30 Gotas por la mañana en ayunas y despues de la cena igual 30 gotas. Las cápsulas de Papaína debe consumirse 20 min antes en los 3 horarios (Desayuno, Comida y Cena).', 'a6ce4111239d987815a243fd525a262d.pdf', 1, 1, '370b0e47404d9422919d105243710c32', 1, '2024-07-12 03:33:24', '2024-07-12 03:33:24', '0000-00-00 00:00:00', 'Zamora', '549', '549', 'Molino de Parras', 'Michoacán', 'Morelia', '58010', '1993-01-29', '110/85', '0.00', '90.00', '1.79', '36.50', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'Ángel Guillermo', 'Hernández Zambrano', '31', 'NA', 'NA', '1 año', '', '', '1 año', ' Los elixires se deben consumir 30 Gotas por la mañana en ayunas y despues de la cena igual 30 gotas. Las cápsulas de Papaína debe consumirse 20 min antes en los 3 horarios (Desayuno, Comida y Cena).', '7c6904cc2021879bb8ff58b08ef2aea8.pdf', 1, 1, '52dbee1c451b79eb5c17df39e8b690e7', 1, '2024-07-12 03:34:23', '2024-07-12 03:35:56', '0000-00-00 00:00:00', 'Zamora', '549', '549', 'Molino de Parras', 'Michoacán', 'Morelia', '58010', '1993-01-29', '110/85', '6.50', '90.00', '1.79', '36.50', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`id`, `nombre`) VALUES
(1, 'Aprendíz'),
(2, 'Constructor'),
(3, 'Líder');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id` int(11) NOT NULL,
  `perfil` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id`, `perfil`) VALUES
(1, 'Admin'),
(2, 'Paciente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `descripcion` text COLLATE utf8mb4_bin NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `imagen` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `tags` varchar(120) COLLATE utf8mb4_bin DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `descuento`, `cantidad`, `imagen`, `tags`, `categoria_id`, `activo`) VALUES
(2, ' Café Puro Con Ganoderma', 'El café con ganoderma, fortalece el sistema inmunológico, aumentando la energía, ayuda a desintoxicar, ayuda a perder peso sin comprometer la salud ofreciendo más de 200 fitonutrientes. \r\n<br>Sabor: Cappuccino.', '450.00', '290.00', 100, 'de8ce44b64756c69e0f0ab02f61f6221', 'Ayudar a reforzar nuestro sistema inmunológico ( sube las defensas de forma natural),Ayuda a calmar los nervios y ansied', 3, 0),
(3, ' Café Cappuccino', 'El café con ganoderma, fortalece el sistema inmunológico, aumentando la energía, ayuda a desintoxicar, ayuda a perder peso sin comprometer la salud ofreciendo más de 200 fitonutrientes.\r\n\r\nSabor: Cappuccino.', '450.00', '290.00', 100, '504b7ccc8f306f6804f8f9455a9723e8', 'Ayudar a reforzar nuestro sistema inmunológico ( sube las defensas de forma natural),Ayuda a calmar los nervios y ansied', 3, 0),
(4, ' Café Cappuccino Mocca', 'El Ganoderma lucidum es una medicación natural que se usa ampliamente y es recomendada por los médicos y los naturópatas asiáticos por sus efectos de apoyo sobre el sistema inmunológico.\r\n\r\nSabor: Mocca.', '450.00', '290.00', 100, 'f24e246f3a7f4a84cd1927ae190a9867', 'Ayudar a reforzar nuestro sistema inmunológico ( sube las defensas de forma natural),Ayuda a calmar los nervios y ansied', 3, 0),
(5, ' Café Baileys', 'El Ganoderma lucidum es una medicación natural que se usa ampliamente y es recomendada por los médicos y los naturópatas asiáticos por sus efectos de apoyo sobre el sistema inmunológico.\r\n\r\nSabor: Baileys.', '450.00', '290.00', 100, 'c5a511f47040b00959d66f91d8f6c1ad', 'Ayudar a reforzar nuestro sistema inmunológico ( sube las defensas de forma natural),Ayuda a calmar los nervios y ansied', 3, 0),
(6, ' Ganoderma Lucidum - Reishi', 'El Ganoderma lucidum es una medicación natural que se usa ampliamente y es recomendada por los médicos y los naturópatas asiáticos por sus efectos de apoyo sobre el sistema inmunológico.', '550.00', '390.00', 100, '3b53d13f39f40bd2d4290ae632f19586', 'Anticancerígenos: actualmente se está estudiando su uso como coadyuvante en la terapia contra el cáncer, con resultados ', 1, 0),
(7, ' Ganoderma Lucidum - Reishi', 'Mejora la función de glándulas adrenales, mantenido un balance endócrimo reduciendo la tensión nerviosa y la ansiedad, además que corrige lesiones hepáticas(hepatitis, cirrosis, etc).\r\nCombate a más de 100 enfermedades autoinmunes.', '700.00', '500.00', 100, '4681c432391152055ddf71fa39c8b8b9', 'Fortalece el sistema inmunológico,Desecha las toxinas,Anti-inflamatorio,Anti-Alérgico', 2, 0),
(8, ' Crema Dans Le Temps', 'Crema humectante con Ganoderma, ácido hialurónico, vitamina E y colágeno.\r\nHidrata, revitaliza, protege y reestructura la piel, reduce líneas de expresión.', '650.00', '450.00', 100, '08fa1df5539cd585c0dc216e47cddc1b', 'Protege de los Rayos V,Fortalece e Hidrata la piel,Acción anti envejecimiento en la crema como antiviral.,Anti-inflamato', 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `paquete_id` int(11) DEFAULT NULL,
  `pago_id` varchar(30) DEFAULT NULL,
  `token` varchar(8) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `registros`
--

INSERT INTO `registros` (`id`, `paquete_id`, `pago_id`, `token`, `usuario_id`) VALUES
(39, 1, '3T253660DB983135U', 'f751dcdc', 13),
(40, 1, '35U71096SH953282F', 'e8787631', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `setas`
--

CREATE TABLE `setas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` varchar(120) NOT NULL,
  `tags` varchar(120) NOT NULL,
  `especie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `setas`
--

INSERT INTO `setas` (`id`, `nombre`, `descripcion`, `imagen`, `tags`, `especie_id`) VALUES
(4, 'Ganoderma Lucidum - Reishi', 'El Ganoderma L. Es un basidiomiceto perteneciente a la familia de las poliporáceas. Crece en los bosques densos, húmedos y con poca luz.\r\n\r\nAparecen en árboles muertos, pinos y quercus. \r\n\r\nSus esporas tienen un recubrimiento externo que hace difícil su germinación. \r\nAntiguamente, cuando el hongo era descubierto, se debía guardar en secreto, aún a los familiares más cercanos. Su historia está muy bien documentada en la farmacopea china, escrita en el siglo I o II antes de Cristo durante la dinastía HAN, en ella se dice que tiene los más grandes y efectivos poderes curativos. \r\n\r\nVarios países actualmente conducen investigaciones muy sofisticadas acerca del cultivo y procesamiento de este hongo.\r\n\r\nEL HONGO DEL TERCER MILENIO', 'c3fd60178e6e29811383898265a6869a', 'Combate el cáncer de Mama.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE `sexo` (
  `id` int(11) NOT NULL,
  `sexo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`id`, `sexo`) VALUES
(1, 'Masculino'),
(2, 'Femenino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(15) CHARACTER SET utf8 NOT NULL,
  `foto` text CHARACTER SET utf8 NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  `token` varchar(13) CHARACTER SET utf8 DEFAULT NULL,
  `perfil` text CHARACTER SET utf8 DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `fecha_eliminacion` datetime DEFAULT NULL,
  `estado` tinyint(4) NOT NULL,
  `direccion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `telefono`, `foto`, `password`, `confirmado`, `token`, `perfil`, `fecha_creacion`, `fecha_modificacion`, `fecha_eliminacion`, `estado`, `direccion_id`) VALUES
(1, 'Angel Guillermo', 'Hernandez Zambrano', 'angelguillermohernandezz@gmail.com', '4432183103', '8e62d3a9e61c95270a699073e826652d', '$2y$10$pp8MUCgau7XQ7q8gqc6DluBSqWOuyn00hX71udyHwO/pEiUmq9VD2', 1, '', 'admin', '2023-03-09 22:38:56', '2023-03-27 08:41:13', NULL, 1, 0),
(2, ' Eduardo', 'Sandoval', 'llamahoy@gmail.com', '4433688682', 'c012e54ed4c64dabaecac5bc203ef3fc', '$2y$10$zy/uSzROy8ww7UGppBgG/euj7/HBKQWAD3.xWUM0I3GdH392S8cna', 1, '', 'admin', '2023-03-09 22:38:56', '2024-07-18 14:41:18', NULL, 1, 0),
(3, 'Vanessa', 'Farfan', 'vanessafarfan@gmail.com', '4431250145', '', '$2y$10$WdYsMUSz4fDUQck7IyQM7uWO6j1GCmXh8S2a5Two8j3ynYFFdDBcW', 1, '', 'admin', '2024-08-01 03:32:06', '0000-00-00 00:00:00', NULL, 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorys`
--
ALTER TABLE `categorys`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`paciente_id`);

--
-- Indices de la tabla `citas_medica`
--
ALTER TABLE `citas_medica`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `c_terapia_alternativa`
--
ALTER TABLE `c_terapia_alternativa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dias`
--
ALTER TABLE `dias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `especie`
--
ALTER TABLE `especie`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_eventos_categorys_idx` (`category_id`),
  ADD KEY `fk_eventos_dias1_idx` (`dia_id`),
  ADD KEY `fk_eventos_horas1_idx` (`hora_id`),
  ADD KEY `fk_eventos_medicos1_idx` (`medico_id`);

--
-- Indices de la tabla `horas`
--
ALTER TABLE `horas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pacient`
--
ALTER TABLE `pacient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario` (`usuario_id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario` (`usuario_id`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categorias` (`categoria_id`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarioId` (`usuario_id`),
  ADD KEY `paquete_id` (`paquete_id`);

--
-- Indices de la tabla `setas`
--
ALTER TABLE `setas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_especies` (`especie_id`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `categorys`
--
ALTER TABLE `categorys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `citas_medica`
--
ALTER TABLE `citas_medica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `c_terapia_alternativa`
--
ALTER TABLE `c_terapia_alternativa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `dias`
--
ALTER TABLE `dias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `especie`
--
ALTER TABLE `especie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `horas`
--
ALTER TABLE `horas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `pacient`
--
ALTER TABLE `pacient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `setas`
--
ALTER TABLE `setas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_eventos_categorys` FOREIGN KEY (`category_id`) REFERENCES `categorys` (`id`),
  ADD CONSTRAINT `fk_eventos_dias1` FOREIGN KEY (`dia_id`) REFERENCES `dias` (`id`),
  ADD CONSTRAINT `fk_eventos_horas1` FOREIGN KEY (`hora_id`) REFERENCES `horas` (`id`),
  ADD CONSTRAINT `fk_eventos_medicos1` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `setas`
--
ALTER TABLE `setas`
  ADD CONSTRAINT `fk_especies` FOREIGN KEY (`especie_id`) REFERENCES `especie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
