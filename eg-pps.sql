-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db:3306
-- Tiempo de generación: 24-03-2024 a las 16:26:57
-- Versión del servidor: 8.0.36
-- Versión de PHP: 8.2.16

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
  `name` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `career`
--

INSERT INTO `career` (`career_id`, `name`, `deleted`) VALUES
(1, 'Ingeniería Mecánica', 0),
(2, 'Ingeniería en Sistemas', 0),
(3, 'Ingeniería Eléctrica', 0),
(4, 'Ingeniería Química', 0),
(5, 'Ingeniería Civil', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `document`
--

CREATE TABLE `document` (
  `document_id` int NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `correction` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `spp_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notification`
--

CREATE TABLE `notification` (
  `notification_id` int NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `message` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `role_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`role_id`, `name`, `deleted`) VALUES
(1, 'Alumno', 0),
(2, 'Profesor', 0),
(3, 'Admin', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `spp`
--

CREATE TABLE `spp` (
  `spp_id` int NOT NULL,
  `organization_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `organization_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `organization_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `organization_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `organization_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `organization_state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `organization_zip` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `spp`
--

INSERT INTO `spp` (`spp_id`, `organization_name`, `organization_email`, `organization_phone`, `organization_address`, `organization_city`, `organization_state`, `organization_zip`, `start_date`, `end_date`, `status`, `deleted`) VALUES
(1, 'globant', 'contactus@globant.com.ar', '211222111', 'calle falsa 123', 'Rosario', 'something?', 2131, '2024-03-24', NULL, 'in course', 0),
(2, 'Accenture', 'contactus@accenture.com', '123456789', '123 Main St', 'New York', 'NY', 10001, '2024-04-01', NULL, 'in course', 0),
(3, 'IBM', 'contactus@ibm.com', '987654321', '456 Elm St', 'Los Angeles', 'CA', 90001, '2024-04-15', NULL, 'in course', 0),
(4, 'Microsoft', 'contactus@microsoft.com', '111222333', '789 Oak St', 'Chicago', 'IL', 60001, '2024-05-01', NULL, 'in course', 0),
(5, 'Google', 'contactus@google.com', '444555666', '321 Pine St', 'San Francisco', 'CA', 90002, '2024-05-15', NULL, 'in course', 0),
(6, 'Amazon', 'contactus@amazon.com', '777888999', '654 Birch St', 'Seattle', 'WA', 98101, '2024-06-01', NULL, 'in course', 0),
(7, 'Facebook', 'contactus@facebook.com', '999888777', '987 Cedar St', 'Austin', 'TX', 78701, '2024-06-15', NULL, 'in course', 0),
(8, 'Apple', 'contactus@apple.com', '333444555', '147 Walnut St', 'Cupertino', 'CA', 95014, '2024-07-01', NULL, 'in course', 0),
(9, 'Tesla', 'contactus@tesla.com', '666777888', '369 Maple St', 'Palo Alto', 'CA', 94301, '2024-07-15', NULL, 'in course', 0),
(10, 'Netflix', 'contactus@netflix.com', '222333444', '753 Oak St', 'Los Gatos', 'CA', 95030, '2024-08-01', NULL, 'in course', 0),
(11, 'Uber', 'contactus@uber.com', '888999000', '159 Elm St', 'San Francisco', 'CA', 94105, '2024-08-15', NULL, 'in course', 0),
(12, 'SpaceX', 'contactus@spacex.com', '000111222', '852 Pine St', 'Hawthorne', 'CA', 90250, '2024-09-01', NULL, 'in course', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `spp_user`
--

CREATE TABLE `spp_user` (
  `spp_id` int NOT NULL,
  `supervisor_id` int NOT NULL,
  `mentor_id` int NOT NULL,
  `student_id` int NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `spp_user`
--

INSERT INTO `spp_user` (`spp_id`, `supervisor_id`, `mentor_id`, `student_id`, `deleted`) VALUES
(1, 9, 4, 7, 0),
(2, 9, 4, 7, 0),
(3, 9, 4, 7, 0),
(4, 9, 4, 7, 0),
(5, 9, 4, 7, 0),
(6, 9, 4, 7, 0),
(7, 9, 4, 7, 0),
(8, 9, 4, 7, 0),
(9, 9, 4, 7, 0),
(10, 9, 4, 7, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `reset_token` varchar(64) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `career_id` int DEFAULT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `name`, `photo`, `deleted`, `reset_token`, `reset_token_expires_at`, `career_id`, `role_id`) VALUES
(3, 'anom117utn@gmail.com', '$2y$10$A7zRC53ezr4ZNkPWnAnOFuib39N7y44YlRY7yD2z.mbgji4Ta4Jzy', 'Santiago', NULL, 0, NULL, NULL, 1, 2),
(4, 'tomasamori@gmail.com', '$2y$10$1DObR9y8SAyVDdA2XFfLTu4Q5vh7Z57GwJest4xRQYaBFz78z2e0.', 'Tomás Amori', NULL, 0, NULL, NULL, 2, 2),
(5, 'matiasmayor@gmail.com', '$2y$10$2oGdaM9ytSzPgyn/W2atWe.wiRlZ/o8EreJDRJELFphyXqlOeuZWm', 'Matías Mayor', NULL, 0, NULL, NULL, 2, 2),
(6, 'manuelferrareto@gmail.com', '$2y$10$zv33sdTuMe31NeQZGCuJZuNAkUpy7euAMtk4.Q5NJ9XJRQvoCNHSu', 'Manuel Ferrareto', NULL, 0, NULL, NULL, 3, 2),
(7, 'santiagoatombolini@gmail.com', '$2y$10$ZFHO4eRLDq6Ftz0.dbNONO45o260uUlIKk7AZsLS5MiZw1mNL4gC2', 'Santiago Tombolini', NULL, 0, NULL, NULL, 2, 1),
(8, 'anom117utn@gmail.com', '$2y$10$f323D5jBY8u7WOiDPnRm4.y9uV.fpnhLeuXhODHJkXA2w09H18Ms2', 'Santiago', NULL, 0, NULL, NULL, 2, 1),
(9, 'picho.utn@gmail.com', '123456789', 'picho', NULL, 0, NULL, NULL, NULL, 3);

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
  ADD KEY `spp_spp_id` (`spp_id`);

--
-- Indices de la tabla `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`,`receiver_id`),
  ADD KEY `user_sender_id` (`sender_id`),
  ADD KEY `user_receiver_id` (`receiver_id`);

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
  ADD KEY `user_supervisor_id` (`supervisor_id`),
  ADD KEY `user_mentor_id` (`mentor_id`),
  ADD KEY `user_student_id` (`student_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `reset_token` (`reset_token`),
  ADD KEY `career_career_id` (`career_id`),
  ADD KEY `role_role_id` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `career`
--
ALTER TABLE `career`
  MODIFY `career_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `spp`
--
ALTER TABLE `spp`
  MODIFY `spp_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_spp_id_spp` FOREIGN KEY (`spp_id`) REFERENCES `spp` (`spp_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `user_receiver_id` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_sender_id` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `spp_user`
--
ALTER TABLE `spp_user`
  ADD CONSTRAINT `spp_spp_id` FOREIGN KEY (`spp_id`) REFERENCES `spp` (`spp_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_mentor_id` FOREIGN KEY (`mentor_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_student_id` FOREIGN KEY (`student_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_supervisor_id` FOREIGN KEY (`supervisor_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `career_career_id` FOREIGN KEY (`career_id`) REFERENCES `career` (`career_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `role_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
