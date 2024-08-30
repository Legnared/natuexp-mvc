-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-08-2024 a las 01:46:18
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
-- Estructura de tabla para la tabla `antecedentes_medicos`
--

CREATE TABLE `antecedentes_medicos` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
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
  `abortos` tinyint(1) DEFAULT 0,
  `num_cirugias` int(11) DEFAULT NULL,
  `desc_cirugias` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_embarazos` int(11) DEFAULT NULL,
  `num_abortos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `antecedentes_medicos`
--

INSERT INTO `antecedentes_medicos` (`id`, `paciente_id`, `diabetes`, `cancer`, `obesidad`, `infartos`, `alergias`, `depresion`, `artritis`, `estrenimiento`, `gastritis`, `comida_chatarra`, `fumas`, `bebes`, `cirugias`, `embarazos`, `abortos`, `num_cirugias`, `desc_cirugias`, `num_embarazos`, `num_abortos`) VALUES
(1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0);

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
(1, 1, '2024-08-23', '09:00:00', 'Ángel Guillermo', 'Hernández Zambrano', 'ESTA SOLO ES UNA PRUEBA'),
(2, 1, '2024-08-23', '12:00:00', 'Ángel', 'Hernández Zambrano', 'TEST');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_medica`
--

CREATE TABLE `citas_medica` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `edad` int(11) NOT NULL,
  `sexo` enum('Masculino','Femenino') COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_hora` datetime NOT NULL,
  `motivo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_consulta` enum('General','Especialista','Urgencias') COLLATE utf8mb4_unicode_ci NOT NULL,
  `aceptar_terminos` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_eliminacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `citas_medica`
--

