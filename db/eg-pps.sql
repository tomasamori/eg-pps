-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Sep 03, 2024 at 12:23 AM
-- Server version: 8.0.39
-- PHP Version: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eg-pps`
--

-- --------------------------------------------------------

--
-- Table structure for table `career`
--

CREATE TABLE `career` (
  `career_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `career`
--

INSERT INTO `career` (`career_id`, `name`, `deleted`) VALUES
(1, 'Ingeniería Mecánica', 0),
(2, 'Ingeniería en Sistemas', 0),
(3, 'Ingeniería Eléctrica', 0),
(4, 'Ingeniería Química', 0),
(5, 'Ingeniería Civil', 0);

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `document_id` int NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'Pendiente',
  `correction` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `spp_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'No leída',
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `sender_id`, `receiver_id`, `timestamp`, `status`, `message`, `deleted`) VALUES
(1, 1, 3, '2024-09-03 00:02:00', 'No leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 1', 0),
(2, 1, 3, '2024-09-03 00:05:28', 'No leída', 'Se ha registrado una nueva solicitud de PPS con número de identificación 2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
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
  `spp_id` int NOT NULL,
  `organization_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `organization_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `organization_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `organization_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `organization_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `organization_state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `organization_zip` int NOT NULL,
  `organization_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `spp`
--

INSERT INTO `spp` (`spp_id`, `organization_name`, `organization_email`, `organization_phone`, `organization_address`, `organization_city`, `organization_state`, `organization_zip`, `organization_contact`, `start_date`, `end_date`, `status`, `deleted`) VALUES
(1, 'Globant', 'practicas@globant.com', '01141091700', 'Alvear 1670', 'Rosario', 'Santa Fe', 2000, 'John Doe', '2024-09-03', NULL, 'Sin Asignar', 0),
(2, 'Accenture', 'practicas@accenture.com', '03414478300', 'Madres Plaza 25 de Mayo 3020', 'Rosario', 'Santa Fe', 2000, 'Javier López', '2024-09-03', NULL, 'Sin Asignar', 0);

-- --------------------------------------------------------

--
-- Table structure for table `spp_user`
--

CREATE TABLE `spp_user` (
  `spp_id` int NOT NULL,
  `supervisor_id` int DEFAULT NULL,
  `mentor_id` int DEFAULT NULL,
  `student_id` int NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `spp_user`
--

INSERT INTO `spp_user` (`spp_id`, `supervisor_id`, `mentor_id`, `student_id`, `deleted`) VALUES
(1, NULL, NULL, 12, 0),
(2, NULL, NULL, 13, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT '../img/profiles/default.png',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `reset_token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `career_id` int DEFAULT NULL,
  `role_id` int NOT NULL
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
(7, 'profesor.sistemas@frro.utn.edu.ar', '$2y$10$tRNRhCVbnzuoyRqOVNRSS.ucnO6Biv2RjBEgC2MyJLP328QZqc4A2', 'Profesor Ingeniería en Sistemas', '../img/profiles/default.png', 0, NULL, NULL, 2, 2),
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
(33, 'profesor2.quimica@frro.utn.edu.ar', '$2y$10$52gX1poL/W0jc5w2NJpiw.Q05zkLG59H8qyAkjhx7sOFSv89V7kou', 'Profesor Ingeniería Química 2', '../img/profiles/default.png', 0, NULL, NULL, 4, 2);

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
  MODIFY `career_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `document_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `spp`
--
ALTER TABLE `spp`
  MODIFY `spp_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
