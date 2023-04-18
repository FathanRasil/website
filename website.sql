-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2023 at 07:07 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `image` varchar(128) NOT NULL,
  `is_active` int(11) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `image`, `is_active`, `date_created`) VALUES
(3, 'Muhammad Fathan Rasil Haq', 'muhammadrasil47@gmail.com', '$2y$10$3sFvwfCrSJFRLwqxSHn4bO9htmGx5cjxkI.radrCVZMcogp3CbWrW', 'IMG_20160222_164251.jpg', 1, 0),
(4, 'Muhammad Fathan Rasil Haq', 'fathan.065118081@unpak.ac.id', '$2y$10$owCTKnJyUlazXkTH5Xq6e.VTW1sp4xGJrlB.khBkqOEYEQpLH8ufS', 'Pas Foto.jpeg', 1, 0),
(5, 'Nizam Hairul', 'nizamhairul15@gmail.com', '$2y$10$nsdwl9oPw7Sljf03xHhszuM8I.FxTe7DK6oSbwQJkg3iQoewpAxRi', 'WhatsApp Image 2023-01-25 at 15.19.48.jpeg', 1, 0),
(6, 'Boogie', 'xbtspeeedespada1@gmail.com', '$2y$10$4ZRlvq7zge1z1LsgesLSWuJnG.rlcHvdTpQjda9YPNmzwBSzAHi3.', 'WhatsApp Image 2023-01-25 at 15.19.48.jpeg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(1, 'fathan.065118081@unpak.ac.id', 'YkJZ4Sa11KEtkwhM8DBETsHJx0F8n5/557lNm6K/L1U=', 1681539001),
(2, 'fathan.065118081@unpak.ac.id', 'R2e+3+7ex53FDZoy3am35l1iv4FUWg9T9PmD6ib7ZVY=', 1681539753),
(3, 'muhammadrasil47@gmail.com', 'RnZFHzf7vo3ZGOQjrMjqV28SH2VmlaBu0tO2ajR49Es=', 1681539791),
(4, 'fathan.065118081@unpak.ac.id', 'Wb74rT2pIlvywioHlxL6x48DFe4I62crO+Zi8BwIh64=', 1681540796),
(5, 'muhammadrasil47@gmail.com', '2gUwrMc5eyOrh/qH136SPW5trREL0fjx473/yJEMlZE=', 1681540822),
(6, 'muhammadrasil47@gmail.com', 'ILcdfJ8m7+C4kr+yf8AAXvrETHHg2mc/FKaSkqGkbik=', 1681540864),
(7, 'muhammadrasil47@gmail.com', 'C0lWKTxEw7o3XEx0J4GRARF7OuTXOc4Q4xq/0YDeNf4=', 1681543232),
(8, 'muhammadrasil47@gmail.com', 'SADJqbi5FS9FJ6ec7MtO5d8FeBMiujN0Wt4cQa44Pnw=', 1681561794),
(9, 'xbtspeeedespada1@gmail.com', 'cbGPO+nIMO8EtXu1C1FC93llWZhfkBB0d6P7LUnl+3g=', 1681562628);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
