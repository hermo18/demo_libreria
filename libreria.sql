-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-01-2025 a las 19:09:53
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
-- Base de datos: `libreria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `isbn`, `titulo`, `autor`) VALUES
(1, '9789513111465', 'Harry Potter and the Philosopher', 'J. K. Rowling'),
(2, '1611748860', 'The Lord of the Rings', 'J.R.R. Tolkien'),
(7, '3608960929', 'Farmer Giles of Ham', 'J.R.R. Tolkien'),
(8, '8374805552', 'The Well of Ascension', 'Brandon Sanderson'),
(9, '9783608955361', 'The fellowship of the ring', 'J.R.R. Tolkien'),
(10, '1429951664', 'Oathbringer', 'Brandon Sanderson'),
(11, '8485952316', 'La plaça del diamant', 'Mercè Rodoreda'),
(12, '1317235061', 'Teaching thinking', 'Robert J. Swartz'),
(13, '6070774248', 'Nosotros en la luna', 'Alice Kellen'),
(14, 'Sin ISBN', 'Encuentra tu persona vitamina', 'Marian Rojas Estapé'),
(16, '9781408855676', 'Harry Potter and the Prisoner of Azkaban', 'J. K. Rowling'),
(17, '0261103679', 'The Silmarillion', 'J.R.R. Tolkien');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
