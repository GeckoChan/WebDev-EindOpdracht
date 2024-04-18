-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jan 21, 2024 at 12:46 PM
-- Server version: 11.2.2-MariaDB-1:11.2.2+maria~ubu2204
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `developmentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `username`, `password`, `email`) VALUES
(1, 'Gecko', '$2y$10$54E8RPa082smTwrqc/YiMOG8r2.i2DWzHy1kX.jteQXV/tOtkRcAi', 'kian.steffes@gmail.com'),
(2, 'Admin', '$2y$10$jrBAO3N/VX/oTxWOix6oc.edS6z1gd8D/D3ZKLY1rAANj45c8Ln9m', 'Admin'),
(3, 'Cathryn', '$2y$10$GKw4wZWUb0v64JaCn3yYLOJvm8ugXNbiRpzxqvjbPCZ.YvMyjU.tu', 'Cathryn@gmail.com'),
(14, 'test', '$2y$10$xWSoQLUFzbCNPPNYIOazlOiPah7c4XsvNIVjGGpPz4GVbbsYR9AS6', 'test@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `friend_id` int(11) NOT NULL,
  `account1_id` int(11) DEFAULT NULL,
  `account2_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`friend_id`, `account1_id`, `account2_id`, `status`, `created_at`) VALUES
(1, 1, 3, 'accepted', '2024-01-05 14:13:11'),
(23, 14, 2, 'accepted', '2024-01-17 10:15:44');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `account_id`, `post_id`) VALUES
(98, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `parent_post_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `post_content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `created_by`, `parent_post_id`, `created_at`, `post_content`) VALUES
(1, 1, NULL, '2024-01-09 12:57:24', 'test'),
(2, 3, NULL, '2024-01-09 13:31:44', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent finibus cursus dolor et iaculis. Quisque eu pharetra eros. Pellentesque non dapibus erat. Quisque non nisi eget eros scelerisque pharetra. Proin facilisis mi quis enim interdum molestie. Phasellus massa velit, molestie sed rhoncus mattis, rutrum ac lorem. Vivamus vitae fermentum urna. Nunc tempor lorem sapien, eu venenatis nunc gravida ut. Morbi dapibus ex auctor fringilla ullamcorper. Etiam ultricies sed risus non tempus. Mauris felis odio, aliquet in sem sed, lacinia lobortis leo. Mauris blandit, urna sed lobortis accumsan, ipsum odio pretium tortor, at mattis elit quam ac leo.\r\n\r\nMauris varius enim a ornare fringilla. Curabitur rutrum vitae ipsum ac ullamcorper. Vivamus ac metus mattis sapien tincidunt pulvinar. Aliquam lacus augue, imperdiet varius lacus at, porttitor rutrum lacus. Duis elementum facilisis nulla, quis molestie lorem imperdiet ut. Ut cursus, elit quis fermentum interdum, tellus dui sollicitudin dui, quis scelerisque mi mauris feugiat lectus. In dignissim, mi in semper laoreet, tellus nunc placerat odio, quis volutpat turpis nisi a metus. Suspendisse dictum mattis posuere. Fusce vitae auctor lacus. Aliquam id mi augue. Curabitur id nisi suscipit, volutpat metus et, porttitor nulla. '),
(5, 2, NULL, '2024-01-09 13:41:16', 'test'),
(10, 1, NULL, '2024-01-12 11:24:36', 'and now???'),
(11, 1, NULL, '2024-01-12 11:24:42', 'yay :3\n'),
(24, 1, 11, '2024-01-14 14:33:35', 'test'),
(40, 1, 24, '2024-01-15 14:37:38', 'TEST');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friend_id`),
  ADD KEY `account1_id` (`account1_id`),
  ADD KEY `account2_id` (`account2_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `likes_ibfk_1` (`account_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `posts_ibfk_2_new` (`parent_post_id`),
  ADD KEY `posts_ibfk_1` (`created_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`account1_id`) REFERENCES `accounts` (`account_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`account2_id`) REFERENCES `accounts` (`account_id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `accounts` (`account_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2_new` FOREIGN KEY (`parent_post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
