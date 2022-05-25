-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2021 at 09:16 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apkpenggajianguru`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `nama_guru` varchar(40) NOT NULL,
  `status` varchar(10) NOT NULL,
  `tanggal` datetime NOT NULL,
  `jam_mengajar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `nik`, `nama_guru`, `status`, `tanggal`, `jam_mengajar`) VALUES
(1, '3507122008960002', 'RISKI ZAKARIA S.Pd', 'Hadir', '2021-08-19 10:55:59', 2),
(11, '3507122008960002', 'RISKI ZAKARIA S.Pd', 'Hadir', '2021-09-09 06:00:35', 2),
(12, '3507181008800007', 'ALIYUDIN S.Pd.I', 'Hadir', '2021-09-09 06:03:47', 3),
(13, '3507181008800007', 'ALIYUDIN S.Pd.I', 'Hadir', '2021-09-09 06:05:48', 2);

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `nik` varchar(20) NOT NULL,
  `nama_guru` varchar(40) NOT NULL,
  `kode_jabatan` varchar(3) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`nik`, `nama_guru`, `kode_jabatan`, `status`) VALUES
('350711250499901', 'M. ZABUR KHOLIF S.Pd.I.,M.Pd', 'J01', 'Menikah'),
('3507122008960002', 'RISKI ZAKARIA S.Pd', 'J05', 'Menikah'),
('3507181008800007', 'ALIYUDIN S.Pd.I', 'J02', 'Menikah'),
('3507181008900008', 'SHOLIHAN FAHMI', 'J05', 'Menikah'),
('3507182508890002', 'EVI FEBDIANA', 'J04', 'Menikah');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `kode_jabatan` varchar(3) NOT NULL,
  `nama_jabatan` varchar(20) NOT NULL,
  `gapok` int(10) NOT NULL,
  `mengajar` int(10) NOT NULL,
  `tunjangan` int(10) NOT NULL,
  `uang_makan` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`kode_jabatan`, `nama_jabatan`, `gapok`, `mengajar`, `tunjangan`, `uang_makan`) VALUES
('J01', 'Kepala Sekolah', 1000000, 20, 500000, 5000),
('J02', 'Waka Kurikulum', 200000, 0, 500000, 5000),
('J03', 'Operator', 400000, 0, 200000, 5000),
('J04', 'Kesiswaan', 300000, 0, 200000, 5000),
('J05', 'Wali Kelas', 250000, 0, 200000, 5000),
('J06', 'Kejuruan', 200000, 0, 200000, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `kode_pengajar` varchar(25) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_berakhir` time NOT NULL,
  `tahun_ajar` varchar(10) NOT NULL,
  `bulan_mulai` varchar(10) DEFAULT NULL,
  `bulan_berakhir` varchar(10) DEFAULT NULL,
  `semester` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `nik`, `kode_pengajar`, `hari`, `jam_mulai`, `jam_berakhir`, `tahun_ajar`, `bulan_mulai`, `bulan_berakhir`, `semester`) VALUES
(6, '3507182508890002', 'KP01', 'Kamis', '07:00:00', '09:00:00', '2021-2022', 'Juli', 'Desember', 'ganjil'),
(7, '3507181008800007', 'KP05', 'Jumat', '06:00:00', '09:00:00', '2021-2022', 'Juli', 'Desember', 'ganjil'),
(8, '3507181008900008', 'KP03', 'Rabu', '07:00:00', '09:00:00', '2021-2022', 'Juli', 'Desember', 'ganjil'),
(9, '3507122008960002', 'KP04', 'Kamis', '06:00:00', '08:00:00', '2021-2022', 'Juli', 'Desember', 'ganjil'),
(10, '3507122008960002', 'KP02', 'Sabtu', '12:00:00', '14:00:00', '2021-2022', 'Juli', 'Desember', 'ganjil'),
(16, '3507181008800007', 'KP03', 'Kamis', '06:00:00', '08:00:00', '2021-2022', 'Juli', 'Desember', 'ganjil');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `kode_pengajar` varchar(20) NOT NULL,
  `nama_mapel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`kode_pengajar`, `nama_mapel`) VALUES
