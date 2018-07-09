-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 17 Jul 2017 pada 09.44
-- Versi Server: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasiperpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `ID` int(20) NOT NULL,
  `Nama` varchar(30) NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`ID`, `Nama`, `Username`, `Password`) VALUES
(200, 'Rizky Kurniawan Ritonga', 'rizkykr', '123space789'),
(2000, 'Putri Handayani', 'putri', 'handayani'),
(3000, 'Ibnu Ridwan', 'ibnu', 'ridwan'),
(3001, 'Anjas Tarigan', 'anjas', 'tarigan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `NIS` varchar(15) NOT NULL,
  `NamaSiswa` varchar(30) NOT NULL,
  `TempatLahir` varchar(20) NOT NULL,
  `TanggalLahir` date NOT NULL,
  `JenisKelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `Kelas` varchar(6) NOT NULL,
  `Alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`NIS`, `NamaSiswa`, `TempatLahir`, `TanggalLahir`, `JenisKelamin`, `Kelas`, `Alamat`) VALUES
('2132', 'Yolanda Triaftika', 'Tanjung Morawa', '2013-09-25', 'Perempuan', 'VI-A', 'Dsn.2 Gg. Benteng'),
('2202', 'Nayla Zahra', 'Tanjung Morawa', '2012-03-22', 'Perempuan', 'IV-B', 'Dsn. 4 Gg. Rasmi'),
('2796', 'Aditya Fahreza', 'Tanjung Morawa', '2013-08-05', 'Laki-Laki', 'V-B', 'Dsn.7 Gg. Darmo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `KodeKatalog` varchar(30) NOT NULL,
  `Judul` varchar(80) NOT NULL,
  `Pengarang` varchar(50) NOT NULL,
  `Penerbit` varchar(40) NOT NULL,
  `ISBN` varchar(30) NOT NULL,
  `Stok` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`KodeKatalog`, `Judul`, `Pengarang`, `Penerbit`, `ISBN`, `Stok`) VALUES
('001/KTM.05/A1', 'Teknik Menjahit SD', 'ASTRI', 'Dinamika Media', '978-9791472-68-5', 14),
('007/BIND.02/C3', 'Bahasa Indonesia Membuatku Cerdas', 'Bambang Trimansyah', 'PT. Gramedia', '979-462-837-9', 18),
('013/OLRG.05/B7', 'Belajar Berenang', 'David Haller', 'Pionir Jaya', '979-542-260-x', 9),
('020/CP.01/D1', 'Memegang Janji', 'Asep Tuti Turyana', 'PT. Genesindo', '979-979-9475-38-1', 18),
('027/IPA/D5', 'Mengenal Tubuh Manusia', 'Evie Azhfizar Lucia', 'PT. Lazuardi Putra Pertiwi', '979-8804-09-0', 14);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `KodePeminjaman` mediumint(9) NOT NULL,
  `NIS` varchar(15) NOT NULL,
  `KodeKatalog` varchar(30) NOT NULL,
  `TglPinjam` date NOT NULL,
  `TglKembali` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`KodePeminjaman`, `NIS`, `KodeKatalog`, `TglPinjam`, `TglKembali`) VALUES
(1, '2202', '027/IPA/D5', '2017-07-17', '2017-07-24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE `pengembalian` (
  `KodePengembalian` mediumint(9) NOT NULL,
  `KodePeminjaman` mediumint(9) NOT NULL,
  `NIS` varchar(15) NOT NULL,
  `KodeKatalog` varchar(30) NOT NULL,
  `TglPinjam` date NOT NULL,
  `TglKembali` date NOT NULL,
  `TglDikembalikan` date NOT NULL,
  `Terlambat` int(4) NOT NULL,
  `Denda` mediumint(9) NOT NULL,
  `Tagih` enum('T','Y') NOT NULL DEFAULT 'T'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengembalian`
--

INSERT INTO `pengembalian` (`KodePengembalian`, `KodePeminjaman`, `NIS`, `KodeKatalog`, `TglPinjam`, `TglKembali`, `TglDikembalikan`, `Terlambat`, `Denda`, `Tagih`) VALUES
(1, 1, '2202', '027/IPA/D5', '2017-07-15', '2017-07-16', '2017-07-17', 1, 500, 'Y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`NIS`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`KodeKatalog`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`KodePeminjaman`),
  ADD KEY `NIS` (`NIS`),
  ADD KEY `KodeKatalog` (`KodeKatalog`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`KodePengembalian`),
  ADD KEY `KodePeminjaman` (`KodePeminjaman`),
  ADD KEY `NIS` (`NIS`),
  ADD KEY `KodeKatalog` (`KodeKatalog`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3002;
--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `KodePeminjaman` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `KodePengembalian` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
