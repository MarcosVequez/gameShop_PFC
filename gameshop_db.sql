-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2022 a las 14:33:32
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
-- Base de datos: `gameshop_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(255) NOT NULL,
  `usuario_id` int(255) NOT NULL,
  `producto_id` int(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` double NOT NULL,
  `cantidad` int(100) NOT NULL,
  `imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(255) NOT NULL,
  `usuario_id` int(255) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `mensaje` varchar(1000) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `usuario_id`, `nombre`, `email`, `telefono`, `mensaje`) VALUES
(19, 13, 'usuario1', 'usuario1@gmail.com', '555556677', 'Mensaje de prueba'),
(20, 16, 'usuario2', 'usuario2@gmail.com', '555445566', 'Hola');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(255) NOT NULL,
  `usuario_id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `metodo` varchar(50) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `total_productos` varchar(10000) NOT NULL,
  `total_precio` double NOT NULL,
  `fecha_pedido` date NOT NULL DEFAULT current_timestamp(),
  `estado_pedido` varchar(20) NOT NULL DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `nombre`, `telefono`, `email`, `metodo`, `direccion`, `total_productos`, `total_precio`, `fecha_pedido`, `estado_pedido`) VALUES
(13, 13, 'usuario1', '555556677', 'usuario1@gmail.com', 'Tarjeta de crédito', 'calle, 3 izqda, coruña, coruña, españa - CP: 11123', 'Vampire The Masquerade Swansong (59.99 x 1) - Ciberpunk 2077 (39.99 x 1) - Elden Ring (59.99 x 1) - ', 159.97, '2022-05-25', 'Pendiente'),
(14, 16, 'usuario2', '555445566', 'usuario2@gmail.com', 'Paypal', 'prueba, 1 d, Coruña, Coruña, España - CP: 12345', 'Horizon Forbidden West (59.99 x 1) - Star Wars: La Saga Skywalker (59.99 x 1) - ', 119.98, '2022-05-25', 'Pendiente'),
(15, 17, 'usuario3', '555778899', 'usuario3@gmail.com', 'Tarjeta de crédito', 'Prueba, 4 d, Lugo, Lugo, España - CP: 12234', 'Xbox Series X (399.99 x 1) - Volante Thrustmaster Xbox (399.99 x 1) - Mando Azul Xbox (55.99 x 2) - Auriculares Xbox  (99.95 x 1) - ', 1011.91, '2022-05-25', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(255) NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8 NOT NULL,
  `detalles` varchar(800) CHARACTER SET utf8 NOT NULL,
  `precio` double NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `imagen_01` varchar(100) CHARACTER SET utf8 NOT NULL,
  `imagen_02` varchar(100) CHARACTER SET utf8 NOT NULL,
  `imagen_03` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `detalles`, `precio`, `categoria`, `imagen_01`, `imagen_02`, `imagen_03`) VALUES
