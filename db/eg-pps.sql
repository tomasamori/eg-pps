-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Aug 27, 2024 at 10:25 PM
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
(1, 5, 11, '2024-08-22 18:42:48', 'Leída', 'Pelotudo de mierda', 0),
(2, 5, 11, '2024-08-22 18:45:32', 'Leída', 'Pelotudo de mierda', 0),
(3, 5, 11, '2024-08-22 18:45:42', 'Leída', 'Pelotudo de mierda', 1),
(4, 5, 11, '2024-08-22 18:46:10', 'Leída', 'Todo boludo sos', 1);

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
(3, 'Admin', 0);

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
(1, 'globant', 'contactus@globant.com.ar', '211222111', 'calle falsa 123', 'Rosario', 'something?', 2131, '', '2024-03-24', NULL, 'Finalizada', 0),
(2, 'Accenture', 'contactus@accenture.com', '123456789', '123 Main St', 'New York', 'NY', 10001, '', '2024-04-01', NULL, 'En curso', 0),
(3, 'IBM', 'contactus@ibm.com', '987654321', '456 Elm St', 'Los Angeles', 'CA', 90001, '', '2024-04-15', NULL, 'En curso', 0),
(4, 'Microsoft', 'contactus@microsoft.com', '111222333', '789 Oak St', 'Chicago', 'IL', 60001, '', '2024-05-01', NULL, 'En curso', 0),
(5, 'Google', 'contactus@google.com', '444555666', '321 Pine St', 'San Francisco', 'CA', 90002, '', '2024-05-15', NULL, 'En curso', 0),
(6, 'Amazon', 'contactus@amazon.com', '777888999', '654 Birch St', 'Seattle', 'WA', 98101, '', '2024-06-01', NULL, 'En curso', 0),
(7, 'Facebook', 'contactus@facebook.com', '999888777', '987 Cedar St', 'Austin', 'TX', 78701, '', '2024-06-15', NULL, 'En curso', 0),
(8, 'Apple', 'contactus@apple.com', '333444555', '147 Walnut St', 'Cupertino', 'CA', 95014, '', '2024-07-01', NULL, 'En curso', 0),
(9, 'Tesla', 'contactus@tesla.com', '666777888', '369 Maple St', 'Palo Alto', 'CA', 94301, '', '2024-07-15', NULL, 'En curso', 0),
(10, 'Netflix', 'contactus@netflix.com', '222333444', '753 Oak St', 'Los Gatos', 'CA', 95030, '', '2024-08-01', NULL, 'En curso', 0),
(11, 'Uber', 'contactus@uber.com', '888999000', '159 Elm St', 'San Francisco', 'CA', 94105, '', '2024-08-15', NULL, 'En curso', 0),
(12, 'SpaceX', 'contactus@spacex.com', '000111222', '852 Pine St', 'Hawthorne', 'CA', 90250, '', '2024-09-01', NULL, 'En curso', 0),
(15, 'Hyperx', 'hyperx@gmail.com', '34154512851', 'Zeballos 123', 'Rosario', 'Santa Fe', 2000, 'Migue Granados', '2024-03-26', NULL, 'Pendiente de aprobación', 0);

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
(1, 9, 4, 7, 0),
(2, 9, 4, 7, 0),
(3, 9, 4, 7, 0),
(4, 9, 4, 7, 0),
(5, 9, 4, 7, 0),
(6, 9, 4, 7, 0),
(7, 9, 4, 7, 0),
(8, 9, 4, 7, 0),
(9, 9, 4, 7, 0),
(10, 9, 4, 7, 0),
(15, NULL, NULL, 10, 0);

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
(3, 'anom117utn@gmail.com', '$2y$10$A7zRC53ezr4ZNkPWnAnOFuib39N7y44YlRY7yD2z.mbgji4Ta4Jzy', 'Santiago', '../img/profiles/default.png', 0, NULL, NULL, 1, 2),
(4, 'tomasamori@gmail.com', '$2y$10$UM2y8lMBrNokq88paY0CSuDUejzVaW9m0SmBu9vWZBwZtj2oz//Dm', 'Tomás Amori', '../img/profiles/4.png', 0, NULL, NULL, 2, 2),
(5, 'matiasmayor@gmail.com', '$2y$10$2oGdaM9ytSzPgyn/W2atWe.wiRlZ/o8EreJDRJELFphyXqlOeuZWm', 'Matías Mayor', '../img/profiles/default.png', 0, NULL, NULL, 2, 2),
(6, 'manuelferrareto@gmail.com', '$2y$10$zv33sdTuMe31NeQZGCuJZuNAkUpy7euAMtk4.Q5NJ9XJRQvoCNHSu', 'Manuel Ferrareto', '../img/profiles/default.png', 0, NULL, NULL, 3, 2),
(7, 'santiagoatombolini@gmail.com', '$2y$10$ZFHO4eRLDq6Ftz0.dbNONO45o260uUlIKk7AZsLS5MiZw1mNL4gC2', 'Santiago Tombolini', '../img/profiles/default.png', 0, NULL, NULL, 2, 2),
(8, 'anom117utn@gmail.com', '$2y$10$f323D5jBY8u7WOiDPnRm4.y9uV.fpnhLeuXhODHJkXA2w09H18Ms2', 'Santiago', '../img/profiles/default.png', 0, NULL, NULL, 2, 2),
(9, 'picho.utn@gmail.com', '123456789', 'picho', '../img/profiles/default.png', 0, NULL, NULL, NULL, 2),
(10, 'matias.mayor99@gmail.com', '$2y$10$L5BaPgomPhVfyMv2AE12R.JL.f4BcYnvm1MADf8yM.kQAmOlgNtZi', 'Matias Mayor', '../img/profiles/default.png', 0, NULL, NULL, 2, 2),
(11, 'tomas.amori@gmail.com', '$2y$10$Qo5ug/BtsWC0Ur10DI66pusAWNPsrE0XSLcdMBXaufUcV3np8f0n2', 'Tomás Amori', '../img/profiles/11.png', 0, NULL, NULL, 2, 2),
(12, 'a@gmail.com', '$2y$10$7nO8qk/sE8HgfDNqDaClWeaB/j8iGjK./rVIcD1cppGmjzmxoVize', 'a e i o u', '../img/profiles/default.png', 0, NULL, NULL, 1, 2),
(13, 'ae@gmail.com', '$2y$10$aNbWI8Ytm.efarxy6k7duOvgOXON82grKMneAh0O1Nk7iVUO.TZa6', 'roberto carlos', '../img/profiles/default.png', 0, NULL, NULL, 2, 2),
(14, 'terrible@gmail.com', '$2y$10$KLUrVKgS7qSmQtD2CRE48O0y1x1ffjEjOBBCz4UUnuHlfUma1.sCS', 'terrible', '../img/profiles/default.png', 0, NULL, NULL, 2, 2),
(15, 'toamori@gmail.com', '$2y$10$jHla5SoF08gnD34B2c9QVuaRxmE.UiHQO/ysUtdJ4ki33aCard62i', 'Roberto Carlos', '../img/profiles/default.png', 0, NULL, NULL, 1, 2);

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
  MODIFY `notification_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `spp`
--
ALTER TABLE `spp`
  MODIFY `spp_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
