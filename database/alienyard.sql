-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-05-2020 a las 22:52:50
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `alienyard`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriaingrediente`
--

CREATE TABLE `categoriaingrediente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoriaingrediente`
--

INSERT INTO `categoriaingrediente` (`id`, `nombre`, `updated_at`, `created_at`) VALUES
(2, 'Vegetales', '2020-02-23 13:42:20', '2020-02-23 13:42:20'),
(5, 'Carnes', '2020-03-24 14:34:18', '2020-03-24 14:34:18'),
(6, 'Pan', '2020-03-25 14:28:06', '2020-03-25 14:28:06'),
(7, 'Salsa', '2020-03-25 14:31:43', '2020-03-25 14:31:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `celular` varchar(30) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `role` int(10) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `edad`, `telefono`, `celular`, `email`, `role`, `direccion`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(8, 'Gabriel', 'Dominguez', 23, '(809) 288-2113', '(829) 943-6531', 'gabriel@alienyard.com', 2, 'c/primera', '$2y$10$Un5ZLYie6aBWBWAkVeY0Pu2e3qqd/ycQghPU/guYYoRs/Onfc8.lC', '1582447657Joker Finish.png', NULL, '2020-02-23 08:47:39', '2020-02-23 08:47:39'),
(10, 'Anel', 'Dominguez', 23, '(809) 288-2113', '(829) 943-6531', 'anel@anel.com', 1, 'c/ primera', '$2y$10$rhndfFhWg0i9U1QZOjBBAucpR6KzR1mik86FkoCtxTzLKFsy/v/Eq', '1582465508678027.jpg', NULL, '2020-02-23 13:45:10', '2020-02-23 13:45:10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoriaingrediente`
--
ALTER TABLE `categoriaingrediente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoriaingrediente`
--
ALTER TABLE `categoriaingrediente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
