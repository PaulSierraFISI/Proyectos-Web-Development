-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-09-2021 a las 03:12:43
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dsw`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `CodPedido` int(11) NOT NULL AUTO_INCREMENT,
  `CodCliente` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `CodProducto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `FechaPedido` datetime NOT NULL,
  `Total` float NOT NULL,
  `Estado` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Direccion` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `NumContacto` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `NombreCliente` varchar(40) COLLATE utf8mb4_spanish_ci NOT NULL,
  `NombreProducto` varchar(40) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`CodPedido`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`CodPedido`, `CodCliente`, `CodProducto`, `Cantidad`, `FechaPedido`, `Total`, `Estado`, `Direccion`, `NumContacto`, `NombreCliente`, `NombreProducto`) VALUES
(1, 'alexander@gmail.com', 131, 10, '2021-09-05 17:55:18', 50, 'En envÃ­o', 'Mz D Lt 1 Urb Villa Juanita', '+51973793548', 'Paul Alexander', 'Promo Especial San Salvador'),
(2, 'alexander@gmail.com', 130, 50, '2021-09-05 19:36:21', 500, 'Entregado', 'Mz D Lt 1 Urb Villa Juanita', '+51973793548', 'Paul Alexander', 'Paquete Fit');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `CodProducto` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Descripcion` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `Precio` float NOT NULL,
  `RutaImagen` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`CodProducto`)
) ENGINE=MyISAM AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`CodProducto`, `Nombre`, `Descripcion`, `Precio`, `RutaImagen`) VALUES
(129, 'Combo familiar', 'Paquete de snacks (almendras, mani­ y pasas), 4 Kg de Yougrt de Durazno y 200 gr de Yogurt Griego.', 10, './img/productos/Combo familiar.jpg'),
(130, 'Paquete Fit', 'Paquete de snacks (almendras, mani­ y pasas), 4 Kg de Yougrt de Durazno y 700 gr de Queso Fresco.', 10, './img/productos/Paquete Fit.jpg'),
(131, 'Promo Especial San Salvador', '2 Kg de Yogurt San Salvador de Maracuya, 100 gr de Yogurt de Fresa y 300 gr de Queso Fresco Semiblando Entero', 5, './img/productos/Promo Especial San Salvador.jpg'),
(132, 'Queso Mozarella y Manjar de Leche', '500 gr de Queso Mozarella y 400 gr de Manjar de Leche', 5, './img/productos/Queso Mozarella y Manjar de Leche.jpg'),
(133, 'Queso Mozarella y Yogurt de Durazno', '1 kg de Yogurt de Durazno, 1kg de Queso Mozzarella y 500 gr de queso Fresco Semiblando Entero', 10, './img/productos/Queso Mozarella y Yogurt de Durazno.jpg'),
(134, 'Tri Pack Especial', '2 kg de Yogurt de guanabana, 350 gr Granol Milas y 50 gr de Yogurt Griego', 5, './img/productos/Tri-Pack Yogurt.jpg'),
(135, 'Yogurt de Mora y Queso Mozarella', '2 kg de Yogurt de Mora y 500 Queso Mozarella', 5, './img/productos/Yogurt de Mora y Queso Mozarella.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `Correo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Contrasena` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Rol` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Nombres` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Apellidos` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Telefono` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `FechaNacimiento` date NOT NULL,
  `Direccion` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`Correo`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Correo`, `Contrasena`, `Rol`, `Nombres`, `Apellidos`, `Telefono`, `FechaNacimiento`, `Direccion`) VALUES
('127', '127', 'Admin', 'Admin', 'Admin', '973793548', '2020-10-20', 'Mz \"D\" Lt \"1\" Urb. Villa Juanita'),
('alexander@gmail.com', 'alexander@gmail.com', 'Cliente', 'Paul Alexander', 'Sierra Cordova', '+51973793548', '2000-11-02', 'Mz D Lt 1 Urb Villa Juanita');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
