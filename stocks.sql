-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2024 at 01:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `bruto` decimal(10,2) NOT NULL,
  `promo_berlaku` varchar(50) NOT NULL,
  `netto` decimal(10,2) NOT NULL,
  `ukuran_39` int(11) NOT NULL,
  `ukuran_40` int(11) NOT NULL,
  `ukuran_41` int(11) NOT NULL,
  `ukuran_42` int(11) NOT NULL,
  `ukuran_43` int(11) NOT NULL,
  `ukuran_44` int(11) NOT NULL,
  `ukuran_45` int(11) NOT NULL,
  `lokasi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `kode_barang`, `nama_barang`, `bruto`, `promo_berlaku`, `netto`, `ukuran_39`, `ukuran_40`, `ukuran_41`, `ukuran_42`, `ukuran_43`, `ukuran_44`, `ukuran_45`, `lokasi`) VALUES
(6, 'MCFCL00843E.01A', 'Barang 1', 1000000.00, 'SP 449000', 449000.00, 0, 1, 1, 2, 1, 1, 0, 'Gudang'),
(7, 'MCFCL00842E.01A', 'Barang 2', 100000.00, 'SP 449000', 449000.00, 0, 0, 0, 0, 1, 2, 0, 'Gudang'),
(8, 'MC6CFZ1016N.01A', 'Barang 3', 1000000.00, 'SP 289000', 289000.00, 0, 2, 3, 1, 1, 2, 0, 'Gudang Baru');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
