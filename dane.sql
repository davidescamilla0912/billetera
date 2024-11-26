--- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2024 a las 23:25:04
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Base de datos: `dane`

-- --------------------------------------------------------

-- Estructura de la tabla `usuario`
CREATE TABLE `usuario` (
  `Id_Usuario` varchar(255) NOT NULL,
  `Identificacion` varchar(255) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Telefono` varchar(255) NOT NULL,
  `Fecha_registro` datetime NOT NULL,
  `Saldo` double NOT NULL,
  PRIMARY KEY (`Id_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuario` (`Id_Usuario`, `Identificacion`, `Nombre`, `Email`, `Telefono`, `Fecha_registro`, `Saldo`) 
VALUES 
('U001', '123456789', 'Juan Pérez', 'juan.perez@example.com', '5551234567', NOW(), 1500.00);


-- --------------------------------------------------------

-- Estructura de la tabla `cuenta`
CREATE TABLE `cuenta` (
  `Id_Cuenta` varchar(255) NOT NULL,
  `Saldo` DECIMAL(10, 2) NOT NULL,
  `Id_Usuario` varchar(255) NOT NULL,
  PRIMARY KEY (`Id_Cuenta`),
  FOREIGN KEY (`Id_Usuario`) REFERENCES `usuario` (`Id_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `cuenta` (`Id_Cuenta`, `Saldo`, `Id_Usuario`) 
VALUES 
('C001', 1000.00, 'U001');

-- --------------------------------------------------------

-- Estructura de la tabla `transaccion`
CREATE TABLE `transaccion` (
  `Id_Transaccion` varchar(255) NOT NULL,
  `id_Cuenta_Origen` varchar(255) NOT NULL,
  `Id_Cuenta_Destino` varchar(255) NOT NULL,
  `Monto` DECIMAL(10, 2) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Tipo_Transaccion` enum('Deposito', 'Retiro', 'Transferencia', 'PagoServicio', 'RecargaMovil') NOT NULL,
  `Estado` enum('Pendiente', 'Completada', 'Fallida', 'Revertida') NOT NULL,
  `Descripcion` text NOT NULL,
  `Servicios` enum('Luz', 'Agua', 'Gas', 'Telefonía', 'Internet', 'TV', 'Otros') NOT NULL,
  PRIMARY KEY (`Id_Transaccion`),
  CONSTRAINT `fk_cuenta_origen` FOREIGN KEY (`id_Cuenta_Origen`) REFERENCES `cuenta` (`Id_Cuenta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_cuenta_destino` FOREIGN KEY (`Id_Cuenta_Destino`) REFERENCES `cuenta` (`Id_Cuenta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `transaccion` 
(`Id_Transaccion`, `id_Cuenta_Origen`, `Id_Cuenta_Destino`, `Monto`, `Fecha`, `Tipo_Transaccion`, `Estado`, `Descripcion`, `Servicios`) 
VALUES 
('T001', 'C001', 'C002', 200.00, NOW(), 'Transferencia', 'Completada', 'Transferencia entre cuentas', 'Otros');


-- --------------------------------------------------------

-- Índices para las tablas volcadas

-- Índices para la tabla `usuario`
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id_Usuario`);

-- Índices para la tabla `cuenta`
ALTER TABLE `cuenta`
  ADD KEY `idx_usuario` (`Id_Usuario`);

-- Índices para la tabla `transaccion`
ALTER TABLE `transaccion`
  ADD KEY `idx_cuenta_origen` (`id_Cuenta_Origen`),
  ADD KEY `idx_cuenta_destino` (`Id_Cuenta_Destino`);

-- --------------------------------------------------------

-- Restricciones para las tablas volcadas

-- Claves foráneas para la tabla `transaccion`
ALTER TABLE `transaccion`
  ADD CONSTRAINT `fk_cuenta_origen` FOREIGN KEY (`id_Cuenta_Origen`) REFERENCES `cuenta` (`Id_Cuenta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cuenta_destino` FOREIGN KEY (`Id_Cuenta_Destino`) REFERENCES `cuenta` (`Id_Cuenta`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Claves foráneas para la tabla `cuenta`
ALTER TABLE `cuenta`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuario` (`Id_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

