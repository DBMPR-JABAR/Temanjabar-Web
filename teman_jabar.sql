
START TRANSACTION;


CREATE TABLE `landing_fitur` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `judul` varchar(50) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
);


INSERT INTO `landing_fitur` (`id`, `judul`, `deskripsi`, `icon`, `link`) VALUES
(1, 'Pengaduan', 'Ada masalah dengan insfrastruktur di daerah anda? Segera lapor kepada kami!', 'fas fa-bullhorn', '#laporan'),
(2, 'Paket Pekerjaan', 'projek pembangunan infrastruktur yang sudah kami selesaikan', 'fas fa-box-open', 'http://localhost:8000/paket-pekerjaan');



CREATE TABLE `landing_pesan` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pesan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
);


INSERT INTO `landing_pesan` (`id`, `nama`, `email`, `pesan`, `created_at`) VALUES
(1, 'Rumah Sakit Santo Yusup', 'priyayidimas@upi.edu', 'dsfsdf', '2020-09-23 01:41:20');


CREATE TABLE `landing_profil` (
  `id` int(1) NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
);


INSERT INTO `landing_profil` (`id`, `nama`, `deskripsi`, `alamat`, `email`, `kontak`, `jam_layanan`, `link_website`, `link_instagram`, `link_facebook`, `link_twitter`, `gambar`, `pencapaian_selesai`, `pencapaian_target`, `updated_at`) VALUES
(1, 'DBMPR Provinsi Jawa Barat', 'Dinas Bina Marga dan Penataan Ruang Provinsi Jawa Barat merupakan salah satu dari dinas daerah dan menjadi bagian dari Pemerintah Daerah Provinsi Jawa Barat. Merupakan unsur pelaksana otonomi daerah yang mempunyai tugas melaksanakan urusan Bidang Kebinamargaan dan Penataan Ruang serta Tugas Pembantuan.', 'Jl. Asia Afrika No.79, Braga, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40111', 'dbmpr.jawabarat@support.com', '021 - 222 - 346', '08.00 - 17.00', 'http://dbmtr.jabarprov.go.id/', NULL, NULL, NULL, 'http://localhost:8000/assets/images/about/about.jpg', 874, 1200, '2020-09-24 02:34:26');


CREATE TABLE `landing_slideshow` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `judul` varchar(50) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
);

INSERT INTO `landing_slideshow` (`id`, `judul`, `gambar`) VALUES
(1, 'DBMPR Konektivitas Seluruh Wilayah', 'localhost:8000/assets/images/slider/hero01.jpg');


CREATE TABLE `landing_uptd` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `slug` varchar(50) DEFAULT NULL,
  `altnama` varchar(50) DEFAULT NULL,
  `deskripsi` varchar(80) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
);


INSERT INTO `landing_uptd` (`id`, `nama`, `slug`, `altnama`, `deskripsi`, `gambar`) VALUES
(1, 'UPTD 1', 'uptd-1', 'Wilayah Pelayanan 1', 'WILAYAH KAB.CIANJUR-KOTA/KAB.BOGOR-KOTA DEPOK-KOTA/KAB.BEKASI', 'http://localhost:8000/assets/images/uptd/uptd1.jpg'),
(2, 'UPTD 2', 'uptd-2', 'Wilayah Pelayanan 2', 'WILAYAH KOTA & KAB. SUKABUMI', 'http://localhost:8000/assets/images/uptd/uptd2.jpg'),
(4, 'UPTD 99', 'uptd-99', 'Wilayah Pelayanan 99', 'sdfdsf', NULL),
(5, 'UPTD 69', 'uptd-69', 'Wilayah Pelayanan 69', 'asdasdsa', NULL);


CREATE TABLE `monitoring_laporan_masyarakat` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
);


INSERT INTO `monitoring_laporan_masyarakat` (`id`, `nama`, `nik`, `email`, `telp`, `jenis`, `deskripsi`, `lat`, `long`, `gambar`, `uptd_id`, `created_at`) VALUES
(1, 'Sumanto', '3212321323211232', 'sumanto@mail.com', '082382123212', 'Jalan Berlubang', 'Punten, Jalan dekat rumah saya rusak', -6, 141, 'https://images.hukumonline.com/frontend/lt5a954764bab1a/lt5a954d70cd9dd.jpg', 1, NULL);


COMMIT;

