-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 19, 2023 at 04:49 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_si_akademik_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int NOT NULL,
  `id_siswa` int NOT NULL,
  `id_mapel` int NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','sakit','izin','alfa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_siswa`, `id_mapel`, `tanggal`, `status`) VALUES
(1, 1, 1, '2023-07-19', 'sakit'),
(2, 2, 1, '2023-07-19', 'izin'),
(3, 3, 1, '2023-07-19', 'hadir'),
(4, 1, 3, '2023-07-19', 'sakit'),
(5, 2, 3, '2023-07-19', 'hadir'),
(6, 3, 3, '2023-07-19', 'hadir'),
(7, 1, 2, '2023-07-19', 'hadir'),
(8, 2, 2, '2023-07-19', 'hadir'),
(9, 3, 2, '2023-07-19', 'hadir'),
(10, 1, 4, '2023-07-19', 'sakit'),
(11, 2, 4, '2023-07-19', 'hadir'),
(12, 3, 4, '2023-07-19', 'hadir');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int NOT NULL,
  `id_user` int NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama_guru` varchar(40) NOT NULL,
  `gender_guru` enum('L','P') NOT NULL,
  `tanggal_lahir_guru` date DEFAULT NULL,
  `tempat_lahir_guru` varchar(30) NOT NULL,
  `agama_guru` enum('Islam','Protestan','Katolik','Hindu','Budha','Lainnya') NOT NULL,
  `alamat_guru` varchar(100) NOT NULL,
  `email` varchar(40) NOT NULL,
  `nohp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `id_user`, `nip`, `nama_guru`, `gender_guru`, `tanggal_lahir_guru`, `tempat_lahir_guru`, `agama_guru`, `alamat_guru`, `email`, `nohp`) VALUES
(1, 39, '2001', 'Nova Halizah', 'P', '2023-07-19', 'bengkulu', 'Islam', 'belimbing', '', ''),
(2, 40, '2002', 'Fivemiwati', 'P', '2023-07-19', '', 'Islam', 'belimbing', '', ''),
(3, 41, '2003', 'Ishaq', 'L', '2023-07-19', '', 'Islam', '', '', ''),
(4, 42, '2004', 'Yogi Kurniadi', 'L', '2023-07-19', '', 'Islam', 'siteba', '', ''),
(5, 37, '627168', 'Kepala Sekolah', 'L', '1980-07-06', 'Padang', 'Islam', 'Padang', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `jenisnilai`
--

CREATE TABLE `jenisnilai` (
  `id_jenisnilai` int NOT NULL,
  `id_guru` int NOT NULL,
  `jenisnilai` varchar(30) NOT NULL,
  `bobot_nilai` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `jenisnilai`
--

INSERT INTO `jenisnilai` (`id_jenisnilai`, `id_guru`, `jenisnilai`, `bobot_nilai`) VALUES
(35, 1, 'NH', 10),
(36, 1, 'UTS', 10),
(37, 1, 'UAS', 10),
(38, 2, 'NH', 10),
(39, 2, 'UTS', 10),
(40, 2, 'UAS', 10),
(41, 3, 'NH', 10),
(42, 3, 'UTS', 10),
(43, 3, 'UAS', 10),
(44, 4, 'NH', 10),
(45, 4, 'UTS', 10),
(46, 4, 'UAS', 10);

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int NOT NULL,
  `nama_mapel` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `nama_mapel`) VALUES
(1, 'bahasa arab'),
(2, 'pai'),
(3, 'biologi'),
(4, 'olahraga');

-- --------------------------------------------------------

--
-- Table structure for table `pengampu`
--

CREATE TABLE `pengampu` (
  `id_pengampu` int NOT NULL,
  `id_mapel` int NOT NULL,
  `id_rombel` int NOT NULL,
  `id_guru` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `pengampu`
--

INSERT INTO `pengampu` (`id_pengampu`, `id_mapel`, `id_rombel`, `id_guru`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 3),
(3, 3, 1, 2),
(4, 4, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int NOT NULL,
  `id_siswa` int NOT NULL,
  `id_mapel` int NOT NULL,
  `id_jenisnilai` int NOT NULL,
  `nilai` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_siswa`, `id_mapel`, `id_jenisnilai`, `nilai`) VALUES
