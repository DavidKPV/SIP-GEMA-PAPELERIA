-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-06-2019 a las 02:00:02
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sip-gema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones_de_usuario`
--

CREATE TABLE `acciones_de_usuario` (
  `id_diccionario` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `caracteristica` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `acciones_de_usuario`
--

INSERT INTO `acciones_de_usuario` (`id_diccionario`, `caracteristica`) VALUES
('restart', 'Reiniciar estadisticas'),
('ven', 'Venta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id_usuario` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_venta` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `monto` float NOT NULL,
  `fecha` date NOT NULL,
  `id_diccionario` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id_usuario`, `id_venta`, `monto`, `fecha`, `id_diccionario`) VALUES
('usr01', 'usr01282104', 25, '2019-06-28', 'ven'),
('usr01', 'usr0128411', 150, '2019-06-28', 'ven'),
('usr01', 'usr01281511', 77, '2019-06-28', 'ven'),
('usr01', 'usr01281511', 77, '2019-06-28', 'ven'),
('usr01', 'usr01281511', 77, '2019-06-28', 'ven'),
('usr01', 'usr01281617', 19.5, '2019-06-28', 'ven'),
('usr01', 'usr01281617', 19.5, '2019-06-28', 'ven'),
('usr01', 'usr01281621', 3, '2019-06-28', 'ven'),
('usr01', 'usr01281642', 995, '2019-06-28', 'ven'),
('usr01', 'usr01281642', 995, '2019-06-28', 'ven');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diccionario_de_productos`
--

CREATE TABLE `diccionario_de_productos` (
  `id_tipoproducto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `caracteristica` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `diccionario_de_productos`
--

INSERT INTO `diccionario_de_productos` (`id_tipoproducto`, `caracteristica`) VALUES
('1b', 'Biografia'),
('1g', 'Producto General'),
('1M', 'Monografia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `nombre_producto` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `precio_producto` float NOT NULL,
  `cantidad_producto` int(20) NOT NULL,
  `descripcion_producto` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `id_producto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_tipoproducto` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`nombre_producto`, `precio_producto`, `cantidad_producto`, `descripcion_producto`, `id_producto`, `id_tipoproducto`) VALUES
