-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 20, 2019 at 02:15 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rl`
--

-- --------------------------------------------------------

--
-- Table structure for table `rl_experiment`
--

CREATE TABLE `rl_experiment` (
  `id` int(11) NOT NULL,
  `experiment` varchar(30) NOT NULL,
  `equipment_id` varchar(20) NOT NULL,
  `session_key` varchar(20) NOT NULL,
  `command` text NOT NULL,
  `value` text NOT NULL,
  `command_set_at` datetime NOT NULL,
  `command_get_at` datetime NOT NULL,
  `value_set_at` datetime NOT NULL,
  `value_get_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rl_experiment`
--

INSERT INTO `rl_experiment` (`id`, `experiment`, `equipment_id`, `session_key`, `command`, `value`, `command_set_at`, `command_get_at`, `value_set_at`, `value_get_at`) VALUES
(1, 'INTERFERENCE', 'asdfgh', 'qwerty', 'LASER|RED', '{\r\n\"chart\":[[1.1,10],[2.1,12],[3.0,15]]\r\n}', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rl_experiment`
--
ALTER TABLE `rl_experiment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rl_experiment`
--
ALTER TABLE `rl_experiment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
