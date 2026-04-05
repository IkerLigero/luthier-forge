-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-04-2026 a las 13:01:48
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
-- Base de datos: `luthier_forge`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_carrito`, `id_usuario`, `fecha_creacion`) VALUES
(4, 20, '2026-03-26 14:35:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_detalle`
--

CREATE TABLE `carrito_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_carrito` int(11) NOT NULL,
  `id_guitarra_usuario` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_base`
--

CREATE TABLE `forma_base` (
  `id_forma_base` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `forma_base`
--

INSERT INTO `forma_base` (`id_forma_base`, `nombre`, `imagen`) VALUES
(1, 'Estratocaster', 'imagenes_asociadas/estrato.png'),
(2, 'Explorer', 'imagenes_asociadas/explorer.png'),
(3, 'SingleCut', 'imagenes_asociadas/lespaul.png'),
(4, 'Telecaster', 'imagenes_asociadas/telecaster.png'),
(5, 'Guitarra_V', 'imagenes_asociadas/V.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_color`
--

CREATE TABLE `forma_color` (
  `id_forma_color` int(11) NOT NULL,
  `id_forma_base` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `referencia_glb` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `unidades` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `forma_color`
--

INSERT INTO `forma_color` (`id_forma_color`, `id_forma_base`, `color`, `descripcion`, `referencia_glb`, `precio`, `unidades`) VALUES
(1, 1, 'Alder', 'Estratocaster Alder', 'Modelos/Formas/Estratocaster/Estratocaster_Alder.glb', 500.00, 10),
(2, 1, 'Caoba', 'Estratocaster Caoba', 'Modelos/Formas/Estratocaster/Estratocaster_Caoba.glb', 520.00, 10),
(3, 1, 'Fresno', 'Estratocaster Fresno', 'Modelos/Formas/Estratocaster/Estratocaster_Fresno.glb', 510.00, 10),
(4, 1, 'Madera', 'Estratocaster Madera', 'Modelos/Formas/Estratocaster/Estratocaster_Madera.glb', 530.00, 10),
(5, 2, 'Alder', 'Explorer Alder', 'Modelos/Formas/Explorer/Explorer_Alder.glb', 600.00, 10),
(6, 2, 'Caoba', 'Explorer Caoba', 'Modelos/Formas/Explorer/Explorer_Caoba.glb', 620.00, 10),
(7, 2, 'Fresno', 'Explorer Fresno', 'Modelos/Formas/Explorer/Explorer_Fresno.glb', 610.00, 10),
(8, 2, 'Madera', 'Explorer Madera', 'Modelos/Formas/Explorer/Explorer_Madera.glb', 630.00, 10),
(9, 3, 'Alder', 'SingleCut Alder', 'Modelos/Formas/SingleCut/SingleCut_Alder.glb', 650.00, 10),
(10, 3, 'Caoba', 'SingleCut Caoba', 'Modelos/Formas/SingleCut/SingleCut_Caoba.glb', 670.00, 10),
(11, 3, 'Fresno', 'SingleCut Fresno', 'Modelos/Formas/SingleCut/SingleCut_Fresno.glb', 660.00, 10),
(12, 3, 'Madera', 'SingleCut Madera', 'Modelos/Formas/SingleCut/SingleCut_Madera.glb', 680.00, 10),
(13, 4, 'Alder', 'Telecaster Alder', 'Modelos/Formas/Telecaster/Telecaster_Alder.glb', 700.00, 10),
(14, 4, 'Caoba', 'Telecaster Caoba', 'Modelos/Formas/Telecaster/Telecaster_Caoba.glb', 720.00, 10),
(15, 4, 'Fresno', 'Telecaster Fresno', 'Modelos/Formas/Telecaster/Telecaster_Fresno.glb', 710.00, 10),
(16, 4, 'Madera', 'Telecaster Madera', 'Modelos/Formas/Telecaster/Telecaster_Madera.glb', 730.00, 10),
(17, 5, 'Alder', 'Guitarra V Alder', 'Modelos/Formas/Guitarra_V/Guitarra_V_Alder.glb', 550.00, 10),
(18, 5, 'Caoba', 'Guitarra V Caoba', 'Modelos/Formas/Guitarra_V/Guitarra_V_Caoba.glb', 570.00, 10),
(19, 5, 'Fresno', 'Guitarra V Fresno', 'Modelos/Formas/Guitarra_V/Guitarra_V_Fresno.glb', 560.00, 10),
(20, 5, 'Madera', 'Guitarra V Madera', 'Modelos/Formas/Guitarra_V/Guitarra_V_Madera.glb', 580.00, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guitarra_usuario`
--

CREATE TABLE `guitarra_usuario` (
  `id_guitarra_usuario` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_forma_color` int(11) NOT NULL,
  `id_pastilla_modelo` int(11) NOT NULL,
  `id_mastil` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `guitarra_usuario`
--

INSERT INTO `guitarra_usuario` (`id_guitarra_usuario`, `id_usuario`, `id_forma_color`, `id_pastilla_modelo`, `id_mastil`, `fecha_creacion`) VALUES
(14, 20, 2, 3, 5, '2026-03-26 14:35:16'),
(15, 20, 2, 8, 5, '2026-03-26 15:27:21'),
(16, 20, 2, 6, 3, '2026-04-03 16:32:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_compra`
--

CREATE TABLE `historial_compra` (
  `id_compra` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `historial_compra`
--

INSERT INTO `historial_compra` (`id_compra`, `id_usuario`, `total`, `fecha`) VALUES
(1, 8, 1470.00, '2026-03-08 14:37:18'),
(2, 8, 760.00, '2026-03-08 15:32:54'),
(7, 20, 760.00, '2026-03-26 16:12:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_detalle`
--

CREATE TABLE `historial_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_compra` int(11) DEFAULT NULL,
  `id_guitarra_usuario` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `historial_detalle`
--

INSERT INTO `historial_detalle` (`id_detalle`, `id_compra`, `id_guitarra_usuario`, `precio`) VALUES
(1, 1, 11, 740.00),
(2, 1, 9, 730.00),
(4, 2, 8, 760.00),
(9, 7, 14, 760.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mastil`
--

CREATE TABLE `mastil` (
  `id_mastil` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `referencia_glb` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT 0.00,
  `forma_clavijero` varchar(100) DEFAULT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mastil`
--

INSERT INTO `mastil` (`id_mastil`, `nombre`, `descripcion`, `imagen`, `referencia_glb`, `precio`, `forma_clavijero`, `stock`) VALUES
(2, 'Fender Classic', 'Mástil Fender', 'imagenes_asociadas/fender.png', 'Modelos/Pala_Mastil/Fender_Classic.glb', 200.00, 'Clasico', 10),
(3, 'Gibson 3mas3', 'Mástil Gibson', 'imagenes_asociadas/gibson3.png', 'Modelos/Pala_Mastil/Gibson_3mas3.glb', 220.00, '3+3', 10),
(4, 'Gibson Asimetrica', 'Mástil Gibson Asim', 'imagenes_asociadas/gibsona.png', 'Modelos/Pala_Mastil/Gibson_Asimetrica.glb', 230.00, 'Asimetrico', 10),
(5, 'Ibanez Afilada', 'Mástil Ibanez', 'imagenes_asociadas/ibanez.png', 'Modelos/Pala_Mastil/Ibanez_Afilada.glb', 240.00, 'Afilado', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pastilla_modelo`
--

CREATE TABLE `pastilla_modelo` (
  `id_pastilla_modelo` int(11) NOT NULL,
  `id_forma_base` int(11) NOT NULL,
  `tipo` enum('humbucker','singlecoil') NOT NULL,
  `referencia_glb` varchar(255) NOT NULL,
  `imagen_pastillas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pastilla_modelo`
--

INSERT INTO `pastilla_modelo` (`id_pastilla_modelo`, `id_forma_base`, `tipo`, `referencia_glb`, `imagen_pastillas`) VALUES
(1, 1, 'humbucker', 'Modelos/Hambucker/Hambucker_Estratocaster.glb', 'imagenes_asociadas/hambucker_estratocaster.png'),
(2, 2, 'humbucker', 'Modelos/Hambucker/Hambucker_Explorer.glb', 'imagenes_asociadas/hambucker_explorer.png'),
(3, 3, 'humbucker', 'Modelos/Hambucker/Hambucker_Guitarra_V.glb', 'imagenes_asociadas/hambucker_v.png'),
(4, 4, 'humbucker', 'Modelos/Hambucker/Hambucker_SingleCut.glb', 'imagenes_asociadas/hambucker_lespaul.png'),
(5, 5, 'humbucker', 'Modelos/Hambucker/Hambucker_Telecaster.glb', 'imagenes_asociadas/hambucker_telecaster.png'),
(6, 1, 'singlecoil', 'Modelos/SingleCoil/SingleCoil_Estratocaster.glb', 'imagenes_asociadas/singlecoil_estratocaster.png'),
(7, 2, 'singlecoil', 'Modelos/SingleCoil/SingleCoil_Explorer.glb', 'imagenes_asociadas/singlecoil_explorer.png'),
(8, 3, 'singlecoil', 'Modelos/SingleCoil/SingleCoil_Guitarra_V.glb', 'imagenes_asociadas/singlecoil_v.png'),
(9, 4, 'singlecoil', 'Modelos/SingleCoil/SingleCoil_SingleCut.glb', 'imagenes_asociadas/singlecoil_lespaul.png'),
(10, 5, 'singlecoil', 'Modelos/SingleCoil/SingleCoil_Telecaster.glb', 'imagenes_asociadas/singlecoil_telecaster.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pieza_suelta`
--

CREATE TABLE `pieza_suelta` (
  `id_pieza` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT 0.00,
  `imagen` varchar(255) DEFAULT NULL,
  `referencia_glb` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `id_distribuidor` int(11) DEFAULT NULL,
  `aprobado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES
(1, 'cliente'),
(2, 'admin'),
(3, 'distribuidor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_distribuidor`
--

CREATE TABLE `solicitudes_distribuidor` (
  `id_solicitud` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `estado` enum('pendiente','aceptada','rechazada') DEFAULT 'pendiente',
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `solicitudes_distribuidor`
--

INSERT INTO `solicitudes_distribuidor` (`id_solicitud`, `id_usuario`, `estado`, `fecha`) VALUES
(12, 14, 'aceptada', '2026-03-07 15:55:13'),
(13, 15, 'aceptada', '2026-03-07 15:59:06'),
(14, 12, 'aceptada', '2026-03-07 16:43:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `edad` int(11) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `contrasenia_hash` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `edad`, `email`, `contrasenia_hash`, `id_rol`) VALUES
(18, 'admin', 'adminoso', NULL, 'admin@gmail.com', '$2y$10$yIyzVOtKe5tDvuhDe5R1CeXniDVQjPKDCk3eqGuxA0brq4rAWB9fC', 2),
(19, 'distribuidor', 'distribuidoso', NULL, 'distribuidor@gmail.com', '$2y$10$TY1edvVvavwujxzWNqxSK.LI4gLFh95KIqQUHgKeEm2uXEdHCjDRm', 3),
(20, 'cliente', 'clientoso', NULL, 'cliente@gmail.com', '$2y$10$sYSYQ2nxH6kL36Uddzj.o.o33K91eY5qIyfLUnHqPqQYIuqXoJc3W', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `carrito_detalle`
--
ALTER TABLE `carrito_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_carrito` (`id_carrito`),
  ADD KEY `id_guitarra_usuario` (`id_guitarra_usuario`);

--
-- Indices de la tabla `forma_base`
--
ALTER TABLE `forma_base`
  ADD PRIMARY KEY (`id_forma_base`);

--
-- Indices de la tabla `forma_color`
--
ALTER TABLE `forma_color`
  ADD PRIMARY KEY (`id_forma_color`),
  ADD KEY `id_forma_base` (`id_forma_base`);

--
-- Indices de la tabla `guitarra_usuario`
--
ALTER TABLE `guitarra_usuario`
  ADD PRIMARY KEY (`id_guitarra_usuario`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_forma_color` (`id_forma_color`),
  ADD KEY `id_pastilla_modelo` (`id_pastilla_modelo`),
  ADD KEY `id_mastil` (`id_mastil`);

--
-- Indices de la tabla `historial_compra`
--
ALTER TABLE `historial_compra`
  ADD PRIMARY KEY (`id_compra`);

--
-- Indices de la tabla `historial_detalle`
--
ALTER TABLE `historial_detalle`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `mastil`
--
ALTER TABLE `mastil`
  ADD PRIMARY KEY (`id_mastil`);

--
-- Indices de la tabla `pastilla_modelo`
--
ALTER TABLE `pastilla_modelo`
  ADD PRIMARY KEY (`id_pastilla_modelo`),
  ADD UNIQUE KEY `id_forma_base` (`id_forma_base`,`tipo`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pieza_suelta`
--
ALTER TABLE `pieza_suelta`
  ADD PRIMARY KEY (`id_pieza`),
  ADD KEY `id_distribuidor` (`id_distribuidor`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `solicitudes_distribuidor`
--
ALTER TABLE `solicitudes_distribuidor`
  ADD PRIMARY KEY (`id_solicitud`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `carrito_detalle`
--
ALTER TABLE `carrito_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `forma_base`
--
ALTER TABLE `forma_base`
  MODIFY `id_forma_base` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `forma_color`
--
ALTER TABLE `forma_color`
  MODIFY `id_forma_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `guitarra_usuario`
--
ALTER TABLE `guitarra_usuario`
  MODIFY `id_guitarra_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `historial_compra`
--
ALTER TABLE `historial_compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `historial_detalle`
--
ALTER TABLE `historial_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `mastil`
--
ALTER TABLE `mastil`
  MODIFY `id_mastil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pastilla_modelo`
--
ALTER TABLE `pastilla_modelo`
  MODIFY `id_pastilla_modelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pieza_suelta`
--
ALTER TABLE `pieza_suelta`
  MODIFY `id_pieza` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `solicitudes_distribuidor`
--
ALTER TABLE `solicitudes_distribuidor`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `carrito_detalle`
--
ALTER TABLE `carrito_detalle`
  ADD CONSTRAINT `fk_carrito_rel` FOREIGN KEY (`id_carrito`) REFERENCES `carrito` (`id_carrito`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_guitarra_rel` FOREIGN KEY (`id_guitarra_usuario`) REFERENCES `guitarra_usuario` (`id_guitarra_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `forma_color`
--
ALTER TABLE `forma_color`
  ADD CONSTRAINT `forma_color_ibfk_1` FOREIGN KEY (`id_forma_base`) REFERENCES `forma_base` (`id_forma_base`) ON DELETE CASCADE;

--
-- Filtros para la tabla `guitarra_usuario`
--
ALTER TABLE `guitarra_usuario`
  ADD CONSTRAINT `guitarra_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `guitarra_usuario_ibfk_2` FOREIGN KEY (`id_forma_color`) REFERENCES `forma_color` (`id_forma_color`) ON DELETE CASCADE,
  ADD CONSTRAINT `guitarra_usuario_ibfk_3` FOREIGN KEY (`id_pastilla_modelo`) REFERENCES `pastilla_modelo` (`id_pastilla_modelo`) ON DELETE CASCADE,
  ADD CONSTRAINT `guitarra_usuario_ibfk_4` FOREIGN KEY (`id_mastil`) REFERENCES `mastil` (`id_mastil`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pastilla_modelo`
--
ALTER TABLE `pastilla_modelo`
  ADD CONSTRAINT `pastilla_modelo_ibfk_1` FOREIGN KEY (`id_forma_base`) REFERENCES `forma_base` (`id_forma_base`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pieza_suelta`
--
ALTER TABLE `pieza_suelta`
  ADD CONSTRAINT `pieza_suelta_ibfk_1` FOREIGN KEY (`id_distribuidor`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
