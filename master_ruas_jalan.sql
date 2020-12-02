-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Des 2020 pada 11.58
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.3.21

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
-- Struktur dari tabel `master_ruas_jalan`
--

CREATE TABLE `master_ruas_jalan` (
  `id` int(11) NOT NULL,
  `id_ruas_jalan` char(6) NOT NULL,
  `nama_ruas_jalan` varchar(255) NOT NULL,
  `sup` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `panjang` decimal(10,2) NOT NULL,
  `sta_awal` int(11) NOT NULL,
  `sta_akhir` int(11) NOT NULL,
  `lat_awal` varchar(100) NOT NULL,
  `long_awal` varchar(100) NOT NULL,
  `lat_akhir` int(11) NOT NULL,
  `long_akhir` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `master_ruas_jalan`
--
ALTER TABLE `master_ruas_jalan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `master_ruas_jalan`
--
ALTER TABLE `master_ruas_jalan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
