-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 06, 2021 at 12:25 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pkjd`
--

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

DROP TABLE IF EXISTS `gudang`;
CREATE TABLE IF NOT EXISTS `gudang` (
  `id_gudang` int(11) NOT NULL AUTO_INCREMENT,
  `Lokasi_gudang` varchar(25) NOT NULL,
  PRIMARY KEY (`id_gudang`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`id_gudang`, `Lokasi_gudang`) VALUES
(1, 'Dumai'),
(2, 'Bengkalis');

-- --------------------------------------------------------

--
-- Table structure for table `keluar`
--

DROP TABLE IF EXISTS `keluar`;
CREATE TABLE IF NOT EXISTS `keluar` (
  `id_keluar` int(11) NOT NULL AUTO_INCREMENT,
  `nama_client` varchar(50) NOT NULL,
  `tanggal_pengambilan` datetime DEFAULT NULL,
  `tanggal_kembali` datetime DEFAULT NULL,
  `masuk_id` int(11) NOT NULL,
  PRIMARY KEY (`id_keluar`),
  KEY `masuk_id` (`masuk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

DROP TABLE IF EXISTS `masuk`;
CREATE TABLE IF NOT EXISTS `masuk` (
  `id_barang` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(50) NOT NULL,
  `no_serial` int(11) NOT NULL,
  `gudang_id_gudang` int(11) NOT NULL,
  `status_id_status` int(11) NOT NULL,
  PRIMARY KEY (`id_barang`),
  KEY `id_gudang` (`gudang_id_gudang`),
  KEY `id_status` (`status_id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`id_barang`, `nama_barang`, `no_serial`, `gudang_id_gudang`, `status_id_status`) VALUES
(42, 'Burung', 123456789, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(25) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id_status`, `status`) VALUES
(1, 'Available'),
(2, 'Not Available');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `Nama` varchar(50) NOT NULL,
  `Username` varchar(12) NOT NULL,
  `Password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `Nama`, `Username`, `Password`) VALUES
(1, 'Admin', 'Admin', 'e3afed0047b08059d0fada10f400c1e5');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keluar`
--
ALTER TABLE `keluar`
  ADD CONSTRAINT `keluar_ibfk_1` FOREIGN KEY (`masuk_id`) REFERENCES `masuk` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `masuk`
--
ALTER TABLE `masuk`
  ADD CONSTRAINT `masuk_ibfk_1` FOREIGN KEY (`gudang_id_gudang`) REFERENCES `gudang` (`id_gudang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `masuk_ibfk_2` FOREIGN KEY (`status_id_status`) REFERENCES `status` (`id_status`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
