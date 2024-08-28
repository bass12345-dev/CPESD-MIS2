-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 23, 2024 at 02:15 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cpesd_mis_users_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `logged_in_history`
--

CREATE TABLE `logged_in_history` (
  `logged_in_history_id` int NOT NULL,
  `web_type` set('cpesd-mis','dts','wl') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `logged_in_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logged_in_history`
--

INSERT INTO `logged_in_history` (`logged_in_history_id`, `web_type`, `user_id`, `logged_in_date`) VALUES
(750, 'cpesd-mis', 8, '2024-07-22 08:45:16'),
(751, 'cpesd-mis', 8, '2024-07-22 09:04:18'),
(752, 'cpesd-mis', 8, '2024-07-22 09:13:23'),
(753, 'cpesd-mis', 8, '2024-07-22 10:02:00'),
(754, 'cpesd-mis', 8, '2024-07-22 10:05:03'),
(755, 'cpesd-mis', 8, '2024-07-23 11:15:10'),
(756, 'cpesd-mis', 8, '2024-07-23 13:17:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('sTIvmSuReq8swxRjz1zUPxBu2fdbsT4phSFW2Qab', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo5OntzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1NzoiaHR0cDovL2xvY2FsaG9zdC9DUEVTRF9NSVNfRlVMTF9TWVNURU0vdXNlci9kdHMvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6IkxvdlJxMkZBclVKMFpGN3pwN1RPVTF6V0pmQjMxY25nZmQ3ZWRYSVEiO3M6NDoibmFtZSI7czoxMjoiTWFyayBBbnRob255IjtzOjc6InVzZXJfaWQiO2k6ODtzOjEwOiJpc0xvZ2dlZEluIjtiOjE7czo5OiJ1c2VyX3R5cGUiO3M6NToiYWRtaW4iO3M6MTE6ImlzX3JlY2VpdmVyIjtzOjI6Im5vIjtzOjY6ImlzX29pYyI7YjoxO30=', 1721740807);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `extension` varchar(10) DEFAULT NULL,
  `contact_number` varchar(15) NOT NULL,
  `address` varchar(150) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `profile_pic` varchar(50) DEFAULT NULL,
  `user_type` varchar(50) NOT NULL,
  `user_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `work_status` set('jo','regular') DEFAULT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(200) NOT NULL,
  `off_id` int NOT NULL,
  `is_receiver` set('no','yes') NOT NULL,
  `is_oic` set('no','yes') NOT NULL,
  `user_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `middle_name`, `last_name`, `extension`, `contact_number`, `address`, `email_address`, `profile_pic`, `user_type`, `user_status`, `work_status`, `username`, `password`, `off_id`, `is_receiver`, `is_oic`, `user_created`) VALUES
