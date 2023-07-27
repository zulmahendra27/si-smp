-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 19, 2023 at 08:44 AM
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
-- Database: `db_si_akademik`
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
(1, 2, 2, '2023-05-09', 'hadir'),
(2, 3, 2, '2023-05-09', 'sakit'),
(3, 4, 2, '2023-05-09', 'izin'),
(4, 5, 2, '2023-05-09', 'sakit'),
(5, 6, 2, '2023-05-09', 'alfa'),
(6, 2, 4, '2023-05-10', 'hadir'),
(7, 3, 4, '2023-05-10', 'izin'),
(8, 4, 4, '2023-05-10', 'hadir'),
(9, 5, 4, '2023-05-10', 'sakit'),
(10, 6, 4, '2023-05-10', 'hadir'),
(11, 2, 2, '2023-05-10', 'alfa'),
(12, 3, 2, '2023-05-10', 'sakit'),
(13, 4, 2, '2023-05-10', 'hadir'),
(14, 5, 2, '2023-05-10', 'sakit'),
(15, 6, 2, '2023-05-10', 'hadir'),
(16, 2, 2, '2023-05-23', 'hadir'),
(17, 3, 2, '2023-05-23', 'izin'),
(18, 4, 2, '2023-05-23', 'sakit'),
(19, 5, 2, '2023-05-23', 'hadir'),
(20, 6, 2, '2023-05-23', 'alfa'),
(21, 2, 2, '2023-06-17', 'hadir'),
(22, 3, 2, '2023-06-17', 'hadir'),
(23, 4, 2, '2023-06-17', 'sakit'),
(24, 5, 2, '2023-06-17', 'alfa'),
(25, 6, 2, '2023-06-17', 'hadir'),
(26, 2, 4, '2023-06-17', 'hadir'),
(27, 3, 4, '2023-06-17', 'hadir'),
(28, 4, 4, '2023-06-17', 'hadir'),
(29, 5, 4, '2023-06-17', 'sakit'),
(30, 6, 4, '2023-06-17', 'hadir'),
(31, 2, 2, '2023-06-21', 'hadir'),
(32, 3, 2, '2023-06-21', 'hadir'),
(33, 4, 2, '2023-06-21', 'alfa'),
(34, 5, 2, '2023-06-21', 'hadir'),
(35, 6, 2, '2023-06-21', 'hadir'),
(36, 2, 4, '2023-06-21', 'hadir'),
(37, 3, 4, '2023-06-21', 'sakit'),
(38, 4, 4, '2023-06-21', 'hadir'),
(39, 5, 4, '2023-06-21', 'hadir'),
(40, 6, 4, '2023-06-21', 'hadir'),
(41, 2, 4, '2023-06-22', 'hadir'),
(42, 3, 4, '2023-06-22', 'hadir'),
(43, 4, 4, '2023-06-22', 'hadir'),
(44, 5, 4, '2023-06-22', 'hadir'),
(45, 6, 4, '2023-06-22', 'hadir'),
(46, 7, 3, '2023-06-22', 'hadir');

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
(1, 2, '789', 'Siti', 'L', '1980-01-22', 'Padang', 'Islam', 'Padang', 'siti@gmail.com', '3242'),
(3, 4, '879789', 'Nuraini', 'P', '1997-02-27', 'Padang', 'Islam', 'Padang', 'nuraini@gmail.com', '981902'),
(4, 5, '2839421', 'Nuraini Sitorus', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'aini@gmail.com', '82913'),
(5, 6, '8989', 'Bella', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'bella@gmail.com', '9024'),
(7, 8, '687678', 'Dani', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'dani@gmail.com', '76987'),
(8, 9, '68768', 'Ferdy Sambo', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'ferdi@gmail.com', '877'),
(10, 11, '687', 'Nurhikmah', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'nurhikmah@gmail.com', '8789-'),
(11, 12, '89080', 'Hamdan', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'hamdan@gmail.com', '728934'),
(12, 13, '829304', 'Hafidzah', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'hafidzah@gmail.com', '9423'),
(13, 14, '82304989', 'Mirwan', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'mirwan@gmail.com', '872813'),
(14, 15, '798', 'Syahreza', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'syahreza@gmail.com', '8234'),
(15, 16, '6543567', 'Rahmad', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'rahmad@gmail.com', '67312313'),
(16, 17, '', 'Situmorang', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'situmorang@gmail.com', '8423042'),
(17, 18, '62873453', 'Suparman', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'suparman@gmail.com', '2899423100'),
(22, 28, '', 'Syahbani', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'syahbani@gmail.com', '8179031'),
(23, 31, '123', 'Guru', 'L', '1980-01-01', 'Padang', 'Islam', 'Padang', 'guru@gmail.com', '081212345678'),
(25, 37, '152678712798121', 'Ahmad Ibrahim', 'L', '1978-02-27', 'Padang', 'Islam', 'Padang', 'kepalasekolah@gmail.com', '082374385628');

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
(2, 23, 'Tugas 1', 20),
(3, 23, 'Tugas 2', 10),
(4, 23, 'Tugas 3', 10),
(5, 23, 'UAS', 35);

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
(2, 'Matematika'),
(3, 'Fisika'),
(4, 'Kimia'),
(5, 'Biologi');

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
(1, 2, 3, 12),
(2, 2, 1, 23),
(3, 3, 3, 23),
(4, 4, 1, 23),
(5, 4, 5, 1);

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
(8, 2, 2, 2, 89),
(9, 3, 2, 2, 81),
(10, 4, 2, 2, 90),
(11, 5, 2, 2, 60),
(12, 6, 2, 2, 78),
(13, 2, 4, 2, 100),
(14, 3, 4, 2, 90),
(15, 4, 4, 2, 90),
(16, 5, 4, 2, 85),
(17, 6, 4, 2, 90),
(18, 2, 2, 3, 89),
(19, 3, 2, 3, 90),
(20, 4, 2, 3, 89),
(21, 5, 2, 3, 82),
(22, 6, 2, 3, 95),
(23, 2, 2, 4, 80),
(24, 3, 2, 4, 80),
(25, 4, 2, 4, 90),
(26, 5, 2, 4, 87),
(27, 6, 2, 4, 85),
(28, 2, 2, 5, 90),
(29, 3, 2, 5, 91),
(30, 4, 2, 5, 85),
(31, 5, 2, 5, 85),
(32, 6, 2, 5, 90);

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
(1, 1, 'VII.2'),
(3, 3, 'VII.3'),
(4, 10, 'VII.1'),
(5, 1, 'XI IPA 1');

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
(2, 22, 1, 2, 'Ricki', '12380', 'P', '2002-08-19', 'Bumi', 'Islam', 'Padang', 'ricki@gmail.com', '821901'),
(3, 30, 1, 2, 'Ibrahim Lubis', '123456', 'L', '2002-07-28', 'Riau', 'Islam', 'Pekanbaru', 'ibrahimlubis@gmail.com', '7128930912000'),
(4, 32, 1, 2, 'Rio', '1290', 'P', '2002-10-01', 'Padang', 'Islam', 'Padang', 'rio@gmail.com', '98123-12'),
(5, 33, 1, 3, 'Kiki', '1238900', 'L', '2002-09-03', 'Padang Panjang', 'Islam', 'Bukittinggi', 'kiki@gmail.com', '8723'),
(6, 34, 1, 3, 'Ujang', '12347890', 'L', '2001-01-13', 'Payakumbuh', 'Islam', 'Lima Puluh Kota', 'ujang@gmail.com', '82139'),
(7, 35, 3, 3, 'Hasan Fakhri', '09876', 'L', '2002-02-19', 'Padang', 'Islam', 'Padang', 'hasanfakhri@gmail.com', '872342');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(256) NOT NULL,
  `level` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `level`) VALUES
