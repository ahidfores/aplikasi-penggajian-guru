-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2021 at 03:14 PM
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
(51, '3596192007980002', 'Ilmi', 'Hadir', '2021-08-04 19:25:06', 3),
(52, '3596192007980002', 'Ilmi', 'Hadir', '2021-08-04 19:27:04', 3),
(57, '3507181008800007', 'ALIYUDIN S.Pd.I', 'Izin', '2021-08-04 21:53:39', 0),
(58, '3507182508890002', 'EVI FEBDIANA', 'Izin', '2021-08-04 21:54:05', 0),
(59, '3507182508890002', 'EVI FEBDIANA', 'Izin', '2021-08-04 21:54:33', 0),
(60, '3507181008800007', 'ALIYUDIN S.Pd.I', 'Izin', '2021-08-04 21:54:41', 0),
(61, '3507182508890002', 'EVI FEBDIANA', 'Hadir', '2021-08-07 17:03:10', 5);

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
('3507122008960002', 'RISKI ZAKARIA S.Pd', 'J06', 'Menikah'),
('3507181008800007', 'ALIYUDIN S.Pd.I', 'J02', 'Menikah'),
('3507181008900008', 'SHOLIHAN FAHMI', 'J05', 'Menikah'),
('3507182009900001', 'Alfan rachmat', 'J04', 'Belum Menikah'),
('3507182508890002', 'EVI FEBDIANA', 'J04', 'Menikah'),
('3596192007980002', 'Ilmi', 'J02', 'Belum Menikah');

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
  `semester` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `nik`, `kode_pengajar`, `hari`, `jam_mulai`, `jam_berakhir`, `tahun_ajar`, `semester`) VALUES
(10, '3507181008800007', 'KP05', 'Senin', '16:00:00', '18:00:00', '2021-2022', 'genap'),
(11, '3507181008800007', 'KP05', 'Senin', '18:00:00', '20:00:00', '2022-2023', 'ganjil'),
(15, '3507181008800007', 'KP03', 'Selasa', '06:00:00', '09:00:00', '2022-2023', 'ganjil'),
(18, '3596192007980002', 'KP04', 'Rabu', '18:00:00', '21:00:00', '2021-2022', 'ganjil'),
(24, '3507182508890002', 'KP03', 'Sabtu', '15:35:00', '20:35:00', '2021-2022', 'ganjil'),
(27, '3507181008900008', 'KP02', 'Senin', '14:00:00', '16:00:00', '2021-2022', 'ganjil'),
(29, '3507182009900001', 'KP03', 'Senin', '19:00:00', '22:00:00', '2021-2022', 'genap'),
(30, '3507181008800007', 'KP02', 'Senin', '20:00:00', '22:00:00', '2021-2022', 'ganjil');

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
(11, '2021-08', '3596192007980002', 1, 0, 0, 6, 1369, '2021-08-07'),
(14, '2021-08', '3507181008800007', 2, 2, 0, 0, 0, '2021-08-09'),
(15, '2021-08', '3507182508890002', 1, 2, 0, 5, 0, '2021-08-07'),
(20, '2021-08', '3507182009900001', 1, 0, 0, 0, 0, '2021-08-09');

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
(2, '3596192007980002', 'asadasd', 123, '2021-08-07 12:32:21'),
(3, '3596192007980002', 'asadasd', 123, '2021-08-07 12:33:14'),
(4, '3596192007980002', 'Keperluan oke', 1000, '2021-08-07 12:58:52'),
(5, '3507182009900001', 'pinjam', 100000, '2021-08-09 19:28:15');

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
(12, 'fahmi', '827ccb0eea8a706c4c34a16891f84e7b', 'SHOLIHAN FAHMI', 'Gondanglegi', 'guru', 1),
(17, 'ilmi123', '827ccb0eea8a706c4c34a16891f84e7b', 'Ilmi', 'Dsn. Kebondalem - Ka', 'guru', 1),
(18, 'alfan', '827ccb0eea8a706c4c34a16891f84e7b', 'alfan rachmat', 'karangsono', 'guru', 1);

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
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `master_gaji`
--
ALTER TABLE `master_gaji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `potongan`
--
ALTER TABLE `potongan`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
