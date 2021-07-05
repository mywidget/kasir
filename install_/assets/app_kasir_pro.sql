#
# TABLE STRUCTURE FOR: bahan
#

DROP TABLE IF EXISTS `bahan`;

CREATE TABLE `bahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL DEFAULT '0',
  `kunci` int(1) NOT NULL DEFAULT '0',
  `pub` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (1, '-', 0, 1, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (2, 'Flexi Cina 280', 20000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (3, 'vinil cloth', 35000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (4, 'Art Paper 150', 10000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (5, 'stiker vinil ', 80000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (11, 'Flexi Cina 260', 18000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (12, 'Art Carton 210 gsm', 10000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (13, 'stiker kromo a3+', 10000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (18, 'stiker vinil a3+', 35000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (14, 'flexi china 340', 25000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (15, 'flexi korea 440', 50000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (16, 'flexi backlite', 80000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (17, 'stiker oneway', 80000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (19, 'stiker transparan a3+', 35000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (20, 'luster ', 80000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (21, 'albatros', 80000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (32, 'kain teteron', 35000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (33, 'kain drill', 60000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (25, 'stiker cutting ', 60, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (26, 'cuting polyplex', 100, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (34, 'stiker transparan', 80000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (35, 'stempel otomatis', 80000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (36, 'stempel runaflex', 50000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (37, 'mug', 250000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (38, 'ganci', 4000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (39, 'pin', 40000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (40, 'cotton kardet', 65000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (41, ' cotton combat', 80000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (42, 'polo shirt pique', 90000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (43, 'spunbond', 6000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (44, 'tas custom', 250000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (45, 'jasa', 80000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (46, 'sablon manual', 5000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (47, 'blangko', 2000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (48, 'topi', 25000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (49, 'ncr ', 45000, 0, 1);
INSERT INTO `bahan` (`id`, `title`, `harga`, `kunci`, `pub`) VALUES (50, 'hvs', 35000, 0, 1);


#
# TABLE STRUCTURE FOR: bayar_invoice_detail
#

DROP TABLE IF EXISTS `bayar_invoice_detail`;

CREATE TABLE `bayar_invoice_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_invoice` int(11) DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jml_bayar` int(11) DEFAULT NULL,
  `kunci` int(1) NOT NULL DEFAULT '0',
  `id_byr` int(11) DEFAULT NULL,
  `jdiskon` int(11) DEFAULT '0',
  `id_uang` int(11) DEFAULT NULL,
  `id_user` int(3) DEFAULT NULL,
  `rekap` enum('Y','N') NOT NULL DEFAULT 'N',
  `setor` enum('Y','N') NOT NULL DEFAULT 'N',
  `tgl_setor` datetime DEFAULT NULL,
  `hapus` int(1) NOT NULL DEFAULT '0',
  `urutan` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: bayar_pengeluaran
#

DROP TABLE IF EXISTS `bayar_pengeluaran`;

CREATE TABLE `bayar_pengeluaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengeluaran` int(11) DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jml_bayar` int(11) DEFAULT NULL,
  `id_byr` int(11) DEFAULT NULL,
  `id_user` int(3) DEFAULT NULL,
  `setor` enum('Y','N') NOT NULL DEFAULT 'N',
  `tgl_setor` datetime DEFAULT NULL,
  `jurnal` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=39 ROW_FORMAT=FIXED;

#
# TABLE STRUCTURE FOR: cara_bayar
#

DROP TABLE IF EXISTS `cara_bayar`;

CREATE TABLE `cara_bayar` (
  `id_byr` int(2) NOT NULL AUTO_INCREMENT,
  `cara_bayar` varchar(30) DEFAULT NULL,
  `kode` varchar(5) DEFAULT NULL,
  `no_rek` varchar(20) DEFAULT NULL,
  `pemilik` varchar(40) DEFAULT NULL,
  `slug` varchar(5) DEFAULT NULL,
  `publish` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_byr`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 PACK_KEYS=0;

