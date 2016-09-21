-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-04-2016 a las 10:44:52
-- Versión del servidor: 10.0.13-MariaDB
-- Versión de PHP: 5.5.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `grupo_48`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento`
--

CREATE TABLE IF NOT EXISTS `alimento` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `codigo` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `alimento`
--

INSERT INTO `alimento` (`codigo`, `descripcion`) VALUES
(1, 'ARROZ'),
(2, 'MAIZ'),
(3, 'HARINA'),
(4, 'BANANA'),
(5, 'ARROCES'),
(6, 'FIDEO'),
(7, 'MAICENA'),
(8, 'LECHE'),
(9, 'MILANESA'),
(10, 'PURÉ DE TOMATES'),
(11, 'QUESO CREMOSO'),
(12, 'PAN LACTAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento_donante`
--

CREATE TABLE IF NOT EXISTS `alimento_donante` (
  `detalle_alimento_id` int(11) NOT NULL,
  `donante_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`detalle_alimento_id`,`donante_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimento_donante`
--

INSERT INTO `alimento_donante` (`detalle_alimento_id`, `donante_id`, `cantidad`) VALUES
(7, 4, 10),
(8, 3, 15),
(9, 5, 45),
(12, 7, 50),
(13, 3, 9),
(14, 3, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento_entrega_directa`
--

CREATE TABLE IF NOT EXISTS `alimento_entrega_directa` (
  `entrega_directa_id` int(11) NOT NULL,
  `detalle_alimento_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  KEY `entrega_directa_id` (`entrega_directa_id`,`detalle_alimento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimento_entrega_directa`
--

INSERT INTO `alimento_entrega_directa` (`entrega_directa_id`, `detalle_alimento_id`, `cantidad`) VALUES
(1, 7, 4),
(1, 10, 10),
(1, 11, 3),
(1, 12, 5),
(2, 8, 3),
(5, 8, 1),
(6, 8, 1),
(7, 16, 5),
(8, 7, 1),
(8, 14, 1),
(9, 8, 10),
(10, 8, 30),
(11, 17, 17),
(12, 16, 14),
(13, 21, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento_pedido`
--

CREATE TABLE IF NOT EXISTS `alimento_pedido` (
  `pedido_numero` int(11) NOT NULL,
  `detalle_alimento_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  KEY `pedido_numero` (`pedido_numero`,`detalle_alimento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimento_pedido`
--

INSERT INTO `alimento_pedido` (`pedido_numero`, `detalle_alimento_id`, `cantidad`) VALUES
(1, 4, 1),
(22, 15, 3),
(23, 15, 1),
(25, 16, 1),
(22, 8, 3),
(22, 7, 3),
(23, 9, 1),
(24, 15, 13),
(24, 9, 3),
(24, 17, 3),
(25, 20, 5),
(25, 19, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(50) NOT NULL,
  `valor` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `clave`, `valor`) VALUES
(1, 'limiteDias', '30'),
(2, 'latitud', '-34.909450'),
(3, 'longitud', '-57.913609'),
(4, 'clave_api', '77knoenb9s88fz'),
(5, 'clave_secreta', 'KJIJucZ56Y5YKDSl'),
(6, 'credencial_oauth', 'c6201594-b459-4b3f-b55c-6314a80c6e0f'),
(7, 'secreto_oauth', 'e2caba90-3ce8-4918-94c8-78bb6498711c');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_alimento`
--

CREATE TABLE IF NOT EXISTS `detalle_alimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alimento_codigo` varchar(10) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `contenido` varchar(200) NOT NULL,
  `peso_paquete` double(6,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `reservado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alimento_codigo` (`alimento_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `detalle_alimento`
--

INSERT INTO `detalle_alimento` (`id`, `alimento_codigo`, `fecha_vencimiento`, `contenido`, `peso_paquete`, `stock`, `reservado`) VALUES
(7, '4', '2014-11-19', '10 racimos ', 3.00, 0, 13),
(8, '5', '2014-11-23', '3 paq. de 2Kgssss!!', 6.00, 0, 61),
(9, '2', '2014-10-26', ' 20paq. de 500gr', 10.00, 6, 13),
(10, '6', '2014-11-17', ' 20x500gb', 1.00, 74, 11),
(11, '7', '2014-11-14', '3 paq. de 15gr. ', 2.00, 83, 5),
(12, '7', '2014-11-15', '30 paq. de 100gr', 3.00, 5, 3),
(13, '3', '2014-09-14', ' 10x19lt', 10.00, 29, 1),
(14, '8', '2014-11-19', 'asdasdasd', 1.00, 2, 1),
(15, '1', '2014-12-10', 'molino ala x 1Kg', 15.00, 0, 15),
(16, '9', '2014-11-29', 'Malva Blancos', 2.00, 0, 1),
(17, '9', '2014-12-10', 'Mila de pollo (unidad)', 20.00, 0, 3),
(18, '10', '2015-12-30', 'Lata de 360gm - Marolio', 0.36, 10, 0),
(19, '11', '2014-12-31', 'Orma de queso "Vacalín"', 4.00, 4, 1),
(20, '6', '2015-07-23', 'Tirabuzón "Marolio"', 0.50, 15, 5),
(21, '12', '2014-12-15', 'Fargo Rodajas Finas', 0.35, 15, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donante`
--

CREATE TABLE IF NOT EXISTS `donante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(100) NOT NULL,
  `apellido_contacto` varchar(50) NOT NULL,
  `nombre_contacto` varchar(50) NOT NULL,
  `telefono_contacto` varchar(30) NOT NULL,
  `mail_contacto` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `donante`
--

INSERT INTO `donante` (`id`, `razon_social`, `apellido_contacto`, `nombre_contacto`, `telefono_contacto`, `mail_contacto`) VALUES
(3, 'Alimentaria La Plata S.R.L.', 'Ramirez', 'Javier', '+542214654578', 'javier@ramirez.com'),
(4, 'Supermercado El Nene', 'Rosales', 'Roberto', '+542214652344', 'rober@rosa.com'),
(5, 'Mantecol S.A.', 'Switch', 'Julia', '+542214650000', 'juli@gmail.com'),
(7, 'McDonals', 'Donal', 'Miguel', '+5422123423578', 'info@mcdonal.com'),
(12, 'Sol Poniente', 'Gonzales', 'Hernestina', '+542216547898', 'hernestina@hotmail.com'),
(13, 'Molino Campodónico', 'Rossi', 'Guillermo', '+542214230000', 'info@molino.com.ar'),
(14, 'Hileret', 'Villa', 'Clodomiro', '+542214231953', 'info@hileret.com.ar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad_receptora`
--

CREATE TABLE IF NOT EXISTS `entidad_receptora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(100) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `domicilio` varchar(200) NOT NULL,
  `estado_entidad_id` int(11) NOT NULL,
  `necesidad_entidad_id` int(11) NOT NULL,
  `servicio_prestado_id` int(11) NOT NULL,
  `latitud` varchar(15) NOT NULL,
  `longitud` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `estado_entidad_id` (`estado_entidad_id`,`necesidad_entidad_id`,`servicio_prestado_id`),
  KEY `estado_entidad_id_2` (`estado_entidad_id`),
  KEY `necesidad_entidad_id` (`necesidad_entidad_id`),
  KEY `servicio_prestado_id` (`servicio_prestado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `entidad_receptora`
--

INSERT INTO `entidad_receptora` (`id`, `razon_social`, `telefono`, `domicilio`, `estado_entidad_id`, `necesidad_entidad_id`, `servicio_prestado_id`, `latitud`, `longitud`) VALUES
(1, 'Escuela 501', '(02227) 439675', 'Alem 222', 1, 1, 1, '-35.183360', '-59.092977'),
(4, 'Jardin La Cigarra', '4307582', 'Peralta Ramos 233', 1, 1, 1, '-34.901850', '-57.980608'),
(5, 'Serenisima', '4307582', 'Calle 23 y 32', 1, 1, 1, '-34.886491', '-57.960346'),
(6, 'Autos S.A', '4592-0909', '99tgsdtgwer', 2, 1, 4, '-34.925243', '-57.947109'),
(7, 'El Futuro S.A.', '+542215456878', 'Domicilio x', 1, 3, 2, '-34.999464', '-58.042683'),
(8, 'Matrices de Pan', '0221 554-5687', 'Avellaneda 1320', 1, 1, 1, '-34.916319', '57.989031');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega_directa`
--

CREATE TABLE IF NOT EXISTS `entrega_directa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entidad_receptora_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `entidad_receptora_id` (`entidad_receptora_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `entrega_directa`
--

INSERT INTO `entrega_directa` (`id`, `entidad_receptora_id`, `fecha`) VALUES
(1, 5, '2014-11-09'),
(2, 8, '2014-11-09'),
(3, 4, '2014-11-19'),
(5, 4, '2014-11-10'),
(6, 4, '2014-11-06'),
(7, 4, '2014-11-09'),
(8, 1, '2014-11-10'),
(9, 4, '2014-11-21'),
(10, 1, '2014-11-21'),
(11, 4, '2014-11-26'),
(12, 8, '2014-11-26'),
(13, 7, '2014-12-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_entidad`
--

CREATE TABLE IF NOT EXISTS `estado_entidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `estado_entidad`
--

INSERT INTO `estado_entidad` (`id`, `descripcion`) VALUES
(1, 'Alta'),
(2, 'En tramite'),
(3, 'Suspendida'),
(4, 'Baja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pedido`
--

CREATE TABLE IF NOT EXISTS `estado_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `estado_pedido`
--

INSERT INTO `estado_pedido` (`id`, `descripcion`) VALUES
(1, 'Nuevo'),
(2, 'En Espera'),
(3, 'En Proceso'),
(4, 'Entregado'),
(5, 'Cancelado'),
(6, 'Imposible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `necesidad_entidad`
--

CREATE TABLE IF NOT EXISTS `necesidad_entidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `necesidad_entidad`
--

INSERT INTO `necesidad_entidad` (`id`, `descripcion`) VALUES
(1, 'Maxima'),
(2, 'Mediana'),
(3, 'Minima');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_modelo`
--

CREATE TABLE IF NOT EXISTS `pedido_modelo` (
  `numero` int(11) NOT NULL AUTO_INCREMENT,
  `entidad_receptora_id` int(11) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `estado_pedido_id` int(11) NOT NULL,
  `turno_entrega_id` int(11) NOT NULL,
  `con_envio` tinyint(1) NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Volcado de datos para la tabla `pedido_modelo`
--

INSERT INTO `pedido_modelo` (`numero`, `entidad_receptora_id`, `fecha_ingreso`, `estado_pedido_id`, `turno_entrega_id`, `con_envio`) VALUES
(22, 1, '2014-11-15', 3, 28, 1),
(23, 1, '2014-11-20', 5, 29, 1),
(24, 7, '2014-11-26', 1, 33, 1),
(25, 1, '2014-11-26', 2, 34, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id del rol',
  `nombreRol` varchar(20) NOT NULL COMMENT 'nombre del rol',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombreRol`) VALUES
(1, 'administrador'),
(2, 'gestion'),
(3, 'consulta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_prestado`
--

CREATE TABLE IF NOT EXISTS `servicio_prestado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `servicio_prestado`
--

INSERT INTO `servicio_prestado` (`id`, `descripcion`) VALUES
(1, 'Comedor infantil'),
(2, 'Hogar de dia'),
(3, 'Hogar de adolescentes'),
(4, 'Jardin maternal'),
(5, 'Comedor Universitario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shadow`
--

CREATE TABLE IF NOT EXISTS `shadow` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id de usuario',
  `nombre` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_rol` int(11) NOT NULL COMMENT 'id rol usuario',
  `pass` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='usuarios del sistema' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `shadow`
--

INSERT INTO `shadow` (`id`, `nombre`, `id_rol`, `pass`) VALUES
(1, 'admin', 1, 'admin'),
(2, 'consulta', 3, 'consulta'),
(3, 'gestion', 2, 'gestion'),
(4, 'mag', 3, '12345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno_entrega`
--

CREATE TABLE IF NOT EXISTS `turno_entrega` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Volcado de datos para la tabla `turno_entrega`
--

INSERT INTO `turno_entrega` (`id`, `fecha`, `hora`) VALUES
(1, '2014-10-28', '00:00:00'),
(2, '2014-10-30', '00:00:00'),
(3, '2014-10-29', '08:00:00'),
(4, '2018-10-25', '00:55:00'),
(5, '2014-10-31', '00:00:00'),
(6, '2014-10-16', '12:59:00'),
(7, '2014-11-13', '12:00:00'),
(8, '2014-10-29', '08:00:00'),
(9, '2014-10-29', '12:59:00'),
(10, '2014-12-26', '12:59:00'),
(11, '2015-04-17', '12:59:00'),
(12, '2014-12-10', '12:59:00'),
(13, '2014-11-29', '12:59:00'),
(14, '2015-01-15', '12:59:00'),
(15, '2014-11-22', '13:00:00'),
(16, '2014-12-20', '12:59:00'),
(17, '2014-11-20', '12:59:00'),
(18, '2014-11-12', '19:48:00'),
(19, '2014-11-10', '19:34:00'),
(20, '2014-11-12', '20:20:00'),
(21, '2014-11-12', '20:20:00'),
(22, '2014-11-27', '20:23:00'),
(23, '2014-11-28', '20:23:00'),
(24, '2014-11-25', '20:25:00'),
(25, '2014-11-11', '19:24:00'),
(26, '2014-11-10', '19:34:00'),
(27, '2014-11-10', '22:00:00'),
(28, '2014-11-15', '11:28:00'),
(29, '2014-11-30', '19:51:00'),
(30, '2014-11-11', '20:22:00'),
(31, '2014-11-26', '20:24:00'),
(32, '2014-11-04', '20:26:00'),
(33, '2014-11-29', '08:42:00'),
(34, '2014-11-28', '09:00:00');