(97, 1, 1, 35, 80),
(98, 2, 1, 35, 90),
(99, 3, 1, 35, 80),
(100, 1, 1, 36, 80),
(101, 2, 1, 36, 80),
(102, 3, 1, 36, 80),
(103, 1, 1, 37, 80),
(104, 2, 1, 37, 90),
(105, 3, 1, 37, 80),
(106, 1, 3, 38, 80),
(107, 2, 3, 38, 90),
(108, 3, 3, 38, 80),
(109, 1, 3, 39, 80),
(110, 2, 3, 39, 90),
(111, 3, 3, 39, 90),
(112, 1, 3, 40, 80),
(113, 2, 3, 40, 80),
(114, 3, 3, 40, 90),
(115, 1, 2, 41, 90),
(116, 2, 2, 41, 90),
(117, 3, 2, 41, 80),
(118, 1, 2, 42, 80),
(119, 2, 2, 42, 80),
(120, 3, 2, 42, 90),
(121, 1, 2, 43, 80),
(122, 2, 2, 43, 80),
(123, 3, 2, 43, 80),
(124, 1, 4, 44, 90),
(125, 2, 4, 44, 90),
(126, 3, 4, 44, 80),
(127, 1, 4, 45, 90),
(128, 2, 4, 45, 80),
(129, 3, 4, 45, 90),
(130, 1, 4, 46, 90),
(131, 2, 4, 46, 80),
(132, 3, 4, 46, 80);

-- --------------------------------------------------------

--
-- Table structure for table `rombel`
--

CREATE TABLE `rombel` (
  `id_rombel` int NOT NULL,
  `walas` int NOT NULL,
  `nama_rombel` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `rombel`
--

INSERT INTO `rombel` (`id_rombel`, `walas`, `nama_rombel`) VALUES
(1, 1, 'IX1'),
(2, 3, 'IX2');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int NOT NULL,
  `id_user` int NOT NULL,
  `id_rombel` int NOT NULL,
  `id_wali` int NOT NULL,
  `nama_siswa` varchar(40) NOT NULL,
  `nisn` varchar(15) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `agama` enum('Islam','Protestan','Katolik','Hindu','Budha','Lainnya') NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `email_siswa` varchar(50) NOT NULL,
  `nohp_siswa` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `id_user`, `id_rombel`, `id_wali`, `nama_siswa`, `nisn`, `gender`, `tanggal_lahir`, `tempat_lahir`, `agama`, `alamat`, `email_siswa`, `nohp_siswa`) VALUES
(1, 48, 1, 1, 'Faiz Fairuz', '3001', 'L', '2023-07-19', '', 'Islam', '', '', ''),
(2, 49, 1, 2, 'Reyhan rudyanto', '3002', 'L', '2023-07-19', '', 'Islam', '', '', ''),
(3, 50, 1, 3, 'sukra al hamda', '3003', 'L', '2023-07-19', '', 'Islam', '', '', ''),
(4, 51, 2, 4, 'lawra fitri', '3004', 'P', '2023-07-19', '', 'Islam', '', '', ''),
(5, 52, 2, 5, 'khumairah zain', '3005', 'P', '2023-07-19', '', 'Islam', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(256) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `level`) VALUES
(1, 'admin', '$2y$10$hhqYYYkiRbP.6hXAjhdABeBB81dZrRdpntwpbAtLCKhaz2YIIEg7u', 'admin'),
(37, 'kepsek', '$2y$10$DClDdTL170FZtC1I7cYP2OY2VVfuE4Vd1FGTqn/CjWlXc/164p8ra', 'kepsek'),
(39, '2001', '$2y$10$uUg2JWoh.HVJOWWPX30hW.wS0ghcIj1p/.ceMTZG0sOAhVl5AX1.a', 'guru'),
(40, '2002', '$2y$10$llfzDnIFJ5NTroX28fHC0uNZlnlAMVc41EjBrThMTNmGCrMHGwlR.', 'guru'),
(41, '2003', '$2y$10$eGlHizetdi.3nJmHfuRkWe9rU7HDtNnVdC2v3.Zje6W2jDBLh7a/m', 'guru'),
(42, '2004', '$2y$10$XjjQqu1n38GuvSEsiTL8kOh1dvbMCqKUFhGCID9g0/FpQhrZXHfhi', 'guru'),
(43, 'ermanto', '$2y$10$Q1cYwc8yCUxF0xkXIQLoLeVJWPJ0tirf4n7V.ouDvHcoCli/pgwqO', 'wali'),
(44, 'ernawati', '$2y$10$aw0jNCL0BcTTav4FQFQLa.rIAtZs0Uusf.vlo1sbwt4f5HHyWP7/K', 'wali'),
(45, 'suhendra', '$2y$10$sNcKiNF7mFMKr6iul45pregEqxk11aAfcpxqa6h.acy086oewnjOa', 'wali'),
(46, 'sri', '$2y$10$WiMofBqf0gHbZ61h6ng2Y.NCqM7R/gTCY417uejISgnjIKrx..Z3u', 'wali'),
(47, 'wulan', '$2y$10$PAbgwrdDu0orJ7L/AXasMe3VC/cABCEQHjlR0kYyicFSs29ktuwLu', 'wali'),
(48, '3001', '$2y$10$q/6K3W4zHRdGsccasVvPB.SUAFJQIBW8m4vMOQfvewOIfRHzVxpSi', 'siswa'),
(49, '3002', '$2y$10$1xmrJ2Pvj8.AK3Gux0qChekBbWUN2OoNgsQcYtxKtdrmwv61EG6SS', 'siswa'),
(50, '3003', '$2y$10$Cz5EZJD0XPgTOEq7/KCby.xt2gcd5OmNvdQPUVZVthSYKev7OhO9G', 'siswa'),
(51, '3004', '$2y$10$s.pOzkxedjso2PTIMYYBg.s48VhFBUATqwnIkZio7cI4PrSnBKhC.', 'siswa'),
(52, '3005', '$2y$10$EyY1Mgclora7DisqYHUUS.jIAAqfxDHAWAOHA38.xaNrcwxgNXYrO', 'siswa');

