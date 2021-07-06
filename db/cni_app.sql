-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-07-2021 a las 21:43:39
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cni_app`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `idLibro` int(11) NOT NULL,
  `titulo` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `autor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `serie` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `categoria` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcion`
--

CREATE TABLE `recepcion` (
  `idRecepcion` int(11) NOT NULL,
  `asunto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tipoDocumento` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `archivo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Nuevo',
  `idSolicitante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `recepcion`
--

INSERT INTO `recepcion` (`idRecepcion`, `asunto`, `tipoDocumento`, `archivo`, `fecha`, `estado`, `idSolicitante`) VALUES
(1, 'Recuerdo', '1', '60e337cbdb890.pdf', '2021-07-05 11:48:11', 'Nuevo', 5),
(3, 'Asunto Test', '4', '60e3391303abd.pdf', '2021-07-05 11:53:39', 'Nuevo', 1),
(4, 'Carta de Presentacion', '3', '60e3450fb06d1.pdf', '2021-07-05 12:44:47', 'Nuevo', 2),
(5, 'Oficio', '2', '60e345abb48d6.pdf', '2021-07-05 12:47:23', 'Nuevo', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitante`
--

CREATE TABLE `solicitante` (
  `idSolicitante` int(11) NOT NULL,
  `dni` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `celular` varchar(9) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `solicitante`
--

INSERT INTO `solicitante` (`idSolicitante`, `dni`, `nombre`, `apellido`, `email`, `celular`) VALUES
(1, '96878585', 'Mario', 'Chumpitaz', 'mario.chumpitaz@gmail.com', '965487855'),
(2, '96868585', 'Rocio', 'Martinez', 'rocio.martinez@gmail.com', '965878578'),
(3, '90868585', 'Rocio', 'Martinez', 'rocio.martinez@gmail.com', '965878578'),
(4, '90868500', 'Marco', 'Quispe Navarro', 'marco.quispe@gmail.com', '965878578'),
(5, '36587542', 'Rocio', 'Martinez Guerra', 'rocio.martinez@gmail.com', '965878578');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_libro`
--

CREATE TABLE `solicitud_libro` (
  `idSolicitudLibro` int(11) NOT NULL,
  `tipoSolicitante` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `fechaRecojo` date NOT NULL,
  `fechaDevolucion` date NOT NULL,
  `idSolicitante` int(11) NOT NULL,
  `idLibro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `dni` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clave` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `privilegio` int(1) NOT NULL,
  `estado` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `dni`, `nombre`, `apellido`, `username`, `email`, `clave`, `privilegio`, `estado`) VALUES
(1, '73109572', 'Jhonny', 'Quispe Navarro', 'RedHunter', '', 'bTRKYUZSdHh5NTQvUTMwcVRjcjFNdz09', 1, 'Activo'),
(2, '96485785', 'Jhonny', 'Quispe Navarro', 'byredhunter', '', 'UFhzZmY5KzlWTitMUjc3RmVZcFp5dz09', 1, 'Activo'),
(3, '96585655', 'Luz', 'Sandoval Gutierrez', 'luzsandoval', '', 'TmJIb2F0SFNyS0pOWGN6eTNHS0lWZz09', 2, 'Activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`idLibro`);

--
-- Indices de la tabla `recepcion`
--
ALTER TABLE `recepcion`
  ADD PRIMARY KEY (`idRecepcion`),
  ADD KEY `fk_solicitante_recepcion` (`idSolicitante`);

--
-- Indices de la tabla `solicitante`
--
ALTER TABLE `solicitante`
  ADD PRIMARY KEY (`idSolicitante`);

--
-- Indices de la tabla `solicitud_libro`
--
ALTER TABLE `solicitud_libro`
  ADD PRIMARY KEY (`idSolicitudLibro`),
  ADD KEY `fk_solicitante_solicitudLibro` (`idSolicitante`),
  ADD KEY `fk_libro_solicitudLibro` (`idLibro`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `idLibro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recepcion`
--
ALTER TABLE `recepcion`
  MODIFY `idRecepcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `solicitante`
--
ALTER TABLE `solicitante`
  MODIFY `idSolicitante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `solicitud_libro`
--
ALTER TABLE `solicitud_libro`
  MODIFY `idSolicitudLibro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `recepcion`
--
ALTER TABLE `recepcion`
  ADD CONSTRAINT `fk_solicitante_recepcion` FOREIGN KEY (`idSolicitante`) REFERENCES `solicitante` (`idSolicitante`);

--
-- Filtros para la tabla `solicitud_libro`
--
ALTER TABLE `solicitud_libro`
  ADD CONSTRAINT `fk_libro_solicitudLibro` FOREIGN KEY (`idLibro`) REFERENCES `libro` (`idLibro`),
  ADD CONSTRAINT `fk_solicitante_solicitudLibro` FOREIGN KEY (`idSolicitante`) REFERENCES `solicitante` (`idSolicitante`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
