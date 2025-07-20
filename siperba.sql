-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Mar 2024 pada 15.30
-- Versi server: 10.4.8-MariaDB
-- Versi PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siperba`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(225) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `nama_barang` varchar(225) NOT NULL,
  `satuan` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_barang`, `id_jenis`, `nama_barang`, `satuan`) VALUES
(14, '11.02.24.0001', 1, 'KERTAS A4 80 GSM SIDU', 'RIM'),
(15, '11.02.24.0002', 1, 'KERTAS A4 70 gsm SIDU', 'RIM'),
(16, '11.02.24.0003', 1, 'TINTA EPSON 003 YELLOW', 'PCS'),
(17, '11.02.24.0004', 1, 'TINTA EPSON 003 CYAN', 'PCS'),
(18, '11.02.24.0005', 1, 'TINTA EPSON 003 HITAM', 'PCS'),
(19, '11.02.24.0006', 1, 'TINTA EPSON 003 MAGENTA', 'PCS'),
(20, '11.02.24.0007', 1, 'PEN KENKO K-1 HITAM', 'PCS'),
(21, '11.02.24.0008', 1, 'PEN KENKO K-1 BIRU', 'PCS'),
(22, '11.02.24.0009', 2, 'TISSUE PASEO', 'PCS'),
(23, '11.02.24.0010', 2, 'STELLA GANTUNG', 'PCS'),
(24, '11.02.24.0011', 2, 'SABUN CUCI PIRING SUNLIGHT', 'PCS'),
(25, '11.02.24.0012', 2, 'PEMBERSIH TOILET WIPOLL', 'PCS'),
(26, '11.02.24.0013', 2, 'PEMBERSIH KACA CLING', 'PCS'),
(27, '11.02.24.0014', 3, 'LAMPU BOLA LED 7 W PANASONIC', 'PCS'),
(28, '11.02.24.0015', 3, 'OBAT NYAMUK SEMPROT', 'PCS'),
(29, '11.02.24.0016', 3, 'Publikasi Statistik Daerah Kabupaten Banjar', 'PCS'),
(30, '11.02.24.0017', 3, 'BOX ARSIP BPS', 'PCS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_barang_keluar` int(11) NOT NULL,
  `nomor_keluar` varchar(225) NOT NULL,
  `id_permintaan_detail` int(11) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `kondisi` enum('BAIK','RUSAK') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_barang_keluar`, `nomor_keluar`, `id_permintaan_detail`, `tanggal_keluar`, `kondisi`) VALUES
(22, 'BK-2024-0001', 11, '2024-02-15', 'BAIK'),
(23, 'BK-2024-0002', 18, '2024-02-21', 'BAIK'),
(24, 'BK-2024-0003', 14, '2024-02-23', 'BAIK');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_barang_masuk` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `nomor_masuk` varchar(225) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `jumlah` varchar(225) NOT NULL,
  `harga_satuan` varchar(225) NOT NULL,
  `total` varchar(225) NOT NULL,
  `kondisi` enum('BAIK','RUSAK') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_barang_masuk`, `id_supplier`, `id_pegawai`, `nomor_masuk`, `id_barang`, `tanggal_masuk`, `jumlah`, `harga_satuan`, `total`, `kondisi`) VALUES
(57, 1, 1, 'BM-2024-0001', 14, '2024-02-02', '5', '150000', '750000', 'BAIK'),
(58, 1, 1, 'BM-2024-0002', 16, '2024-02-03', '2', '125000', '250000', 'BAIK'),
(59, 2, 1, 'BM-2024-0003', 18, '2024-02-02', '5', '125000', '625000', 'BAIK'),
(65, 2, 1, 'BM-2024-0009', 16, '2024-02-23', '2', '50000', '100000', 'BAIK'),
(74, 3, 1, 'BM-2024-0014', 20, '2024-02-23', '5', '5000', '25000', 'BAIK'),
(77, 3, 2, 'BM-2024-0007', 27, '2024-02-24', '1', '45000', '45000', 'RUSAK'),
(78, 1, 1, 'BM-2024-0016', 23, '2024-02-24', '1', '10000', '10000', 'RUSAK'),
(82, 1, 1, 'BM-2024-0004', 23, '2024-02-24', '5', '10000', '50000', 'RUSAK');

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` int(11) NOT NULL,
  `nama_divisi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`) VALUES
(1, 'UMUM'),
(2, 'DISTRIBUSI'),
(3, 'PRODUKSI'),
(4, 'SOSIAL'),
(5, 'NERWILIS'),
(6, 'IPDS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` int(11) NOT NULL,
  `jenis_barang` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `jenis_barang`) VALUES
