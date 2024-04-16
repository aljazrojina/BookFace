-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 16, 2024 at 09:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `BookFaceDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `body`, `created_at`, `image_path`) VALUES
(32, 45, 'Objava Aljaž 1', 'Kako smo danes?', '2024-04-11 23:29:42', NULL),
(34, 47, 'Zakaj je &scaron;la koko&scaron;ka čez cesto?', 'Da bi pri&scaron;la na drugo stran.', '2024-04-11 23:37:55', NULL),
(35, 45, 'Slika', 'To je slika', '2024-04-12 08:00:09', '3226D20E-8919-46A3-AF4D-66E4BBE96DE8.JPG'),
(36, 45, 'Slika', 'To je slika', '2024-04-12 08:09:46', '3226D20E-8919-46A3-AF4D-66E4BBE96DE8.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `role`) VALUES
(45, 'Aljaž', 'aljaz.rojina@gmail.com', '$2y$10$k1kSCHWpw/aTdn0tyFl9rOArgDA0Tpiywblis.t5D4ZiWG0y.DHvm', '2024-04-11 23:14:58', 'admin'),
(46, 'Žan', 'zan.kavcic@gmail.com', '$2y$10$7.7p/1S.bCk0lbw2thjIwO5TDUCgVMd57LRTqLnNIT8NdQ22AsQWi', '2024-04-11 23:30:28', 'user'),
(47, 'Blaž', 'blaz.rugelj@gmail.com', '$2y$10$XLxqVeMJtPbHgven.l.OPebMcR/cOH7cvTh491zG6nzkvbJWnz0Bi', '2024-04-11 23:35:52', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
