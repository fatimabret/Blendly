-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2025 a las 20:05:18
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
-- Base de datos: `bd_bret_fati`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(10) NOT NULL,
  `nombre_categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Italian'),
(2, 'Natural'),
(3, 'Scottish');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `id_consulta` int(10) NOT NULL,
  `correo_consulta` varchar(50) NOT NULL,
  `telefono_consulta` varchar(20) NOT NULL,
  `motivo_consulta` varchar(80) NOT NULL,
  `texto_consulta` varchar(150) NOT NULL,
  `leido_consulta` int(1) NOT NULL,
  `id_estado` int(10) DEFAULT 1,
  `respuesta_consulta` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`id_consulta`, `correo_consulta`, `telefono_consulta`, `motivo_consulta`, `texto_consulta`, `leido_consulta`, `id_estado`, `respuesta_consulta`) VALUES
(1, 'fatimabret@outlook.com', '', 'prueba', 'dia de prueba uno.', 1, 1, ''),
(2, 'ejemplo@com.ar', '+543790800080', 'prueba dos', 'primer dia de prueba, segunda vez.', 1, 1, ''),
(3, 'juanperez@example.com', '8057939811', 'Cumplido', 'Satisfecho con sus productos, muy buena pagina.', 0, 1, ''),
(4, 'juanperez@example.com', '8057939811', 'Cumplido', 'Satisfecho con sus productos, muy buena pagina.', 1, 1, ''),
(5, 'beatrizcolumia@contac.exe', '4944483909', 'Calidad', 'Producto de muy buena calidad con unos precios increíbles.', 0, 1, ''),
(6, 'juanperez@example.com', '0489903899', 'Reactivar mi cuenta', 'Paso mucho tiempo de mi ultimo inicio de sesión, si me pueden reactivar mi cuenta, gracias.', 1, 1, 'Listo!'),
(10, 'beatrizcolum@contac.exa', '0489903899', 'hola', '12345', 1, 1, 'respuesta!'),
(11, 'juanperez@example.com', '0489903899', '1242567', 'vbnhjk', 0, 1, ''),
(12, 'beatrizcolum@contac.exa', '0489903899', 'yy', '8923fnef', 1, 1, 'hola'),
(13, 'adolfoluis@gmail.com', '0880093038', 'degustacion', 'abrirán otra sucursal por el centro?', 0, 1, ''),
(14, 'juanperez@example.com', '0489903899', 'probamos', 'consultas', 1, 1, 'hola chau'),
(15, 'luisacabe@gmail.com', '0880093038', 'Felicitaciones', 'Aviso que me llego espléndidamente los productos', 1, 1, ''),
(16, 'luisacabe@gmail.com', '0880093038', 'Pequeña pregunta', 'aceptan pedidos los domingos?', 1, 1, 'Aceptamos y preparamos los pedidos las 24hs, los 7 dias a la semana.Saludos!'),
(17, 'luisacabe@gmail.com', '0880093038', 'Horario', 'Que hora esta abierto el local?', 1, 1, ''),
(18, 'spirtmar@gmail.com', '0489903899', 'probando', 'puedo retirar en el local mi pedido?', 0, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(10) NOT NULL,
  `nombre_estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `nombre_estado`) VALUES
(0, 'Inactivo'),
(1, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(10) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `id_estado` int(10) DEFAULT 1,
  `id_cliente` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `fecha_pedido`, `id_estado`, `id_cliente`) VALUES