INSERT INTO `cara_bayar` (`id_byr`, `cara_bayar`, `kode`, `no_rek`, `pemilik`, `slug`, `publish`) VALUES (1, 'Tunai', NULL, NULL, 'CV. Pelita Kreasindo', NULL, 'Y');
INSERT INTO `cara_bayar` (`id_byr`, `cara_bayar`, `kode`, `no_rek`, `pemilik`, `slug`, `publish`) VALUES (2, 'Transfer Bank BCA', NULL, '5410 4571 31', 'MUHAMMAD GUFRON', 'BCA', 'Y');
INSERT INTO `cara_bayar` (`id_byr`, `cara_bayar`, `kode`, `no_rek`, `pemilik`, `slug`, `publish`) VALUES (9, 'Tempo', NULL, NULL, NULL, NULL, 'Y');
INSERT INTO `cara_bayar` (`id_byr`, `cara_bayar`, `kode`, `no_rek`, `pemilik`, `slug`, `publish`) VALUES (10, 'Transfer Bank Mandiri', NULL, NULL, NULL, NULL, 'N');
INSERT INTO `cara_bayar` (`id_byr`, `cara_bayar`, `kode`, `no_rek`, `pemilik`, `slug`, `publish`) VALUES (21, 'Tranfer Bank BJB', NULL, NULL, NULL, NULL, 'N');
INSERT INTO `cara_bayar` (`id_byr`, `cara_bayar`, `kode`, `no_rek`, `pemilik`, `slug`, `publish`) VALUES (19, 'Transfer Bank BRI', '002', '0062 01 002419 30 4', 'CV. Pelita Kreasindo', 'BRI', 'Y');
INSERT INTO `cara_bayar` (`id_byr`, `cara_bayar`, `kode`, `no_rek`, `pemilik`, `slug`, `publish`) VALUES (23, 'Debit', NULL, NULL, NULL, NULL, 'N');


#
# TABLE STRUCTURE FOR: data_rekap
#

DROP TABLE IF EXISTS `data_rekap`;

CREATE TABLE `data_rekap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kasir` int(11) DEFAULT NULL,
  `tgl_rekap` date NOT NULL,
  `debet` int(11) NOT NULL DEFAULT '0',
  `kredit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: hak_akses
#

DROP TABLE IF EXISTS `hak_akses`;

CREATE TABLE `hak_akses` (
  `id_level` int(3) NOT NULL AUTO_INCREMENT,
  `id_parent` int(2) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `level` varchar(20) NOT NULL,
  `publish` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_level`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `hak_akses` (`id_level`, `id_parent`, `nama`, `level`, `publish`) VALUES (1, 0, 'Administrator', 'admin', 'Y');
INSERT INTO `hak_akses` (`id_level`, `id_parent`, `nama`, `level`, `publish`) VALUES (2, 0, 'Owner', 'owner', 'Y');
INSERT INTO `hak_akses` (`id_level`, `id_parent`, `nama`, `level`, `publish`) VALUES (3, 0, 'Kasir', 'kasir', 'Y');
INSERT INTO `hak_akses` (`id_level`, `id_parent`, `nama`, `level`, `publish`) VALUES (4, 0, 'Keuangan', 'keu', 'Y');


#
# TABLE STRUCTURE FOR: info
#

DROP TABLE IF EXISTS `info`;

