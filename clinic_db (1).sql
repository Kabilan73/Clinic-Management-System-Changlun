-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 10:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinic_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `sickness_id` int(11) NOT NULL,
  `appointment_time` datetime NOT NULL,
  `status` enum('pending','accepted','rejected','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `sickness_id`, `appointment_time`, `status`) VALUES
(1, 4, 3, 2, '2025-06-28 15:06:00', 'accepted'),
(2, 7, 3, 1, '2025-06-18 13:30:00', 'accepted'),
(3, 7, 2, 5, '2025-06-16 21:30:00', 'rejected'),
(5, 6, 2, 1, '2025-06-19 19:10:00', 'pending'),
(7, 11, 12, 3, '2025-06-20 12:48:00', 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `sickness_types`
--

CREATE TABLE `sickness_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sickness_types`
--

INSERT INTO `sickness_types` (`id`, `name`) VALUES
(1, 'Flu'),
(2, 'Cold'),
(3, 'Back Pain'),
(4, 'Headache'),
(5, 'Allergy');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `role` enum('patient','doctor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Anthony', 'admin@gmail.com', '$2y$10$sk7.TtjAyzlKxyMik9LLO.GGhprhKt5MG.aV6EdCQ604v0fM52aJG', 'patient'),
(2, 'Kabilan', 'doc@gmail.com', '$2y$10$9hgmceZf8PP2pcjao0Zo1.AWF5MApRHgp3dYa3u0ye7ZfeGYwXq9O', 'doctor'),
(3, 'Sri', 'sri@gmail.com', '$2y$10$Tmz7k/xUrOTuxKYfo4RpMetKrcoRNCFfinua9WNJn6kNMNlCpgYA.', 'doctor'),
(4, 'kabs', 'kabs@gmail.com', '$2y$10$s3MxWHXobUxIIGsNMtMrleRFGO6IF.Z7XLEv51v3ADGB3tbL6YiL6', 'patient'),
(5, 'Camelia', 'c@gmail.com', '$2y$10$6.KhRf6d8GS2AVSUaJCHQOFKOfFxTlpqbCXhqdBUSkOdSPdToSWs6', 'patient'),
(6, 'Alif', 'a@gmail.com', '$2y$10$a6ISjvbiMoB93/cnCtIk..FIcv6WVPw09dN.eiyOfH8cEv/ypJuHG', 'patient'),
(7, 'taka', 'taka@gmail.com', '$2y$10$WKOAFPl6A58YLwEI9DhGzOeIFXVUMtDlBaImvC8JXuB/WJYgr73pC', 'patient'),
(8, 'Alifff', 'aliff@gmail.com', '$2y$10$OL.bPjp2WwOZp/Yf0o.YKeS.PcJmheM66IIM1XUws9avQ2T.Ggd0a', 'patient'),
(9, 'Kharil', 'kharil@gmail.com', '$2y$10$ruaMLRRG2DMDOLxjTgtqneahUaLaLcfhhgerYpjmFFRQUTUAOhdMm', 'doctor'),
(10, 'Gg', 'g@gmail.com', '$2y$10$kwZZxwtfS6BTjjCGyoen4eiepsJSK7L82nQTE86AeKmb0QTIVpRQe', 'patient'),
(11, 'Neymar', 'n@gmail.com', '$2y$10$FTtRUDOgrv7oytnvxLpUze.J.itGihu5D4nBnvN1Tu/sO8JROUi1u', 'patient'),
(12, 'Paul', 'p@gmail.com', '$2y$10$KdbqTuAB8Y5nzFA5D4UbFuYa4aqVvwRPm9ad6uBmYuM1OGUMzIlQ.', 'doctor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `sickness_id` (`sickness_id`);

--
-- Indexes for table `sickness_types`
--
ALTER TABLE `sickness_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sickness_types`
--
ALTER TABLE `sickness_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`sickness_id`) REFERENCES `sickness_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