(1, 'admin', '$2y$10$hhqYYYkiRbP.6hXAjhdABeBB81dZrRdpntwpbAtLCKhaz2YIIEg7u', 'admin'),
(2, '789', '$2y$10$mBnXbGSyGtTIHL8ApCnxpeJuyCr3GcYQzdL5F8cHJBoqPBKrAavCm', 'guru'),
(4, '879789', '$2y$10$6KkLMytWFIfuWOfNoDKD8.LDz6otpEALT8P3Njc/2rVMDLK38zXAW', 'guru'),
(5, '2839421', '$2y$10$YhKd8UfxzyjzVeQq6BGf3e8mfkiHyK1854BGPInOMmeXRa5bLSiSa', 'guru'),
(6, '8989', '$2y$10$j0peKvOXWhpj4ftPfH7jkeNVcU88Ak3pJ/mZmXwhdOpaKFW6sX6yO', 'guru'),
(8, '687678', '$2y$10$pj6X2rDl6uivfa3MFYqM4Om6Y.EES/0mxQngfVLNIWkkCwi.rsJD2', 'guru'),
(9, '68768', '$2y$10$XCwvlCX.DUytbDgMa32vQekjaENCoNaJJPbpRFacuolpXfbJ4eQlO', 'guru'),
(11, '687', '$2y$10$SFSoR7j4Cje5av/xKVR0V.pcSgXqZTje1avFUze4qdyDrkF2rImBW', 'guru'),
(12, '89080', '$2y$10$uj.nq7fl0VSehPxC5QlXL.ZCw7Sl7OLNtDrSxPkgJH84gqgqTXgWm', 'guru'),
(13, '829304', '$2y$10$XTXPJ3FCyCcxRWgyXzxkkuzakDX4FhQV9kPPLQ3EqsVejZWXvVBMy', 'guru'),
(14, '82304989', '$2y$10$w1gLUqxZflwDFCD1WH/g5uwH925tlqDa799a7Jr7dC3FE65QJEWdC', 'guru'),
(15, '798', '$2y$10$JfAz5dEBs1paDRPymvqZ/ujvVPepVQjKklc4WRSeHqzASJCG0F.C.', 'guru'),
(16, '6543567', '$2y$10$EPhEhG8EAedD30Oo13YTXOIBcQXD/HmG5B/g.wIECzW.TRexTfhrq', 'guru'),
(17, 'situmorang', '$2y$10$IUjc4Q/cWTdxP8TAWWYGq.x6REjePgOeSKPp7/r4bagZaGaUFDlZm', 'guru'),
(18, '6287', '$2y$10$Rj.L6mFCxQuN5sMT1b4AHOrj4yhYom/.KYa80XDEV0O70QdEo9dKO', 'guru'),
(22, '12380', '$2y$10$XuKLo3.xkWIHaEf8Q0Gz1uHSNXrGcvCskikYRSS1rh677CmZOvZ3K', 'siswa'),
(23, 'supratman', '$2y$10$X5HCjiwHWlLHLzuttWqlceDEyK9Ayb7.037daxiKFSlBOTloyzGUS', 'wali'),
(24, 'agus', '$2y$10$SiOivBgtC/6xYSdOctgCPeEBcz.zZDszA1IOw/iU8pna1AhZg6iGu', 'wali'),
(28, 'syahbani', '$2y$10$vnNLOjxQTYCdM7zp/dXKRuG7y00noQbSLXHOz2EK2HZ9WGilkY6bO', 'guru'),
(29, '123456', '$2y$10$2JLWWCPlnGsrievo2elL0OuFuWsO7DWDMOmvNnu92QN39W1txwfjy', 'siswa'),
(30, '123456', '$2y$10$yNGpY73qP4ZWd8TjWpAet.GRaLjdVhndbVHU4aAHCOpS5BHoIxXbC', 'siswa'),
(31, '123', '$2y$10$V2qW1T2m.A1qYG3G1/1QrusTwtQUqvCGBC0EE6STTRGwWRDhTb00u', 'guru'),
(32, '1290', '$2y$10$eELFSAOCqxVaIIzFvrrfPeRBKQ1Y.ulnW61qXg3VthNkMEc9qGQBu', 'siswa'),
(33, '1238900', '$2y$10$PaJdyuPLgxvurY.Nh34Wzelvl.szV7qmfzg5hwmRehiN5Ud9JWf.S', 'siswa'),
(34, '12347890', '$2y$10$Z/eZ3dnWN9UsHQuKHZYCk.IMYTaazjTJMu5DO/mxt9.R1JHbdjLsO', 'siswa'),
(35, '09876', '$2y$10$/AfIPCRAjl/dZQI4lKo5wOCf3k/4vthTWxr7.XAVNgjaBTzwQMNga', 'siswa'),
(37, 'kepsek', '$2y$10$DClDdTL170FZtC1I7cYP2OY2VVfuE4Vd1FGTqn/CjWlXc/164p8ra', 'kepsek');

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
(2, 23, 'Supratman', 'L', '1991-02-03', 'Padang Panjang', 'Islam', 'Padang Panjang', 'supratman@gmail.com', '982092342'),
(3, 24, 'Agus', 'L', '1991-02-03', 'Padang', 'Islam', 'Padang', 'agus@gmail.com', '928342');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `jenisnilai`
--
ALTER TABLE `jenisnilai`
  ADD PRIMARY KEY (`id_jenisnilai`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `pengampu`
--
ALTER TABLE `pengampu`
  ADD PRIMARY KEY (`id_pengampu`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`);

--
-- Indexes for table `rombel`
--
ALTER TABLE `rombel`
  ADD PRIMARY KEY (`id_rombel`);

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
  MODIFY `id_absensi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `jenisnilai`
--
ALTER TABLE `jenisnilai`
  MODIFY `id_jenisnilai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengampu`
--
ALTER TABLE `pengampu`
  MODIFY `id_pengampu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `rombel`
--
ALTER TABLE `rombel`
  MODIFY `id_rombel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `wali`
--
ALTER TABLE `wali`
  MODIFY `id_wali` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
