/*
 Navicat Premium Data Transfer

 Source Server         : lokal
 Source Server Type    : MySQL
 Source Server Version : 80030
 Source Host           : localhost:3306
 Source Schema         : siperba

 Target Server Type    : MySQL
 Target Server Version : 80030
 File Encoding         : 65001

 Date: 20/07/2025 20:46:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for barang
-- ----------------------------
DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang`  (
  `id_barang` int(0) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_jenis` int(0) NOT NULL,
  `nama_barang` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `satuan` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_barang`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of barang
-- ----------------------------
INSERT INTO `barang` VALUES (14, '11.02.24.0001', 1, 'KERTAS A4 80 GSM SIDU', 'RIM');
INSERT INTO `barang` VALUES (15, '11.02.24.0002', 1, 'KERTAS A4 70 gsm SIDU', 'RIM');
INSERT INTO `barang` VALUES (16, '11.02.24.0003', 1, 'TINTA EPSON 003 YELLOW', 'PCS');
INSERT INTO `barang` VALUES (17, '11.02.24.0004', 1, 'TINTA EPSON 003 CYAN', 'PCS');
INSERT INTO `barang` VALUES (18, '11.02.24.0005', 1, 'TINTA EPSON 003 HITAM', 'PCS');
INSERT INTO `barang` VALUES (19, '11.02.24.0006', 1, 'TINTA EPSON 003 MAGENTA', 'PCS');
INSERT INTO `barang` VALUES (20, '11.02.24.0007', 1, 'PEN KENKO K-1 HITAM', 'PCS');
INSERT INTO `barang` VALUES (21, '11.02.24.0008', 1, 'PEN KENKO K-1 BIRU', 'PCS');
INSERT INTO `barang` VALUES (22, '11.02.24.0009', 2, 'TISSUE PASEO', 'PCS');
INSERT INTO `barang` VALUES (23, '11.02.24.0010', 2, 'STELLA GANTUNG', 'PCS');
INSERT INTO `barang` VALUES (24, '11.02.24.0011', 2, 'SABUN CUCI PIRING SUNLIGHT', 'PCS');
INSERT INTO `barang` VALUES (25, '11.02.24.0012', 2, 'PEMBERSIH TOILET WIPOLL', 'PCS');
INSERT INTO `barang` VALUES (26, '11.02.24.0013', 2, 'PEMBERSIH KACA CLING', 'PCS');
INSERT INTO `barang` VALUES (27, '11.02.24.0014', 3, 'LAMPU BOLA LED 7 W PANASONIC', 'PCS');
INSERT INTO `barang` VALUES (28, '11.02.24.0015', 3, 'OBAT NYAMUK SEMPROT', 'PCS');
INSERT INTO `barang` VALUES (29, '11.02.24.0016', 3, 'Publikasi Statistik Daerah Kabupaten Banjar', 'PCS');
INSERT INTO `barang` VALUES (30, '11.02.24.0017', 3, 'BOX ARSIP BPS', 'PCS');
INSERT INTO `barang` VALUES (31, '11.07.25.0001', 1, 'tes', 'buah');

-- ----------------------------
-- Table structure for barang_keluar
-- ----------------------------
DROP TABLE IF EXISTS `barang_keluar`;
CREATE TABLE `barang_keluar`  (
  `id_barang_keluar` int(0) NOT NULL AUTO_INCREMENT,
  `nomor_keluar` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_permintaan_detail` int(0) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `kondisi` enum('BAIK','RUSAK') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_barang_keluar`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of barang_keluar
-- ----------------------------
INSERT INTO `barang_keluar` VALUES (22, 'BK-2024-0001', 11, '2024-02-15', 'BAIK');
INSERT INTO `barang_keluar` VALUES (23, 'BK-2024-0002', 18, '2024-02-21', 'BAIK');
INSERT INTO `barang_keluar` VALUES (24, 'BK-2024-0003', 14, '2024-02-23', 'BAIK');

-- ----------------------------
-- Table structure for barang_masuk
-- ----------------------------
DROP TABLE IF EXISTS `barang_masuk`;
CREATE TABLE `barang_masuk`  (
  `id_barang_masuk` int(0) NOT NULL AUTO_INCREMENT,
  `id_supplier` int(0) NOT NULL,
  `id_pegawai` int(0) NOT NULL,
  `nomor_masuk` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_barang` int(0) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `jumlah` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `harga_satuan` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `total` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kondisi` enum('BAIK','RUSAK') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_barang_masuk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 83 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of barang_masuk
-- ----------------------------
INSERT INTO `barang_masuk` VALUES (57, 1, 1, 'BM-2024-0001', 14, '2024-02-02', '5', '150000', '750000', 'BAIK');
INSERT INTO `barang_masuk` VALUES (58, 1, 1, 'BM-2024-0002', 16, '2024-02-03', '2', '125000', '250000', 'BAIK');
INSERT INTO `barang_masuk` VALUES (59, 2, 1, 'BM-2024-0003', 18, '2024-02-02', '5', '125000', '625000', 'BAIK');
INSERT INTO `barang_masuk` VALUES (65, 2, 1, 'BM-2024-0009', 16, '2024-02-23', '2', '50000', '100000', 'BAIK');
INSERT INTO `barang_masuk` VALUES (74, 3, 1, 'BM-2024-0014', 20, '2024-02-23', '5', '5000', '25000', 'BAIK');
INSERT INTO `barang_masuk` VALUES (77, 3, 2, 'BM-2024-0007', 27, '2024-02-24', '1', '45000', '45000', 'RUSAK');
INSERT INTO `barang_masuk` VALUES (78, 1, 1, 'BM-2024-0016', 23, '2024-02-24', '1', '10000', '10000', 'RUSAK');
INSERT INTO `barang_masuk` VALUES (82, 1, 1, 'BM-2024-0004', 23, '2024-02-24', '5', '10000', '50000', 'RUSAK');

-- ----------------------------
-- Table structure for divisi
-- ----------------------------
DROP TABLE IF EXISTS `divisi`;
CREATE TABLE `divisi`  (
  `id_divisi` int(0) NOT NULL AUTO_INCREMENT,
  `nama_divisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_divisi`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of divisi
-- ----------------------------
INSERT INTO `divisi` VALUES (1, 'UMUM');
INSERT INTO `divisi` VALUES (2, 'DISTRIBUSI');
INSERT INTO `divisi` VALUES (3, 'PRODUKSI');
INSERT INTO `divisi` VALUES (4, 'SOSIAL');
INSERT INTO `divisi` VALUES (5, 'NERWILIS');
INSERT INTO `divisi` VALUES (6, 'IPDS');

-- ----------------------------
-- Table structure for jenis
-- ----------------------------
DROP TABLE IF EXISTS `jenis`;
CREATE TABLE `jenis`  (
  `id_jenis` int(0) NOT NULL AUTO_INCREMENT,
  `jenis_barang` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_jenis`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jenis
-- ----------------------------
INSERT INTO `jenis` VALUES (1, 'ATK');
INSERT INTO `jenis` VALUES (2, 'Alat Kebersihan');
INSERT INTO `jenis` VALUES (3, 'Perlengkapan Lain');

-- ----------------------------
-- Table structure for pegawai
-- ----------------------------
DROP TABLE IF EXISTS `pegawai`;
CREATE TABLE `pegawai`  (
  `id_pegawai` int(0) NOT NULL AUTO_INCREMENT,
  `nama_pegawai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nip` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_divisi` int(0) NOT NULL,
  PRIMARY KEY (`id_pegawai`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pegawai
-- ----------------------------
INSERT INTO `pegawai` VALUES (1, 'Sri Kartika Br.Silaban,A.Md', '199504212022032000', 1);
INSERT INTO `pegawai` VALUES (2, 'Lina Yuliana S.ST', '198907252012112001', 6);
INSERT INTO `pegawai` VALUES (3, 'Monica Raina Listya', '198601102007012000', 5);
INSERT INTO `pegawai` VALUES (4, 'Mellinda.S.Tr.Stat', '200003222202012000', 5);
INSERT INTO `pegawai` VALUES (5, 'Ellen Lelian', '199207820141020001', 2);

-- ----------------------------
-- Table structure for pengadaan
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan`;
CREATE TABLE `pengadaan`  (
  `id_pengadaan` int(0) NOT NULL AUTO_INCREMENT,
  `tanggal_surat` date NULL DEFAULT NULL,
  `nomor_surat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `id_barang` int(0) NULL DEFAULT NULL,
  `id_jenis` int(0) NULL DEFAULT NULL,
  `jumlah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `id_supplier` int(0) NULL DEFAULT NULL,
  `id_pegawai` int(0) NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengadaan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengadaan
-- ----------------------------
INSERT INTO `pengadaan` VALUES (1, '2025-07-20', '123123', 14, 1, '22', 1, 1, '1', '');
INSERT INTO `pengadaan` VALUES (2, '2025-07-20', '123123', 14, 1, '22', 1, 1, '1', 'Mengetahui.pdf');

-- ----------------------------
-- Table structure for permintaan
-- ----------------------------
DROP TABLE IF EXISTS `permintaan`;
CREATE TABLE `permintaan`  (
  `id_permintaan` int(0) NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(0) NOT NULL,
  `id_divisi` int(0) NOT NULL,
  `tgl_permintaan` date NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `no_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_permintaan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permintaan
-- ----------------------------
INSERT INTO `permintaan` VALUES (8, 4, 5, '2024-02-15', NULL, NULL);
INSERT INTO `permintaan` VALUES (9, 2, 6, '2024-02-15', NULL, NULL);
INSERT INTO `permintaan` VALUES (10, 5, 2, '2024-02-15', NULL, NULL);
INSERT INTO `permintaan` VALUES (11, 2, 1, '2025-07-10', 'Mengetahui.pdf', NULL);
INSERT INTO `permintaan` VALUES (12, 1, 1, '2025-07-10', 'Mengetahui.pdf', NULL);
INSERT INTO `permintaan` VALUES (13, 2, 1, '2025-07-10', 'Mengetahui.pdf', NULL);
INSERT INTO `permintaan` VALUES (14, 1, 2, '2025-07-10', 'Doc2.docx', NULL);
INSERT INTO `permintaan` VALUES (15, 2, 1, '2025-07-10', 'Mengetahui.pdf', NULL);
INSERT INTO `permintaan` VALUES (16, 3, 1, '2025-07-10', 'Mengetahui.pdf', NULL);
INSERT INTO `permintaan` VALUES (17, 1, 2, '2025-07-10', 'Mengetahui.pdf', NULL);
INSERT INTO `permintaan` VALUES (18, 2, 2, '2025-07-10', 'Mengetahui.pdf', NULL);
INSERT INTO `permintaan` VALUES (19, 4, 2, '2025-07-10', 'Mengetahui.pdf', NULL);
INSERT INTO `permintaan` VALUES (20, 3, 2, '2025-07-10', 'Mengetahui.pdf', NULL);
INSERT INTO `permintaan` VALUES (21, 3, 3, '2025-07-10', 'Mengetahui.pdf', NULL);

-- ----------------------------
-- Table structure for permintaan_detail
-- ----------------------------
DROP TABLE IF EXISTS `permintaan_detail`;
CREATE TABLE `permintaan_detail`  (
  `id_permintaan_detail` int(0) NOT NULL AUTO_INCREMENT,
  `id_permintaan` int(0) NOT NULL,
  `id_barang` int(0) NOT NULL,
  `jumlah` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` int(0) NOT NULL,
  PRIMARY KEY (`id_permintaan_detail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permintaan_detail
-- ----------------------------
INSERT INTO `permintaan_detail` VALUES (11, 8, 14, '1', 1);
INSERT INTO `permintaan_detail` VALUES (12, 8, 23, '2', 1);
INSERT INTO `permintaan_detail` VALUES (13, 8, 30, '5', 0);
INSERT INTO `permintaan_detail` VALUES (14, 9, 24, '1', 3);
INSERT INTO `permintaan_detail` VALUES (15, 9, 16, '1', 0);
INSERT INTO `permintaan_detail` VALUES (16, 10, 22, '1', 1);
INSERT INTO `permintaan_detail` VALUES (17, 10, 27, '2', 1);
INSERT INTO `permintaan_detail` VALUES (18, 8, 14, '14', 3);
INSERT INTO `permintaan_detail` VALUES (19, 12, 19, '2', 1);
INSERT INTO `permintaan_detail` VALUES (20, 12, 14, '3', 1);
INSERT INTO `permintaan_detail` VALUES (21, 12, 18, '1', 1);

-- ----------------------------
-- Table structure for stok
-- ----------------------------
DROP TABLE IF EXISTS `stok`;
CREATE TABLE `stok`  (
  `id_stok` int(0) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `id_barang_masuk` int(0) NOT NULL,
  `id_barang` int(0) NOT NULL,
  `stok` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kondisi` enum('BAIK','RUSAK') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_stok`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stok
-- ----------------------------
INSERT INTO `stok` VALUES (19, '2024-02-20', 57, 14, '11', 'BAIK');
INSERT INTO `stok` VALUES (20, '2024-02-23', 58, 16, '12', 'BAIK');
INSERT INTO `stok` VALUES (21, '2024-02-23', 59, 18, '10', 'BAIK');
INSERT INTO `stok` VALUES (22, '2024-02-24', 67, 30, '13', 'BAIK');
INSERT INTO `stok` VALUES (23, '2024-02-23', 69, 25, '10', 'BAIK');
INSERT INTO `stok` VALUES (24, '2024-02-16', 70, 24, '4', 'BAIK');
INSERT INTO `stok` VALUES (26, '2024-02-23', 74, 20, '5', 'BAIK');
INSERT INTO `stok` VALUES (27, '2024-02-24', 75, 27, '2', 'BAIK');
INSERT INTO `stok` VALUES (28, '2024-02-24', 78, 23, '6', 'BAIK');
INSERT INTO `stok` VALUES (29, '2024-02-24', 80, 26, '1', 'BAIK');

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id_supplier` int(0) NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_kontak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nomor_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_supplier`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES (1, 'Toko Mulia', 'Mas Jo', '083865475821', 'Martapura');
INSERT INTO `supplier` VALUES (2, 'CV Sinar', 'Mbak Pia', '0821554785421', 'Martapura');
INSERT INTO `supplier` VALUES (3, 'Toko Berkat', 'Mbak Cici', '081457894512', 'Banjarbaru');
INSERT INTO `supplier` VALUES (4, 'Salemba', 'Salemba', '087845784122', 'Banjarbaru');
INSERT INTO `supplier` VALUES (5, 'CV Diamond', 'Diamondbjm', '085311100024', 'Banjarmasin');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_pegawai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `level` enum('Admin','Kepala Bagian','Pegawai') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'tika', 'Sri Kartika Br.Silaban', 'tika@gmail.com', 'c27cd12c8034c739304c22a3a3748e39', 'Admin');
INSERT INTO `user` VALUES (3, 'abdul', 'Abdullah Riva\'i', 'abdul@gmail.com', '82027888c5bb8fc395411cb6804a066c', 'Kepala Bagian');
INSERT INTO `user` VALUES (4, 'ellen', 'Ellen Lelian', 'ellen@gmail.com', 'b692ed7c39be684f88950544e409f15c', 'Pegawai');
INSERT INTO `user` VALUES (5, 'mellinda', 'Mellinda', 'mellinda@gmail.com', '2a8a1a10906c6e2220fb437f25828bd6', 'Pegawai');
INSERT INTO `user` VALUES (6, 'putri', 'Fachmi Puspita Saputri', 'putri@gmail.com', '4093fed663717c843bea100d17fb67c8', 'Pegawai');
INSERT INTO `user` VALUES (7, 'fajar', 'Ahmad Fajar Novianto', 'fajar@gmail.com', '24bc50d85ad8fa9cda686145cf1f8aca', 'Pegawai');
INSERT INTO `user` VALUES (8, 'najma', 'Najma Hayani', 'najma@gmail.com', 'a688574d608c0157370e310f1c3ac202', 'Pegawai');

SET FOREIGN_KEY_CHECKS = 1;