('lapiz     ', 5, 163, 'lapiz marca patito prueba edicion   ', 'as12  ', '1g'),
('benito juarez', 2, 20, 'biografia de benito juarez', 'bio1', '1b'),
('colores mapita ', 30, 30, 'caja de 12 colores mapita ', 'cjcol12', '1g'),
('corrector de brocha ', 18.5, 106, 'corrector de brocha marca borel. ', 'co1', '1g'),
('clip metalico ', 1.5, 68, 'clip metalico marca zorca. ', 'ge12', '1g'),
('goma', 7.5, 82, 'goma bicolor chica ', 'gom15', '1g'),
('la tierra    ', 1, 68, 'dx     ', 'mon1', '1M'),
('los ninos heroes', 2, 190, 'monografia de los ninos heroes xd', 'mon2', '1M'),
('memoria usb', 128, 82, 'memoria usb de 32 gigabytes marca kingstom', 'mus1', '1g'),
('Regla de Plastico', 25, 70, 'Regla de plastico flexible de diferentes colores.', 'regcol', '1g'),
('Sacapuntas', 6, 69, 'Sacapuntas panini', 'sac12', '1g'),
('tijeras ', 9.5, 10, 'tijeras escolares ', 'tij011', '1g'),
('lapiz ', 2.5, 78, 'lapiz econonico.', 'xs', '1g');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `correo_usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `password_usuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `tipo_usuario`, `nombre_usuario`, `correo_usuario`, `password_usuario`) VALUES
('usr01', 'administrador', 'David Lopez', 'daviddago@gmail.com', '123'),
('usr02', 'vendedor', 'Marcos Martinez', 'daviddago10@gmail.com', '123'),
('usr03', 'administrador', 'David Martinez', 'daviddavid@gmail.com', 'qwaszx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_descripcion`
--

CREATE TABLE `ventas_descripcion` (
  `id_venta` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_producto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad_producto` int(20) NOT NULL,
  `precio_producto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas_descripcion`
--

INSERT INTO `ventas_descripcion` (`id_venta`, `id_producto`, `cantidad_producto`, `precio_producto`) VALUES
('usr02241629', 'as12', 5, 0),
('usr02241629', 'ge12', 10, 0),
('usr01241677', 'cjcol12', 2, 0),
('usr01241677', 'gom15', 1, 0),
('usr0125623', 'as12', 5, 0),
('usr0125625', 'as12', 2, 0),
('usr0125629', 'sac12', 15, 0),
('usr0125737', 'as12', 4, 0),
('usr02251928', 'mus1', 1, 0),
('usr0126770', 'sac12', 2, 0),
('usr01261726', 'xs', 7, 0),
('usr01261726', 'mon1', 7, 0),
('usr01261726', 'mon1', 1, 0),
('usr01261726', 'mon1', 1, 0),
('usr01261731', 'ge12', 30, 0),
('usr01261731', 'as12', 8, 0),
('usr01262312', 'as12', 1, 0),
('usr01262312', 'ge12', 7, 0),
('usr0127489', 'gom15', 4, 0),
('usr0127148', 'cjcol12', 10, 0),
('usr0127148', 'ge12', 10, 0),
('usr0128250', 'as12', 5, 5),
('usr0128254', 'as12', 5, 5),
('usr0128256', 'as12', 5, 5),
('usr0128262', 'mus1', 2, 128),
('usr0128266', 'as12', 5, 5),
('usr012276', 'mon2', 10, 2),
('usr01282104', 'regcol', 1, 25),
('usr0128411', 'cjcol12', 5, 30),
('usr01281511', 'as12', 2, 5),
('usr01281511', 'cjcol12', 1, 30),
('usr01281511', 'co1', 2, 18.5),
('usr01281617', 'gom15', 1, 7.5),
('usr01281617', 'sac12', 2, 6),
('usr01281621', 'mon1', 3, 1),
('usr01281642', 'tij011', 10, 9.5),
('usr01281642', 'cjcol12', 30, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_encabezado`
--

CREATE TABLE `ventas_encabezado` (
  `id_venta` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `precio_final` float NOT NULL,
  `id_usuario` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas_encabezado`
--

INSERT INTO `ventas_encabezado` (`id_venta`, `fecha`, `precio_final`, `id_usuario`) VALUES
('usr012276', '2019-07-02', 20, 'usr01'),
('usr01241677', '2019-06-24', 67.5, 'usr01'),
('usr0125623', '2019-06-25', 25, 'usr01'),
('usr0125625', '2019-06-25', 10, 'usr01'),
('usr0125629', '2019-06-25', 90, 'usr01'),
('usr0125737', '2019-06-25', 20, 'usr01'),
('usr01261726', '2019-06-26', 26.5, 'usr01'),
('usr01261731', '2019-06-26', 85, 'usr01'),
('usr01262312', '2019-06-26', 0, 'usr01'),
('usr0126770', '2019-06-26', 12, 'usr01'),
('usr0127148', '2019-06-27', 0, 'usr01'),
('usr0127365', '2019-06-27', 0, 'usr01'),
('usr0127489', '2019-06-27', 0, 'usr01'),
('usr01281511', '2019-06-28', 77, 'usr01'),
('usr01281617', '2019-06-28', 19.5, 'usr01'),
('usr01281621', '2019-06-28', 3, 'usr01'),
('usr01281642', '2019-06-28', 995, 'usr01'),
('usr01282104', '2019-06-28', 25, 'usr01'),
('usr0128250', '2019-06-28', 25, 'usr01'),
('usr0128254', '2019-06-28', 25, 'usr01'),
('usr0128256', '2019-06-28', 25, 'usr01'),
('usr0128262', '2019-06-28', 256, 'usr01'),
('usr0128266', '2019-06-28', 25, 'usr01'),
('usr0128411', '2019-06-28', 150, 'usr01'),
('usr02241629', '2019-06-24', 40, 'usr02'),
('usr02251928', '2019-06-25', 128, 'usr02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones_de_usuario`
--
ALTER TABLE `acciones_de_usuario`
  ADD PRIMARY KEY (`id_diccionario`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_diccionario` (`id_diccionario`);

--
-- Indices de la tabla `diccionario_de_productos`
--
ALTER TABLE `diccionario_de_productos`
  ADD PRIMARY KEY (`id_tipoproducto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_tipoproducto` (`id_tipoproducto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `ventas_descripcion`
--
ALTER TABLE `ventas_descripcion`
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `ventas_encabezado`
--
ALTER TABLE `ventas_encabezado`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `bitacora_ibfk_2` FOREIGN KEY (`id_diccionario`) REFERENCES `acciones_de_usuario` (`id_diccionario`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_tipoproducto`) REFERENCES `diccionario_de_productos` (`id_tipoproducto`);

--
-- Filtros para la tabla `ventas_descripcion`
--
ALTER TABLE `ventas_descripcion`
  ADD CONSTRAINT `ventas_descripcion_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas_encabezado` (`id_venta`),
  ADD CONSTRAINT `ventas_descripcion_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `ventas_encabezado`
--
ALTER TABLE `ventas_encabezado`
  ADD CONSTRAINT `ventas_encabezado_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