CREATE TABLE `info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `keywords` text,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `fb` varchar(50) DEFAULT NULL,
  `tw` varchar(50) DEFAULT NULL,
  `ig` varchar(50) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `logo_bw` varchar(255) DEFAULT NULL,
  `favicon` varchar(100) DEFAULT NULL,
  `stamp_l` varchar(100) DEFAULT NULL,
  `stamp_b` varchar(100) DEFAULT NULL,
  `warna_lunas` varchar(10) DEFAULT NULL,
  `warna_blunas` varchar(10) DEFAULT NULL,
  `tema` varchar(10) DEFAULT NULL,
  `ket` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `info` (`id`, `title`, `deskripsi`, `keywords`, `email`, `phone`, `fb`, `tw`, `ig`, `logo`, `logo_bw`, `favicon`, `stamp_l`, `stamp_b`, `warna_lunas`, `warna_blunas`, `tema`, `ket`) VALUES (1, 'Aplikasi BONE Percetakan', '<p>Aplikasi POS untuk percetakan<br></p>', '-', 'bone.percetakan@gmail.com', '089611274798', 'bone-percetakan', 'https://twitter.com/', 'bone_percetakan', 'logo.png', 'logo-ConvertImage.png', 'bone.png', 'lunas_11.png', 'belum_lunas.png', '#8E44AD', '#34495E', '#D35400', '<p>ini merupakan Halaman login aplikasi BONE PERCETAKAN &amp; DIGITAL PRINT<br></p>\r\n                                <p>Gunakan dengan bijak</p>');


#
# TABLE STRUCTURE FOR: invoice
#

DROP TABLE IF EXISTS `invoice`;

CREATE TABLE `invoice` (
  `id_invoice` int(11) NOT NULL AUTO_INCREMENT,
  `total_bayar` int(11) NOT NULL DEFAULT '0',
  `pajak` float NOT NULL DEFAULT '0',
  `pos` enum('Y','N') NOT NULL DEFAULT 'N',
  `lunas` int(1) NOT NULL DEFAULT '0',
  `tgl_trx` date DEFAULT NULL,
  `tgl_ambil` datetime DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_marketing` int(11) DEFAULT NULL,
  `tgl_update` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('baru','simpan','edit','pending','batal') DEFAULT NULL COMMENT '''baru'',''simpan'',''edit'',''pending'',''batal''',
  `oto` int(1) NOT NULL DEFAULT '0' COMMENT '0=buka,1=Edit Order,2=hapus pembayaran,3=Edit Order Lunas,4=Pending Order,5=Batal Order',
  `history` text,
  `data_json` text,
  `id_konsumen` int(11) DEFAULT NULL,
  `cetak` int(11) NOT NULL DEFAULT '0',
  `sesi_cart` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_invoice`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: invoice_detail
#

DROP TABLE IF EXISTS `invoice_detail`;

CREATE TABLE `invoice_detail` (
  `id_rincianinvoice` int(10) NOT NULL AUTO_INCREMENT,
  `id_invoice` int(11) DEFAULT NULL,
  `id_produk` int(10) NOT NULL DEFAULT '0',
  `jenis_cetakan` int(11) DEFAULT '0',
  `id_mesin` int(5) NOT NULL DEFAULT '1',
  `keterangan` text,
  `detail` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `jumlah` int(10) DEFAULT '0',
  `harga` int(20) DEFAULT '0',
  `diskon` int(11) NOT NULL DEFAULT '0',
  `satuan` varchar(10) DEFAULT NULL,
  `ukuran` varchar(20) DEFAULT NULL,
  `tot_ukuran` float(5,1) DEFAULT '0.0',
  `uk_real` varchar(20) DEFAULT '0',
  `id_bahan` int(10) DEFAULT '0',
  `catatan` text,
  `ambil` enum('Y','N') DEFAULT 'N',
  `rak` enum('Y','N') NOT NULL DEFAULT 'N',
  `id_operator` int(5) DEFAULT '0',
  `id_pengirim` int(5) DEFAULT '0',
  `id_gudang` int(5) DEFAULT '0',
  `jumlah_kirim` int(11) DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `kunci` int(1) NOT NULL DEFAULT '0',
  `token` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id_rincianinvoice`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: jenis_cetakan
#

DROP TABLE IF EXISTS `jenis_cetakan`;

