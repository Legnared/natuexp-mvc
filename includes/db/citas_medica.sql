-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-08-2024 a las 17:46:24
-- Versión del servidor: 10.6.19-MariaDB
-- Versión de PHP: 8.3.8

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
-- Estructura de tabla para la tabla `citas_medica`
--

CREATE TABLE `citas_medica` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` enum('Masculino','Femenino') NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `fecha_hora` datetime NOT NULL,
  `motivo` text NOT NULL,
  `tipo_consulta` enum('General','Especialista','Urgencias') NOT NULL,
  `aceptar_terminos` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `citas_medica`
--

INSERT INTO `citas_medica` (`id`, `nombre`, `fecha_nacimiento`, `sexo`, `telefono`, `email`, `direccion`, `fecha_hora`, `motivo`, `tipo_consulta`, `aceptar_terminos`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'Ángel Guillermo Hernandez Zambrano', '1993-01-29', 'Masculino', '4432183103', 'angelguillermohernandezz@gmail.com', 'Acuitzeramo 12 Morelia Michoacán 58337', '2024-07-30 12:00:00', 'test', 'General', 0, '2024-07-30 16:18:36', '2024-07-30 16:18:36'),
(2, 'Ángel Guillermo', '1993-01-29', 'Masculino', '4432183103', 'angelguillermohernandezz@gmail.com', 'Acuitzeramo 12 Morelia Michoacán 58337', '2024-08-05 10:00:00', 'Testeo', 'General', 0, '2024-08-02 16:57:36', '2024-08-02 16:57:36'),
(3, 'ROSI', '1992-03-12', 'Femenino', '4433688682', 'contacto@telatte.com', 'zamora #564 ', '2024-08-16 09:00:00', 'escaneo', 'General', 0, '2024-08-14 17:27:00', '2024-08-14 17:27:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas_medica`
--
ALTER TABLE `citas_medica`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas_medica`
--
ALTER TABLE `citas_medica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