(1, 'ATK'),
(2, 'Alat Kebersihan'),
(3, 'Perlengkapan Lain');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nama_pegawai` varchar(255) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `id_divisi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama_pegawai`, `nip`, `id_divisi`) VALUES
(1, 'Sri Kartika Br.Silaban,A.Md', '199504212022032000', 1),
(2, 'Lina Yuliana S.ST', '198907252012112001', 6),
(3, 'Monica Raina Listya', '198601102007012000', 5),
(4, 'Mellinda.S.Tr.Stat', '200003222202012000', 5),
(5, 'Ellen Lelian', '199207820141020001', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `permintaan`
--

CREATE TABLE `permintaan` (
  `id_permintaan` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `tgl_permintaan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `permintaan`
--

INSERT INTO `permintaan` (`id_permintaan`, `id_pegawai`, `id_divisi`, `tgl_permintaan`) VALUES
(8, 4, 5, '2024-02-15'),
(9, 2, 6, '2024-02-15'),
(10, 5, 2, '2024-02-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permintaan_detail`
--

CREATE TABLE `permintaan_detail` (
  `id_permintaan_detail` int(11) NOT NULL,
  `id_permintaan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` varchar(225) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `permintaan_detail`
--

INSERT INTO `permintaan_detail` (`id_permintaan_detail`, `id_permintaan`, `id_barang`, `jumlah`, `status`) VALUES
(11, 8, 14, '1', 1),
(12, 8, 23, '2', 1),
(13, 8, 30, '5', 0),
(14, 9, 24, '1', 3),
(15, 9, 16, '1', 0),
(16, 10, 22, '1', 1),
(17, 10, 27, '2', 1),
(18, 8, 14, '14', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok`
--

CREATE TABLE `stok` (
  `id_stok` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_barang_masuk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `stok` varchar(50) NOT NULL,
  `kondisi` enum('BAIK','RUSAK') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `stok`
--

INSERT INTO `stok` (`id_stok`, `tanggal`, `id_barang_masuk`, `id_barang`, `stok`, `kondisi`) VALUES
(19, '2024-02-20', 57, 14, '11', 'BAIK'),
(20, '2024-02-23', 58, 16, '12', 'BAIK'),
(21, '2024-02-23', 59, 18, '10', 'BAIK'),
(22, '2024-02-24', 67, 30, '13', 'BAIK'),
(23, '2024-02-23', 69, 25, '10', 'BAIK'),
(24, '2024-02-16', 70, 24, '4', 'BAIK'),
(26, '2024-02-23', 74, 20, '5', 'BAIK'),
(27, '2024-02-24', 75, 27, '2', 'BAIK'),
(28, '2024-02-24', 78, 23, '6', 'BAIK'),
(29, '2024-02-24', 80, 26, '1', 'BAIK');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `nama_kontak` varchar(255) NOT NULL,
  `nomor_hp` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `nama_kontak`, `nomor_hp`, `alamat`) VALUES
(1, 'Toko Mulia', 'Mas Jo', '083865475821', 'Martapura'),
(2, 'CV Sinar', 'Mbak Pia', '0821554785421', 'Martapura'),
(3, 'Toko Berkat', 'Mbak Cici', '081457894512', 'Banjarbaru'),
(4, 'Salemba', 'Salemba', '087845784122', 'Banjarbaru'),
(5, 'CV Diamond', 'Diamondbjm', '085311100024', 'Banjarmasin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `nama_pegawai` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('Admin','Kepala Bagian','Pegawai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `nama_pegawai`, `email`, `password`, `level`) VALUES
(1, 'tika', 'Sri Kartika Br.Silaban', 'tika@gmail.com', 'c27cd12c8034c739304c22a3a3748e39', 'Admin'),
(3, 'abdul', 'Abdullah Riva\'i', 'abdul@gmail.com', '82027888c5bb8fc395411cb6804a066c', 'Kepala Bagian'),
(4, 'ellen', 'Ellen Lelian', 'ellen@gmail.com', 'b692ed7c39be684f88950544e409f15c', 'Pegawai'),
(5, 'mellinda', 'Mellinda', 'mellinda@gmail.com', '2a8a1a10906c6e2220fb437f25828bd6', 'Pegawai'),
(6, 'putri', 'Fachmi Puspita Saputri', 'putri@gmail.com', '4093fed663717c843bea100d17fb67c8', 'Pegawai'),
(7, 'fajar', 'Ahmad Fajar Novianto', 'fajar@gmail.com', '24bc50d85ad8fa9cda686145cf1f8aca', 'Pegawai'),
(8, 'najma', 'Najma Hayani', 'najma@gmail.com', 'a688574d608c0157370e310f1c3ac202', 'Pegawai');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`);

--
-- Indeks untuk tabel `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indeks untuk tabel `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`);

--
-- Indeks untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id_permintaan`);

--
-- Indeks untuk tabel `permintaan_detail`
--
ALTER TABLE `permintaan_detail`
  ADD PRIMARY KEY (`id_permintaan_detail`);

--
-- Indeks untuk tabel `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id_stok`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id_barang_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_barang_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `id_permintaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `permintaan_detail`
--
ALTER TABLE `permintaan_detail`
  MODIFY `id_permintaan_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `stok`
--
ALTER TABLE `stok`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
