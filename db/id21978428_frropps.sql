-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 19, 2024 at 08:32 PM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id21978428_frropps`
--

-- --------------------------------------------------------

--
-- Table structure for table `career`
--

CREATE TABLE `career` (
  `career_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `career`
--

INSERT INTO `career` (`career_id`, `name`, `deleted`) VALUES
(1, 'Ingeniería Mecánica', 0),
(2, 'Ingeniería en Sistemas', 0),
(3, 'Ingeniería Eléctrica', 0),
(4, 'Ingeniería Química', 0),
(5, 'Ingeniería Civil', 0),
(6, 'XX', 0);

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `document_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pendiente',
  `correction` text DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `spp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`document_id`, `path`, `status`, `correction`, `type`, `deleted`, `spp_id`) VALUES
(1, '1_Plan de trabajo.pdf', 'Aprobado', 'adecuado', 'Plan de trabajo', 0, 1),
(2, '1_Informe semanal_1.pdf', 'Aprobado', NULL, 'Informe semanal', 0, 1),
(3, '1_Informe semanal_2.pdf', 'Aprobado', NULL, 'Informe semanal', 0, 1),
(4, '1_Informe semanal_3.pdf', 'Aprobado', NULL, 'Informe semanal', 0, 1),
(5, '1_Informe semanal_4.pdf', 'Aprobado', NULL, 'Informe semanal', 0, 1),
(6, '1_Informe semanal_5.pdf', 'Aprobado', NULL, 'Informe semanal', 0, 1),
(7, '1_Informe semanal_6.pdf', 'Aprobado', NULL, 'Informe semanal', 0, 1),
(8, '1_Informe final.pdf', 'Aprobado', NULL, 'Informe final', 0, 1),
(12, '12_Plan de trabajo.pdf', 'Aprobado', 'esta bien', 'Plan de trabajo', 0, 12),
(14, '14_Plan de trabajo.pdf', 'Pendiente', 'Modificar plan', 'Plan de trabajo', 0, 14),
(15, '14_Plan de trabajo.pdf', 'Aprobado', NULL, 'Plan de trabajo', 0, 14);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'No leída',
  `message` text NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `sender_id`, `receiver_id`, `timestamp`, `status`, `message`, `deleted`) VALUES
