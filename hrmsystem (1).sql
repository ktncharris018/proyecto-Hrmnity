-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2024 a las 03:42:02
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hrmsystem`
--
CREATE DATABASE IF NOT EXISTS `hrmsystem` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `hrmsystem`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidatos`
--

CREATE TABLE `candidatos` (
  `id_candidato` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `identificacion` varchar(50) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `estado` enum('preseleccionado','descartado','pendiente') NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `vacante_id` int(11) DEFAULT NULL,
  `portafolio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `candidatos`
--

INSERT INTO `candidatos` (`id_candidato`, `nombre`, `identificacion`, `contacto`, `estado`, `fecha_solicitud`, `vacante_id`, `portafolio`) VALUES
(1, 'Pedro López', '67890123', 'pedro.lopez@candidato.com', 'preseleccionado', '2024-08-01', 1, 'http://portafolio.pedro.com'),
(2, 'Sofia Ruiz', '78901234', 'sofia.ruiz@candidato.com', 'preseleccionado', '2024-08-05', 2, 'http://portafolio.sofia.com'),
(3, 'Ricardo Morales', '89012345', 'ricardo.morales@candidato.com', 'preseleccionado', '2024-08-10', 3, 'http://portafolio.ricardo.com'),
(4, 'Elena Gómez', '90123456', 'elena.gomez@candidato.com', 'preseleccionado', '2024-08-15', 4, 'http://portafolio.elena.com'),
(5, 'Juan Pérez', '01234567', 'juan.perez@candidato.com', 'preseleccionado', '2024-08-20', 5, 'http://portafolio.juan.com'),
(10, 'juan candidato', '1122334455', '3004567789', 'preseleccionado', '2024-10-04', 5, NULL),
(25, 'karla martinez mendoza', '5050404444', '3004652729', 'preseleccionado', '2024-10-03', 5, 'candidato_5050404444.pdf'),
(29, 'manuel candidato', '7777337700', '3000788499', 'preseleccionado', '2024-10-03', 3, NULL),
(30, 'candidato prueba now', '0303037777', '3008478339', 'preseleccionado', '2024-11-24', 24, 'candidato_0303037777.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `nombre`, `estado`) VALUES
(1, 'Recursos Humanos', 'activo'),
(2, 'Finanzas', 'activo'),
(3, 'Tecnología de la Información', 'activo'),
(4, 'Marketing', 'activo'),
(5, 'Operaciones-a1', 'activo'),
(9, 'Administrativo', 'activo'),
(12, 'psicologia', 'activo'),
(14, 'candidatos contratados', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `identificacion` varchar(50) NOT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `tipo_contrato` enum('independiente','indefinido','temporal','fijo') DEFAULT NULL,
  `supervisor` varchar(100) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `departamento_id` int(11) DEFAULT NULL,
  `foto_perfil` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `nombre`, `identificacion`, `contacto`, `tipo_contrato`, `supervisor`, `titulo`, `departamento_id`, `foto_perfil`) VALUES
(1, 'Ana Pérez', '12345678', 'anaPerez@empresa.com', 'indefinido', 'andrea', 'Gerente de HR', 1, 'empleado_12345678.jpg'),
(2, 'Luis Gómez', '23456789', 'luis.gomez@empresa.com', 'temporal', 'Ana Pérez', 'Analista de Finanzas', 2, 'default-user.png'),
(3, 'María Rodríguez', '34567890', 'maria.rodriguez@empresa.com', 'fijo', 'Ana Pérez', 'Desarrolladora', 3, 'default-user.png'),
(4, 'Carlos Fernández', '45678901', 'carlos.fernandez@empresa.com', 'independiente', 'Ana Pérez', 'Especialista en Marketing', 4, 'default-user.png'),
(5, 'Laura Martínez', '56789012', 'laura.martinez@empresa.com', 'indefinido', 'Ana Pérez', 'Coordinadora de Operaciones', 5, 'default-user.png'),
(84, 'luis g', '1223456789', 'luisG@empresa.com', 'temporal', 'andres', 'gestor', 5, 'default-user.png'),
(106, 'paola jara', '1111122222', 'paolaJara@empresa.com', 'indefinido', 'andrea g.', 'economista', 3, 'default-user.png'),
(143, 'manuel candidato', '7777337700', 'manuel@candidato.com', 'indefinido', 'Por definir', 'Por definir', 1, 'empleado_7777337700.png'),
(147, 'juan candidato', '1122334455', 'juan@empresa.com', 'temporal', 'karla', 'administrador', 14, NULL),
(148, 'karla martinez mendoza', '1100122222', 'karlaMartinez@empresa.com', 'temporal', 'andrea g.', 'administradora', 9, NULL),
(151, 'jimena gonzales', '0012385037', 'jimenaGonzales@empresa.com', 'indefinido', '', 'administradora', 14, NULL),
(152, 'Ricardo Morales', '89012345', 'ricardo.morales@candidato.com', 'temporal', 'Por definir', 'Por definir', 14, 'avatar-candidato.jpg'),
(153, 'Elena Gómez', '90123456', 'elena.gomez@candidato.com', 'temporal', 'andrea g.', 'Por definir', 14, NULL),
(159, 'Kristian Charris', '1066890123', 'cristiankstudios@gmail.com', 'independiente', 'ana perez', 'ingeniero de sistema', 3, 'empleado_1066890123.jpg'),
(161, 'empleado de prueba', '1111139393', 'empleado@gmail.com', 'temporal', 'ana perez', 'economista', 9, 'empleado_1111139393.jpg'),
(162, 'candidato prueba now', '0303037777', '3008478339', NULL, 'Por definir', 'Por definir', 14, 'avatar-candidato.jpg'),
(163, 'Pedro López', '67890123', 'pedro.lopez@candidato.com', NULL, 'Por definir', 'Por definir', 14, 'avatar-candidato.jpg'),
(164, 'jose roberto', '1111122777', 'jose@gmail.com', 'indefinido', 'kristian', 'gestor', 9, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrevistas`
--

CREATE TABLE `entrevistas` (
  `id_entrevista` int(11) NOT NULL,
  `candidato_id` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `soportes` varchar(255) DEFAULT NULL,
  `estado` enum('contratado','seleccionado','rechazado') NOT NULL,
  `observacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `entrevistas`
--

INSERT INTO `entrevistas` (`id_entrevista`, `candidato_id`, `fecha`, `soportes`, `estado`, `observacion`) VALUES
(1, 1, '2024-08-10', NULL, 'contratado', 'Buena presentación'),
(2, 2, '2024-08-12', NULL, 'seleccionado', 'Excelente perfil'),
(3, 3, '2024-08-15', NULL, 'contratado', 'Falta experiencia'),
(4, 4, '2024-08-18', NULL, 'contratado', 'Buen encaje cultural'),
(5, 5, '2024-08-22', 'http://soportes.juan.com', 'rechazado', 'No cumplió requisitos'),
(13, 10, '2024-10-07', NULL, 'contratado', 'Empleado con experiencia laboral en el area solicitada. Ademas educado y amable como persona'),
(15, 29, '2024-10-08', 'entrevista-manuel candidato.pdf', 'contratado', 'al cambiar el estado a \"contratado\" el candidato se convertira en empleado'),
(16, 30, '2024-11-26', NULL, 'contratado', 'pendiente para ser empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start` date NOT NULL,
  `end` date DEFAULT NULL,
  `className` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `title`, `start`, `end`, `className`) VALUES
(1, 'primer evento', '2024-10-07', NULL, 'bg-success'),
(2, 'segundo evento now', '2024-10-08', NULL, 'bg-succes'),
(3, 'tercer evento', '2024-10-09', NULL, 'bg-succes'),
(4, 'cuarto evento', '2024-10-10', NULL, 'bg-succes'),
(5, 'quinto evento', '2024-10-14', NULL, 'bg-succes'),
(6, 'sexto evento', '2024-10-15', NULL, 'event-warning'),
(7, 'septimo evento', '2024-10-16', NULL, 'event-warning'),
(8, 'octavo evento', '2024-10-17', NULL, 'event-danger'),
(11, 'Semana para presentar en expo software', '2024-11-21', NULL, 'event-warning'),
(12, 'Cumpleaños del desarrollador de hrmnity', '2024-11-18', NULL, 'event-warning'),
(14, 'parcial ecuaciones', '2024-11-28', NULL, 'event-info');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencias`
--

CREATE TABLE `licencias` (
  `id_licencia` int(11) NOT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `tipo` enum('maternal','paternal','personal','duelo','vacacional','otro') NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estado` enum('aprobada','rechazada','pendiente') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `licencias`
--

INSERT INTO `licencias` (`id_licencia`, `empleado_id`, `tipo`, `fecha_inicio`, `fecha_final`, `estado`) VALUES
(1, 1, 'vacacional', '2024-09-01', '2024-09-15', 'aprobada'),
(2, 2, 'paternal', '2024-09-10', '2024-09-20', 'rechazada'),
(3, 3, 'maternal', '2024-09-01', '2024-12-31', 'rechazada'),
(4, 4, 'paternal', '2024-07-10', '2024-08-20', 'aprobada'),
(5, 5, 'duelo', '2024-08-05', '2024-08-12', 'aprobada'),
(6, 84, 'otro', '2024-11-15', '2024-12-31', 'aprobada'),
(8, 106, 'vacacional', '2024-11-01', '2024-11-29', 'pendiente'),
(9, 162, 'otro', '2024-11-01', '2024-11-30', 'aprobada'),
(10, 161, 'vacacional', '2024-11-19', '2024-11-30', 'aprobada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nominas`
--

CREATE TABLE `nominas` (
  `id_nomina` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `fecha_anterior` date DEFAULT NULL,
  `fecha_proxima` date DEFAULT NULL,
  `estado` enum('pagado','pendiente','deuda') NOT NULL,
  `horas_extras_total` decimal(10,2) DEFAULT NULL,
  `deduccion_ausencia` decimal(10,2) DEFAULT NULL,
  `nomina_total` decimal(10,2) DEFAULT NULL,
  `salario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nominas`
--

INSERT INTO `nominas` (`id_nomina`, `empleado_id`, `fecha_anterior`, `fecha_proxima`, `estado`, `horas_extras_total`, `deduccion_ausencia`, `nomina_total`, `salario_id`) VALUES
(3, 84, '2024-10-25', '2024-11-25', 'pagado', '0.00', '300000.00', '1020000.00', 15),
(4, 148, '0000-00-00', '2024-10-25', 'pendiente', '50000.00', '106666.67', '1879333.33', 16),
(6, 106, '2024-10-25', '2024-11-25', 'pagado', '0.00', '266666.67', '1605333.33', 18),
(10, 161, '2024-11-25', '2024-12-25', 'pagado', '0.00', '0.00', '1688000.00', 23),
(11, 162, '2024-11-25', '2024-12-25', 'pagado', '50000.00', '0.00', '1354000.00', 24),
(12, 152, '2024-11-25', '2024-12-25', 'pagado', '0.00', '0.00', '1836000.00', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id_notificacion`, `titulo`, `descripcion`, `fecha`) VALUES
(1, 'Activacion', 'Se ha realizado la activacion de notificaciones para ciertos modulos en el sistema', '2024-11-10 12:42:19'),
(40, 'usuarios', 'Se ha modificado la contraseña del usuario con nombre: Ana Pérez', '2024-11-15 22:12:55'),
(42, 'usuarios', 'Se ha modificado la contraseña del usuario con nombre: Ana Pérez', '2024-11-15 22:28:46'),
(44, 'licencias', 'Se ha aprobado la licencia del empleado: empleado de prueba ', '2024-11-26 09:14:31'),
(45, 'nominas', 'Se ha pagado la nomina del empleado: Ricardo Morales ', '2024-11-28 10:23:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salarios`
--

CREATE TABLE `salarios` (
  `id_salario` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `salario_base` decimal(10,2) NOT NULL,
  `aux_transporte` decimal(10,2) DEFAULT NULL,
  `bonificacion` decimal(10,2) DEFAULT NULL,
  `deduccion_salud` decimal(10,2) DEFAULT NULL,
  `deduccion_pension` decimal(10,2) DEFAULT NULL,
  `salario_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `salarios`
--

INSERT INTO `salarios` (`id_salario`, `empleado_id`, `salario_base`, `aux_transporte`, `bonificacion`, `deduccion_salud`, `deduccion_pension`, `salario_total`) VALUES
(15, 84, '1000000.00', '200000.00', '200000.00', '40000.00', '40000.00', '1320000.00'),
(16, 148, '1600000.00', '200000.00', '200000.00', '64000.00', '0.00', '1936000.00'),
(18, 106, '1600000.00', '200000.00', '200000.00', '64000.00', '64000.00', '1872000.00'),
(23, 161, '1400000.00', '200000.00', '200000.00', '56000.00', '56000.00', '1688000.00'),
(24, 162, '1200000.00', '100000.00', '100000.00', '48000.00', '48000.00', '1304000.00'),
(25, 152, '1600000.00', '200000.00', '100000.00', '64000.00', '0.00', '1836000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `tipo_usuario` enum('administrador','otro') DEFAULT 'administrador',
  `foto_perfil` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `empleado_id`, `usuario`, `contraseña`, `estado`, `tipo_usuario`, `foto_perfil`) VALUES
(1, 1, 'aperezhrm', 'ana123', 'activo', 'administrador', 'empleado_12345678.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacante`
--

CREATE TABLE `vacante` (
  `id_vacante` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(400) DEFAULT NULL,
  `titulo_profesional` varchar(100) DEFAULT NULL,
  `activa` enum('si','no') NOT NULL,
  `encargado_id` int(11) DEFAULT NULL,
  `departamento_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `vacante`
--

INSERT INTO `vacante` (`id_vacante`, `nombre`, `descripcion`, `titulo_profesional`, `activa`, `encargado_id`, `departamento_id`) VALUES
(1, 'Vacante en Recursos Humanos', 'Buscamos un profesional para formar parte de nuestra empresa. Tiene que ser una persona proactiva y con experiencia a la hora de gestionar las tareas asignada, de comunicarse con los ejecutivos de la empresa y con otro personal en puestos de responsabilidad. ademas de ser honesto, buenas contumbres y respetuoso.', 'Gerente de Recursos Humanos', 'si', 1, 1),
(2, 'Vacante en Finanzas', 'Buscamos un profesional para formar parte de nuestra empresa. Tiene que ser una persona proactiva y con experiencia a la hora de gestionar las tareas asignada, de comunicarse con los ejecutivos de la ', 'Contador Senior', 'si', 2, 2),
(3, 'Vacante en Tecnología', 'Buscamos un profesional para formar parte de nuestra empresa. Tiene que ser una persona proactiva y con experiencia a la hora de gestionar las tareas asignada, de comunicarse con los ejecutivos de la ', 'Ingeniero de Software', 'si', 3, 3),
(4, 'Vacante en Marketing', 'Buscamos un profesional para formar parte de nuestra empresa. Tiene que ser una persona proactiva y con experiencia a la hora de gestionar las tareas asignada, de comunicarse con los ejecutivos de la ', 'Estratega Digital', 'no', 4, 4),
(5, 'Vacante en Operaciones', 'Buscamos un profesional para formar parte de nuestra empresa. Tiene que ser una persona proactiva y con experiencia a la hora de gestionar las tareas asignada, de comunicarse con los ejecutivos de la ', 'Especialista en Logística', 'si', 5, 5),
(24, 'psicologia cognitiva', 'Buscamos un profesional para formar parte de nuestra empresa. Tiene que ser una persona proactiva y con experiencia a la hora de gestionar las tareas asignada', 'psicologia licenciada', 'si', 106, 12);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `candidatos`
--
ALTER TABLE `candidatos`
  ADD PRIMARY KEY (`id_candidato`),
  ADD UNIQUE KEY `identificacion` (`identificacion`),
  ADD KEY `vacante_id` (`vacante_id`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `identificacion` (`identificacion`),
  ADD KEY `departamento_id` (`departamento_id`);

--
-- Indices de la tabla `entrevistas`
--
ALTER TABLE `entrevistas`
  ADD PRIMARY KEY (`id_entrevista`),
  ADD KEY `candidato_id` (`candidato_id`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `licencias`
--
ALTER TABLE `licencias`
  ADD PRIMARY KEY (`id_licencia`),
  ADD KEY `empleado_id` (`empleado_id`);

--
-- Indices de la tabla `nominas`
--
ALTER TABLE `nominas`
  ADD PRIMARY KEY (`id_nomina`),
  ADD KEY `empleado_id` (`empleado_id`),
  ADD KEY `fk_salario` (`salario_id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`);

--
-- Indices de la tabla `salarios`
--
ALTER TABLE `salarios`
  ADD PRIMARY KEY (`id_salario`),
  ADD UNIQUE KEY `empleado_id` (`empleado_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `empleado_id` (`empleado_id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `vacante`
--
ALTER TABLE `vacante`
  ADD PRIMARY KEY (`id_vacante`),
  ADD KEY `encargado_id` (`encargado_id`),
  ADD KEY `departamento_id` (`departamento_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `candidatos`
--
ALTER TABLE `candidatos`
  MODIFY `id_candidato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT de la tabla `entrevistas`
--
ALTER TABLE `entrevistas`
  MODIFY `id_entrevista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `licencias`
--
ALTER TABLE `licencias`
  MODIFY `id_licencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `nominas`
--
ALTER TABLE `nominas`
  MODIFY `id_nomina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `salarios`
--
ALTER TABLE `salarios`
  MODIFY `id_salario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `vacante`
--
ALTER TABLE `vacante`
  MODIFY `id_vacante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `candidatos`
--
ALTER TABLE `candidatos`
  ADD CONSTRAINT `candidatos_ibfk_1` FOREIGN KEY (`vacante_id`) REFERENCES `vacante` (`id_vacante`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`departamento_id`) REFERENCES `departamento` (`id_departamento`);

--
-- Filtros para la tabla `entrevistas`
--
ALTER TABLE `entrevistas`
  ADD CONSTRAINT `entrevistas_ibfk_1` FOREIGN KEY (`candidato_id`) REFERENCES `candidatos` (`id_candidato`);

--
-- Filtros para la tabla `licencias`
--
ALTER TABLE `licencias`
  ADD CONSTRAINT `licencias_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`id_empleado`);

--
-- Filtros para la tabla `nominas`
--
ALTER TABLE `nominas`
  ADD CONSTRAINT `fk_salario` FOREIGN KEY (`salario_id`) REFERENCES `salarios` (`id_salario`),
  ADD CONSTRAINT `nominas_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`id_empleado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `salarios`
--
ALTER TABLE `salarios`
  ADD CONSTRAINT `salarios_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`id_empleado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`id_empleado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vacante`
--
ALTER TABLE `vacante`
  ADD CONSTRAINT `vacante_ibfk_1` FOREIGN KEY (`encargado_id`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `vacante_ibfk_2` FOREIGN KEY (`departamento_id`) REFERENCES `departamento` (`id_departamento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
