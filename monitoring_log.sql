-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2023 at 03:24 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitoring_log`
--

-- --------------------------------------------------------

--
-- Table structure for table `station1`
--

CREATE TABLE `station1` (
  `id` int(20) UNSIGNED NOT NULL,
  `suhu` float NOT NULL,
  `kelembaban` int(11) NOT NULL,
  `ph` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `station1`
--
DELIMITER $$
CREATE TRIGGER `updatedashboard` AFTER INSERT ON `station1` FOR EACH ROW BEGIN
    INSERT INTO station1_dashboard (suhu, kelembaban, ph, created_at, CabaiMerah, Terong, KacangPanjang, Kol, Singkong)
    VALUES (NEW.suhu, NEW.kelembaban, NEW.ph, NEW.created_at,
            CASE
                WHEN (NEW.suhu BETWEEN 25 AND 30 AND NEW.kelembaban BETWEEN 60 AND 70 AND NEW.ph BETWEEN 5.6 AND 7.5) THEN 'Rekomended'
                ELSE 'Tidak Rekomended'
            END,
            CASE
                WHEN (NEW.suhu BETWEEN 22 AND 32 AND NEW.kelembaban BETWEEN 60 AND 70 AND NEW.ph BETWEEN 5.6 AND 7) THEN 'Rekomended'
                ELSE 'Tidak Rekomended'
            END,
            CASE
                WHEN (NEW.suhu BETWEEN 22 AND 32 AND NEW.kelembaban BETWEEN 50 AND 60 AND NEW.ph BETWEEN 5.5 AND 7.5) THEN 'Rekomended'
                ELSE 'Tidak Rekomended'
            END,
            CASE
                WHEN (NEW.suhu BETWEEN 21 AND 32 AND NEW.kelembaban BETWEEN 60 AND 70 AND NEW.ph BETWEEN 5.5 AND 7.5) THEN 'Rekomended'
                ELSE 'Tidak Rekomended'
            END,
            CASE
                WHEN (NEW.suhu BETWEEN 22 AND 32 AND NEW.kelembaban BETWEEN 50 AND 60 AND NEW.ph BETWEEN 5.5 AND 7) THEN 'Rekomended'
                ELSE 'Tidak Rekomended'
            END
           );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `station1_dashboard`
--

CREATE TABLE `station1_dashboard` (
  `id` int(11) NOT NULL,
  `suhu` decimal(5,2) DEFAULT NULL,
  `kelembaban` decimal(5,2) DEFAULT NULL,
  `ph` decimal(5,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `terong` varchar(20) DEFAULT NULL,
  `cabaimerah` varchar(20) DEFAULT NULL,
  `kacangpanjang` varchar(20) DEFAULT NULL,
  `kol` varchar(20) DEFAULT NULL,
  `singkong` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `station1`
--
ALTER TABLE `station1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `station1_dashboard`
--
ALTER TABLE `station1_dashboard`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `station1`
--
ALTER TABLE `station1`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18843;

--
-- AUTO_INCREMENT for table `station1_dashboard`
--
ALTER TABLE `station1_dashboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5262;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
