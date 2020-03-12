-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 02, 2020 at 04:53 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `mtp`
--

-- --------------------------------------------------------

--
-- Table structure for table `assesment`
--

CREATE TABLE `assesment` (
  `assesment_id` int(11) NOT NULL,
  `kriteria` varchar(40) DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assesment_personel`
--

CREATE TABLE `assesment_personel` (
  `assesment_personel_id` int(11) NOT NULL,
  `personel_id` int(11) DEFAULT NULL,
  `kriteria` varchar(40) DEFAULT NULL,
  `nilai_assesment` float DEFAULT NULL,
  `tgl_assesment` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bobot`
--

CREATE TABLE `bobot` (
  `bobot_id` int(11) NOT NULL,
  `bobot_pendidikan_pembentukan` float DEFAULT NULL,
  `bobot_pendidikan_umum` float DEFAULT NULL,
  `bobot_dikbangum` float DEFAULT NULL,
  `bobot_dikbangspers_dalam` float DEFAULT NULL,
  `bobot_dikbangspers_luar` float DEFAULT NULL,
  `bobot_pelatihan_dalam` float DEFAULT NULL,
  `bobot_pelatihan_luar` float DEFAULT NULL,
  `bobot_assesment` float DEFAULT NULL,
  `bobot_smk` float DEFAULT NULL,
  `bobot_catpers` float DEFAULT NULL,
  `bobot_prestasi` float DEFAULT NULL,
  `bobot_tipologi` float DEFAULT NULL,
  `bobot_jabatan` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bobot`
--

INSERT INTO `bobot` (`bobot_id`, `bobot_pendidikan_pembentukan`, `bobot_pendidikan_umum`, `bobot_dikbangum`, `bobot_dikbangspers_dalam`, `bobot_dikbangspers_luar`, `bobot_pelatihan_dalam`, `bobot_pelatihan_luar`, `bobot_assesment`, `bobot_smk`, `bobot_catpers`, `bobot_prestasi`, `bobot_tipologi`, `bobot_jabatan`, `created_at`) VALUES
(1, 10, 10, 10, 10, 10, 10, 10, 10, 10, 89, 890, 8, 10, '2019-11-19 07:29:42');

-- --------------------------------------------------------

--
-- Table structure for table `catpers`
--

CREATE TABLE `catpers` (
  `catpers_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `catpers`
--

INSERT INTO `catpers` (`catpers_id`, `name`, `nilai`, `urutan`, `created_at`) VALUES
(1, 'CATATAN 1', 10, NULL, '2019-11-19 08:23:52');

-- --------------------------------------------------------

--
-- Table structure for table `dikbangspers`
--

CREATE TABLE `dikbangspers` (
  `dikbangspers_id` int(11) NOT NULL,
  `frekuensi` int(11) DEFAULT NULL,
  `simbol` char(2) DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `status` enum('dalam_negri','luar_negri') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dikpol`
--

CREATE TABLE `dikpol` (
  `dikpol_id` int(11) NOT NULL,
  `dikbangum` varchar(100) DEFAULT NULL,
  `dikpol_sipp_id` int(11) DEFAULT NULL,
  `dikpol_sipp` varchar(40) DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dikpol`
--

INSERT INTO `dikpol` (`dikpol_id`, `dikbangum`, `dikpol_sipp_id`, `dikpol_sipp`, `nilai`, `urutan`, `created_at`) VALUES
(1, 'Sekolah Staf dan Pimpinan Menengah (Sespimmen)', 29, 'SESPIMMEN', 5, NULL, '2019-11-19 06:51:35'),
(2, '  Diklat Pimpinan 2 (Diklatpim 2)', 35, 'DIKLATPIM TK.II', 10, NULL, '2019-11-19 08:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `dikum`
--

CREATE TABLE `dikum` (
  `dikum_id` int(11) NOT NULL,
  `dikum` varchar(40) DEFAULT NULL,
  `dikum_sipp_id` int(11) DEFAULT NULL,
  `dikum_sipp` varchar(40) DEFAULT NULL,
  `akreditasi` varchar(20) DEFAULT NULL,
  `status` enum('dinas','non_dinas') DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dikum`
--

INSERT INTO `dikum` (`dikum_id`, `dikum`, `dikum_sipp_id`, `dikum_sipp`, `akreditasi`, `status`, `nilai`, `urutan`, `created_at`) VALUES
(1, 'Pendidikan S2 dan Akreditasi A Dinas', 15, 'S2', 'A', 'dinas', 19, NULL, '2019-11-19 06:49:38'),
(2, 'Pendidikan S2 dan Akreditasi B Dinas', 15, 'S2', 'B', 'dinas', 90, NULL, '2019-11-19 07:30:23');

-- --------------------------------------------------------

--
-- Table structure for table `eliminasi`
--

CREATE TABLE `eliminasi` (
  `eliminasi_id` int(11) NOT NULL,
  `personel_id` int(11) DEFAULT NULL,
  `pangkat` varchar(40) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `satuan` varchar(100) DEFAULT NULL,
  `angkatan` varchar(20) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(40) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`group_id`, `group_name`, `created_at`) VALUES
(1, 'SUPERADMIN', '2019-10-16 02:38:49'),
(2, 'MABES', '2019-10-16 02:39:34'),
(3, 'POLDA', '2019-10-16 02:39:37'),
(4, 'POLRES', '2019-10-16 02:39:39'),
(5, 'POLSEK', '2019-11-15 07:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan_satwil`
--

CREATE TABLE `jabatan_satwil` (
  `jabatan_satwil_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jabatan_satwil`
--

INSERT INTO `jabatan_satwil` (`jabatan_satwil_id`, `name`, `nilai`, `urutan`, `created_at`) VALUES
(1, 'BAMIN RODALPERS SSDM POLRI', 10, NULL, '2019-12-12 04:07:57');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_prestasi`
--

CREATE TABLE `jenis_prestasi` (
  `jenis_prestasi_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_tipologi`
--

CREATE TABLE `jenis_tipologi` (
  `jenis_tipologi_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jenis_tipologi`
--

INSERT INTO `jenis_tipologi` (`jenis_tipologi_id`, `name`, `nilai`, `urutan`, `created_at`) VALUES
(1, 'PAMA SSDM POLRI', 10, NULL, '2019-12-12 04:07:16');

-- --------------------------------------------------------

--
-- Table structure for table `mtp_nilai`
--

CREATE TABLE `mtp_nilai` (
  `mtp_nilai_id` int(11) NOT NULL,
  `personel_id` int(11) DEFAULT NULL,
  `pangkat` varchar(40) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `satuan` varchar(100) DEFAULT NULL,
  `angkatan` varchar(20) DEFAULT NULL,
  `nilai_pendidikan_pembentukan` float DEFAULT NULL,
  `nilai_pendidikan_umum` float DEFAULT NULL,
  `nilai_dikbangum` float DEFAULT NULL,
  `nilai_dikbangspers_dalam` float DEFAULT NULL,
  `nilai_dikbangspers_luar` float DEFAULT NULL,
  `nilai_pelatihan_dalam` float DEFAULT NULL,
  `nilai_pelatihan_luar` float DEFAULT NULL,
  `nilai_assesment` float DEFAULT NULL,
  `nilai_smk` float DEFAULT NULL,
  `nilai_catpers` float DEFAULT NULL,
  `nilai_prestasi` float DEFAULT NULL,
  `nilai_tipologi` float DEFAULT NULL,
  `nilai_jabatan` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `status_mtp` enum('draft','publish') DEFAULT NULL,
  `tahun_penilaian` int(11) DEFAULT NULL,
  `ranking_terendah` enum('0','1') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mtp_nilai`
--

INSERT INTO `mtp_nilai` (`mtp_nilai_id`, `personel_id`, `pangkat`, `jabatan`, `satuan`, `angkatan`, `nilai_pendidikan_pembentukan`, `nilai_pendidikan_umum`, `nilai_dikbangum`, `nilai_dikbangspers_dalam`, `nilai_dikbangspers_luar`, `nilai_pelatihan_dalam`, `nilai_pelatihan_luar`, `nilai_assesment`, `nilai_smk`, `nilai_catpers`, `nilai_prestasi`, `nilai_tipologi`, `nilai_jabatan`, `total`, `status_mtp`, `tahun_penilaian`, `ranking_terendah`, `created_at`) VALUES
(1, 10, 'AJUN KOMISARIS POLISI', 'PAUR SUBBAGMUTJAB BAGBINKAR ROSDM POLDA JATIM', NULL, '2010', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, 10, 0, 'draft', 2019, NULL, '2019-12-12 04:08:18'),
(2, 11, 'CAPEG', 'BAUR RENMIN SIUM POLSEK BELIMBING POLRES BANJAR POLDA KALSEL', NULL, '1970', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, 10, 0, 'draft', 2019, NULL, '2019-12-12 04:15:15'),
(3, 13, 'KOMISARIS JENDERAL POLISI', 'WAKAPOLRI', NULL, '1985', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'draft', 2019, NULL, '2019-12-19 10:04:32');

-- --------------------------------------------------------

--
-- Table structure for table `pelatihan`
--

CREATE TABLE `pelatihan` (
  `pelatihan_id` int(11) NOT NULL,
  `frekuensi` int(11) DEFAULT NULL,
  `simbol` char(2) DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `status` enum('dalam_negri','luar_negri') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `penghargaan`
--

CREATE TABLE `penghargaan` (
  `penghargaan_id` int(11) NOT NULL,
  `penghargaan` varchar(40) DEFAULT NULL,
  `penghargaan_sipp_id` int(11) DEFAULT NULL,
  `penghargaan_sipp` varchar(40) DEFAULT NULL,
  `penghargaan_tingkat_sipp_id` int(11) DEFAULT NULL,
  `penghargaan_tingkat_sipp` varchar(40) DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `penghargaan`
--

INSERT INTO `penghargaan` (`penghargaan_id`, `penghargaan`, `penghargaan_sipp_id`, `penghargaan_sipp`, `penghargaan_tingkat_sipp_id`, `penghargaan_tingkat_sipp`, `nilai`, `urutan`, `created_at`) VALUES
(1, 'Penghargaan dari Presiden (piagam) atau ', 4, 'PROMOSI JABATAN', 5, 'KAPOLDA', 7, NULL, '2019-11-19 07:41:31');

-- --------------------------------------------------------

--
-- Table structure for table `personel`
--

CREATE TABLE `personel` (
  `personel_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nrp` varchar(40) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `angkatan` varchar(20) DEFAULT NULL,
  `pangkat` varchar(40) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `status_personel` enum('aktif','naktif') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `personel`
--

INSERT INTO `personel` (`personel_id`, `user_id`, `nrp`, `name`, `angkatan`, `pangkat`, `jabatan`, `created_at`, `created_by`, `status_personel`) VALUES
(10, 23, '83121540', 'YOPPY ANGGI KRISNA', '2010', 'AJUN KOMISARIS POLISI', 'PAUR SUBBAGMUTJAB BAGBINKAR ROSDM POLDA JATIM', '2019-12-12 03:57:02', 11, 'aktif'),
(11, 24, '19123451', 'Age', '1970', 'CAPEG', 'BAUR RENMIN SIUM POLSEK BELIMBING POLRES BANJAR POLDA KALSEL', '2019-12-12 04:13:22', 1, 'aktif'),
(12, 25, '65030488', 'ARIEF SULISTYANTO', '1987', 'KOMISARIS JENDERAL POLISI', 'KALEMDIKLAT POLRI', '2019-12-19 09:45:23', 1, 'aktif'),
(13, 26, '61121010', 'ARI DONO SUKMANTO', '1985', 'KOMISARIS JENDERAL POLISI', 'WAKAPOLRI', '2019-12-19 09:45:58', 1, 'aktif'),
(14, 27, '62050930', 'MOECHGIYARTO', '1986', 'KOMISARIS JENDERAL POLISI', 'IRWASUM ITWASUM POLRI ', '2019-12-19 09:46:43', 1, 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `satuan_id` int(11) NOT NULL,
  `satuan_name` varchar(40) DEFAULT NULL,
  `kode_satuan` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`satuan_id`, `satuan_name`, `kode_satuan`, `created_at`) VALUES
(1, 'POLDA JATIM', '216610101', '2019-10-16 02:42:42'),
(2, 'BAG RENMIN', '1040102', '2019-10-16 18:43:40'),
(3, 'POLDA JATIM', '218', '2019-11-12 07:11:57'),
(4, NULL, '21819060201', '2019-12-12 04:13:22'),
(5, NULL, '121', '2019-12-19 09:45:23'),
(6, NULL, '1', '2019-12-19 09:45:58'),
(7, NULL, '101', '2019-12-19 09:46:43');

-- --------------------------------------------------------

--
-- Table structure for table `smk`
--

CREATE TABLE `smk` (
  `smk_id` int(11) NOT NULL,
  `kategori` varchar(40) DEFAULT NULL,
  `start_range` float DEFAULT NULL,
  `end_range` float DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `status` enum('smk','mentoring') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `smk`
--

INSERT INTO `smk` (`smk_id`, `kategori`, `start_range`, `end_range`, `nilai`, `status`, `created_at`) VALUES
(1, 'SMK 1', 10, 100, 10000000, 'smk', '2019-11-19 07:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `smk_personel`
--

CREATE TABLE `smk_personel` (
  `smk_personel_id` int(11) NOT NULL,
  `personel_id` int(11) DEFAULT NULL,
  `nilai_smk` float DEFAULT NULL,
  `nilai_mentoring` float DEFAULT NULL,
  `tgl_smk` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `kode_satuan` varchar(20) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `group_id`, `kode_satuan`, `username`, `password`, `token`, `created_at`) VALUES
(1, 1, '216610101', 'admin', '202cb962ac59075b964b07152d234b70', 'zxpk594gid7c2ob9q11v', '2020-01-02 02:39:57'),
(2, 1, '1040102', 'wawan', '0a000f688d85de79e3761dec6816b2a5', '', '2019-11-12 07:13:30'),
(22, 3, '218', 'age', '202cb962ac59075b964b07152d234b70', 'l6fahbp5i4276zm3r0vu', '2019-11-12 07:22:29'),
(23, NULL, '216610101', '83121540', '795e3fa81e891ff42252dad29b749ada', NULL, '2019-12-12 03:57:02'),
(24, NULL, '21819060201', '19123451', 'bef2fdce89b649ca8199ca2e1f4b41e6', NULL, '2019-12-12 04:13:22'),
(25, NULL, '121', '65030488', '72e25ce3e7f4551107c063428e2658f2', NULL, '2019-12-19 09:45:23'),
(26, NULL, '1', '61121010', '83e8a9c4d22c98418000a3a8c7f45c66', NULL, '2019-12-19 09:45:58'),
(27, NULL, '101', '62050930', 'b885dc8eb0581b42898da4d9c68ae908', NULL, '2019-12-19 09:46:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assesment`
--
ALTER TABLE `assesment`
  ADD PRIMARY KEY (`assesment_id`);

--
-- Indexes for table `assesment_personel`
--
ALTER TABLE `assesment_personel`
  ADD PRIMARY KEY (`assesment_personel_id`),
  ADD KEY `personel_id` (`personel_id`);

--
-- Indexes for table `bobot`
--
ALTER TABLE `bobot`
  ADD PRIMARY KEY (`bobot_id`);

--
-- Indexes for table `catpers`
--
ALTER TABLE `catpers`
  ADD PRIMARY KEY (`catpers_id`);

--
-- Indexes for table `dikbangspers`
--
ALTER TABLE `dikbangspers`
  ADD PRIMARY KEY (`dikbangspers_id`);

--
-- Indexes for table `dikpol`
--
ALTER TABLE `dikpol`
  ADD PRIMARY KEY (`dikpol_id`);

--
-- Indexes for table `dikum`
--
ALTER TABLE `dikum`
  ADD PRIMARY KEY (`dikum_id`);

--
-- Indexes for table `eliminasi`
--
ALTER TABLE `eliminasi`
  ADD PRIMARY KEY (`eliminasi_id`),
  ADD KEY `personel_id` (`personel_id`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `jabatan_satwil`
--
ALTER TABLE `jabatan_satwil`
  ADD PRIMARY KEY (`jabatan_satwil_id`);

--
-- Indexes for table `jenis_prestasi`
--
ALTER TABLE `jenis_prestasi`
  ADD PRIMARY KEY (`jenis_prestasi_id`);

--
-- Indexes for table `jenis_tipologi`
--
ALTER TABLE `jenis_tipologi`
  ADD PRIMARY KEY (`jenis_tipologi_id`);

--
-- Indexes for table `mtp_nilai`
--
ALTER TABLE `mtp_nilai`
  ADD PRIMARY KEY (`mtp_nilai_id`),
  ADD KEY `personel_id` (`personel_id`);

--
-- Indexes for table `pelatihan`
--
ALTER TABLE `pelatihan`
  ADD PRIMARY KEY (`pelatihan_id`);

--
-- Indexes for table `penghargaan`
--
ALTER TABLE `penghargaan`
  ADD PRIMARY KEY (`penghargaan_id`);

--
-- Indexes for table `personel`
--
ALTER TABLE `personel`
  ADD PRIMARY KEY (`personel_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`satuan_id`);

--
-- Indexes for table `smk`
--
ALTER TABLE `smk`
  ADD PRIMARY KEY (`smk_id`);

--
-- Indexes for table `smk_personel`
--
ALTER TABLE `smk_personel`
  ADD PRIMARY KEY (`smk_personel_id`),
  ADD KEY `personel_id` (`personel_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assesment`
--
ALTER TABLE `assesment`
  MODIFY `assesment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assesment_personel`
--
ALTER TABLE `assesment_personel`
  MODIFY `assesment_personel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bobot`
--
ALTER TABLE `bobot`
  MODIFY `bobot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `catpers`
--
ALTER TABLE `catpers`
  MODIFY `catpers_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dikbangspers`
--
ALTER TABLE `dikbangspers`
  MODIFY `dikbangspers_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dikpol`
--
ALTER TABLE `dikpol`
  MODIFY `dikpol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dikum`
--
ALTER TABLE `dikum`
  MODIFY `dikum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `eliminasi`
--
ALTER TABLE `eliminasi`
  MODIFY `eliminasi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jabatan_satwil`
--
ALTER TABLE `jabatan_satwil`
  MODIFY `jabatan_satwil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jenis_prestasi`
--
ALTER TABLE `jenis_prestasi`
  MODIFY `jenis_prestasi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_tipologi`
--
ALTER TABLE `jenis_tipologi`
  MODIFY `jenis_tipologi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mtp_nilai`
--
ALTER TABLE `mtp_nilai`
  MODIFY `mtp_nilai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pelatihan`
--
ALTER TABLE `pelatihan`
  MODIFY `pelatihan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penghargaan`
--
ALTER TABLE `penghargaan`
  MODIFY `penghargaan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personel`
--
ALTER TABLE `personel`
  MODIFY `personel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `satuan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `smk`
--
ALTER TABLE `smk`
  MODIFY `smk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `smk_personel`
--
ALTER TABLE `smk_personel`
  MODIFY `smk_personel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assesment_personel`
--
ALTER TABLE `assesment_personel`
  ADD CONSTRAINT `assesment_personel_ibfk_1` FOREIGN KEY (`personel_id`) REFERENCES `personel` (`personel_id`);

--
-- Constraints for table `eliminasi`
--
ALTER TABLE `eliminasi`
  ADD CONSTRAINT `eliminasi_ibfk_1` FOREIGN KEY (`personel_id`) REFERENCES `personel` (`personel_id`);

--
-- Constraints for table `mtp_nilai`
--
ALTER TABLE `mtp_nilai`
  ADD CONSTRAINT `mtp_nilai_ibfk_1` FOREIGN KEY (`personel_id`) REFERENCES `personel` (`personel_id`);

--
-- Constraints for table `personel`
--
ALTER TABLE `personel`
  ADD CONSTRAINT `personel_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `smk_personel`
--
ALTER TABLE `smk_personel`
  ADD CONSTRAINT `smk_personel_ibfk_1` FOREIGN KEY (`personel_id`) REFERENCES `personel` (`personel_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`);
