-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 20, 2025 at 05:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensi_siswa_2025`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2025-01-18 10:44:59');

-- --------------------------------------------------------

--
-- Table structure for table `angkatan`
--

CREATE TABLE `angkatan` (
  `id_angkatan` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `angkatan`
--

INSERT INTO `angkatan` (`id_angkatan`, `nama`, `status`, `created_at`) VALUES
(1, '2020', 1, '2025-01-20 22:07:19'),
(2, '2021', 1, '2025-01-20 22:07:19'),
(3, '2022', 1, '2025-01-20 22:07:19'),
(4, '2023', 1, '2025-01-20 22:07:19'),
(5, '2024', 1, '2025-01-20 22:07:19'),
(6, '2025', 1, '2025-01-20 22:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama`, `status`, `created_at`) VALUES
(1, 'IPA', 1, '2025-01-20 22:05:24'),
(2, 'IPS', 1, '2025-01-20 22:05:24'),
(3, 'Bahasa', 1, '2025-01-20 22:05:24'),
(4, 'TKJ', 1, '2025-01-20 22:05:24'),
(5, 'RPL', 1, '2025-01-20 22:05:24'),
(6, 'Mesin', 1, '2025-01-20 22:05:24'),
(7, 'Automotif', 1, '2025-01-20 22:05:24'),
(8, 'Elektro', 1, '2025-01-20 22:05:24'),
(9, 'Sipil', 1, '2025-01-20 22:05:24');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama`, `status`, `created_at`) VALUES
(1, 'X IPA 1', 1, '2025-01-20 21:19:43'),
(2, 'X IPS 1', 1, '2025-01-20 21:19:43'),
(3, 'XI Bahasa 1', 1, '2025-01-20 21:19:43'),
(4, 'XII Automotif', 1, '2025-01-20 21:19:43'),
(5, 'XII Mesin', 1, '2025-01-20 21:19:43');

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id_presensi` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_tahun_ajaran` int(11) NOT NULL,
  `tgl_check_in` datetime DEFAULT NULL,
  `jam_check_in` time DEFAULT NULL,
  `tgl_check_out` datetime DEFAULT NULL,
  `jam_check_out` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id_presensi`, `id_siswa`, `id_tahun_ajaran`, `tgl_check_in`, `jam_check_in`, `tgl_check_out`, `jam_check_out`) VALUES
(1, 22, 2025, '2025-01-20 00:00:00', '22:14:55', '0000-00-00 00:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nisn` varchar(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `id_angkatan` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nisn`, `nama`, `id_angkatan`, `id_kelas`, `id_jurusan`, `alamat`, `status`) VALUES
(12, '12345678901', 'Siswa 1', 1, 1, 1, 'Jl. Merdeka No. 1', 1),
(13, '12345678902', 'Siswa 2', 1, 1, 1, 'Jl. Merdeka No. 2', 1),
(14, '12345678903', 'Siswa 3', 1, 2, 2, 'Jl. Merdeka No. 3', 1),
(15, '12345678904', 'Siswa 4', 1, 2, 2, 'Jl. Merdeka No. 4', 1),
(16, '12345678905', 'Siswa 5', 1, 3, 3, 'Jl. Merdeka No. 5', 1),
(17, '12345678906', 'Siswa 6', 2, 3, 3, 'Jl. Merdeka No. 6', 1),
(18, '12345678907', 'Siswa 7', 2, 4, 4, 'Jl. Merdeka No. 7', 1),
(19, '12345678908', 'Siswa 8', 2, 4, 4, 'Jl. Merdeka No. 8', 1),
(20, '12345678909', 'Siswa 9', 2, 5, 5, 'Jl. Merdeka No. 9', 1),
(21, '12345678910', 'Siswa 10', 2, 5, 5, 'Jl. Merdeka No. 10', 1),
(22, '20091054', 'Siswa 100', 5, 5, 5, 'Jl. Merdeka No. 11', 1),
(25, '12345678912', 'Doanal Trump', 5, 1, 1, 'Pasawahan Hill', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id_tahun_ajaran` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id_tahun_ajaran`, `nama`, `status`, `created_at`) VALUES
(1, '2020/2021', 1, '2025-01-20 22:08:32'),
(2, '2021/2022', 1, '2025-01-20 22:08:32'),
(3, '2022/2023', 1, '2025-01-20 22:08:32'),
(4, '2023/2024', 1, '2025-01-20 22:08:32'),
(5, '2024/2025', 1, '2025-01-20 22:08:32'),
(6, '2025/2026', 1, '2025-01-20 22:08:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `angkatan`
--
ALTER TABLE `angkatan`
  ADD PRIMARY KEY (`id_angkatan`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `id_tahun_ajaran` (`id_tahun_ajaran`) USING BTREE,
  ADD KEY `id_siswa` (`id_siswa`) USING BTREE;

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `id_angkatan` (`id_angkatan`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id_tahun_ajaran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `angkatan`
--
ALTER TABLE `angkatan`
  MODIFY `id_angkatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id_tahun_ajaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
