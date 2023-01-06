-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-01-2023 a las 21:03:23
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kpi_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto`
--

CREATE TABLE `concepto` (
  `id` int(11) NOT NULL,
  `id_kpi` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `concepto`
--

INSERT INTO `concepto` (`id`, `id_kpi`, `descripcion`) VALUES
(9, 1, 'AUSENTISMO LABORAL'),
(10, 1, 'Q PERSONAS %');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicador`
--

CREATE TABLE `indicador` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detallado` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `indicador`
--

INSERT INTO `indicador` (`id`, `nombre`, `detallado`, `tipo`, `area`) VALUES
(1, 'AUSENTISMO LABORAL', 'Ausentismo', 'M', 'RRHH');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kpi_data`
--

CREATE TABLE `kpi_data` (
  `id` int(11) NOT NULL,
  `sucursal` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `concepto_id` int(11) NOT NULL,
  `periodo` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_combustible` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `producto` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `kpi_data`
--

INSERT INTO `kpi_data` (`id`, `sucursal`, `concepto_id`, `periodo`, `tipo_combustible`, `producto`, `valor`) VALUES
(1, '900', 9, '202212\r', '', '', 2),
(2, '900', 10, '202212\r', '', '', 56),
(3, '900', 9, '202211\r', '', '', 1),
(4, '900', 10, '202211\r', '', '', 4),
(5, '900', 9, '202210\r', '', '', 5),
(6, '900', 10, '202210\r', '', '', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `concepto`
--
ALTER TABLE `concepto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kpi` (`id_kpi`);

--
-- Indices de la tabla `indicador`
--
ALTER TABLE `indicador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `kpi_data`
--
ALTER TABLE `kpi_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `concepto_id` (`concepto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `concepto`
--
ALTER TABLE `concepto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `indicador`
--
ALTER TABLE `indicador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `kpi_data`
--
ALTER TABLE `kpi_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `concepto`
--
ALTER TABLE `concepto`
  ADD CONSTRAINT `concepto_ibfk_1` FOREIGN KEY (`id_kpi`) REFERENCES `indicador` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `kpi_data`
--
ALTER TABLE `kpi_data`
  ADD CONSTRAINT `kpi_data_ibfk_1` FOREIGN KEY (`concepto_id`) REFERENCES `concepto` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
