-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-11-2026 a las 06:09:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agenda_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `favorito` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id`, `id_usuario`, `nombre`, `telefono`, `correo`, `ciudad`, `fecha_creacion`, `favorito`) VALUES
(1, 2, 'Carlos A', '0999456789', 'yyy@gmail.com', 'Cuenca', '2026-11-20 22:17:10', 0),
(2, 2, 'Samy', '0123654784', 'yyy@gmail.com', 'Quito', '2026-11-20 22:17:10', 1),
(3, 3, 'José Luis', '7778899112', 'eee@gmail.com', 'Quito', '2026-11-18 22:17:10', 0),
(4, 2, 'Ana', '5555555', 'ttt@gmail.com', 'Manta', '2026-11-18 22:17:10', 0),
(5, 2, 'Nicolas', '456789456', 'nico@gmail.com', 'Ambato', '2026-11-20 23:02:35', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `fecha_registro`) VALUES
(2, 'Kary', 'xxx@gmail.com', '$2y$10$5aYdw604Y/92u0fEyhfCj.8dUlF2/sDxyecaup9gkcDdrsgSgObM2', '2026-11-14 23:40:57'),
(3, 'Valentina', 'aaa@gmail.com', '$2y$10$TsNzoqrD/azKPt2KyYlkbu6oC.FCGon.KpZhI9k3ppaPf/1SlLLTe', '2026-11-15 00:42:07'),
(7, 'xxxx', 'bbb@gmail.com', '$2y$10$Y.UBmzeOVjiV1erAf35PqurdYVoHZjD6ACvAaHoIFHlp4vJ34UO.y', '2026-11-15 09:58:13');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `contactos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
