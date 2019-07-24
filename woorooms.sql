-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 31, 2019 at 01:42 PM
-- Server version: 10.2.19-MariaDB-log-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rooms_himanshi`
--

-- --------------------------------------------------------

--
-- Table structure for table `ammenities`
--

CREATE TABLE `ammenities` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ammenities`
--

INSERT INTO `ammenities` (`id`, `name`) VALUES
(1, 'wifi'),
(2, 'parking'),
(3, '24-hr-water'),
(4, 'power backup'),
(5, 'swimming pool');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `city`, `state_id`) VALUES
(1, 'jaipur', 1),
(2, 'udaipur', 1),
(3, 'ajmer', 1),
(4, 'jodhpur', 1);

-- --------------------------------------------------------

--
-- Table structure for table `listing`
--

CREATE TABLE `listing` (
  `id` int(10) NOT NULL,
  `category` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `want` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `terms` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `locality` varchar(100) NOT NULL,
  `accomo_for` varchar(100) NOT NULL,
  `ammenities` varchar(100) NOT NULL,
  `deposite` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `is_active` int(1) NOT NULL,
  `is_premium` int(1) NOT NULL,
  `create_at` datetime NOT NULL,
  `user_id` int(10) NOT NULL,
  `views` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `listing`
--

INSERT INTO `listing` (`id`, `category`, `type`, `want`, `title`, `description`, `terms`, `state`, `city`, `locality`, `accomo_for`, `ammenities`, `deposite`, `price`, `area`, `name`, `email`, `mobile`, `is_active`, `is_premium`, `create_at`, `user_id`, `views`) VALUES
(4, '2', 'owner', 'hostel', 'cedfc', 'cc', 'fcf', '0', '0', 'ffvrfv', 'female', '', '123', '345', '', 'dokdo', 'kldl;k', 'lkdl;k', 1, 0, '2017-07-04 00:00:00', 2, 0),
(5, '3', 'owner', 'sell', 'flat', 'loan', 'loan', '1', '1', 'big', 'female', '', '', '111', 'Noise', 'himanshi', 'himanshi', '1234567899', 1, 0, '2017-07-05 00:00:00', 2, 0),
(6, '3', 'owner', 'sell', 'flat', 'loan', 'loan', '1', '1', 'big', 'female', '', '', '111', 'Noise', 'himanshi', 'himanshi', '1234567899', 1, 0, '2017-07-05 00:00:00', 2, 0),
(7, '3', 'owner', 'sell', 'flat', 'loan', 'loan', '1', '1', 'big', 'female', '', '', '111', 'Noise', 'himanshi', 'himanshi', '1234567899', 1, 0, '2017-07-05 00:00:00', 2, 1),
(8, '4', 'owner', 'sell', 'flat', 'loan', 'loan', '1', '1', 'big', 'female', '', '', '111', 'Noise', 'himanshi', 'himanshi', '1234567899', 1, 0, '2017-07-05 00:00:00', 2, 0),
(9, '3', 'owner', 'sell', 'flat', 'loan', 'loan', '1', '1', 'big', 'female', '', '', '111', 'Noise', 'himanshi', 'himanshi', '1234567899', 1, 0, '2017-07-05 00:00:00', 2, 0),
(10, '1', 'owner', 'sell', 'rent', 'rent rooms', 'no', '1', '1', 'middle', 'female', '1', '', '3000', 'garden', 'himanshi', 'himanshi@gmail.com', '1234567899', 1, 0, '2017-07-12 00:00:00', 0, 0),
(11, '1', 'owner', 'rent', 'rent', 'rent', 'rent', '1', '1', 'center ', 'female', '1', '111', 'owner', '', 'himanshi', 'himanshi@gmail.com', '1234567899', 1, 0, '2017-07-13 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `listing_image`
--

CREATE TABLE `listing_image` (
  `id` int(10) NOT NULL,
  `list_id` int(10) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `listing_image`
--

INSERT INTO `listing_image` (`id`, `list_id`, `image`) VALUES
(1, 9, '0'),
(2, 9, '0'),
(3, 9, '0'),
(4, 9, '0'),
(5, 9, '0'),
(6, 10, '0'),
(7, 10, '0'),
(8, 10, '0'),
(9, 10, '0'),
(10, 10, '0'),
(11, 11, 'img01.jpg'),
(12, 11, 'img02.jpg'),
(13, 11, 'img03.jpg'),
(15, 8, '3836eda45d4d9c9653f982d701e1ca43c62966fa76a1e7df7497486f56a7ca1d.jpg'),
(16, 8, '77a81a1b5179cf14f4f7ff9420230f47442fa7b1173c3fd634a0c40c9831182a.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

CREATE TABLE `property_type` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `property_type`
--

INSERT INTO `property_type` (`id`, `name`) VALUES
(1, 'Residential room'),
(2, 'Residential flat'),
(3, 'Residential appartments'),
(4, 'Commercial shop');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int(10) NOT NULL,
  `state` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `state`) VALUES
(1, 'rajasthan');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(500) NOT NULL,
  `create_at` datetime NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `email`, `password`, `create_at`, `is_active`) VALUES
(2, 'himanshi', '1234567899', 'himansh@gmail.com', '46096e6c0debf46a5e384bc7eb25d768', '2017-07-10 10:25:50', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ammenities`
--
ALTER TABLE `ammenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listing`
--
ALTER TABLE `listing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listing_image`
--
ALTER TABLE `listing_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_type`
--
ALTER TABLE `property_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
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
-- AUTO_INCREMENT for table `listing`
--
ALTER TABLE `listing`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `listing_image`
--
ALTER TABLE `listing_image`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `property_type`
--
ALTER TABLE `property_type`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
