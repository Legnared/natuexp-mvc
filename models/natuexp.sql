-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2024 a las 00:55:04
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
  `nombre` varchar(250) NOT NULL,
  `apellidos` varchar(90) NOT NULL,
  `edad` varchar(50) NOT NULL,
  `motivo_consulta` text NOT NULL,
  `tratamiento_sujerido` text NOT NULL,
  `tiempo_tratamiento_clinico` varchar(250) NOT NULL,
  `tiempo_tratamiento_sujerido` varchar(250) NOT NULL,
  `dosis_tratamiento` text NOT NULL,
  `expediente_file` varchar(250) NOT NULL,
  `sexo_id` int(11) NOT NULL,
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

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombre`, `apellidos`, `edad`, `motivo_consulta`, `tratamiento_sujerido`, `tiempo_tratamiento_clinico`, `tiempo_tratamiento_sujerido`, `dosis_tratamiento`, `expediente_file`, `sexo_id`, `genero`, `usuario_id`, `url_avance`, `estatus`, `fecha_creacion`, `fecha_modificacion`, `fecha_eliminacion`, `n_calle_avenida`, `n_exterior`, `n_interior`, `colonia_barrio`, `municipio_delegacion`, `estado_provincia`, `cp`) VALUES
(1, ' Salvador ', 'Agregado DÃ­az ', '74', '3/11/2022 Bloqueo en respuesta erectiva, disminuciÃ³n agudeza auditiva, insuficiencia venosa en ambas piernas, sensaciÃ³n de molestia del tensor externo del muslo y cadera derecha ', 'Imuzen, Shitake, Cordyceps, OPC complex', '3 meses ', '3 meses', 'Imuzen: 1 dosis c/30 dÃ­as, Shitake: 30 gotas 4/ c.dia, Cordyceps: 30 gotas 4/c.dia, OPC complex: 3/dia, Tamsulosina todos los dÃ­as ', 'a8a3b4e59c6abbf05a98ab0d783aa0c3.pdf', 1, '', 26, '08d8b34cd8c358cd389d72549fc96962', 1, '2023-06-07 04:03:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NicolÃ¡s RamÃ­rez ', '306', '306', 'Modelo ', 'Aguascalientes ', 'Aguascalientes ', '20080 '),
(2, ' Hermelinda ', 'Soto Moreno ', '67', '01/02/2022 Hipertensa y diabÃ©tica, 03/03/2022 Contractura muscular severa en hombro y supra escapular derecha, neuralgia Trigeminal izquierda, RetenciÃ³n de lÃ­quidos, 30/03/2022 InfecciÃ³n, lesiÃ³n en la espinilla derecha, ulceraciÃ³n superficial.', 'Fungi, Reishi, Luvik- Glimeprida 2mg, Metformina 850 mg, Spiolto respimat', 'Luvik- Glimeprida 2 meses, Metformina 1 mes, Spiolto Respimat 2 meses ', '2 meses ', 'Luvik- Glimepririda 2mg una tableta con el desayuno y la cena, Metformina de 850mg una c/12 horas, Spiolto Respimat una aplicaciÃ³n en cada fosa nasal c/12 horas, Fungi 10 gotas 4/dia', '33fb6c88f9cc477864d5fafa75bdd4e6.pdf', 2, '', 26, '9da3f70bd2b14e878c995f9cd8b97bf9', 1, '2023-06-07 04:27:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Azteca', '208', '208', 'Barrio de Guadalupe ', 'Aguascalientes ', 'Aguascalientes ', '20059 '),
(3, ' VerÃ³nica Guadalupe ', 'Ponce JuÃ¡rez ', '63', '08/06/2022 Falla renal y diabetes, 17/10/2022 Cuadro gripal severo', 'Imuzen, Fungiterapia, fungÃ­, Shitake, H- del sol, Gano-he,Coprinus Comatus, Eritropoyetina 4000 UI, Chaga ', '1 mes', '4 meses', 'Imuzen: una dosis c/15 dÃ­as 4 veces al dia, Chaga 15 gotas, Shitake: 15 gotas, Poliporo 15 gotas, Coprinus 1 cÃ¡psula 3/dia, Eritropoyetina 4000 UI cada semana ', 'ebd535e69cdf753ae5e15d4c27e8da43.pdf', 2, '', 26, '163d8f98fdd0201431a088482828bde6', 1, '2023-06-07 04:47:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Azteca ', '208', '208', 'Barrio de Guadalupe ', 'Aguascalientes ', 'Aguascalientes ', '20059 '),
(4, ' MarÃ­a Fernanda ', 'CÃ³rdova Barroso ', '15', 'Nefritis por PÃºrpura de Hemoch- SchÃ¶nlein-Henoch clase IV', 'Imuzen, FungÃ­, Sunset Kyani ', '1 mes', '1 mes', 'Imuzen una dosis c/semana, FungÃ­ 10 gotas/ dia, Sunset Kyani una cÃ¡psula entre alimentos', '18900261f445c49f4ca40a31b011d87f.pdf', 2, '', 26, '133b7a95bc66bff4abe1dd620de1bd1f', 1, '2023-06-07 04:58:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Azteca ', '208', '208', 'Barrio de Guadalupe ', 'Aguascalientes', 'Aguascalientes ', '20059 '),
(6, ' Eduardo', 'Sandoval Garcia', '58 aÃ±os', 'Testeo', 'Testeo', '6 Meses', '8 Meses', '30 Gotas en extracto de C/U Por la maÃ±ana y por la noche. 1 Capsula por la maÃ±ana y otra por noche.', '579bbf09183a18e450986edcd24b11c4.pdf', 1, '', 1, '28bc5ca603d3e48c986994daa2e19165', 1, '2023-06-22 19:30:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Prueba', 'Prueba', 'Prueba', 'Prueba', 'Prueba', 'Prueba', 'Prueba '),
(7, ' Angel Guillermo', 'HernÃ¡ndez Zambrano', '30 aÃ±os.', 'Paciente con problemas de vesÃ­cula biliar y colon irritado.', 'Prueba', '6 Meses', '8 Meses', '30 gotas por la maÃ±ana y por la noche, 2 capsulas de papaÃ­na 20 minutos antes de cada comida.', '9c7daba6a98c31a47dfac670ef560919.pdf', 1, '', 1, '11696ba9ae29b637b983a5d75933a24f', 1, '2023-06-22 19:47:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Acuitzeramo', '12', '12', 'Ciudad JardÃ­n', 'Morelia', 'MichoacÃ¡n', '58337 '),
(8, ' Juan Pablo', 'Calvillo Diaz de Leon', '24', '6/10/2022 dermatitis frontal, alergias, gingivitis\r\n15/11/2022 desviaciÃ³n a derecha y espolÃ³n contanctante en cornete inferior, mucosa polipoide, sinusitis etmoidal en celdillas posteriores, quiste de retenciÃ³n en arcada dental izquierda ', 'Imuzen, gano-he, melena de leon, cordyceps-militaris, reishi, coprinus, son/map formula, curcuma-plus', '6 meses', 'gano-he 6 meses, melena de leon 6 meses, cordyceps-militaris 5 meses, reishi 2 meses, coprinus 2 meses, son/map formula 5 meses, curcuma-plus 5 meses', 'Imuzen una dosis por semana, gano-he 50 gotas 2 veces al dÃ­a, melena de leon 1 cÃ¡psula cada 12 horas, cordyceps-militaris 1 cÃ¡psula cada 12 horas, reishi 1 cÃ¡psula 2 veces al dÃ­a, coprinus 1 cÃ¡psula 2 veces al dÃ­a con alimentos, son/maap 1 tableta 3 veces al dÃ­a con alimentos', 'c93b169e13128faf87d1995a4dc20cfa.pdf', 1, '', 26, 'b0b4e6a60653bd6668c2d9819c8c9785', 1, '2023-06-26 14:17:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'n/a', 'n/a', 'n/a', 'n/a', 'San Felipe', 'Guanajuato', 'n//a '),
(9, ' Francisco', 'Mendoza DÃ­az', '68', '11/02/2021 tinitus\r\n17/08/2022\r\n23/09/2022\r\n6/10/2022\r\n7/11/2022\r\n9/12/2022\r\n13/01/2023', 'IMUZEN, OPC Complex cÃ¡psulas, Bio Cia cÃ¡psulas, Bio-En (Bio 4) crema,  Matzutake gotas, Hongo Chaga (Diamante Negro, Kawaratake (Cola de Pavo), Matzutake, Chaga y Kawaratake, Passiflora incarnata, Sunset kyani ', 'n/a', 'n/a', 'IMUZEN: Una dosis vÃ­a oral cada 30 dÃ­as.     OPC Complex cÃ¡psulas: Una cÃ¡psula vÃ­a oral cada 12 horas.     Bio Cia cÃ¡psulas: Una cÃ¡psula con los alimentos 3 veces al dÃ­a.     Bio-En (Bio 4) crema: 4 veces al dÃ­a.  Matzutake gotas: 20 gotas tomar 4 veces al dÃ­a. Hongo Chaga (Diamante Negro): 20 gotas  tomar 4 veces al dÃ­a. Kawaratake (Cola de Pavo): 20 gotas tomar 4 veces al dÃ­a. Curcuma-Nanofy gotas: 3 gotas  (Matzutake, Chaga y Kawaratake) y 4 veces al dÃ­a.  Passiflora incarnata 5 gotas por la maÃ±ama, 5 por el medio dÃ­a, 5 por la media tarde y 10 por la noche.   Sunset kyani 3 capsulas con la comida.', 'be4b3e00bc78efd693dce345e71dcbed.pdf', 1, '', 26, 'fdd04ebd3c5ae5c162e99da6fef81295', 1, '2023-06-26 16:42:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'x', 'x', 'xx', 'x', 'xx', 'x', 'x '),
(10, ' Lluvia Mayra', 'Esparza Pedroza ', '36', 'Ãleon terminal con hiperplasia linfoide, mucosa colonia en ciego con adenomas linfoides tubulares con displasia de bajo grado, compatible con poliposis familiar mÃºltiple ', 'Agnato-E 300 mg una cÃ¡psula 3/al dÃ­a, Imuzen 1/c semana, Nitro FX-KYANI 15 gotas 4/al dÃ­a, Sunrise Kyani 1/24 hrs, Ganoderma 25 gotas 4/al dÃ­a , Protandim-NRF1 1/12 hrs, Protadim-NRF2 1/24 hrs, Imuzen 1/30 dÃ­as, Map- O 1 g 3/ al dÃ­a, FungÃ­ 20 gotas, Matzutake 10 gotas 4/al dÃ­a, melena de LeÃ³n 1/ c 12 hrs, Aceite de uva 2 cucharadas antes de alimentos, cola de pavo 20 gotas 4/al dÃ­a, Map Fordula 2 tabletas 3/al dÃ­a ', '3 aÃ±os', '3 aÃ±os', 'Agnato-E 300 mg una cÃ¡psula 3/al dÃ­a, Imuzen 1/c semana, Nitro FX-KYANI 15 gotas 4/al dÃ­a, Sunrise Kyani 1/24 hrs, Ganoderma 25 gotas 4/al dÃ­a , Protandim-NRF1 1/12 hrs, Protadim-NRF2 1/24 hrs, Imuzen 1/30 dÃ­as, Map- O 1 g 3/ al dÃ­a, FungÃ­ 20 gotas, Matzutake 10 gotas 4/al dÃ­a, melena de LeÃ³n 1/ c 12 hrs, Aceite de uva 2 cucharadas antes de alimentos, cola de pavo 20 gotas 4/al dÃ­a, Map Fordula 2 tabletas 3/al dÃ­a ', 'e1dea6428ced6d224d9cace9b421fd22.pdf', 2, '', 26, 'd2f20200039fa43cfa55fc9857b775a2', 1, '2023-07-19 08:00:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Nadir', '526', '526', 'Vistas del sol ', 'Aguascalientes ', 'Aguascalientes ', '20264 '),
(11, ' Vania Erandi ', 'MacÃ­as Lozada ', '36', 'ColonizaciÃ³n bacteriana, lÃ­pidos bajos, disfunciÃ³n cortico- subcortical global predominio en regiones frontoparietales, tac craneal con afecciÃ³n por lesiones de arma de fuego y aun esquirlas, datos de sinusitis frontoesfenoidal', 'Imuzen, FungÃ­, matzitake, melena de latÃ³n, pleurotus, cÃºrcuma nanofy, papalina, enema de plasma marino, ganoderma', '9 meses', '9 meses', 'Imuzen 1/c semana, FungÃ­ 10 gotas, matzutaje 10 gotas, melena de LeÃ³n 30 gotas, cÃºrcuma 3 gotas, papalina 2 4/al dÃ­a, enema de plasma marino 30 ml por litro de agua, Ganoderma 4 tomas por dÃ­a ', '2992a21130ab94d8b5b53cc2bb074789.pdf', 2, '', 26, '0f2f45965345910a052e445d825a2d46', 1, '2023-07-19 08:10:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Azteca ', '208', '208', 'Barrio de Guadalupe ', 'Aguascalientes ', 'Aguascalientes ', '20059 '),
(12, ' JosÃ© Marcos ', 'GarcÃ­a Teran', '72', 'PreparaciÃ³n para Quelacion ', 'Symbicort, Gano-e, imuzen, fungÃ­, melena de LeÃ³n, Today (BIO4), Coprinus, curcuminas- nanofy, Reishi, Cordyceps', '1 aÃ±o 7 meses', '1 aÃ±o 7 meses', 'Imuzen 1/ c 30 dÃ­as, Gano-E  10 GOTAS 4/AL DÃA, FungÃ­ 10 gotas c/12 hrs, Coprinus 3 veces al dÃ­a, CÃºrcuma- Nanofy 5 GOTAS C/12 HRS, Simbricort 1 aplicaciÃ³n en cada fosa c/12 hrs', '60a2eb62d2fef8d194cd653db5c5b031.pdf', 1, '', 26, 'eba5274d37a81473d51d856556548d4e', 1, '2023-07-19 08:25:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Claveles ', '107', '107', 'Las flores ', 'Aguascalientes ', 'Aguascalientes ', '20220 '),
(13, ' Monica ', 'Cardoso Flores ', '55', 'Esclerosis mÃºltiple, Lito amÃ­gdala pino izquierdo, quiste pararectal, sensaciÃ³n de vibraciÃ³n en oÃ­dos, pecho apretado, bajo peso, lindo a no Hodkin tipo folicular grado 1', 'Imuzen, matzutake, Kawaratake, Bio-en, FungÃ­, Sig, inonotus, Bio- cia, Hongo chaca, shitake ', '1 aÃ±o', '1 aÃ±o', 'Imuzen 1 dosis c/15 dÃ­as, Hongo chaca 25 gotas 4/al dÃ­a, Shitake 25 gotas 4/al dÃ­a, inonotus 20 gotas, bio-EN 1 c/12hrs, Bio-CIA 1 con alimentos ', 'ce8d55d5ba40b0f6a240ed438a85902e.pdf', 2, '', 26, '516d82febb417c700d1d63f167f4f410', 1, '2023-07-19 08:43:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Vivero de la hacienda ', '462', '462', 'Casa Blanca ', 'Aguascalientes ', 'Aguascalientes ', '20297 '),
(14, ' MarÃ­a Auxilio ', 'LÃ³pez Ruiz ', '61', 'Control de Neoplasia colonica, persistencia de dolor dorso lumbar, asintomÃ¡tica en patrÃ³n ventilado rio pulmonar, lesiones nodulares mÃºltiples siguiendo trayectos fibrosos pulmonares', 'Imuzen, sunset-Kyani, reishi, papalina, Matzutake, H.chaca, Kawaratake, Maitake, Passiflora incarnata, cÃºrcuma Nonofy, CBD-Platinum, FungÃ­, melena de LeÃ³n, Arcoxia, Levrika, Veluan ', '1 mes ', '3 aÃ±os ', 'Imuzen 1 c/semana, Sunset Kyani 1 cÃ¡psula 3/al dÃ­a, Papaina 1 cÃ¡psula c/12 hrs, CBD-platinum 5 a 10 gotas c/12 hrs, Matzutake, chaca, Kawaratake, passiflora, reishi, cÃºrcuma, 30 gotas en 50 ml de agua, colÃ¡geno complex 1 cÃ¡psula c/12 hrs, pregabalina 150 mg 1 cÃ¡psula c/12 hrs, calecoxib 200 mg a las 8, 15 y 21 hrs, CBD gotas 12 gotas c/12 hrs, para etanol 500 mg c/12 hrs', '5c53dd7aa803f0a5374993ed3473970c.pdf', 2, '', 26, '11a8eb3bfe535a161ba3206c219793c3', 1, '2023-07-21 21:08:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Azteca', '208', '208', 'Barrio de Guadalupe ', 'Aguascalientes ', 'Aguascalientes ', '20059 '),
(15, ' Laura Elena ', 'Pineda Moctezuma ', '42', 'RestricciÃ³n severa de la vÃ­a aÃ©rea perifÃ©rica, calculo en vÃ­a biliar, exacerbaciÃ³n bronquiectadias, hemotÃ³xicos en grado mÃ­nimo, lesiÃ³n en seno izquierdo, nÃ³dulo solido hacia el radio de las 4 lÃ­neas B de la mama izquierda, Fibroadenoma atipico, IrritaciÃ³n oro farÃ­ngea importante', 'Profacte, Serbia- Breezhaler, Montelukast, Combivent Respimat, Facinvite, oSLIF, Koptin, Bredelin, dimitan D, Misdapro, Cronolevel Hypak, Aytugre, Symbicort, Celestamine, Imuzen, Bioforce, fungÃ­, OPC-Complex, Lacto-inmuno complex, colÃ¡geno complex, Sinomarin,Gano-He, Hierro y folatos de Amaya,', '8 aÃ±os ', '3 aÃ±os', 'Imuzen 1 c/30 dÃ­as, Symbicort una inhalaciÃ³n 3 dÃ­as por semana, OPC complex una cÃ¡psula c/24 hrs, Hierro y folatos de Amaya 2 veces al dÃ­a ', '74bdaee21f0f9a8f96712b206a50ee13.pdf', 2, '', 0, 'ecff907a7ae0f9ecdad068063a23d61a', 1, '2023-07-21 21:33:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Hortalizas ', '159', '159', 'Los encinos ', 'Aguascalientes', 'Aguascalientes ', '20734 '),
(16, ' Laura Elena ', 'Pineda Moctezuma ', '42', 'RestricciÃ³n severa de la vÃ­a aÃ©rea perifÃ©rica, calculo en la vÃ­a biliar, LesiÃ³n en la mama izquierda, Bronquiectadias, hemoptoicos en grado mÃ­nimo, calcificaciones benignas bilateral, disfunciÃ³n intestinal , pulmÃ³n derecho bicariante, molestias de vientre, hombro y espalda, anemia,fibrosis basal izquierda, Atelectasia basal izquierda', 'Profacte, Serbia- Breezhaler, Montelukast, Combivent Respimat, Facinvite, oSLIF, Koptin, Bredelin, dimitan D, Misdapro, Cronolevel Hypak, Aytugre, Symbicort, Celestamine, Imuzen, Bioforce, fungÃ­, OPC-Complex, Lacto-inmuno complex, colÃ¡geno complex, Sinomarin,Gano-He, Hierro y folatos de Amaya,', '8 aÃ±os', '3 aÃ±os', 'Imuzen 1 c/30 dÃ­as, Symbicort 1 inhalaciÃ³n 3 veces a la semana, OPC COMPLEX 1 c/24 hrs, Gano-HE 10 gotas 4/al dÃ­a, hierro y folatos de Amaya 2 veces al dia', '1f4c7cdbbe97a0476bfaa59dad0959fd.pdf', 2, '', 26, '5ed38435b6461ead52c1a1e329f22ad5', 1, '2023-07-21 21:42:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Hortalizas ', '159', '159', 'Los encinos ', 'Aguascalientes ', 'Aguascalientes ', '20734 '),
(17, ' Araceli ', 'MacÃ­as Reyes', '43 ', 'Pancreatitis, estenosis fibrotica de la ampolla vater, daÃ±o hepatico y desnutriciÃ³n severa, dolor al evacuar con tennesmo, lesiÃ³n en el epicarpio lado derecho, sangrado abundante, hemartoma, dolor epigÃ¡strico, pancreatitis autoinmune,disminuciÃ³n en la agudeza visual, tensiÃ³n en hipocondrio derecho, COVID-19, lengua negra, distensiÃ³n abdominal ', 'Imuzen, Lacto-inmuno-complex, Map, Biotiquin, Gentilax, Libertrim, Spiolto respimat, montelukast, cronolevel hypak, espaven enzimÃ¡tico, Annatto-E, Bio-Forte inmuno, BIO4 bio.con, Bio-gru, Bio-forcÃ©, Bio-En, Bio-CIA, SantivÃ¡n- Ceutica, Ganoderma, Passiflora,  Maitake, Afamind, Anti-FLU, FungÃ­, Coprinus, Melena de LeÃ³n, GanÃ³-HE,', '3 meses ', '4 aÃ±os', 'Imuzen 1 c/30 dÃ­as, GanO-HE 10 gotas, passiflora 10 gotas c/12 hrs, melena de LeÃ³n 1 3/al dia, Coprinus 1 cÃ¡psula 3 veces al dia, papaina 1 todos los dÃ­as lunes, miÃ©rcoles y viernes ', 'cb52ce910a49efad7d94ce6fe696903b.pdf', 2, '', 0, 'dce682c09bb48c3dc07b9fb28087d3a5', 1, '2023-07-21 22:31:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Alicia de la Rosa ', '108', '108', 'Cumbres sur ', 'Aguascalientes ', 'Aguascalientes ', '20179 ');

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
  `nombre` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `apellido` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
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
(2, ' Eduardo', 'Sandoval', 'llamahoy@gmail.com', '4433688682', 'c012e54ed4c64dabaecac5bc203ef3fc', '$2y$10$a3RlsYlxiEM.Oj5/02tJoei/R0GYG5Zrl/PtfIU2iY1tG2kH72mTi', 1, '6407660b706ca', 'admin', '2023-03-09 22:38:56', NULL, NULL, 1, 0),
(21, ' Angel', 'Hernandez', 'm3m.angel1761@gmail.com', '4431195286', '', '$2y$10$FQ7co97WkQ1YgYuNtixV6OEoV2yqICMV0Wax.izB43KETCz1b3iMe', 1, '645e5c08874ea', 'usuario', '2023-03-10 20:39:40', '0000-00-00 00:00:00', NULL, 1, 0),
(22, ' Yoselyn ', 'HernÃ¡ndez Ortiz ', 'yoselynestfania04@gmail.com', '4492732022', '', '$2y$10$dc5mgielaQQdLrnhNBWW/O2E/u/l7MUfiskHfy7wL1GE04/MePs/G', 0, '6471c5341e6a8', 'usuario', '2023-05-27 08:54:12', '0000-00-00 00:00:00', NULL, 1, 0),
(23, ' Yoselyn EstefanÃ­a', 'HernÃ¡ndez', 'yoselynestefania04@gmail.com', '4492732022', '', '$2y$10$BHB2aREef/rIPN95.nAlU.eRknvaTVuvGKiU1dHdEx1b276RK0IzO', 0, '6471c6128f787', 'usuario', '2023-05-27 08:57:54', '0000-00-00 00:00:00', NULL, 1, 0),
(25, ' Alejandro', 'Sandoval', 'alex.sandoval.valhalla.mc@gmail.com', '4436840011', '', '$2y$10$Yy2ie9iHL7e.LwsfsysixOa9bzYkJxrvbYMdJOR476OOnJrfCWVgy', 1, '647e5ed9d89ec', 'usuario', '2023-06-05 22:16:57', '0000-00-00 00:00:00', NULL, 1, 0),
(26, ' Francisco Javier', 'Alvarado NÃºÃ±ez', 'dr.alvarado.nunez@gmail.com', '1 56 3887 2910', '', '$2y$10$.1xufmsIKofcShuwAqESjeFYzQrLQjmKC27xp7ei2ljmXG.TdUQKS', 1, '647f7b3959cdf', 'usuario', '2023-06-06 16:47:50', '0000-00-00 00:00:00', NULL, 1, 0);

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
-- AUTO_INCREMENT de la tabla `c_terapia_alternativa`
--
ALTER TABLE `c_terapia_alternativa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restricciones para tablas volcadas
--

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
