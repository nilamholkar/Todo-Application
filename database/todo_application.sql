-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2025 at 12:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todo_application`
--

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('open','in_progress','completed') DEFAULT 'open',
  `assigned_to` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`id`, `title`, `description`, `status`, `assigned_to`, `created_by`, `created_at`) VALUES
(1, 'Database Structure', 'Create database structure for hr management with all required diagram..', 'in_progress', 1, 2, '2025-02-08 02:51:03'),
(3, 'Login Page', 'Create login page for admin and user.', 'open', 1, 2, '2025-02-08 07:41:50'),
(4, 'Sign Up Page', 'Create sign up page for user and admin.', 'open', 3, 2, '2025-02-08 11:04:12'),
(5, 'Sign Up Page', 'Create sign up page for user and admin.', 'open', 3, 2, '2025-02-08 11:07:57'),
(6, 'Sign Up Page', 'test', 'open', 3, 2, '2025-02-08 11:08:16'),
(7, 'test', 'test', 'open', 1, 2, '2025-02-08 11:11:52'),
(9, 'Sign up  page', 'Create signup page for admin and user.', 'in_progress', 3, 2, '2025-02-08 11:17:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','employee') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Nilam', 'holkarnilam14@gmail.com', '$2y$10$IXDbJBveh1IEpqOYyKjHV.MDbs.prFd6haYggQtLR2U8/tN6dihfe', 'employee', '2025-02-08 02:40:16'),
(2, 'Admin', 'admin@gmail.com', '$2y$10$YQ7gCHQyljdywPzfrdiXaetlUl6B1U3f4b8YEo9C7XjljrKKT9D4q', 'admin', '2025-02-08 02:47:44'),
(3, 'srushtidhar', 'srushtidharyedase24@gmail.com', '$2y$10$3MBQD/9W2FgRkZj1vTmW/eyVbeNmo49GZJyyvbEwbtycwYmLSOaKK', 'employee', '2025-02-08 10:44:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `created_by` (`created_by`);

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
-- AUTO_INCREMENT for table `todos`
--
ALTER TABLE `todos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `todos`
--
ALTER TABLE `todos`
  ADD CONSTRAINT `todos_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `todos_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