(22, '0000-00-00', 1, 3),
(23, '0000-00-00', 1, 14),
(24, '0000-00-00', 1, 14),
(25, '0000-00-00', 1, 2),
(27, '2024-06-25', 1, 14),
(30, '2024-06-25', 1, 2),
(31, '2024-06-25', 1, 14),
(32, '2024-06-25', 1, 2),
(33, '2024-06-25', 1, 3),
(34, '2024-06-26', 1, 2),
(35, '2024-06-27', 1, 3),
(36, '2024-07-01', 1, 15),
(37, '2024-07-01', 1, 15),
(38, '2024-07-01', 1, 15),
(39, '2024-07-01', 1, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalle`
--

CREATE TABLE `pedido_detalle` (
  `id_pedido` int(10) NOT NULL,
  `id_producto` int(10) NOT NULL,
  `cantidad_pedido` int(10) NOT NULL,
  `precio_unitario` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido_detalle`
--

INSERT INTO `pedido_detalle` (`id_pedido`, `id_producto`, `cantidad_pedido`, `precio_unitario`) VALUES
(22, 10, 1, 556.00),
(23, 5, 1, 801.73),
(24, 5, 1, 801.73),
(24, 12, 1, 790.32),
(24, 2, 1, 9800.59),
(25, 12, 2, 790.32),
(27, 5, 1, 801.73),
(30, 9, 1, 4500.01),
(31, 9, 1, 4500.01),
(32, 1, 2, 909.89),
(33, 2, 3, 9800.59),
(34, 12, 1, 790.32),
(35, 3, 1, 6700.75),
(35, 5, 1, 801.73),
(36, 4, 3, 8990.62),
(36, 8, 1, 7880.70),
(37, 1, 2, 990.90),
(37, 12, 1, 790.32),
(38, 6, 2, 6990.23),
(39, 8, 1, 7880.70),
(22, 10, 1, 556.00),
(23, 5, 1, 801.73),
(24, 5, 1, 801.73),
(24, 12, 1, 790.32),
(24, 2, 1, 9800.59),
(25, 12, 2, 790.32),
(27, 5, 1, 801.73),
(30, 9, 1, 4500.01),
(31, 9, 1, 4500.01),
(32, 1, 2, 909.89),
(33, 2, 3, 9800.59),
(34, 12, 1, 790.32),
(35, 3, 1, 6700.75),
(35, 5, 1, 801.73),
(36, 4, 3, 8990.62),
(36, 8, 1, 7880.70),
(37, 1, 2, 990.90),
(37, 12, 1, 790.32),
(38, 6, 2, 6990.23),
(39, 8, 1, 7880.70),
(22, 10, 1, 556.00),
(23, 5, 1, 801.73),
(24, 5, 1, 801.73),
(24, 12, 1, 790.32),
(24, 2, 1, 9800.59),
(25, 12, 2, 790.32),
(27, 5, 1, 801.73),
(30, 9, 1, 4500.01),
(31, 9, 1, 4500.01),
(32, 1, 2, 909.89),
(33, 2, 3, 9800.59),
(34, 12, 1, 790.32),
(35, 3, 1, 6700.75),
(35, 5, 1, 801.73),
(36, 4, 3, 8990.62),
(36, 8, 1, 7880.70),
(37, 1, 2, 990.90),
(37, 12, 1, 790.32),
(38, 6, 2, 6990.23),
(39, 8, 1, 7880.70),
(22, 10, 1, 556.00),
(23, 5, 1, 801.73),
(24, 5, 1, 801.73),
(24, 12, 1, 790.32),
(24, 2, 1, 9800.59),
(25, 12, 2, 790.32),
(27, 5, 1, 801.73),
(30, 9, 1, 4500.01),
(31, 9, 1, 4500.01),
(32, 1, 2, 909.89),
(33, 2, 3, 9800.59),
(34, 12, 1, 790.32),
(35, 3, 1, 6700.75),
(35, 5, 1, 801.73),
(36, 4, 3, 8990.62),
(36, 8, 1, 7880.70),
(37, 1, 2, 990.90),
(37, 12, 1, 790.32),
(38, 6, 2, 6990.23),
(39, 8, 1, 7880.70);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(10) NOT NULL,
  `nombre_perfil` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nombre_perfil`) VALUES
(1, 'Cliente'),
(2, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(10) NOT NULL,
  `categoria_producto` int(10) NOT NULL,
  `nombre_producto` varchar(50) NOT NULL,
  `descripcion_producto` varchar(110) NOT NULL,
  `precio_producto` decimal(7,2) NOT NULL,
  `stock_producto` int(5) NOT NULL,
  `imagen_producto` varchar(255) NOT NULL,
  `id_estado` int(10) DEFAULT 1,
  `proveedor_producto` int(10) DEFAULT NULL,
  `vendidos_producto` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `categoria_producto`, `nombre_producto`, `descripcion_producto`, `precio_producto`, `stock_producto`, `imagen_producto`, `id_estado`, `proveedor_producto`, `vendidos_producto`) VALUES
(1, 2, 'Drink White', 'Pure, freshly squeezed.', 990.90, 2, '1718651989_naturalmarc.jpeg', 1, 1, 0),
(2, 3, 'Scorttish Heart', 'Whisky-smùidh agus fiodha le blasanna caramel, vanille, agus caorann.', 9800.59, 0, '1718651945_blackmarc.jpeg', 0, 2, 1),
(3, 1, 'Somul', 'Vino bianco fresco con aromi di agrumi e fiori.', 6700.75, 0, '1718652237_somul.jpeg', 0, 3, 0),
(4, 1, 'Somul Exclusive', 'Vino rosso corposo con note di frutti scuri e un tocco di rovere.', 8990.62, 4, '1718652309_somulexcl.jpeg', 1, 3, 0),
(5, 2, 'Lemonade', 'A zesty, tangy lemonade made from fresh lemons.', 801.73, 0, '1718650970_natural.jpeg', 0, 1, 2),
(6, 3, 'Desgn', 'Gìn àrd-inbheach le nòtanan bòtannach. Sònraichte airson gìn-tonic clasaigeach.', 6990.23, 5, '1718652667_whitedesgn.jpeg', 1, 2, 0),
(8, 1, 'Berd', 'Gin premium con note di ginepro, agrumi ed erbe.', 7880.70, 5, '1718652886_whiteberd.jpeg', 1, 3, 0),
(9, 3, 'Yotre Haimn', 'Beòr ceann-làidir le measgachadh freagarrach.', 4500.01, 2, '1718653059_black.jpeg', 1, 2, 0),
(10, 1, 'Drink White', 'Much heath...', 556.00, 7, '1718716690_whitedrink.jpeg', 1, 3, 1),
(12, 2, 'Orange Juice', 'Pure, freshly squeezed orange juice packed with vitamins and flavor.', 790.32, 3, '1718652001_natural00.jpeg', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(10) NOT NULL,
  `nombre_proveedor` varchar(50) NOT NULL,
  `correo_proveedor` varchar(80) NOT NULL,
  `telefono_proveedor` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre_proveedor`, `correo_proveedor`, `telefono_proveedor`) VALUES
