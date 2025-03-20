-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2025 at 01:40 PM
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
-- Database: `sound_scapes_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `soundscape_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `soundscape_id`, `rating`, `created_at`) VALUES
(1, 1, 9, 4, '2025-03-02 19:01:53'),
(2, 1, 7, 4, '2025-03-02 19:04:18'),
(3, 1, 8, 4, '2025-03-02 19:47:46'),
(4, 1, 10, 5, '2025-03-16 19:30:25'),
(5, 7, 12, 4, '2025-03-17 23:58:38'),
(6, 7, 9, 5, '2025-03-17 23:59:10'),
(7, 7, 11, 3, '2025-03-18 00:46:06'),
(8, 7, 10, 4, '2025-03-18 00:52:42'),
(9, 7, 8, 5, '2025-03-18 00:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `soundscape_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `soundscape_id`, `user_id`, `review`, `created_at`) VALUES
(1, 7, 1, 'dsfnjklnfsdklfdkl  fldeslkfk dsfjfdnsfdln s fdnmklfdskl dsfknfdlkfn fskjsfln fdsnjf fdnfd djfnf dslnf sfnfd', '2025-03-02 19:08:40'),
(2, 7, 1, 'dsfnjklnfsdklfdkl  fldeslkfk dsfjfdnsfdln s fdnmklfdskl dsfknfdlkfn fskjsfln fdsnjf fdnfd djfnf dslnf sfnfd', '2025-03-02 19:12:31'),
(3, 9, 1, 'dcx ccx xc xc cxdz cz', '2025-03-02 19:34:19'),
(4, 9, 1, 'asax adad  fsds', '2025-03-02 19:37:22'),
(5, 9, 1, 'dcx ccx xc xc cxdz cz', '2025-03-02 19:42:22'),
(6, 8, 1, 'fddn fcdn bhx ffb dbvgh', '2025-03-02 19:50:11'),
(7, 10, 1, 'sdcd dsdcd sd sd df ff ff s', '2025-03-16 19:30:10'),
(8, 12, 7, 'This chicken sound is So awsome', '2025-03-17 23:58:59'),
(9, 9, 7, 'This soundscape is so heartwarming', '2025-03-17 23:59:41'),
(10, 12, 7, 'like for real', '2025-03-18 00:41:29'),
(11, 11, 7, 'This waterfall sounds like a dream', '2025-03-18 00:46:58'),
(12, 10, 7, 'this is so cool', '2025-03-18 00:53:09'),
(13, 8, 7, 'typical soundscape', '2025-03-18 00:56:33');

-- --------------------------------------------------------

--
-- Table structure for table `soundscapes`
--

CREATE TABLE `soundscapes` (
  `id` int(11) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `file` varchar(1024) NOT NULL,
  `image` varchar(1024) NOT NULL,
  `title` varchar(100) NOT NULL,
  `plays` varchar(11) NOT NULL DEFAULT '0',
  `popularity` varchar(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `soundscapes`
--

INSERT INTO `soundscapes` (`id`, `user_id`, `file`, `image`, `title`, `plays`, `popularity`, `date`) VALUES
(7, '6', 'uploads/Ocean Bloom - Catamaran (freetouse.com).mp3', 'uploads/1.jpg', 'OceanBloom ', '18', '0', '2025-02-14 13:01:53'),
(8, '6', 'uploads/Lukrembo - Travel (freetouse.com).mp3', 'uploads/12.jpg', 'mmmm', '39', '0', '2025-02-14 13:43:59'),
(9, '1', 'uploads/Epic Spectrum - Wallflower (freetouse.com).mp3', 'uploads/3.jpg', '1', '6', '0', '2025-03-02 18:58:32'),
(10, '1', 'uploads/labyrinth-for-the-brain-190096.mp3', 'uploads/18.jpg', 'horrifying', '6', '0', '2025-03-05 15:55:37'),
(11, '7', 'uploads/audio_67d8b45a3501f.mp3', 'uploads/img_67d8b45a2e429.jpg', 'Waterfall', '0', '0', '2025-03-18 00:46:34'),
(12, '7', 'uploads/audio_67d8b4d547aff.mp3', 'uploads/img_67d8b4d54260b.jpg', 'Chicken', '0', '0', '2025-03-18 00:48:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(225) NOT NULL,
  `role` varchar(6) NOT NULL,
  `date` datetime NOT NULL,
  `image` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `role`, `date`, `image`) VALUES
(1, 'Chrome', 'Shane', 'Sibanda', 'sibandashane@yahoo.com', '$2y$10$Jg9eXRV3qB2p9UxGCOOUPuc0vUEEkUYdSMQCbC0IWxXgRkgNyBJXG', 'admin', '2025-02-14 02:06:23', 'uploads/1741191495_3d-illustration-lovely-girl-holding-icecream-balloon-rendering_1150-53676.png'),
(5, 'kuntakente', 'kunta', 'kente', 'kunta@email.com', '$2y$10$b4fDfkZiVA0U/bJ8706AxOXwsmcfgvJWfxjiuOvtdnsaM7h5Uy8.2', 'user', '2025-02-14 02:31:41', NULL),
(6, 'Johndoe', 'john', 'doe', 'john@email.com', '$2y$10$BQg.rDJTV3iY65jTK.ZsYeKGKJ7B.bIkTb3swgzf1t81Do587eZQm', 'user', '2025-02-14 09:06:27', NULL),
(7, 'User1', 'User', '1', 'user1@email.com', '$2y$10$NU.VNyjBo18ICWb7j5cKD.pwO5WjKIiAVLwuQk0QVn2.vkSl3Cc1C', 'user', '2025-03-18 00:44:10', 'uploads/1742255873_curly-man-with-broad-smile-shows-perfect-teeth-being-amused-by-interesting-talk-has-bushy-curly-dark-hair-stands-indoor-against-white-blank-wall_273609-17092.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`soundscape_id`),
  ADD KEY `soundscape_id` (`soundscape_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soundscape_id` (`soundscape_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `soundscapes`
--
ALTER TABLE `soundscapes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `title` (`title`),
  ADD KEY `plays` (`plays`),
  ADD KEY `ratings` (`popularity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `soundscapes`
--
ALTER TABLE `soundscapes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`soundscape_id`) REFERENCES `soundscapes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`soundscape_id`) REFERENCES `soundscapes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