(1, 1, 3, '2024-09-03 00:02:00', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 1', 0),
(2, 1, 3, '2024-09-03 00:05:28', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 2', 0),
(3, 1, 3, '2024-09-03 00:30:13', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 3', 0),
(4, 1, 3, '2024-09-03 00:31:10', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 4', 0),
(5, 1, 3, '2024-09-03 00:32:05', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 5', 0),
(6, 1, 3, '2024-09-03 00:37:02', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 6', 0),
(7, 1, 3, '2024-09-03 00:38:24', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 7', 0),
(8, 1, 3, '2024-09-03 00:40:32', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 8', 0),
(9, 1, 3, '2024-09-03 00:41:32', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 9', 0),
(10, 1, 3, '2024-09-03 00:42:28', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 10', 0),
(15, 1, 7, '2024-09-03 01:03:06', 'No leída', 'Se te ha asignado como profesor de una PPS', 0),
(16, 1, 12, '2024-09-03 01:03:06', 'No leída', 'Se te ha asignado un profesor para tu PPS', 0),
(17, 1, 7, '2024-09-03 01:04:41', 'No leída', 'Se te ha asignado como profesor de una PPS', 0),
(18, 1, 13, '2024-09-03 01:04:41', 'No leída', 'Se te ha asignado un profesor para tu PPS', 0),
(19, 1, 7, '2024-09-03 01:04:45', 'No leída', 'Se te ha asignado como profesor de una PPS', 0),
(20, 1, 14, '2024-09-03 01:04:45', 'No leída', 'Se te ha asignado un profesor para tu PPS', 0),
(21, 1, 7, '2024-09-03 01:04:48', 'No leída', 'Se te ha asignado como profesor de una PPS', 0),
(22, 1, 15, '2024-09-03 01:04:48', 'No leída', 'Se te ha asignado un profesor para tu PPS', 0),
(23, 1, 7, '2024-09-03 01:07:33', 'No leída', 'Se te ha asignado como profesor de una PPS', 0),
(24, 1, 16, '2024-09-03 01:07:33', 'No leída', 'Se te ha asignado un profesor para tu PPS', 0),
(25, 1, 7, '2024-09-03 01:07:36', 'No leída', 'Se te ha asignado como profesor de una PPS', 0),
(26, 1, 17, '2024-09-03 01:07:36', 'No leída', 'Se te ha asignado un profesor para tu PPS', 0),
(27, 1, 7, '2024-09-03 01:07:41', 'No leída', 'Se te ha asignado como profesor de una PPS', 0),
(28, 1, 18, '2024-09-03 01:07:41', 'No leída', 'Se te ha asignado un profesor para tu PPS', 0),
(29, 1, 7, '2024-09-03 01:07:44', 'No leída', 'Se te ha asignado como profesor de una PPS', 0),
(30, 1, 19, '2024-09-03 01:07:44', 'No leída', 'Se te ha asignado un profesor para tu PPS', 0),
(31, 1, 7, '2024-09-03 01:07:48', 'Leída', 'Se te ha asignado como profesor de una PPS', 0),
(32, 1, 20, '2024-09-03 01:07:48', 'No leída', 'Se te ha asignado un profesor para tu PPS', 0),
(33, 3, 12, '2024-09-03 01:24:45', 'No leída', 'El documento de tipo \'Plan de trabajo\' asociado a tu PPS con número de identificación 1 fue aprobado', 0),
(34, 3, 12, '2024-09-03 01:24:53', 'No leída', 'El documento de tipo \'Informe semanal\' asociado a tu PPS con número de identificación 1 fue aprobado', 0),
(35, 3, 12, '2024-09-03 01:24:56', 'No leída', 'El documento de tipo \'Informe semanal\' asociado a tu PPS con número de identificación 1 fue aprobado', 0),
(36, 3, 12, '2024-09-03 01:24:58', 'No leída', 'El documento de tipo \'Informe semanal\' asociado a tu PPS con número de identificación 1 fue aprobado', 0),
(37, 3, 12, '2024-09-03 01:25:00', 'No leída', 'El documento de tipo \'Informe semanal\' asociado a tu PPS con número de identificación 1 fue aprobado', 0),
(38, 3, 12, '2024-09-03 01:25:02', 'No leída', 'El documento de tipo \'Informe semanal\' asociado a tu PPS con número de identificación 1 fue aprobado', 0),
(39, 3, 12, '2024-09-03 01:25:05', 'No leída', 'El documento de tipo \'Informe semanal\' asociado a tu PPS con número de identificación 1 fue aprobado', 0),
(40, 3, 12, '2024-09-03 01:25:07', 'No leída', 'El documento de tipo \'Informe final\' asociado a tu PPS con número de identificación 1 fue aprobado', 0),
(41, 1, 12, '2024-09-03 01:25:21', 'No leída', 'El estado de tu PPS ha sido actualizado a Pendiente de Aprobación', 0),
(42, 1, 3, '2024-09-03 01:25:21', 'Leída', 'Se ha marcado la PPS 1 como Pendiente de Aprobación', 0),
(43, 1, 12, '2024-09-03 01:25:51', 'No leída', 'El estado de tu PPS ha sido actualizado a Aprobada', 0),
(44, 1, 7, '2024-09-03 01:25:51', 'Leída', 'Se ha marcado la PPS 1 como Aprobada', 0),
(45, 1, 3, '2024-09-03 21:58:20', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 11', 0),
(46, 1, 32, '2024-09-03 21:59:10', 'No leída', 'Se te ha asignado como profesor de una PPS', 0),
(51, 1, 3, '2024-09-03 22:03:49', 'Leída', 'Se ha marcado la PPS 11 como Pendiente de Aprobación', 0),
(53, 1, 32, '2024-09-03 22:04:10', 'No leída', 'Se ha marcado la PPS 11 como Aprobada', 0),
(56, 3, 12, '2024-09-09 22:36:55', 'No leída', 'Se ha agregado una corrección al documento de tipo \'Plan de trabajo\' asociado a tu PPS con número de identificación 1', 0),
(57, 1, 13, '2024-09-09 22:37:43', 'No leída', 'El estado de tu PPS ha sido actualizado a Pendiente de Aprobación', 0),
(58, 1, 3, '2024-09-09 22:37:43', 'Leída', 'Se ha marcado la PPS 2 como Pendiente de Aprobación', 0),
(59, 1, 3, '2024-09-11 17:13:29', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 12', 1),
(60, 1, 32, '2024-09-11 17:18:19', 'No leída', 'Se te ha asignado como profesor de una PPS', 0),
(61, 1, 37, '2024-09-11 17:18:19', 'Leída', 'Se te ha asignado un profesor para tu PPS', 0),
(62, 3, 37, '2024-09-11 17:25:19', 'No leída', 'Se ha agregado una corrección al documento de tipo \'Plan de trabajo\' asociado a tu PPS con número de identificación 12', 0),
(63, 3, 37, '2024-09-11 17:25:21', 'No leída', 'Se ha agregado una corrección al documento de tipo \'Plan de trabajo\' asociado a tu PPS con número de identificación 12', 0),
(64, 3, 37, '2024-09-11 17:25:31', 'No leída', 'El documento de tipo \'Plan de trabajo\' asociado a tu PPS con número de identificación 12 fue aprobado', 0),
(65, 1, 37, '2024-09-11 17:27:30', 'No leída', 'El estado de tu PPS ha sido actualizado a Pendiente de Aprobación', 0),
(66, 1, 3, '2024-09-11 17:27:30', 'Leída', 'Se ha marcado la PPS 12 como Pendiente de Aprobación', 0),
(67, 1, 37, '2024-09-11 17:30:15', 'No leída', 'El estado de tu PPS ha sido actualizado a Aprobada', 0),
(68, 1, 32, '2024-09-11 17:30:15', 'No leída', 'Se ha marcado la PPS 12 como Aprobada', 0),
(69, 1, 3, '2024-09-17 21:03:13', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 13', 0),
(70, 1, 32, '2024-09-17 21:06:45', 'Leída', 'Se te ha asignado como profesor de una PPS', 0),
(75, 1, 3, '2024-09-17 21:11:07', 'Leída', 'Se ha marcado la PPS 13 como Pendiente de Aprobación', 0),
(77, 1, 32, '2024-09-17 21:12:15', 'No leída', 'Se ha marcado la PPS 13 como Aprobada', 0),
(78, 1, 3, '2024-09-18 11:26:20', 'Leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 14', 0),
(79, 1, 7, '2024-09-18 11:27:48', 'No leída', 'Se te ha asignado como profesor de una PPS', 0),
(80, 1, 40, '2024-09-18 11:27:48', 'Leída', 'Se te ha asignado un profesor para tu PPS', 0),
(81, 3, 40, '2024-09-18 11:30:59', 'No leída', 'Se ha agregado una corrección al documento de tipo \'Plan de trabajo\' asociado a tu PPS con número de identificación 14', 0),
(82, 3, 40, '2024-09-18 11:33:34', 'No leída', 'El documento de tipo \'Plan de trabajo\' asociado a tu PPS con número de identificación 14 fue aprobado', 0),
(83, 1, 40, '2024-09-18 11:33:50', 'No leída', 'El estado de tu PPS ha sido actualizado a Pendiente de Aprobación', 0),
(84, 1, 3, '2024-09-18 11:33:50', 'Leída', 'Se ha marcado la PPS 14 como Pendiente de Aprobación', 0),
(85, 1, 40, '2024-09-18 11:34:30', 'Leída', 'El estado de tu PPS ha sido actualizado a Aprobada', 0),
(86, 1, 7, '2024-09-18 11:34:30', 'No leída', 'Se ha marcado la PPS 14 como Aprobada', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `name`, `deleted`) VALUES
(1, 'Alumno', 0),
(2, 'Profesor', 0),
(3, 'Administrador', 0),
(4, 'Responsable', 0);

-- --------------------------------------------------------

--
-- Table structure for table `spp`
--

CREATE TABLE `spp` (
  `spp_id` int(11) NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `organization_email` varchar(255) NOT NULL,
  `organization_phone` varchar(255) NOT NULL,
  `organization_address` varchar(255) NOT NULL,
  `organization_city` varchar(255) NOT NULL,
  `organization_state` varchar(255) NOT NULL,
  `organization_zip` int(11) NOT NULL,
  `organization_contact` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `spp`
--

INSERT INTO `spp` (`spp_id`, `organization_name`, `organization_email`, `organization_phone`, `organization_address`, `organization_city`, `organization_state`, `organization_zip`, `organization_contact`, `start_date`, `end_date`, `status`, `deleted`) VALUES
(1, 'Globant', 'practicas@globant.com', '01141091700', 'Alvear 1670', 'Rosario', 'Santa Fe', 2000, 'John Doe', '2024-09-03', '2024-09-03', 'Aprobada', 0),
(2, 'Accenture', 'practicas@accenture.com', '03414478300', 'Madres Plaza 25 de Mayo 3020', 'Rosario', 'Santa Fe', 2000, 'Javier López', '2022-09-14', NULL, 'Pendiente de Aprobación', 0),
(3, 'IBM', 'practicas@ibm.com', '01141091600', 'Corrientes 345', 'Buenos Aires', 'Buenos Aires', 1003, 'Ana Pérez', '2024-09-03', NULL, 'En Curso', 0),
(4, 'Tata Consultancy Services', 'practicas@tcs.com', '01156781234', 'San Martín 1234', 'Buenos Aires', 'Buenos Aires', 1004, 'Carlos Ruiz', '2024-09-03', NULL, 'En Curso', 0),
(5, 'Microsoft', 'practicas@microsoft.com', '03414471234', 'Córdoba 987', 'Rosario', 'Santa Fe', 2000, 'Laura Gómez', '2024-09-03', NULL, 'En Curso', 0),
(6, 'Syloper', 'practicas@syloper.com', '03415278962', 'Lamadrid 470', 'Rosario', 'Santa Fe', 2000, 'Julián Butti', '2024-09-03', NULL, 'En Curso', 0),
(7, 'HP', 'practicas@hp.com', '01145094567', 'Belgrano 456', 'Córdoba', 'Córdoba', 5000, 'Martín Pérez', '2024-09-03', NULL, 'En Curso', 0),
(8, 'Oracle', 'practicas@oracle.com', '03414479876', 'Santa Fe 321', 'Rosario', 'Santa Fe', 2000, 'Gabriela Martínez', '2024-09-03', NULL, 'En Curso', 0),
(9, 'SAP', 'practicas@sap.com', '01146091234', 'Mitre 789', 'Buenos Aires', 'Buenos Aires', 1005, 'Marcos Herrera', '2024-09-03', NULL, 'En Curso', 0),
(10, 'Google', 'practicas@google.com', '03414560123', 'Rivadavia 2020', 'Rosario', 'Santa Fe', 2000, 'Nicolás Vázquez', '2024-09-03', NULL, 'Sin Asignar', 0),
(12, 'Entornos Gráficos', 'danyelisabet@gmail.com', '121313123121', 'Zeballos 1341', 'Rosario', 'Santa Fe', 2000, 'José ', '2024-09-11', '2024-09-11', 'Aprobada', 0),
(14, 'EG', 'danyelisabet@gmail.com', '03413654507', '3 de Febrero 665', 'Rosario', 'Santa Fe', 2000, 'José', '2024-09-18', '2024-09-18', 'Aprobada', 0);

-- --------------------------------------------------------

--
-- Table structure for table `spp_user`
--

CREATE TABLE `spp_user` (
  `spp_id` int(11) NOT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `mentor_id` int(11) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `spp_user`
--

INSERT INTO `spp_user` (`spp_id`, `supervisor_id`, `mentor_id`, `student_id`, `deleted`) VALUES
(1, 3, 7, 12, 0),
(2, 3, 7, 13, 0),
(3, 3, 7, 14, 0),
(4, 3, 7, 15, 0),
(5, 3, 7, 16, 0),
(6, 3, 7, 17, 0),
(7, 3, 7, 18, 0),
(8, 3, 7, 19, 0),
(9, 3, 7, 20, 0),
(10, NULL, NULL, 21, 0),
(12, 3, 32, 37, 0),
(14, 3, 7, 40, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT '../img/profiles/default.png',
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `career_id` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `name`, `photo`, `deleted`, `reset_token`, `reset_token_expires_at`, `career_id`, `role_id`) VALUES
(1, 'pps@frro.utn.edu.ar', '$2y$10$ToTS4VLkoAX3MM1sG1M3k.6PMA3KbpdyQuJZ0780B7AXwsZO3JFHG', 'PPS FRRo Admin', '../img/profiles/default.png', 0, NULL, NULL, 2, 3),
(2, 'responsable.mecanica@frro.utn.edu.ar', '$2y$10$Zr4nwMV0XmS2DVFtehI9T.vvVYmNzSqDI31HX10rdzhOyBeTAC.0K', 'Responsable Ingeniería Mecánica', '../img/profiles/default.png', 0, NULL, NULL, 1, 4),
(3, 'responsable.sistemas@frro.utn.edu.ar', '$2y$10$SAIz5YxqLPPA/KsuOwhv7eaCP2HI8fflnlzk.HUzoQmsbHaiaPupC', 'Responsable Ingeniería en Sistemas', '../img/profiles/default.png', 0, NULL, NULL, 2, 4),
(4, 'responsable.electrica@frro.utn.edu.ar', '$2y$10$YcdJjXCetTUet5isryqJJO/av8NU.cJ1b7tsMWJEhLUsCl7SDfEIu', 'Responsable Ingeniería Eléctrica', '../img/profiles/default.png', 0, NULL, NULL, 3, 4),
(5, 'responsable.quimica@frro.utn.edu.ar', '$2y$10$5TjL3XxcnyHlt5uNRX7K9uh6qg5OYfX9.a7RnSK.DPgiRjEW6uxoy', 'Responsable Ingeniería Química', '../img/profiles/default.png', 0, NULL, NULL, 4, 4),
(6, 'responsable.civil@frro.utn.edu.ar', '$2y$10$kb2sitKpNocuzqE2mCw.AeMiGEYoHypYyeqzRPyBdqLDbAgxIalTK', 'Responsable Ingeniería Civil', '../img/profiles/default.png', 0, NULL, NULL, 5, 4),
(7, 'profesor.sistemas@frro.utn.edu.ar', '$2y$10$00ThMhcwAX1L9uhxUUo6/.GeVS6ErdtumqYpGNiwmtK3N9VUrvIjO', 'Profesor Ingeniería en Sistemas', '../img/profiles/default.png', 0, NULL, NULL, 2, 2),
(8, 'profesor.mecanica@frro.utn.edu.ar', '$2y$10$387RZKP4SUA1qKfQHveQHuN9cC3hCKWTvv67xj/3pXNRyz2JjGcke', 'Profesor Ingeniería Mecánica', '../img/profiles/default.png', 0, NULL, NULL, 1, 2),
(9, 'profesor.electrica@frro.utn.edu.ar', '$2y$10$bQ2l.O2xwjF6JSErwyhLnu9HlH6gAD5aqW2LIkn36AEWWn/OzX/..', 'Profesor Ingeniería Eléctrica', '../img/profiles/default.png', 0, NULL, NULL, 3, 2),
(10, 'profesor.quimica@frro.utn.edu.ar', '$2y$10$Tsc66G17DGvujZS9IxM.3ukpbJZ7WV87DIqt5J5S46hfnXCzAw.oy', 'Profesor Ingeniería Química', '../img/profiles/default.png', 0, NULL, NULL, 4, 2),
(11, 'profesor.civil@frro.utn.edu.ar', '$2y$10$wgFsc/fwJlny64ahbF7kiuZZSqxOBGnwTFvpYcnEy.NJj2I2LpXwa', 'Profesor Ingeniería Civil', '../img/profiles/default.png', 0, NULL, NULL, 5, 2),
(12, 'alumno1.sistemas@frro.utn.edu.ar', '$2y$10$4eEIFx7WAuY0U7wlBTMGCOB/FTAxo4jr6cNS4ALrRiNVDp0r7DOdq', 'Alumno 1', '../img/profiles/default.png', 0, NULL, NULL, 2, 1),
(13, 'alumno2.sistemas@frro.utn.edu.ar', '$2y$10$iwFAqh07DFpxVsHDGNXwR.TTtDb52h6hRIpeAULnqJseaQiugkFsi', 'Alumno 2', '../img/profiles/default.png', 0, NULL, NULL, 2, 1),
(14, 'alumno3.sistemas@frro.utn.edu.ar', '$2y$10$5NUZPK5LC/1GnhN8fSxPJu4QoRVnO4YllKHGxZ504h8JPSHHY278a', 'Alumno 3', '../img/profiles/default.png', 0, NULL, NULL, 2, 1),
(15, 'alumno4.sistemas@frro.utn.edu.ar', '$2y$10$FjqZR72x47TA./VUKDgyo.6uAJdHCFtYSTyNWIUcBHd8EbeUzt16a', 'Alumno 4', '../img/profiles/default.png', 0, NULL, NULL, 2, 1),
(16, 'alumno5.sistemas@frro.utn.edu.ar', '$2y$10$cigtODCuVKWGKsFcM5c6Oef3NyK49yl3pwQTM/RXic2.r/K6yTDRi', 'Alumno 5', '../img/profiles/default.png', 0, NULL, NULL, 2, 1),
(17, 'alumno6.sistemas@frro.utn.edu.ar', '$2y$10$tIOiPqOvBUsBwbNmibIjoOOy.1tlkMeGAV9rghb82qBX/1lXjQ5vG', 'Alumno 6', '../img/profiles/default.png', 0, NULL, NULL, 2, 1),
(18, 'alumno7.sistemas@frro.utn.edu.ar', '$2y$10$MFPgFH0/MCFucIZiU38TV.L06tZ0LkvSlc1DAQsAIrBuMFXtzlisq', 'Alumno 7', '../img/profiles/default.png', 0, NULL, NULL, 2, 1),
(19, 'alumno8.sistemas@frro.utn.edu.ar', '$2y$10$.wNjOsGkSiLIFOYENJqeYuUJiQPP7z2x4ahKVZ07GjrcKCBgLuJRa', 'Alumno 8', '../img/profiles/default.png', 0, NULL, NULL, 2, 1),
(20, 'alumno9.sistemas@frro.utn.edu.ar', '$2y$10$l7niSo3m0MuyGPHJuCBvSuiozpvhETyP2w.cCDDYCn.aRPW1LfQ8m', 'Alumno 9', '../img/profiles/default.png', 0, NULL, NULL, 2, 1),
(21, 'alumno10.sistemas@frro.utn.edu.ar', '$2y$10$XQBJDvs9t5w2X8LShNMvG.GkDuq8o3VU9ohz2EDXb9CBiyV4.7PTm', 'Alumno 10', '../img/profiles/default.png', 0, NULL, NULL, 2, 1),
(22, 'alumno1.quimica@frro.utn.edu.ar', '$2y$10$OBtkIczuZGwowpC.udDj6OClNeONmxTLzKQTrfArrj1Y8NnT60R5C', 'Alumno 1', '../img/profiles/default.png', 0, NULL, NULL, 4, 1),
(23, 'alumno2.quimica@frro.utn.edu.ar', '$2y$10$IFTaMul3DqwqL.IzqgLDi.xSTdQEXYDZSHTaSzpQttSICwrQOJJ1S', 'Alumno 2', '../img/profiles/default.png', 0, NULL, NULL, 4, 1),
(24, 'alumno3.quimica@frro.utn.edu.ar', '$2y$10$wCsFt8zqTzJV187fIk8ururh5WlRZYSTD/nspjiALY8Ekqo00EoVS', 'Alumno 3', '../img/profiles/default.png', 0, NULL, NULL, 4, 1),
(25, 'alumno4.quimica@frro.utn.edu.ar', '$2y$10$AeGnYr0zT4v3sCyLWYWsyOC2S90Ya.R/Nt.2051ULPXKOiOOM5wm.', 'Alumno 4', '../img/profiles/default.png', 0, NULL, NULL, 4, 1),
(26, 'alumno5.quimica@frro.utn.edu.ar', '$2y$10$jvJAb07WBy0SGU5QlfsDGulOOBuK0VwAIpbvCJaifz6lEHCz7w0XK', 'Alumno 5', '../img/profiles/default.png', 0, NULL, NULL, 4, 1),
(27, 'alumno6.quimica@frro.utn.edu.ar', '$2y$10$GgqFi9.r86HRLWAPSrIL5OTvU7LB/a8AoMPX58t88OqyE61a3h3OK', 'Alumno 6', '../img/profiles/default.png', 0, NULL, NULL, 4, 1),
(28, 'alumno7.quimica@frro.utn.edu.ar', '$2y$10$6/28ZCYW0y2JMDG/XcfoaeZG0TqQailF37t5KmPRvoeGYd7/YbaJO', 'Alumno 7', '../img/profiles/default.png', 0, NULL, NULL, 4, 1),
(29, 'alumno8.quimica@frro.utn.edu.ar', '$2y$10$41zljm8HnHXrjadOTCipfe3K3Gz5SRSGWy9VohfzJjOSRhPrHTpVq', 'Alumno 8', '../img/profiles/default.png', 0, NULL, NULL, 4, 1),
(30, 'alumno9.quimica@frro.utn.edu.ar', '$2y$10$oRit2tgtnSXW0g9QvN6QluEjA2kbAJCE8YzvHSt1mptBqALY/X8Ru', 'Alumno 9', '../img/profiles/default.png', 0, NULL, NULL, 4, 1),
(31, 'alumno10.quimica@frro.utn.edu.ar', '$2y$10$ScFEBUmpvFxUffBMphyaueG.9dC.qdzdtPTSTjEM8QHqeIgH2d5Vm', 'Alumno 10', '../img/profiles/default.png', 0, NULL, NULL, 4, 1),
(32, 'profesor2.sistemas@frro.utn.edu.ar', '$2y$10$95UR7mCBfxwYPnKg08wA8u7Xoiva6W9EdkV1lWfO/n9nh3RO3dGH6', 'Profesor Ingeniería en Sistemas 2', '../img/profiles/default.png', 0, NULL, NULL, 2, 2),
(33, 'profesor2.quimica@frro.utn.edu.ar', '$2y$10$52gX1poL/W0jc5w2NJpiw.Q05zkLG59H8qyAkjhx7sOFSv89V7kou', 'Profesor Ingeniería Química 2', '../img/profiles/default.png', 0, NULL, NULL, 4, 2),
(35, 'danyelisabet@gmail.com', '$2y$10$vziwpwOlOBLJnhOVh3joe.tliH9KRaxlPQ8Jzv0wBhFa0Yr3xi3X.', 'Daniela Díaz', '../img/profiles/default.png', 0, NULL, NULL, 2, 1),
(36, 'danielisabet@gmail.com', '$2y$10$xyDe5nEQF6Hg7O7RyOt90.qr.B/jP4QZTQUhiN.jwmcHFSbZVl852', 'Daniela Díaz', '../img/profiles/default.png', 0, NULL, NULL, 2, 1),
(37, 'dediaz@iua.edu.ar', '$2y$10$H.1kT5bP/OwRa8HYl800je2HbVEJdAFL/aAXzY5MXkOuwL4OT7z.O', 'Daniela Elisabet', '../img/profiles/default.png', 0, NULL, NULL, 2, 1),
(38, 'daniela@gmail.com', '$2y$10$ccm/qwt68v7xryBLEeRBk.1s27.ry4IER14cjF76RXHkuo/W9OKsC', 'Daniela', '../img/profiles/default.png', 0, NULL, NULL, 1, 2),
(40, 'danielaeee@gmail.com', '$2y$10$vmWkBz5TRTg1j4kAOxxGiu3omjSDrwtMbNaFqtrDrKUldxPRcyfAy', 'Daniela Díaz', '../img/profiles/default.png', 0, NULL, NULL, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `career`
--
ALTER TABLE `career`
  ADD PRIMARY KEY (`career_id`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `spp_spp_id` (`spp_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`,`receiver_id`),
  ADD KEY `user_sender_id` (`sender_id`),
  ADD KEY `user_receiver_id` (`receiver_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `spp`
--
ALTER TABLE `spp`
  ADD PRIMARY KEY (`spp_id`);

--
-- Indexes for table `spp_user`
--
ALTER TABLE `spp_user`
  ADD PRIMARY KEY (`spp_id`,`student_id`) USING BTREE,
  ADD KEY `user_supervisor_id` (`supervisor_id`),
  ADD KEY `user_mentor_id` (`mentor_id`),
  ADD KEY `user_student_id` (`student_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `reset_token` (`reset_token`),
  ADD KEY `career_career_id` (`career_id`),
  ADD KEY `role_role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `career`
--
ALTER TABLE `career`
  MODIFY `career_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `spp`
--
ALTER TABLE `spp`
  MODIFY `spp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_spp_id_spp` FOREIGN KEY (`spp_id`) REFERENCES `spp` (`spp_id`) ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `user_receiver_id` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_sender_id` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `spp_user`
--
ALTER TABLE `spp_user`
  ADD CONSTRAINT `spp_spp_id` FOREIGN KEY (`spp_id`) REFERENCES `spp` (`spp_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_mentor_id` FOREIGN KEY (`mentor_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_student_id` FOREIGN KEY (`student_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_supervisor_id` FOREIGN KEY (`supervisor_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `career_career_id` FOREIGN KEY (`career_id`) REFERENCES `career` (`career_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `role_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
