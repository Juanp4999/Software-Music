-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-10-2024 a las 19:08:18
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `corosb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partituras`
--

CREATE TABLE `partituras` (
  `idPartituras` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Precio` decimal(3,0) NOT NULL,
  `Descripcion` varchar(300) NOT NULL,
  `Usuario_idUsuario` int(11) NOT NULL,
  `archivoPDF` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `partituras`
--

INSERT INTO `partituras` (`idPartituras`, `Nombre`, `Precio`, `Descripcion`, `Usuario_idUsuario`, `archivoPDF`) VALUES
(0, 'Ave Maria Shubert', 999, 'Canto a la Virgen', 1040034177, 'ave maria (6).pdf'),
(1, 'Ave Maria Caccini', 999, 'Canto a la Virgen', 1040034178, 'Caccini - Ave Maria.pdf'),
(2, 'Four Eliaa', 999, 'Musica Clasica', 1040045000, 'paraelisa.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `Descrip` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `Descrip`) VALUES
(0, '\"Compositores\"'),
(1, '\"Administrador\"');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Contrasenia` varchar(100) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Edad` varchar(100) NOT NULL,
  `Rol_idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `Correo`, `Contrasenia`, `Nombre`, `Apellido`, `Edad`, `Rol_idRol`) VALUES
(1040034177, 'juanpablopatinoarango80@gmail.com', '12345678', 'Juan Pablo', 'Patiño Arango', '18', 1),
(1040034178, 'juanmanuelpatino31@gmail.com', '12345678', 'Juan Manuel', 'Patiño Arango', '19', 0),
(1040044999, 'dany.yub@gmail.com', '12345678', 'Daniel Andres', 'Ramirez Toro', '30', 1),
(1040045000, 'samuramireztoro@gmail.com', '12345678', 'Samuel Alexander', 'Ramirez Toro', '30', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idVentas` int(11) NOT NULL,
  `Descripcion` varchar(300) NOT NULL,
  `Usuario_idUsuario` int(11) NOT NULL,
  `Partituras_idPartituras` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `partituras`
--
ALTER TABLE `partituras`
  ADD PRIMARY KEY (`idPartituras`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idVentas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
