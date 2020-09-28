-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 24, 2020 at 08:08 PM
-- Server version: 10.3.22-MariaDB-1ubuntu1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teman_jabar`
--

-- --------------------------------------------------------

--
-- Table structure for table `landing_fitur`
--

CREATE TABLE `landing_fitur` (
  `id` int(10) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `landing_fitur`
--

INSERT INTO `landing_fitur` (`id`, `judul`, `deskripsi`, `icon`, `link`) VALUES
(1, 'Pengaduan', 'Ada masalah dengan insfrastruktur di daerah anda? Segera lapor kepada kami!', 'fas fa-bullhorn', '#laporan'),
(2, 'Paket Pekerjaan', 'projek pembangunan infrastruktur yang sudah kami selesaikan', 'fas fa-box-open', 'http://localhost:8000/paket-pekerjaan');

-- --------------------------------------------------------

--
-- Table structure for table `landing_pesan`
--

CREATE TABLE `landing_pesan` (
  `id` int(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pesan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `landing_pesan`
--

INSERT INTO `landing_pesan` (`id`, `nama`, `email`, `pesan`, `created_at`) VALUES
(1, 'Rumah Sakit Santo Yusup', 'priyayidimas@upi.edu', 'dsfsdf', '2020-09-23 01:41:20');

-- --------------------------------------------------------

--
-- Table structure for table `landing_profil`
--

CREATE TABLE `landing_profil` (
  `id` int(1) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `kontak` varchar(20) NOT NULL,
  `jam_layanan` varchar(20) NOT NULL,
  `link_website` varchar(255) DEFAULT NULL,
  `link_instagram` varchar(255) DEFAULT NULL,
  `link_facebook` varchar(255) DEFAULT NULL,
  `link_twitter` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `pencapaian_selesai` int(4) NOT NULL,
  `pencapaian_target` int(4) NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `landing_profil`
--

INSERT INTO `landing_profil` (`id`, `nama`, `deskripsi`, `alamat`, `email`, `kontak`, `jam_layanan`, `link_website`, `link_instagram`, `link_facebook`, `link_twitter`, `gambar`, `pencapaian_selesai`, `pencapaian_target`, `updated_at`) VALUES
(1, 'DBMPR Provinsi Jawa Barat', 'Dinas Bina Marga dan Penataan Ruang Provinsi Jawa Barat merupakan salah satu dari dinas daerah dan menjadi bagian dari Pemerintah Daerah Provinsi Jawa Barat. Merupakan unsur pelaksana otonomi daerah yang mempunyai tugas melaksanakan urusan Bidang Kebinamargaan dan Penataan Ruang serta Tugas Pembantuan.', 'Jl. Asia Afrika No.79, Braga, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40111', 'dbmpr.jawabarat@support.com', '021 - 222 - 346', '08.00 - 17.00', 'http://dbmtr.jabarprov.go.id/', NULL, NULL, NULL, 'http://localhost:8000/assets/images/about/about.jpg', 874, 1200, '2020-09-24 02:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `landing_slideshow`
--

CREATE TABLE `landing_slideshow` (
  `id` int(10) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `landing_slideshow`
--

INSERT INTO `landing_slideshow` (`id`, `judul`, `gambar`) VALUES
(1, 'DBMPR Konektivitas Seluruh Wilayah', 'localhost:8000/assets/images/slider/hero01.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `landing_uptd`
--

CREATE TABLE `landing_uptd` (
  `id` int(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `slug` varchar(50) DEFAULT NULL,
  `altnama` varchar(50) DEFAULT NULL,
  `deskripsi` varchar(80) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `landing_uptd`
--

INSERT INTO `landing_uptd` (`id`, `nama`, `slug`, `altnama`, `deskripsi`, `gambar`) VALUES
(1, 'UPTD 1', 'uptd-1', 'Wilayah Pelayanan 1', 'WILAYAH KAB.CIANJUR-KOTA/KAB.BOGOR-KOTA DEPOK-KOTA/KAB.BEKASI', 'http://localhost:8000/assets/images/uptd/uptd1.jpg'),
(2, 'UPTD 2', 'uptd-2', 'Wilayah Pelayanan 2', 'WILAYAH KOTA & KAB. SUKABUMI', 'http://localhost:8000/assets/images/uptd/uptd2.jpg'),
(4, 'UPTD 99', 'uptd-99', 'Wilayah Pelayanan 99', 'sdfdsf', NULL),
(5, 'UPTD 69', 'uptd-69', 'Wilayah Pelayanan 69', 'asdasdsa', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `monitoring_laporan_masyarakat`
--

CREATE TABLE `monitoring_laporan_masyarakat` (
  `id` int(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nik` varchar(17) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `jenis` varchar(20) NOT NULL,
  `deskripsi` text NOT NULL,
  `lat` float NOT NULL,
  `long` float NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `uptd_id` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `monitoring_laporan_masyarakat`
--

INSERT INTO `monitoring_laporan_masyarakat` (`id`, `nama`, `nik`, `email`, `telp`, `jenis`, `deskripsi`, `lat`, `long`, `gambar`, `uptd_id`, `created_at`) VALUES
(1, 'Sumanto', '3212321323211232', 'sumanto@mail.com', '082382123212', 'Jalan Berlubang', 'Punten, Jalan dekat rumah saya rusak', -6, 141, 'https://images.hukumonline.com/frontend/lt5a954764bab1a/lt5a954d70cd9dd.jpg', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `landing_fitur`
--
ALTER TABLE `landing_fitur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landing_pesan`
--
ALTER TABLE `landing_pesan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landing_profil`
--
ALTER TABLE `landing_profil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landing_slideshow`
--
ALTER TABLE `landing_slideshow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landing_uptd`
--
ALTER TABLE `landing_uptd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monitoring_laporan_masyarakat`
--
ALTER TABLE `monitoring_laporan_masyarakat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uptd_id` (`uptd_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `landing_fitur`
--
ALTER TABLE `landing_fitur`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `landing_pesan`
--
ALTER TABLE `landing_pesan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `landing_profil`
--
ALTER TABLE `landing_profil`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `landing_slideshow`
--
ALTER TABLE `landing_slideshow`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `landing_uptd`
--
ALTER TABLE `landing_uptd`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `monitoring_laporan_masyarakat`
--
ALTER TABLE `monitoring_laporan_masyarakat`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
