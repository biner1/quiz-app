-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2023 at 12:43 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz1`
--

-- --------------------------------------------------------

--
-- Table structure for table `attempt_answers`
--

CREATE TABLE `attempt_answers` (
  `id` int(11) NOT NULL,
  `attempt_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attempt_answers`
--

INSERT INTO `attempt_answers` (`id`, `attempt_id`, `question_id`, `option_id`) VALUES
(25, 20, 2, 6),
(26, 20, 3, 10),
(27, 20, 11, 18),
(49, 30, 2, 5),
(50, 30, 3, 4),
(51, 30, 11, 18),
(52, 31, 17, 30),
(53, 31, 18, 31),
(54, 32, 17, 28),
(55, 32, 18, 31),
(56, 33, 17, 29),
(57, 33, 18, 33),
(61, 35, 2, 5),
(62, 35, 3, 4),
(63, 35, 11, 18),
(93, 52, 2, 5),
(94, 52, 3, 10),
(95, 52, 11, 13),
(99, 54, 2, 5),
(100, 54, 3, 4),
(101, 54, 11, 13),
(102, 55, 2, 6),
(103, 55, 3, 7),
(104, 55, 11, 18),
(147, 70, 26, 39),
(148, 70, 27, 40),
(149, 70, 28, 43),
(150, 71, 26, 39),
(151, 71, 27, 40),
(152, 71, 28, 42),
(153, 72, 26, 38),
(154, 72, 27, 41),
(155, 72, 28, 43),
(156, 73, 26, 39),
(157, 73, 27, 41),
(158, 73, 28, 44);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_id`, `option_text`, `is_correct`) VALUES
(4, 3, 'nothing', 1),
(5, 2, 'not fine', 1),
(6, 2, 'fine 1', 0),
(7, 3, 'coding', 0),
(10, 3, 'talking', 0),
(13, 11, 'yes', 0),
(14, 11, 'a', 0),
(18, 11, 'maybe', 1),
(28, 17, 'nothing', 0),
(29, 17, 'yes', 0),
(30, 17, 'a', 1),
(31, 18, 'not fine', 0),
(32, 18, 'coding', 0),
(33, 18, 'a', 1),
(38, 26, 'fine', 0),
(39, 26, 'not fine', 1),
(40, 27, 'yes', 1),
(41, 27, 'coding', 0),
(42, 28, 'fine', 1),
(43, 28, 'not fine', 0),
(44, 28, 'yes', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_text`) VALUES
(2, 2, 'how are you?'),
(3, 2, 'what are you doing?'),
(11, 2, 'does it work?'),
(17, 6, 'what is your name?'),
(18, 6, 'what are you doing?'),
(24, 9, 'what is your name?'),
(25, 9, 'what is your name?'),
(26, 10, 'how are you?'),
(27, 10, 'does it work?'),
(28, 10, 'how are you?');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(512) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `submittable` tinyint(1) DEFAULT 0,
  `mode` enum('all','one') NOT NULL DEFAULT 'all'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `title`, `description`, `user_id`, `created_at`, `submittable`, `mode`) VALUES
(2, 'yourquiz', 'this is  a quiz (updated)', 2, '2023-04-26 16:19:27', 1, 'all'),
(6, 'myquiz', 'a', 2, '2023-04-29 13:53:58', 1, 'all'),
(9, 'a', '', 2, '2023-05-01 18:11:31', 1, 'all'),
(10, 'myquiz', '', 2, '2023-05-07 20:12:27', 1, 'one');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT 0,
  `current_question_id` int(11) DEFAULT NULL,
  `completed` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `quiz_id`, `user_id`, `score`, `current_question_id`, `completed`, `created_at`) VALUES
(20, 2, 2, 67, NULL, 0, '2023-04-28 17:06:22'),
(30, 2, 3, 100, NULL, 0, '2023-04-29 13:35:47'),
(31, 6, 3, 50, NULL, 0, '2023-04-29 13:55:15'),
(32, 6, 3, 0, NULL, 0, '2023-04-29 13:55:35'),
(33, 6, 3, 50, NULL, 0, '2023-04-29 14:05:47'),
(35, 2, 3, 100, NULL, 0, '2023-04-29 14:13:11'),
(52, 2, 3, 33, NULL, 1, '2023-05-10 08:52:43'),
(54, 2, 3, 67, NULL, 1, '2023-05-10 17:59:29'),
(55, 2, 3, 33, NULL, 1, '2023-05-10 18:03:40'),
(70, 10, 3, 67, 28, 1, '2023-05-12 07:43:50'),
(71, 10, 3, 100, 28, 1, '2023-05-12 07:44:09'),
(72, 10, 3, 0, 28, 1, '2023-05-12 07:44:25'),
(73, 10, 3, 33, 28, 1, '2023-05-12 07:44:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_teacher` tinyint(1) DEFAULT 0,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `phone` varchar(15) DEFAULT NULL,
  `image` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_teacher`, `is_admin`, `phone`, `image`) VALUES
(2, 'biner', 'biner@biner.com', '1bbd886460827015e5d605ed44252251', 1, 0, '0770111111', '2 - 2023.04.28 - 01.24.50am.png'),
(3, 'test', 'test@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 0, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attempt_answers`
--
ALTER TABLE `attempt_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attempt_id` (`attempt_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `option_id` (`option_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attempt_answers`
--
ALTER TABLE `attempt_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attempt_answers`
--
ALTER TABLE `attempt_answers`
  ADD CONSTRAINT `attempt_answers_ibfk_1` FOREIGN KEY (`attempt_id`) REFERENCES `quiz_attempts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attempt_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attempt_answers_ibfk_3` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD CONSTRAINT `quiz_attempts_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