-- --------------------------------------------------------

--
-- Table structure for table `wali`
--

CREATE TABLE `wali` (
  `id_wali` int NOT NULL,
  `id_user` int NOT NULL,
  `nama_wali` varchar(40) NOT NULL,
  `gender_wali` enum('L','P') NOT NULL,
  `tanggal_lahir_wali` date DEFAULT NULL,
  `tempat_lahir_wali` varchar(30) NOT NULL,
  `agama_wali` enum('Islam','Protestan','Katolik','Hindu','Budha','Lainnya') NOT NULL,
  `alamat_wali` varchar(100) NOT NULL,
  `email_wali` varchar(50) NOT NULL,
  `nohp_wali` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `wali`
--

INSERT INTO `wali` (`id_wali`, `id_user`, `nama_wali`, `gender_wali`, `tanggal_lahir_wali`, `tempat_lahir_wali`, `agama_wali`, `alamat_wali`, `email_wali`, `nohp_wali`) VALUES
(1, 43, 'ermanto', 'L', '2023-07-19', '', 'Islam', '', '', ''),
(2, 44, 'ernawati', 'P', '2023-07-19', '', 'Islam', '', '', ''),
(3, 45, 'suhendra', 'L', '2023-07-19', '', 'Islam', '', '', ''),
(4, 46, 'sri', 'P', '2023-07-19', '', 'Islam', '', '', ''),
(5, 47, 'wulandari', 'P', '2023-07-19', '', 'Islam', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `FK_absensi_mapel` (`id_mapel`),
  ADD KEY `FK_absensi_siswa` (`id_siswa`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `jenisnilai`
--
ALTER TABLE `jenisnilai`
  ADD PRIMARY KEY (`id_jenisnilai`),
  ADD KEY `FK_jenisnilai_guru` (`id_guru`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `pengampu`
--
ALTER TABLE `pengampu`
  ADD PRIMARY KEY (`id_pengampu`),
  ADD KEY `FK_pengampu_guru` (`id_guru`),
  ADD KEY `FK_pengampu_mapel` (`id_mapel`),
  ADD KEY `FK_pengampu_rombel` (`id_rombel`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `FK_penilaian_jenisnilai` (`id_jenisnilai`),
  ADD KEY `FK_penilaian_mapel` (`id_mapel`),
  ADD KEY `FK_penilaian_siswa` (`id_siswa`);

--
-- Indexes for table `rombel`
--
ALTER TABLE `rombel`
  ADD PRIMARY KEY (`id_rombel`),
  ADD KEY `FK_rombel_guru` (`walas`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `wali`
--
ALTER TABLE `wali`
  ADD PRIMARY KEY (`id_wali`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jenisnilai`
--
ALTER TABLE `jenisnilai`
  MODIFY `id_jenisnilai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengampu`
--
ALTER TABLE `pengampu`
  MODIFY `id_pengampu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `rombel`
--
ALTER TABLE `rombel`
  MODIFY `id_rombel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `wali`
--
ALTER TABLE `wali`
  MODIFY `id_wali` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `FK_absensi_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_absensi_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jenisnilai`
--
ALTER TABLE `jenisnilai`
  ADD CONSTRAINT `FK_jenisnilai_guru` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengampu`
--
ALTER TABLE `pengampu`
  ADD CONSTRAINT `FK_pengampu_guru` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_pengampu_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_pengampu_rombel` FOREIGN KEY (`id_rombel`) REFERENCES `rombel` (`id_rombel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `FK_penilaian_jenisnilai` FOREIGN KEY (`id_jenisnilai`) REFERENCES `jenisnilai` (`id_jenisnilai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_penilaian_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_penilaian_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rombel`
--
ALTER TABLE `rombel`
  ADD CONSTRAINT `FK_rombel_guru` FOREIGN KEY (`walas`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