(14, 'GTA V', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 35.99, 'Juegos Xbox', 'Xbox_GTAV01.jpg', 'Xbox_GTAV02.jpg', 'Xbox_GTAV03.jpg'),
(15, 'Forza Horizon 5', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 59.99, 'Juegos Xbox', 'Xbox_fh5_01.jpg', 'Xbox_fh5_02.jpg', 'Xbox_fh5_03.jpg'),
(16, 'Ori and the Will of the Wisps', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 39.99, 'Juegos Xbox', 'Xbox_ori01.jpg', 'Xbox_ori02.jpg', 'Xbox_ori03.jpg'),
(17, 'Horizon Forbidden West', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 59.99, 'Juegos Playstation', 'Play_Horizon01.jpg', 'Play_Horizon02.jpg', 'Play_Horizon03.jpg'),
(18, 'Ciberpunk 2077', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 39.99, 'Juegos Xbox', 'Xbox_Ciberpunk01.jpg', 'Xbox_Ciberpunk02.jpg', 'Xbox_Ciberpunk03.jpg'),
(19, 'Mando Azul Xbox', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 55.99, 'Complementos', 'mando_Xbox_Azul01.jpg', 'mando_Xbox_Azul02.jpg', 'mando_Xbox_Azul03.jpg'),
(20, 'Volante Thrustmaster Xbox', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 399.99, 'Complementos', 'volante_Xbox01.jpg', 'volante_Xbox02.jpg', 'volante_Xbox03.jpg'),
(21, 'Xbox Series X', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 399.99, 'Videoconsolas Xbox', 'xbox_seriesX01.jpg', 'xbox_seriesX02.jpg', 'xbox_seriesX03.jpg'),
(22, 'Xbox Series S', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 299.99, 'Videoconsolas Xbox', 'xbox_seriesS01.jpg', 'xbox_seriesS02.jpg', 'xbox_seriesS03.jpg'),
(23, 'Xbox Series S + Forza Horizon 5', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 349.99, 'Videoconsolas Xbox', 'xbox_seriesS04.jpg', 'xbox_seriesS05.jpg', 'xbox_seriesS06.jpg'),
(24, 'Elden Ring', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 59.99, 'Juegos Xbox', 'xbox_elden_Ring01.jpg', 'xbox_elden_Ring02.jpg', 'xbox_elden_Ring03.jpg'),
(25, 'Auriculares Xbox ', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 99.95, 'Complementos', 'auricular_xbox01.jpg', 'auricular_xbox02.jpg', 'auricular_xbox03.jpg'),
(26, 'Mando Verde Xbox', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 59.99, 'Complementos', 'mando_Xbox_Verde01.jpg', 'mando_Xbox_Verde02.jpg', 'mando_Xbox_Verde03.jpg'),
(27, 'Mando Negro Xbox', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 49.99, 'Complementos', 'mando_Xbox_Negro01.jpg', 'mando_Xbox_Negro02.jpg', 'mando_Xbox_Negro03.jpg'),
(28, 'Star Wars: La Saga Skywalker', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 59.99, 'Juegos Playstation', 'Play_SWsagaSkywalker01.jpg', 'Play_SWsagaSkywalker02.jpg', 'Play_SWsagaSkywalker03.jpg'),
(29, 'Formula 1 2022', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 69.99, 'Juegos Playstation', 'Play_F122_01.jpg', 'Play_F122_02.jpg', 'Play_F122_03.jpg'),
(30, 'Sifu', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 49.99, 'Juegos Playstation', 'Play_sifu01.jpg', 'Play_sifu02.jpg', 'Play_sifu03.jpg'),
(31, 'PlayStation 5 + Ratchet & Clank', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 699.99, 'Videoconsolas Playstation', 'Play_ratchetclank01.jpg', 'Play_ratchetclank02.jpg', 'Play_ratchetclank03.jpg'),
(32, 'PlayStation 5 Digital', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 399.99, 'Videoconsolas Playstation', 'Play_digital01.jpg', 'Play_digital02.jpg', 'Play_digital03.jpg'),
(33, 'Mando PlayStation 5 Negro', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 59.99, 'Complementos', 'play_mandoNegro01.jpg', 'play_mandoNegro02.jpg', 'play_mandoNegro03.jpg'),
(34, 'Mando PlayStation 5 Purpura', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 59.99, 'Complementos', 'play_mandoPurpura01.jpg', 'play_mandoPurpura02.jpg', 'play_mandoPurpura03.jpg'),
(35, 'Triangle Strategy', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 59.99, 'Juegos Switch', 'Switch_Triangle_01.jpg', 'Switch_Triangle_02.jpg', 'Switch_Triangle_03.jpg'),
(36, 'Nintendo Switch ', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 299.99, 'Videoconsolas Switch', 'Switch_consola01.jpg', 'Switch_consola02.jpg', 'Switch_consola03.jpg'),
(37, 'Switch Lite', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 259.99, 'Videoconsolas Switch', 'Switch_consolaLite01.jpg', 'Switch_consolaLite02.jpg', 'Switch_consolaLite03.jpg'),
(38, 'Mando Switch', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 59.99, 'Complementos', 'Switch_mando01.jpg', 'Switch_mando02.jpg', 'Switch_mando03.jpg'),
(39, 'Pokemon Arceus', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 59.99, 'Juegos Switch', 'Switch_Pokemon01.jpg', 'Switch_Pokemon02.jpg', 'Switch_Pokemon03.jpg'),
(40, 'Kirby y la Tierra Olvidada', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 59.99, 'Juegos Switch', 'Switch_kirby01.jpg', 'Switch_kirby02.jpg', 'Switch_kirby03.jpg'),
(41, 'Fifa 22 Switch', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 39.99, 'Juegos Switch', 'Switch_Fifa22_01.jpg', 'Switch_Fifa22_02.jpg', 'Switch_Fifa22_03.jpg'),
(42, 'Xenoblade Chronicles 3', ' Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic,  iusto adipisci a rerum nemo perspiciatis fugiat sapiente. ', 59.99, 'Juegos Switch', 'Switch_Xenoblade_01.jpg', 'Switch_Xenoblade_02.jpg', 'Switch_Xenoblade_03.jpg'),
(43, 'Evil Dead', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 49.99, 'Juegos Playstation', 'Play_EvilDead01.jpg', 'Play_EvilDead02.jpg', 'Play_EvilDead03.jpg'),
(44, 'Vampire The Masquerade Swansong', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 59.99, 'Juegos Xbox', 'Xbox_Vampire01.jpg', 'Xbox_Vampire02.jpg', 'Xbox_Vampire03.jpg'),
(45, 'Sniper Elite 5', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.', 59.99, 'Juegos Xbox', 'Xbox_SniperElite01.jpg', 'Xbox_SniperElite02.jpg', 'Xbox_SniperElite03.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 NOT NULL,
  `tipo_usuario` varchar(20) NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `email`, `password`, `tipo_usuario`) VALUES
(13, '111', 'usuario1@gmail.com', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'usuario'),
(14, 'admin1', 'admin1@gmail.com', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'admin'),
(15, 'admin2', 'admin2@gmail.com', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'admin'),
(16, 'usuario2', 'usuario2@gmail.com', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'usuario'),
(17, 'usuario3', 'usuario3@gmail.com', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(255) NOT NULL,
  `usuario_id` int(255) NOT NULL,
  `producto_id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` double NOT NULL,
  `imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `wishlist`
--

INSERT INTO `wishlist` (`id`, `usuario_id`, `producto_id`, `nombre`, `precio`, `imagen`) VALUES
(21, 13, 45, 'Sniper Elite 5', 59.99, 'Xbox_SniperElite01.jpg'),
(22, 13, 43, 'Evil Dead', 49.99, 'Play_EvilDead01.jpg'),
(23, 13, 38, 'Mando Switch', 59.99, 'Switch_mando01.jpg'),
(24, 16, 43, 'Evil Dead', 49.99, 'Play_EvilDead01.jpg'),
(25, 17, 26, 'Mando Verde Xbox', 59.99, 'mando_Xbox_Verde01.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_userID_1` (`usuario_id`),
  ADD KEY `FK_productoId_1` (`producto_id`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_userID_2` (`usuario_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_userID` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_usuarioId` (`usuario_id`),
  ADD KEY `FK_productoId` (`producto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `FK_productoId_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_userID_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `FK_userID_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `FK_userID` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `FK_productoId` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_usuarioId` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