INSERT INTO `citas_medica` (`id`, `nombre`, `apellidos`, `fecha_nacimiento`, `edad`, `sexo`, `telefono`, `email`, `direccion`, `fecha_hora`, `motivo`, `tipo_consulta`, `aceptar_terminos`, `fecha_creacion`, `fecha_modificacion`, `fecha_eliminacion`) VALUES
(1, 'Ángel Guillermo', 'Hernández Zambrano', '1993-01-29', 31, 'Masculino', '(443) 218-3103', 'angelguillermohernandezz@gmail.com', 'Acuitzeramo 12 Morelia Michoacán 58337', '2024-08-27 10:00:00', 'TEST', 'General', 1, '2024-08-26 15:58:06', '2024-08-26 15:58:06', '2024-08-26 15:58:06'),
(2, 'Geovanny', 'Sanchez', '1996-05-21', 28, 'Masculino', '4432183150', 'goevanny@gmail.com', 'Acuitzrmo 15', '2024-08-30 09:00:00', 'Test', 'General', 1, '2024-08-29 18:33:22', '2024-08-29 18:33:22', '2024-08-29 18:33:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `motivo_consulta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tratamiento_sugerido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tiempo_tratamiento_clinico` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnostico` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tiempo_tratamiento_sugerido` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dosis_tratamiento` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`id`, `paciente_id`, `motivo_consulta`, `tratamiento_sugerido`, `tiempo_tratamiento_clinico`, `diagnostico`, `observaciones`, `tiempo_tratamiento_sugerido`, `dosis_tratamiento`) VALUES
(1, 1, 'TEST', 'TEST', '1 año', 'TEST', 'TEST', '1 año', ' Los elixires se deben consumir 30 Gotas por la mañana en ayunas y despues de la cena igual 30 gotas. Las cápsulas de Papaína debe consumirse 20 min antes en los 3 horarios (Desayuno, Comida y Cena).');

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
(1, 'Ángel Guillermo Hernandez Zambrano', 'angelguillermohernandezz@gmail.com', 'Testing', 'Esta es una prueba de que esta funcionando el controlador con el modelo de un testing simple.', '2024-08-26 23:56:54'),
(2, 'Ángel Guillermo', 'angelguillermohernandezz@gmail.com', 'TEST', 'TESTING', '2024-08-30 02:32:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_consulta`
--

CREATE TABLE `datos_consulta` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `presion_arterial` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel_azucar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `estatura` decimal(5,2) DEFAULT NULL,
  `temperatura` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `datos_consulta`
--

INSERT INTO `datos_consulta` (`id`, `paciente_id`, `presion_arterial`, `nivel_azucar`, `peso`, `estatura`, `temperatura`) VALUES
(1, 1, '120/80', '70 mg/dl', '65.00', '1.75', '24.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pais` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `calle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_exterior` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_interior` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colonia` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `municipio` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_postal` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id`, `usuario_id`, `pais`, `calle`, `numero_exterior`, `numero_interior`, `colonia`, `municipio`, `estado`, `codigo_postal`, `fecha_creacion`) VALUES
(1, 1, 'México', 'Lopez Lopes', '12', '12', 'Prados Verdes', 'Morelia', 'Michoacán', '58012', '2024-08-28 18:25:19'),
(2, 3, 'México', 'Zamora', '564', '564', 'Molino de Parras', 'Morelia', 'Michoacán', '58010', '2024-08-30 18:51:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `edad` int(11) NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expediente_file` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexo_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `url_avance` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_eliminacion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombre`, `apellidos`, `fecha_nacimiento`, `edad`, `telefono`, `correo`, `expediente_file`, `foto`, `sexo_id`, `usuario_id`, `url_avance`, `estatus`, `fecha_creacion`, `fecha_modificacion`, `fecha_eliminacion`) VALUES
(1, 'Fulano', 'Sultano', '1990-02-01', 34, '44321025', 'sultano@gmail.com', '94c3c42e7ae7e1ac749078810dafad88.pdf', '04b89d0ac004a651b6cb40893b1ed23e.jpg', 1, 1, 'a1ce3daff2dbfa1d0256d69a92cf979a', 1, '2024-08-29 02:25:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
(1, 'admin'),
(2, 'paciente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creado_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `rol_id`, `nombre`, `descripcion`, `creado_at`, `actualizado_at`) VALUES
(1, 1, 'Gestionar Usuarios', 'Puede agregar, editar y eliminar usuarios', '2024-08-22 18:49:04', '2024-08-22 18:49:04'),
(2, 1, 'Ver Reportes', 'Puede ver todos los reportes del sistema', '2024-08-22 18:49:04', '2024-08-22 18:49:04'),
(3, 1, 'Configurar Sistema', 'Tiene acceso a la configuración general del sistema', '2024-08-22 18:49:04', '2024-08-22 18:49:04'),
(4, 2, 'Ver Pacientes', 'Puede ver todos los pacientes', '2024-08-22 18:49:04', '2024-08-22 18:49:04'),
(5, 2, 'Editar Pacientes', 'Puede editar la información de los pacientes', '2024-08-22 18:49:04', '2024-08-22 18:49:04'),
(6, 2, 'Gestionar Citas', 'Puede ver y modificar las citas de los pacientes', '2024-08-22 18:49:04', '2024-08-22 18:49:04'),
(7, 3, 'Ver Pacientes', 'Puede ver todos los pacientes', '2024-08-22 18:49:04', '2024-08-22 18:49:04'),
(8, 3, 'Gestionar Citas', 'Puede agendar y modificar citas de los pacientes', '2024-08-22 18:49:04', '2024-08-22 18:49:04'),
(9, 3, 'Gestionar Contactos', 'Puede gestionar la información de contacto de los pacientes', '2024-08-22 18:49:04', '2024-08-22 18:49:04'),
(10, 4, 'Ver Pacientes', 'Puede ver todos los pacientes', '2024-08-22 18:49:04', '2024-08-22 18:49:04'),
(11, 4, 'Asistir Citas', 'Puede asistir al doctor en la gestión de las citas', '2024-08-22 18:49:04', '2024-08-22 18:49:04'),
(12, 5, 'Ver Citas', 'Puede ver sus citas agendadas', '2024-08-22 18:49:04', '2024-08-22 18:49:04'),
(13, 5, 'Gestionar Perfil', 'Puede gestionar su propio perfil y datos personales', '2024-08-22 18:49:04', '2024-08-22 18:49:04'),
(14, 1, 'Gestión de Roles y Permisos', 'Crear Roles: Crear nuevos roles en el sistema\r\nEditar Roles: Modificar roles existentes.\r\nEliminar Roles: Eliminar roles del sistema.\r\nAsignar Permisos a Roles: Definir qué permisos tiene cada rol.', '2024-08-23 08:26:31', '2024-08-23 08:26:31'),
(15, 7, 'Ver Expedientes', 'Administrador', '2024-08-31 04:28:46', '2024-08-31 04:28:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estatus` int(11) NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creado_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `estatus`, `descripcion`, `creado_at`, `actualizado_at`) VALUES
(1, 'Administrador', 1, 'Tiene acceso completo a todas las funcionalidades del sistema', '2024-08-22 18:48:04', '2024-08-22 22:37:22'),
(2, 'Doctor', 1, 'Puede gestionar sus pacientes y sus citas', '2024-08-22 18:48:04', '2024-08-22 22:37:25'),
(3, 'Recepcionista', 1, 'Puede gestionar las citas y pacientes, pero no puede realizar cambios en la configuración', '2024-08-22 18:48:04', '2024-08-22 22:37:26'),
(4, 'Enfermero', 1, 'Asiste al doctor y puede gestionar la información de los pacientes', '2024-08-22 18:48:04', '2024-08-22 22:37:28'),
(5, 'Paciente', 1, 'Puede ver y gestionar sus citas y su historial médico', '2024-08-22 18:48:04', '2024-08-22 22:37:30'),
(6, 'Paqueteria', 1, 'Envia medicamentos a domicilio de pacientes.', '2024-08-23 07:17:27', '2024-08-27 23:24:49'),
(7, 'Matenimiento', 1, 'Puede dar mantenimiento al sistema', '2024-08-31 04:28:04', '2024-08-31 04:28:04');

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
  `nombre` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  `token` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perfil` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT NULL,
  `fecha_eliminacion` datetime DEFAULT NULL,
  `estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `telefono`, `foto`, `password`, `confirmado`, `token`, `perfil`, `rol_id`, `fecha_creacion`, `fecha_modificacion`, `fecha_eliminacion`, `estado`) VALUES
(1, 'Ángel Guillermo', 'Hernández Zambrano', 'angelguillermohernandezz@gmail.com', '4432183103', 'b7e5f6bd4a82cd18f6482887b17129c8', '$2y$10$V3ICtSxr4XEP.LwDUt1ERu3sc1oNzIR6aTsT58Ktow34oyjc4zd5W', 1, '', 'admin', 1, '2024-08-20 01:25:56', '2024-08-22 16:31:48', NULL, 1),
(2, 'Eduardo', 'Sandoval García', 'llamahoy@gmail.com', '4433688682', '', '$2y$10$Z3hisWuXbU/Zse4iy41DwOWNT0KwCzqf5OIW7V/Yh67kr2nU95/Lu', 1, '', 'admin', 1, '2024-08-20 01:28:12', '2024-08-19 19:28:12', NULL, 1),
(3, 'Geovanny Israel', 'Sanchez', 'geovanny@gmail.com', '443218304', '', '$2y$10$YqFuu2Ij0bsMTOkvSu8w9.zxjOUJo7mV0BL3UUPySti.0CsePvir.', 1, '', 'usuario', 1, '2024-08-31 04:25:00', '2024-08-30 22:25:00', NULL, 1),
(5, 'Panfilo', 'Gurrumino', 'panfilo@gmail.com', '4432195286', '', '$2y$10$cpapPykMB0R2VZG2Xb56buI81pQuIk53Dyd9NYGoAysITwKJuwYa2', 1, '', 'usuario', 1, '2024-08-31 07:02:57', '2024-08-31 01:02:57', NULL, 0),
(7, 'Vanessa', 'Farfan', 'vanessafarfan@gmail.com', '4432183105', '', '$2y$10$2SKxTa1pF1t1FKpG6svxauPMothRBrvW0yfZfNXITwhWRyT55lO0G', 0, '', 'usuario', NULL, '2024-08-31 07:22:10', '2024-08-31 01:22:09', NULL, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `antecedentes_medicos`
--
ALTER TABLE `antecedentes_medicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `antecedentes_medicos_ibfk_1` (`paciente_id`);

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
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `datos_consulta`
--
ALTER TABLE `datos_consulta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuarios_roles` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `antecedentes_medicos`
--
ALTER TABLE `antecedentes_medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `citas_medica`
--
ALTER TABLE `citas_medica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `datos_consulta`
--
ALTER TABLE `datos_consulta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `antecedentes_medicos`
--
ALTER TABLE `antecedentes_medicos`
  ADD CONSTRAINT `antecedentes_medicos_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`);

--
-- Filtros para la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`);

--
-- Filtros para la tabla `datos_consulta`
--
ALTER TABLE `datos_consulta`
  ADD CONSTRAINT `datos_consulta_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`);

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