CREATE TABLE `jenis_cetakan` (
  `id_jenis` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_cetakan` varchar(20) DEFAULT NULL,
  `kunci` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `pub` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_jenis`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=20;

INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (1, '-', 1, 0, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (2, 'Indoor', 0, 0, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (3, 'Outdoor', 0, 0, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (4, 'Print A3+', 0, 0, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (5, 'Offset', 0, 0, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (6, 'Konveksi', 0, 0, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (7, 'Sablon', 0, 0, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (8, 'Merchandise', 0, 0, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (13, 'Jasa', 0, 0, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (9, 'Desain', 0, 0, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (21, 'uang makan', 0, 1, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (22, 'token', 0, 1, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (18, 'Kasbon', 0, 1, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (19, 'Transport', 0, 1, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (20, 'Gaji', 0, 1, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (23, 'pulsa', 0, 1, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (24, 'beban', 0, 1, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `pub`) VALUES (25, 'Order Batal', 0, 1, 'Y');


#
# TABLE STRUCTURE FOR: konsumen
#

DROP TABLE IF EXISTS `konsumen`;

CREATE TABLE `konsumen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_member` varchar(20) DEFAULT NULL,
  `kode_unik` varchar(20) DEFAULT NULL,
  `panggilan` varchar(10) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `no_hp` varchar(17) DEFAULT NULL,
  `tgl_daftar` date DEFAULT NULL,
  `referal` varchar(20) DEFAULT NULL,
  `alamat` text,
  `perusahaan` varchar(50) DEFAULT NULL,
  `kunci` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `hapus` int(1) NOT NULL DEFAULT '0',
  `history` text,
  `max_utang` int(3) DEFAULT '3',
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_hp` (`no_hp`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `konsumen` (`id`, `id_member`, `kode_unik`, `panggilan`, `nama`, `no_hp`, `tgl_daftar`, `referal`, `alamat`, `perusahaan`, `kunci`, `status`, `hapus`, `history`, `max_utang`) VALUES (1, 'P000001', NULL, NULL, 'Default', '-', '2020-12-07', '-', '-', '-', 1, 0, 0, NULL, 3);


#
# TABLE STRUCTURE FOR: menuadmin
#

DROP TABLE IF EXISTS `menuadmin`;

CREATE TABLE `menuadmin` (
  `idmenu` int(5) NOT NULL AUTO_INCREMENT,
  `idparent` int(5) NOT NULL DEFAULT '0',
  `id_level` tinytext,
  `nama_menu` varchar(200) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `link_on` enum('Y','N') NOT NULL DEFAULT 'Y',
  `treeview` varchar(20) NOT NULL DEFAULT 'treeview',
  `classes` varchar(20) DEFAULT NULL,
  `classicon` enum('Y','N') NOT NULL DEFAULT 'Y',
  `icon` varchar(20) DEFAULT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  `level` varchar(100) DEFAULT NULL,
  `urutan` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idmenu`)
) ENGINE=MyISAM AUTO_INCREMENT=170 DEFAULT CHARSET=latin1;

INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (154, 116, '1', 'Satuan produk', 'produk/satuan', 'N', '', NULL, 'Y', '', 'Y', NULL, 5);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (148, 116, '1', 'Jenis', 'produk/jenis', 'N', '', NULL, 'Y', '', 'Y', NULL, 3);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (24, 112, '1', 'Menu Admin', 'main/menuadmin', 'N', '', '', 'N', '', 'Y', 'admin', 18);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (33, 141, '1,2,3,4', 'Pengguna', 'user', 'Y', 'treeview', 'menu5', 'N', '', 'Y', 'admin', 15);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (109, 116, '1', 'Produk', 'produk', 'N', '', 'menu5', 'N', 'file-text', 'Y', '', 2);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (112, 0, '1', 'PENGATURAN', '#pengaturan', 'Y', 'treeview', 'icon-settings', 'Y', 'cog', 'Y', '', 16);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (116, 0, '1', 'Master Data', 'master', 'Y', 'treeview', 'icon-newspaper-o', 'Y', 'file-alt', 'Y', '', 1);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (138, 112, '1', 'Level', 'level', 'Y', '', '', 'Y', '', 'N', NULL, 19);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (139, 112, '1,2', 'Aplikasi', 'main/info', 'N', '', '', 'Y', '', 'Y', NULL, 17);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (141, 0, '1,2', 'Profile', '#', 'Y', 'treeview', 'icon-user', 'Y', 'user', 'Y', NULL, 14);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (153, 116, '1', 'Bahan', 'produk/bahan', 'N', '', NULL, 'Y', '', 'Y', NULL, 4);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (147, 0, '1,2,3,4', 'Data Order', 'penjualan/order', 'N', '', 'icon-chart', 'Y', 'shopping-cart ', 'Y', NULL, 0);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (155, 0, '1,2,3,4', 'Pembukuan', 'pembukuan', 'Y', 'treeview', NULL, 'Y', 'book', 'Y', NULL, 6);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (156, 155, '1,2,3,4', 'Omset Global', 'pembukuan/omset', 'N', '', NULL, 'Y', '', 'Y', NULL, 8);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (157, 155, '1,2,3,4', 'Pengeluaran', 'pembukuan/pengeluaran', 'N', '', NULL, 'Y', '', 'Y', NULL, 11);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (158, 155, '1,2,3,4', 'Data Rekap', 'pembukuan/rekap', 'N', '', NULL, 'Y', '', 'Y', NULL, 12);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (159, 155, '1,2,3,4', 'Uang Masuk', 'pembukuan/uang_masuk', 'N', '', NULL, 'Y', '', 'Y', NULL, 10);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (160, 155, '1,2,3,4', 'Piutang', 'pembukuan/piutang', 'N', '', NULL, 'Y', '', 'Y', NULL, 7);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (162, 0, '1', 'Grafik', 'grafik', 'N', '', NULL, 'Y', 'chart-bar', 'N', NULL, 20);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (163, 155, '1,2,3,4', 'Omset Produk', 'pembukuan/omset_produk', 'N', '', NULL, 'Y', '', 'Y', NULL, 9);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (165, 0, '1', 'Backup DB', 'backup', 'N', '', NULL, 'Y', 'file', 'Y', NULL, 21);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (166, 0, '1,2,3,4', 'Konsumen', 'penjualan/konsumen_data', 'N', '', NULL, 'Y', 'user', 'Y', NULL, 13);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (167, 0, '1,2,3,4', 'Dokumentasi', 'dokumentasi', 'N', 'a', NULL, 'Y', 'file', 'N', NULL, 22);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (168, 0, '1', 'Cek Update', 'update', 'N', 'a', NULL, 'Y', 'download', 'Y', NULL, 23);


#
# TABLE STRUCTURE FOR: pengeluaran
#

DROP TABLE IF EXISTS `pengeluaran`;

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int(6) NOT NULL AUTO_INCREMENT,
  `yg_belanja` int(11) DEFAULT NULL,
  `pemberi_uang` int(11) DEFAULT NULL,
  `tgl_pengeluaran` date DEFAULT NULL,
  `tgl_rekap` date DEFAULT NULL,
  `tgl_jatuhtempo` date DEFAULT NULL,
  `id_user` int(3) DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `pos` enum('Y','N') NOT NULL DEFAULT 'N',
  `rekap` enum('Y','N') NOT NULL DEFAULT 'N',
  `lunas` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id_pengeluaran`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=43;

#
# TABLE STRUCTURE FOR: pengeluaran_detail
#

DROP TABLE IF EXISTS `pengeluaran_detail`;

CREATE TABLE `pengeluaran_detail` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengeluaran` int(11) DEFAULT NULL,
  `id_biaya` int(2) DEFAULT '0',
  `id_supplier` int(5) DEFAULT '0',
  `no_invo` varchar(25) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `jumlah` int(10) DEFAULT '0',
  `harga` int(20) DEFAULT '0',
  `satuan` varchar(10) DEFAULT NULL,
  `id_pemesan` int(5) DEFAULT '0',
  `no_order` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`no`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=55;

#
# TABLE STRUCTURE FOR: produk
#

DROP TABLE IF EXISTS `produk`;

CREATE TABLE `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis` int(5) DEFAULT '0',
  `id_bahan` varchar(200) DEFAULT '0',
  `title` varchar(50) DEFAULT NULL,
  `harga_dasar` int(11) NOT NULL DEFAULT '0',
  `diskon` int(3) NOT NULL DEFAULT '0',
  `pub` int(1) NOT NULL DEFAULT '1',
  `kunci` int(1) NOT NULL DEFAULT '0',
  `finishing` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (1, 1, '1', '-', 0, 0, 1, 1, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (2, 4, '4,12,28,13,18,19', 'Print A3+', 10000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (3, 9, '45', 'Desain', 20000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (4, 3, '2,3,11,16,14,15', 'Spanduk', 20000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (10, 4, '12', 'sertifikat', 5000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (11, 4, '12', 'kartu nama', 40000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (12, 3, '2,14,15', 'x banner', 120000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (13, 3, '2,14,15,20,21', 'roll banner', 250000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (14, 3, '2,3,33,32', 'umbul - umbul', 35000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (15, 3, '2,14,15', 'baliho', 20000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (16, 3, '2,11,14,15,16,21,20', 'banner', 250000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (17, 3, '5,17,34', 'sticker', 80, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (24, 6, '40,41,42', 'kaos panjang', 90000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (18, 4, '', 'laminasi', 3000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (19, 2, '21,20,2,14,15', 'poster', 80, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (20, 13, '', 'jasa', 50000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (21, 8, '39', 'pin', 40000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (22, 8, '38', 'ganci', 4000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (23, 8, '37', 'mug', 25000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (25, 6, '40,41,42', 'kaos pendek', 80, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (26, 6, '42,40,41', 'polo shirt', 90000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (27, 6, '44,43', 'tas', 250000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (28, 2, '25', 'cutting stiker', 60, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (29, 6, '26', 'cuting polyplex', 100, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (30, 5, '49,50', 'nota', 6250, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (31, 5, '', 'kop surat', 120000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (32, 5, '', 'map', 5000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (33, 5, '47', 'undangan blangko', 2000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (34, 5, '12', 'undangan custom', 8000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (35, 7, '46', 'sablon', 2000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (36, 4, '', 'yasin', 25000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (37, 4, '', 'buku', 25000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (38, 6, '48', 'topi', 25000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (39, 6, '33', 'kemeja', 120000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (40, 13, '', 'plang', 1500000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (41, 13, '', 'neon box', 1200000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (42, 2, '', 'pigura', 100000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (43, 8, '35,36', 'stempel', 80, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (44, 3, '5,17', 'stiker ', 102000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (45, 3, '3', 'bendera', 25000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (46, 4, '12', 'undangan', 5000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (47, 4, '12', 'kartu ', 40000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (48, 4, '12', 'cover buku', 15000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (49, 5, '49', 'surat jalan', 6500, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (50, 5, '50,4,12', 'brosur offset', 2500, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (51, 4, '50,4,12', 'leaflet', 3000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (52, 8, '50', 'thumbler', 35000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (53, 8, '50', 'plakat', 250000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (54, 8, '46', 'payung lipat', 45000, 0, 1, 0, NULL);
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `title`, `harga_dasar`, `diskon`, `pub`, `kunci`, `finishing`) VALUES (55, 8, '46', 'payung golf ', 65000, 0, 1, 0, NULL);


#
# TABLE STRUCTURE FOR: referal
#

DROP TABLE IF EXISTS `referal`;

CREATE TABLE `referal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL,
  `slug` varchar(20) DEFAULT NULL,
  `pub` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: rekap_laporan
#

DROP TABLE IF EXISTS `rekap_laporan`;

CREATE TABLE `rekap_laporan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `debit` int(11) NOT NULL,
  `kredit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: satuan
#

DROP TABLE IF EXISTS `satuan`;

CREATE TABLE `satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `satuan` varchar(20) NOT NULL,
  `pub` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 PACK_KEYS=0;

INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (1, 'Pcs', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (2, 'Box', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (3, 'Dus', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (4, 'Buah', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (5, 'Lbr', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (6, 'Roll', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (7, 'Rim', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (8, 'Lusin', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (9, 'Set', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (10, 'Buku', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (11, 'PAK', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (12, 'Plano', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (13, 'meter', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (14, 'Kg', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (15, 'Gross', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (16, 'Gal', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (17, 'Ltr', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (18, 'Btl', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (19, 'Klg', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (20, 'Batang', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (21, 'cm', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (22, 'Jerigen', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (23, 'Kali', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (24, 'Jenis', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (25, 'Paket', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (26, 'Macam', 0);
INSERT INTO `satuan` (`id`, `satuan`, `pub`) VALUES (27, 'Orang', 0);


#
# TABLE STRUCTURE FOR: supplier
#

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL AUTO_INCREMENT,
  `nama_perusahaan` varchar(100) NOT NULL,
  `jenis_usaha` varchar(100) DEFAULT NULL,
  `kontak_person` varchar(20) DEFAULT NULL,
  `jabatan` varchar(20) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `telp` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `norek` varchar(20) DEFAULT NULL,
  `publish` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`id_supplier`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=52;

#
# TABLE STRUCTURE FOR: surat_jalan
#

DROP TABLE IF EXISTS `surat_jalan`;

CREATE TABLE `surat_jalan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_gudang` int(5) NOT NULL,
  `id_invoice` int(10) NOT NULL,
  `id_pengirim` int(5) NOT NULL,
  `jml` int(10) NOT NULL,
  `alamat_kirim` text NOT NULL,
  `catatan` text NOT NULL,
  `tanggal` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tb_users
#

DROP TABLE IF EXISTS `tb_users`;

CREATE TABLE `tb_users` (
  `id_user` int(10) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL DEFAULT '0',
  `idmenu` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `id_level` varchar(100) DEFAULT '2',
  `idlevel` varchar(50) DEFAULT '1,2,3,4',
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `tgl_daftar` datetime DEFAULT NULL,
  `alamat` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `no_hp` varchar(30) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  `hak_akses` int(2) NOT NULL DEFAULT '0',
  `type_akses` varchar(50) NOT NULL DEFAULT '0',
  `id_session` varchar(100) DEFAULT NULL,
  `sesi_login` varchar(100) DEFAULT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `verify` int(1) NOT NULL DEFAULT '0',
  `app_secret` varchar(255) DEFAULT NULL,
  `last_invoice` int(11) NOT NULL DEFAULT '0',
  `last_idp` int(11) DEFAULT '0',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `tb_users` (`id_user`, `parent`, `idmenu`, `id_level`, `idlevel`, `username`, `password`, `nama_lengkap`, `tgl_daftar`, `alamat`, `email`, `no_hp`, `foto`, `level`, `aktif`, `hak_akses`, `type_akses`, `id_session`, `sesi_login`, `logo`, `verify`, `app_secret`, `last_invoice`, `last_idp`) VALUES (2, 0, '147,155,160,156,163,159,157,158,166', '3', '1,2,3,4', 'kasir', '$2y$10$Xj/9wfES/rMb.i1L5TSnHOOyGTps2n0K1MoiA4VR0OBkS5IJwLgvO', 'Kasir Satu', '2020-08-28 00:00:00', 'Banten', 'kasir1@domain.com', '0899828282', '/upload/images/user/favicon.png', 'kasir', 'Y', 0, '0', 'ca43-608e-5c5b-7b50-2085', '0f952db0131434430d82e738eac1a4e4d971a30b', NULL, 1, 'f947976c8ec41e321ddc5926333c75d8a550e5e0a17535cda6234b26ca9e8d98', 0, 0);
INSERT INTO `tb_users` (`id_user`, `parent`, `idmenu`, `id_level`, `idlevel`, `username`, `password`, `nama_lengkap`, `tgl_daftar`, `alamat`, `email`, `no_hp`, `foto`, `level`, `aktif`, `hak_akses`, `type_akses`, `id_session`, `sesi_login`, `logo`, `verify`, `app_secret`, `last_invoice`, `last_idp`) VALUES (3, 0, '147,155,160,156,163,159,157,158', '3', '1,2,3,4', 'kasir', '$2y$10$fPQugxXKLQcLcfg6KZ7n7.qS2cVsDXUsv8E7WOob.r.m2Kvp4gstS', 'neneng', '2021-01-20 09:02:01', NULL, 'kasir2@domain.com', NULL, NULL, 'kasir', 'Y', 0, '0', NULL, 'fe06sf5903d3jv7ab93jmqks7embtcsc', NULL, 0, NULL, 0, 0);
INSERT INTO `tb_users` (`id_user`, `parent`, `idmenu`, `id_level`, `idlevel`, `username`, `password`, `nama_lengkap`, `tgl_daftar`, `alamat`, `email`, `no_hp`, `foto`, `level`, `aktif`, `hak_akses`, `type_akses`, `id_session`, `sesi_login`, `logo`, `verify`, `app_secret`, `last_invoice`, `last_idp`) VALUES (1, 0, '147,116,109,148,153,154,155,160,156,163,159,157,158,166,141,33,112,139,24,138,162,165,167', '1', '1,2,3,4', NULL, '$2y$10$HYnWbIXT6l0/8JDlPifiFeg9pzCLFHhtqPP2eL85.MgkDnhENc/Ru', 'Administrator', '2021-04-22 18:57:02', NULL, 'admin@bone.se.ke', NULL, NULL, 'admin', 'Y', 0, '0', NULL, 'd979e3c3248db9d76b9b3f5e269af39a8d7b3069', NULL, 0, NULL, 0, 0);
INSERT INTO `tb_users` (`id_user`, `parent`, `idmenu`, `id_level`, `idlevel`, `username`, `password`, `nama_lengkap`, `tgl_daftar`, `alamat`, `email`, `no_hp`, `foto`, `level`, `aktif`, `hak_akses`, `type_akses`, `id_session`, `sesi_login`, `logo`, `verify`, `app_secret`, `last_invoice`, `last_idp`) VALUES (4, 0, '147,116,109,148,153,154,155,160,156,163,159,157,158,166,141,33,162,165,167', '2', '1,2,3,4', NULL, '$2y$10$u3PBLtQdyU327p5WBSUGbuv000oTjC.HfGcUslGjCN1Ut.9/1PlRK', 'John Doe', '2021-04-22 18:57:02', NULL, 'owner@domain.com', NULL, NULL, 'owner', 'Y', 0, '0', NULL, NULL, NULL, 0, NULL, 0, 0);


#
# TABLE STRUCTURE FOR: themes
#

DROP TABLE IF EXISTS `themes`;

CREATE TABLE `themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `folder` varchar(10) DEFAULT NULL,
  `pub` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `themes` (`id`, `title`, `folder`, `pub`) VALUES (1, 'dashboard', 'dashboard', 0);