(8, 'Mark Anthony', NULL, 'Artigas', NULL, '0905788844', 'Binuangan', 'markeeboi1985@gmail.com', NULL, 'admin', 'active', NULL, 'markuser', '$2y$10$PzosSlglt.ovv.46i0i62OJAJPFo.XI8h6JJOmRb7UTDl2KJdaIy6', 21, 'no', 'yes', '2023-04-06 16:32:32'),
(9, 'Basil John', 'C.', 'Manabo', NULL, '0912321321', 'Tuyabang Bajo', 'manabobasil@gmail.com', NULL, 'user', 'active', NULL, 'basiluser', '$2y$10$bQ9ReGAErl1cFMBpl7gByO1moZQCDr4bCzZ6J7/ScAjaxUD45o/jy', 21, 'no', '', '2023-04-07 03:04:02'),
(12, 'Katlyn Mary', '', 'Daraman', '', '0963936232', 'Canubay', 'daraman.cp', NULL, 'user', 'active', 'jo', 'katlyn1388', '$2y$10$HU/SEKRHDbELpPI10DLnx.EjP2uh0akDblmg0o1vES9lHPRc47xkC', 21, 'no', '', '2023-05-05 05:00:46'),
(13, 'Judith', 'P.', 'Abuhon', '', '09107324580', 'Villaflor', 'abuhon.cpesdoroq@gmail.com', NULL, 'user', 'active', 'jo', 'ram_tom', '$2y$10$TE3O7GRzGKGl18SRaGV9s.u7BpPN.Fsv/YHAujQXEhROnnfAm1Xbm', 21, 'no', '', '2023-05-05 07:01:00'),
(14, 'Sheila Marie', '', 'Daque', '', '09516531821', 'Lower Loboc', 'daquesheilamarie@gmail.com', NULL, 'user', 'active', 'jo', 'Shelayla', '$2y$10$f/X/DdhAtpWijto0rIcIMOkLrk6rqxBNNUsTserNhqUw5szWZ82Fi', 21, 'no', '', '2023-05-05 07:23:18'),
(15, 'Cel', 'Betero', 'Chua', '', '0912789660', 'Talairon', 'chua.cpesd', NULL, 'user', 'active', 'jo', 'Choyerns', '$2y$10$LNjjAwAdQazQMF22UnUCde32RHVohPL3QPjpQ2tJMkH4xswinXPu6', 21, 'no', '', '2023-05-05 07:25:12'),
(16, 'Wiengelyn', 'Milo', 'Ibasan', NULL, '09369190463', 'Tipan', 'ibasan.cpesdoroq@gmail.com', NULL, 'user', 'active', 'jo', 'Wiengy ', '$2y$10$PzosSlglt.ovv.46i0i62OJAJPFo.XI8h6JJOmRb7UTDl2KJdaIy6', 21, 'no', '', '2023-05-05 07:27:14'),
(18, 'Celrose', 'O.', 'Español', '', '09465543788', 'Mobod', 'celrose14@gmail.com', NULL, 'user', 'active', 'jo', 'CELROSE', '$2y$10$LNjjAwAdQazQMF22UnUCde32RHVohPL3QPjpQ2tJMkH4xswinXPu6', 21, 'yes', '', '2023-05-05 08:18:24'),
(19, 'Judy Mae', 'Taberao', 'Catane', '', '09462326054', 'Pines', 'catane.cpesdoroq@gmail.com', NULL, 'user', 'active', 'jo', 'judai09', '$2y$10$2j8deWGJKg6ftOrTRH43pudfIajE/BBn5n8mbZ2KWTzKK90gIcg1y', 21, 'no', '', '2023-05-09 14:24:42'),
(20, 'Dayanara Mae', 'Molina', 'Hipos', '', '09700746605', 'Villaflor', 'hipos.cpesdoroq@gmail.com', NULL, 'user', 'active', 'jo', 'Dayanara', '$2y$10$Mgt4XlqAHBBUSokzbp1pqeSAoyslqH//3y1TZYwL/i1oOcGo8ST7m', 21, 'no', '', '2023-05-09 14:30:58'),
(21, 'Marilou', 'Gumapac', 'Gultian', NULL, '09632873186', 'Binuangan', 'gumapac.cpesdoroq@gmail.com', NULL, 'user', 'active', 'regular', 'MIG101583', '$2y$10$J//1hfufEN6rX/J3CKZrr.SnXG661aFdU9gWUzHoeu/2WDhzb.Vke', 21, 'no', '', '2023-05-10 08:49:43'),
(22, 'Reymond', 'Manlod', 'Tacastacas', '', '09090821383', 'Taboc Sur', 'verzacheboitax@gmail.com', NULL, 'user', 'active', 'jo', 'boitacs', '$2y$10$PzosSlglt.ovv.46i0i62OJAJPFo.XI8h6JJOmRb7UTDl2KJdaIy6', 21, 'no', '', '2023-05-10 09:26:41'),
(23, 'Richard', 'Cariaga ', 'Liberto ', '', '09383926364', 'Canubay', 'richardliberto11@gmail.com', NULL, 'user', 'active', 'regular', 'Jhong ', '$2y$10$PzosSlglt.ovv.46i0i62OJAJPFo.XI8h6JJOmRb7UTDl2KJdaIy6', 21, 'no', '', '2023-05-10 09:28:27'),
(24, 'Dennamor', 'Tangcay', 'Markinez', NULL, '09300334135', 'Lower Langcangan', 'markinez.cpesdoroq@gmail.com', NULL, 'user', 'active', 'jo', 'amoreezz', '$2y$10$lnfNauHJ/hTWRgEXSWw2g.RIGcsvIUwCqft74vSVpnUcUxJjVwY0K', 21, 'no', '', '2023-05-12 14:08:34'),
(26, 'Cristine Grace', 'Uba', 'Masayon', '', '09124318680', 'Upper Rizal', 'uba.cpesdoroq@gmail.com', NULL, 'user', 'active', 'regular', 'richlyzoe', '$2y$10$XTXpBMzO4Y8Cp3tVOML5lO3.Uy5ZjyVzsDbJr1l5K0FZHlMM0Km1G', 21, 'no', '', '2023-07-20 15:48:26'),
(27, 'King Francis', '', 'Cario', '', '09100000000', 'Lower Loboc', '123@gmail.com', NULL, 'user', 'active', 'jo', 'cario1234', '$2y$10$nLHER1Djvb14TgREHn3ureWhyoRw/RQO0uZjmPK.f4WE4QGpsMIka', 21, 'no', '', '2023-08-14 14:20:52'),
(28, 'Joseph', 'L.', 'Buta', '', '09079187139', 'Upper Lamac', 'butajoseph8@gmail.com', NULL, 'user', 'active', 'jo', 'joseph@27', '$2y$10$Y327MA3IWKS0rMmmKlz7rOYQW8trK6UepSjeQaNoorWtO/SbNoV0u', 21, 'no', '', '2023-09-15 11:29:52'),
(31, 'Larry', 'B', 'Borja', NULL, '09639226256', 'Layawan', 'larry.borjaa@gmail.com', NULL, 'user', 'active', NULL, 'Larx', '$2y$10$PGWpwpsxlyogfYyb/qsIiu.w9vUTp5rT7hSTDgWTCeCu7h.CAzXtq', 21, 'no', '', '2024-02-27 15:57:11'),
(32, 'Lea', NULL, 'Revil', NULL, '', 'poblacion 2', '', NULL, 'user', 'active', 'jo', 'learevil', '$2y$10$PzosSlglt.ovv.46i0i62OJAJPFo.XI8h6JJOmRb7UTDl2KJdaIy6', 21, 'no', '', '2024-02-28 00:00:00'),
(33, 'Dianne', 'Palanas', 'Bariso', NULL, '09816185546', 'Talic', 'barisodianne48@gmail.com', NULL, 'user', 'active', 'jo', 'dianne48', '$2y$10$0Wq6w4qOn8iq7VIX9T8RE.ZyWbdgUB1lMXAZ/zNogNdcsU7ViIv.W', 21, 'yes', '', '2024-02-29 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_system_authorized`
--

CREATE TABLE `user_system_authorized` (
  `usa_id` int NOT NULL,
  `user_id` int NOT NULL,
  `system_authorized` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_system_authorized`
--

INSERT INTO `user_system_authorized` (`usa_id`, `user_id`, `system_authorized`, `updated_on`) VALUES
(10, 9, 'pmas,rfa,watchlisted,dts,lls,whip', '2024-07-22 17:36:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logged_in_history`
--
ALTER TABLE `logged_in_history`
  ADD PRIMARY KEY (`logged_in_history_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_system_authorized`
--
ALTER TABLE `user_system_authorized`
  ADD PRIMARY KEY (`usa_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logged_in_history`
--
ALTER TABLE `logged_in_history`
  MODIFY `logged_in_history_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=757;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_system_authorized`
--
ALTER TABLE `user_system_authorized`
  MODIFY `usa_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
