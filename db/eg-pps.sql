-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db:3306
-- Tiempo de generación: 12-03-2024 a las 00:56:21
-- Versión del servidor: 8.0.35
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eg-pps`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `career`
--

CREATE TABLE `career` (
  `career_id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `career`
--

INSERT INTO `career` (`career_id`, `name`) VALUES
(1, 'Ingeniería en Sistemas de Información');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `document`
--

CREATE TABLE `document` (
  `document_id` int NOT NULL,
  `path` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `correction` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `spp_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notification`
--

CREATE TABLE `notification` (
  `notification_id` int NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `role_id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `spp`
--

CREATE TABLE `spp` (
  `spp_id` int NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `spp_user`
--

CREATE TABLE `spp_user` (
  `spp_id` int NOT NULL,
  `supervisor_id` int NOT NULL,
  `mentor_id` int NOT NULL,
  `student_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL,
  `career_id` int NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `career`
--
ALTER TABLE `career`
  ADD PRIMARY KEY (`career_id`);

--
-- Indices de la tabla `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `document_spp_id_spp` (`spp_id`);

--
-- Indices de la tabla `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`,`sender_id`,`receiver_id`),
  ADD KEY `users_sender_id_notification` (`sender_id`),
  ADD KEY `users_receiver_id_notification` (`receiver_id`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indices de la tabla `spp`
--
ALTER TABLE `spp`
  ADD PRIMARY KEY (`spp_id`);

--
-- Indices de la tabla `spp_user`
--
ALTER TABLE `spp_user`
  ADD PRIMARY KEY (`spp_id`,`supervisor_id`,`mentor_id`,`student_id`),
  ADD KEY `spp_user_supervisor_id_users` (`supervisor_id`),
  ADD KEY `spp_user_mentor_id_users` (`mentor_id`),
  ADD KEY `spp_user_student_id_users` (`student_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `career_career_id_users` (`career_id`),
  ADD KEY `role_role_id_users` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `career`
--
ALTER TABLE `career`
  MODIFY `career_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `document`
--
ALTER TABLE `document`
  MODIFY `document_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `spp`
--
ALTER TABLE `spp`
  MODIFY `spp_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_spp_id_spp` FOREIGN KEY (`spp_id`) REFERENCES `spp` (`spp_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `users_receiver_id_notification` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `users_sender_id_notification` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `spp_user`
--
ALTER TABLE `spp_user`
  ADD CONSTRAINT `spp_user_mentor_id_users` FOREIGN KEY (`mentor_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `spp_user_spp_id_spp` FOREIGN KEY (`spp_id`) REFERENCES `spp` (`spp_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `spp_user_student_id_users` FOREIGN KEY (`student_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `spp_user_supervisor_id_users` FOREIGN KEY (`supervisor_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `career_career_id_users` FOREIGN KEY (`career_id`) REFERENCES `career` (`career_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `role_role_id_users` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