('KP01', 'MATEMATIKA 2'),
('KP02', 'BAHASA INDONESIA'),
('KP03', 'BAHASA INGGRIS'),
('KP04', 'FISIKA'),
('KP05', 'PPKN');

-- --------------------------------------------------------

--
-- Table structure for table `master_gaji`
--

CREATE TABLE `master_gaji` (
  `id` int(11) NOT NULL,
  `tahun_bulan` varchar(15) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `absen` int(3) NOT NULL,
  `izin` int(3) NOT NULL,
  `alpa` int(3) NOT NULL,
  `jam_mengajar` int(10) NOT NULL,
  `total_potongan` int(11) NOT NULL,
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_gaji`
--

INSERT INTO `master_gaji` (`id`, `tahun_bulan`, `nik`, `absen`, `izin`, `alpa`, `jam_mengajar`, `total_potongan`, `updated_at`) VALUES
(1, '2021-08', '3507122008960002', 1, 0, 0, 2, 0, '2021-08-22'),
(13, '2021-09', '3507181008800007', 1, 0, 0, 5, 100000, '2021-09-09');

-- --------------------------------------------------------

--
-- Table structure for table `potongan`
--

CREATE TABLE `potongan` (
  `id` int(4) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `keperluan` text NOT NULL,
  `jumlah_potongan` int(8) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `potongan`
--

INSERT INTO `potongan` (`id`, `nik`, `keperluan`, `jumlah_potongan`, `tanggal`) VALUES
(3, '3507181008800007', 'Pinjam Uang', 100000, '2021-09-09 06:17:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `iduser` int(5) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(32) NOT NULL,
  `namalengkap` varchar(20) NOT NULL,
  `alamat` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `role` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`iduser`, `username`, `password`, `namalengkap`, `alamat`, `status`, `role`) VALUES
(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'YUYUN', 'Gondanglegi', 'admin', 0),
(9, 'ali', '827ccb0eea8a706c4c34a16891f84e7b', 'ALIYUDIN S.Pd.I', 'Dampit', 'guru', 1),
(10, 'lukman', '827ccb0eea8a706c4c34a16891f84e7b', 'LUKMAN EFEND', 'Gondanglegi', 'guru', 1),
(11, 'zabur', '827ccb0eea8a706c4c34a16891f84e7b', 'M. ZABUR KHOLIF S.Pd', 'Gondanglegi', 'guru', 1),
(20, 'riski', '827ccb0eea8a706c4c34a16891f84e7b', 'RISKI ZAKARIA S.Pd', 'Dampit', 'guru', 1),
(21, 'fahmi', '827ccb0eea8a706c4c34a16891f84e7b', 'SHOLIHAN FAHMI', 'Gondanglegi', 'guru', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`nik`),
  ADD KEY `kode_jabatan` (`kode_jabatan`) USING BTREE;

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`kode_jabatan`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nik` (`nik`),
  ADD KEY `kode_pengajar` (`kode_pengajar`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`kode_pengajar`);

--
-- Indexes for table `master_gaji`
--
ALTER TABLE `master_gaji`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `potongan`
--
ALTER TABLE `potongan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `master_gaji`
--
ALTER TABLE `master_gaji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `potongan`
--
ALTER TABLE `potongan`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `guru` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`kode_jabatan`) REFERENCES `jabatan` (`kode_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`kode_pengajar`) REFERENCES `mapel` (`kode_pengajar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_gaji`
--
ALTER TABLE `master_gaji`
  ADD CONSTRAINT `master_gaji_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `guru` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `potongan`
--
ALTER TABLE `potongan`
  ADD CONSTRAINT `potongan_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `guru` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