(1, 'PrimeGoods Ltd.', 'primegoods@yooh.com.ar', 909977710),
(2, 'GlobalImports', 'globalimports@gmail.com', 800880800),
(3, 'NovelSupplies', 'novelsupplies@contac.com', 800808880);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(10) NOT NULL,
  `perfil_usuario` int(1) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `apellido_usuario` varchar(50) NOT NULL,
  `correo_usuario` varchar(100) NOT NULL,
  `edad_usuario` int(3) NOT NULL,
  `pass_usuario` varchar(80) NOT NULL,
  `id_estado` int(10) DEFAULT 1,
  `direccion_usuario` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `perfil_usuario`, `nombre_usuario`, `apellido_usuario`, `correo_usuario`, `edad_usuario`, `pass_usuario`, `id_estado`, `direccion_usuario`) VALUES
(1, 2, 'Fátima', 'Bret', 'fatimabret@outlook.com', 20, '$2y$10$piUEluoc415FSYAI5XtwgOhSfjSVV1EiurJeBKkaTDC.eRoQ1W68W', 1, '0'),
(2, 1, 'Beatriz', 'Colum', 'beatrizcolum@contac.exa', 57, '$2y$10$GbIf.sfkVkiYorZ8Hgytde3fpy2m5px5wAfboycBNzDQ/fKZEUUyu', 1, '0'),
(3, 1, 'Juan', 'Perez', 'juanperez@example.com', 26, '$2y$10$QT9sq45BuVLSYGVgWT52teBkS1orI0fNoOWg.Qth3ZNToubhBFSIW', 1, '0'),
(14, 1, 'José Luis', 'Adolfo', 'adolfoluis@gmail.com', 61, '$2y$10$S8vSAJkfdPJw97fRl5gaCeacJQoSpDDbTbpQDC67ln23kXwk3nD0G', 1, ''),
(15, 1, 'Luisa', 'Caberna', 'luisacabe@gmail.com', 42, '$2y$10$omwsaYv2lWHKBjBWn26CV.t.lEr0vy8Nf22iXnpf2WJVlMmhbDpIS', 1, ''),
(16, 1, 'Mario', 'Spirt', 'spirtmar@gmail.com', 39, '$2y$10$FDZkSoYUxZPxnEuozOs/du5XyoDSNC0sVeA.rJ/aGsfRpS2dFxcey', 1, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id_consulta`),
  ADD KEY `FK_consulta_estado` (`id_estado`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `PK_pedido_producto` (`fecha_pedido`),
  ADD KEY `FK_pedido_usurio` (`id_cliente`),
  ADD KEY `FK_pedido_estado` (`id_estado`);

--
-- Indices de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD KEY `FK_pedido_detalle_producto` (`id_producto`),
  ADD KEY `FK_pedido_detalle_pedido` (`id_pedido`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `FK_producto_categoria` (`categoria_producto`) USING BTREE,
  ADD KEY `FK_producto_proveedor` (`proveedor_producto`) KEY_BLOCK_SIZE=2 USING BTREE,
  ADD KEY `FK_producto_estado` (`id_estado`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo_usuario` (`correo_usuario`),
  ADD KEY `FK_usuario_perfil` (`perfil_usuario`),
  ADD KEY `FK_usuario_estado` (`id_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id_consulta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `FK_consulta_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `FK_pedido_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `FK_pedido_usurio` FOREIGN KEY (`id_cliente`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD CONSTRAINT `FK_pedido_detalle_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `FK_pedido_detalle_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_producto_categoria` FOREIGN KEY (`categoria_producto`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `FK_producto_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `FK_producto_proveedor` FOREIGN KEY (`proveedor_producto`) REFERENCES `proveedor` (`id_proveedor`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_usuario_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `FK_usuario_perfil` FOREIGN KEY (`perfil_usuario`) REFERENCES `perfil` (`id_perfil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
