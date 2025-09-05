-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-09-2025 a las 23:48:37
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `test`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `nombre`, `descripcion`, `fecha_creacion`, `activo`) VALUES
(3, 'Recursos Humanos', 'Supervision de capital humano', '2025-08-29 16:00:55', 1),
(5, 'Administracion', 'Alta y bajas de usuarios', '2025-09-01 18:39:09', 1),
(6, 'Tecnologias', 'Tecnologias de la informacion', '2025-09-04 15:53:49', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_usuario` varchar(20) NOT NULL DEFAULT 'usuario',
  `area_id` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`id`, `usuario`, `password`, `nombre`, `tipo_usuario`, `area_id`, `email`) VALUES
(1, 'admin', '$2y$10$2vZ0O72S8m57M21zfkdZiu44MEX7BDLlIfBzhLrBVBAwTrtG9Nbpa', 'Administrador', 'admin', 5, 'admin@gmail.com'),
(9, 'Majo', '$2y$10$IDyGZ5fm3gFpog2oAKV3D.NPHUGp.apUARRJnkh3GjaSnLul9NRtq', 'Majito', 'user', 3, 'majo@gmail.com'),
(11, 'Julian', '$2y$10$Ruc.4RqZbIBSoGtWEYhMc.Vb/5CYl6JdvEX7ahDdc7TXVlu95Yfzy', 'Julian Lopez', 'user', 3, 'rodriguezlopezjorgejulian@gmail.com'),
(15, 'Juliano', '$2y$10$jbJHmonp98xzGzIA5CpjgefPjaX4UT1CHH03upSrKej4c7Bc2rIzS', 'Jorge Rodriguez', 'user', 6, 'juliano@gmail.com'),
(16, 'Julianos', '$2y$10$vo7/U/Y8YAsKx5tRDdEufuYiiYuLehCZ7MbWLQYZlvexrnAzLeCjG', 'Jorge Rodriguez', 'user', 6, 'julianos@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oficios`
--

CREATE TABLE `oficios` (
  `id` int(11) NOT NULL,
  `remitente` varchar(255) NOT NULL,
  `tipo_persona` enum('natural','juridica') NOT NULL,
  `tipo_documento` enum('carta','ruc_dni') NOT NULL,
  `numero_documento` varchar(20) DEFAULT NULL,
  `folios` int(11) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `asunto` varchar(500) NOT NULL,
  `archivo_nombre` varchar(255) DEFAULT NULL,
  `archivo_ruta` varchar(500) DEFAULT NULL,
  `respuesta` text DEFAULT NULL,
  `area_derivada_id` int(11) DEFAULT NULL,
  `usuario_derivado_id` int(11) DEFAULT NULL,
  `fecha_derivacion` timestamp NULL DEFAULT NULL,
  `fecha_respuesta` timestamp NULL DEFAULT NULL,
  `area_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','tramite','completado','denegado') DEFAULT 'pendiente',
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `oficios`
--

INSERT INTO `oficios` (`id`, `remitente`, `tipo_persona`, `tipo_documento`, `numero_documento`, `folios`, `correo`, `telefono`, `asunto`, `archivo_nombre`, `archivo_ruta`, `respuesta`, `area_derivada_id`, `usuario_derivado_id`, `fecha_derivacion`, `fecha_respuesta`, `area_id`, `usuario_id`, `fecha_registro`, `estado`, `activo`) VALUES
(10, 'Cristiano Ronaldo', 'juridica', 'ruc_dni', '7878787', 2, 'cristiano@gmail.com', '4621234567', 'Videograbacion', 'datospracticas.txt', '../../../uploads/1757008545_datospracticas.txt', 'no hay respuesta', 6, 15, '2025-09-04 19:42:50', '2025-09-04 21:44:39', 5, 1, '2025-09-04 17:55:45', 'denegado', 1),
(11, 'Cristiano Ronaldo', 'juridica', 'ruc_dni', '8521', 2, 'cristiano@gmail.com', '4621234567', 'Videograbacion', 'CSS.txt', '../../../uploads/1757008609_CSS.txt', '4 videograbaciones', 6, 15, '2025-09-04 19:44:55', '2025-09-04 21:43:45', 5, 1, '2025-09-04 17:56:49', 'completado', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiration` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`id`, `email`, `token`, `expiration`, `used`, `created_at`) VALUES
(1, 'rodriguezlopezjorgejulian@gmail.com', 'f0019070572a4951c0e1cd59d2ebd3b39b808217ca6839025eb687d5381b248864df8f3ffa160a73f1b6eea533507275da82', '2025-09-01 22:05:23', 0, '2025-09-01 19:05:23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_login_area` (`area_id`);

--
-- Indices de la tabla `oficios`
--
ALTER TABLE `oficios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `area_derivada_id` (`area_derivada_id`),
  ADD KEY `usuario_derivado_id` (`usuario_derivado_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `oficios`
--
ALTER TABLE `oficios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `fk_login_area` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `oficios`
--
ALTER TABLE `oficios`
  ADD CONSTRAINT `oficios_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `oficios_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `oficios_ibfk_3` FOREIGN KEY (`area_derivada_id`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `oficios_ibfk_4` FOREIGN KEY (`usuario_derivado_id`) REFERENCES `login` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
