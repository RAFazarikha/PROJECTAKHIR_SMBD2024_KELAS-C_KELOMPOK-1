-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Jun 2024 pada 04.51
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectakhirperpus`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `inputAnggota` (IN `ps` VARCHAR(100), IN `p_nama` VARCHAR(100), IN `p_jenis_kelamin` ENUM('L','P'), IN `p_alamat` TINYTEXT, IN `p_telp` VARCHAR(12))   BEGIN
	DECLARE rowCount INT;
	DECLARE idBaru VARCHAR(11);
	DECLARE idAkhir INT;
	DECLARE idTerakhir VARCHAR(11);
	SELECT COUNT(*) INTO rowCount FROM anggota;
	
	IF rowCount = 0 THEN
		SET idBaru = "A0001";
	ELSE 
		SELECT id INTO idTerakhir FROM anggota ORDER BY id DESC LIMIT 1;
		SELECT RIGHT(idTerakhir, 4) INTO idAkhir;
		SET idAkhir = idAkhir + 1;
		SET idBaru = CONCAT('A', LPAD(idAkhir, 4, '0'));
		
	END IF;
	
	INSERT INTO anggota (id, pass, nama, jenis_kelamin, alamat, telp)
	VALUES (idBaru, ps, p_nama, p_jenis_kelamin, p_alamat, p_telp);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inputBuku` (IN `judul` VARCHAR(100), IN `thnTerbit` INT(11), IN `jmlh` INT(11), IN `pengarang` VARCHAR(45), IN `penerbit` VARCHAR(45))   BEGIN
	DECLARE rowCount INT;
	DECLARE idBaru VARCHAR(11);
	DECLARE idAkhir INT;
	DECLARE idTerakhir VARCHAR(11);
	SELECT COUNT(*) INTO rowCount FROM buku;
	
	IF rowCount = 0 THEN
		SET idBaru = "B0001";
	ELSE 
		SELECT id INTO idTerakhir FROM buku ORDER BY id DESC LIMIT 1;
		SELECT RIGHT(idTerakhir, 4) INTO idAkhir;
		SET idAkhir = idAkhir + 1;
		SET idBaru = CONCAT('B', LPAD(idAkhir, 4, '0'));
		
	END IF;
	
	INSERT INTO buku (id, judul, tahun_terbit, jumlah, pengarang, penerbit)
	VALUES (idBaru, judul, thnTerbit, jmlh, pengarang, penerbit);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inputPeminjaman` (IN `tglKembali` DATE, IN `idAnggota` VARCHAR(11), IN `idPetugas` VARCHAR(11), IN `idBuku` VARCHAR(11))   BEGIN
	INSERT INTO peminjaman (tanggal_pinjam, tanggal_kembali, anggota_id, petugas_id)
	VALUES (curdate(), tglKembali, idAnggota, idPetugas);
	
	INSERT INTO peminjaman_detail(buku_id)
	VALUES (idBuku);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inputPengembalian` (IN `idPeminjaman` INT(11))   BEGIN
	DECLARE idAnggota VARCHAR(11);
	DECLARE idPetugas VARCHAR(11);
	DECLARE idBuku VARCHAR(11);
	
	SELECT buku_id INTO idBuku FROM peminjaman_detail where peminjaman_id = idPeminjaman;
	
	SELECT anggota_id INTO idAnggota FROM peminjaman WHERE id = idPeminjaman;
	
	SELECT petugas_id INTO idPetugas FROM peminjaman WHERE id = idPeminjaman;
	
	INSERT INTO pengembalian (tanggal_pengembalian, peminjaman_id, anggota_id, petugas_id)
	VALUES (CURDATE(), idPeminjaman, idAnggota, idPetugas);
	
	INSERT INTO pengembalian_detail(buku_id) 
	VALUES (idBuku);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inputPetugas` (IN `userName` VARCHAR(45), IN `pw` VARCHAR(45), IN `nm` VARCHAR(100), IN `tlp` VARCHAR(12), IN `almt` TINYTEXT)   BEGIN
	DECLARE rowCount INT;
	DECLARE idBaru VARCHAR(11);
	DECLARE idAkhir INT;
	DECLARE idTerakhir VARCHAR(11);
	SELECT COUNT(*) INTO rowCount FROM petugas;
	
	IF rowCount = 0 THEN
		SET idBaru = "P0001";
	ELSE 
		SELECT id INTO idTerakhir FROM petugas ORDER BY id DESC LIMIT 1;
		SELECT RIGHT(idTerakhir, 4) INTO idAkhir;
		SET idAkhir = idAkhir + 1;
		SET idBaru = CONCAT('P', LPAD(idAkhir, 4, '0'));
		
	END IF;
	
	INSERT INTO petugas (id, username, PASSWORD, nama, telp, alamat)
	VALUES (idBaru, userName, pw, nm, tlp, almt);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `riwayatBuku` (IN `idBuku` VARCHAR(11))   begin 
	declare i int default 0;
	declare jumlahDipinjam int default 0;
	declare idPinjamAwal int;
	declare idPinjamAkhir int;
	
	select min(peminjaman.id) into idPinjamAwal from peminjaman 
	JOIN peminjaman_detail ON peminjaman.id = peminjaman_detail.peminjaman_id WHERE peminjaman_detail.buku_id = idBuku;
	
	SELECT max(peminjaman.id) INTO idPinjamAkhir FROM peminjaman 
	JOIN peminjaman_detail ON peminjaman.id = peminjaman_detail.peminjaman_id WHERE peminjaman_detail.buku_id = idBuku;
	
	select count(buku_id) into jumlahDipinjam from peminjaman_detail where buku_id = idBuku;
	
	
	DROP TEMPORARY TABLE IF EXISTS tmplAnggota;
	CREATE TEMPORARY TABLE tmplAnggota(
		idAnggota varchar(11),
		namaAnggota VARCHAR(125),
		tglPinjam date
	);
	
	while i < jumlahDipinjam and idPinjamAwal <= idPinjamAkhir do
		insert into tmplAnggota
		select anggota.id, anggota.nama, peminjaman.tanggal_pinjam
		from anggota join peminjaman on anggota.id = peminjaman.anggota_id
		join peminjaman_detail on peminjaman.id = peminjaman_detail.peminjaman_id where peminjaman_detail.buku_id = idBuku
		and peminjaman_detail.peminjaman_id = idPinjamAwal;
		
		set i = i+1;
		set idPinjamAwal = idPinjamAwal + 1;
	end while;
	select * from tmplAnggota;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id` varchar(11) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `alamat` tinytext DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id`, `pass`, `nama`, `jenis_kelamin`, `alamat`, `telp`) VALUES
('A0001', 'fcff44624c1d113318d2848afc7b3347', 'Nanda', 'P', 'Surabaya', '082143456658'),
('A0002', 'bd86590c33d72b7d6b0d69b5ba032650', 'Rora', 'P', 'Surabaya', '085125250375');

--
-- Trigger `anggota`
--
DELIMITER $$
CREATE TRIGGER `hapusAnggota` BEFORE DELETE ON `anggota` FOR EACH ROW begin
	if exists(select anggota_id from peminjaman where anggota_id = old.id) or
	exists(SELECT anggota_id FROM pengembalian WHERE anggota_id = old.id) then
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = "Anggota Tidak Dapat Dihapus Karena Terhubung Ke Tabel Lain";
	end if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` varchar(11) NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `tahun_terbit` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `pengarang` varchar(45) DEFAULT NULL,
  `penerbit` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `judul`, `tahun_terbit`, `jumlah`, `pengarang`, `penerbit`) VALUES
('B0001', 'Pulang', 2020, 7, 'tere liye', 'repupik'),
('B0002', 'pergi', 2020, 8, 'tere liye', 'repupik'),
('B0003', 'Apa Yaaa', 2020, 10, 'tere liye', 'repupik');

--
-- Trigger `buku`
--
DELIMITER $$
CREATE TRIGGER `cekJumlah` BEFORE INSERT ON `buku` FOR EACH ROW BEGIN
	IF new.jumlah < 0 THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = "Jumlah tidak boleh kurang dari 0";
	END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cekJumlahUpdate` BEFORE UPDATE ON `buku` FOR EACH ROW begin
	IF new.jumlah < 0 THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = "Jumlah tidak boleh kurang dari 0";
	END IF;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `hapusBuku` BEFORE DELETE ON `buku` FOR EACH ROW BEGIN
	IF EXISTS(SELECT buku_id FROM peminjaman_detail WHERE buku_id = old.id) OR
	EXISTS(SELECT buku_id FROM pengembalian_detail WHERE buku_id = old.id) THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = "Buku Tidak Dapat Dihapus Karena Terhubung Ke Tabel Lain";
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `daftaranggota`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `daftaranggota` (
`id` varchar(11)
,`nama` varchar(100)
,`gen` enum('L','P')
,`hp` varchar(12)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `daftarbuku`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `daftarbuku` (
`id` varchar(11)
,`judul` varchar(100)
,`jumlah` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `daftarbukuanggota`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `daftarbukuanggota` (
`id` varchar(11)
,`judul` varchar(100)
,`pengarang` varchar(45)
,`penerbit` varchar(45)
,`jumlah` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `daftarpeminjaman`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `daftarpeminjaman` (
`id` int(11)
,`tglPinjam` date
,`idAnggota` varchar(11)
,`idPetugas` varchar(11)
,`idBuku` varchar(11)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `daftarpengembalian`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `daftarpengembalian` (
`id` int(11)
,`tglPengembalian` date
,`denda` int(11)
,`idAnggota` varchar(11)
,`idPetugas` varchar(11)
,`idBuku` varchar(11)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `daftarpetugas`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `daftarpetugas` (
`idAdmin` varchar(11)
,`nama` varchar(100)
,`hp` varchar(12)
,`alamat` tinytext
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `dashboardadmin`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `dashboardadmin` (
`jumlahPetugas` bigint(21)
,`jumlahAnggota` bigint(21)
,`jumlahBuku` bigint(21)
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `anggota_id` varchar(11) DEFAULT NULL,
  `petugas_id` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `tanggal_pinjam`, `tanggal_kembali`, `anggota_id`, `petugas_id`) VALUES
(16, '2024-06-09', '2024-06-10', 'A0001', 'P0001'),
(17, '2024-06-08', '2024-06-10', 'A0001', 'P0001'),
(18, '2024-06-10', '2024-06-11', 'A0001', 'P0001'),
(21, '2024-06-11', '2024-06-12', 'A0001', 'P0001'),
(22, '2024-06-11', '2024-06-12', 'A0001', 'P0001'),
(23, '2024-06-11', '2024-06-11', 'A0001', 'P0001'),
(24, '2024-06-11', '2024-06-12', 'A0001', 'P0001'),
(25, '2024-06-11', '2024-06-12', 'A0001', 'P0001'),
(26, '2024-06-12', '2024-06-13', 'A0001', 'P0002'),
(27, '2024-06-14', '2024-06-15', 'A0001', 'P0002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman_detail`
--

CREATE TABLE `peminjaman_detail` (
  `peminjaman_id` int(11) DEFAULT NULL,
  `buku_id` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman_detail`
--

INSERT INTO `peminjaman_detail` (`peminjaman_id`, `buku_id`) VALUES
(16, 'B0001'),
(17, 'B0001'),
(18, 'B0001'),
(21, 'B0001'),
(22, 'B0001'),
(23, 'B0001'),
(24, 'B0001'),
(25, 'B0002'),
(26, 'B0002'),
(27, 'B0001');

--
-- Trigger `peminjaman_detail`
--
DELIMITER $$
CREATE TRIGGER `setelahPinjam` BEFORE INSERT ON `peminjaman_detail` FOR EACH ROW begin
	declare idBaru int;
	SELECT MAX(id) into idBaru FROM peminjaman;
	set new.peminjaman_id = idBaru;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id` int(11) NOT NULL,
  `tanggal_pengembalian` date DEFAULT NULL,
  `denda` int(11) DEFAULT NULL,
  `peminjaman_id` int(11) DEFAULT NULL,
  `anggota_id` varchar(11) DEFAULT NULL,
  `petugas_id` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengembalian`
--

INSERT INTO `pengembalian` (`id`, `tanggal_pengembalian`, `denda`, `peminjaman_id`, `anggota_id`, `petugas_id`) VALUES
(2, '2024-06-10', 0, 16, 'A0001', 'P0001'),
(4, '2024-06-11', 0, 18, 'A0001', 'P0001'),
(5, '2024-06-14', 0, 27, 'A0001', 'P0002');

--
-- Trigger `pengembalian`
--
DELIMITER $$
CREATE TRIGGER `bukuSudahKembali` BEFORE INSERT ON `pengembalian` FOR EACH ROW begin
	if exists(select peminjaman_id from pengembalian where peminjaman_id = new.peminjaman_id) then
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = "Buku Sudah Dikembalikan";
	end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `setelahPengembalian` BEFORE INSERT ON `pengembalian` FOR EACH ROW BEGIN 
	DECLARE dnda INT(11);
	DECLARE hariTelat INT(11);
	DECLARE tglJanji DATE;
	
	SELECT a.tanggal_kembali INTO tglJanji FROM peminjaman AS a JOIN pengembalian AS b
	ON a.id = new.id;
	
	
	IF new.tanggal_pengembalian < tglJanji THEN
		SET hariTelat = DATEDIFF(new.tanggal_pengembalian, tglJanji);
		SET dnda = 10000 * hariTelat;
	ELSE
		SET hariTelat = 0;
		SET dnda = 0;
	END IF;
	
	SET new.denda = dnda;
	
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian_detail`
--

CREATE TABLE `pengembalian_detail` (
  `pengembalian_id` int(11) DEFAULT NULL,
  `buku_id` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengembalian_detail`
--

INSERT INTO `pengembalian_detail` (`pengembalian_id`, `buku_id`) VALUES
(2, 'B0001'),
(4, 'B0001'),
(5, 'B0001');

--
-- Trigger `pengembalian_detail`
--
DELIMITER $$
CREATE TRIGGER `setelahKembali` BEFORE INSERT ON `pengembalian_detail` FOR EACH ROW BEGIN
	DECLARE idBaru INT;
	SELECT MAX(id) INTO idBaru FROM pengembalian;
	SET new.pengembalian_id = idBaru;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id` varchar(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `PASSWORD` varchar(45) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id`, `username`, `PASSWORD`, `nama`, `telp`, `alamat`) VALUES
('P0001', 'khaa', '3c75f759db98acef330f39751865db37', 'Rakha', '082143456658', 'Lamongan'),
('P0002', 'Ndaa', 'fcff44624c1d113318d2848afc7b3347', 'Nanda', '087654231673', 'Surabaya');

--
-- Trigger `petugas`
--
DELIMITER $$
CREATE TRIGGER `hapusPetugas` BEFORE DELETE ON `petugas` FOR EACH ROW BEGIN
	IF EXISTS(SELECT petugas_id FROM peminjaman WHERE petugas_id = old.id) OR
	EXISTS(SELECT petugas_id FROM pengembalian WHERE petugas_id = old.id) THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = "Petugas Tidak Dapat Dihapus Karena Terhubung Ke Tabel Lain";
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur untuk view `daftaranggota`
--
DROP TABLE IF EXISTS `daftaranggota`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `daftaranggota`  AS SELECT `anggota`.`id` AS `id`, `anggota`.`nama` AS `nama`, `anggota`.`jenis_kelamin` AS `gen`, `anggota`.`telp` AS `hp` FROM `anggota``anggota`  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `daftarbuku`
--
DROP TABLE IF EXISTS `daftarbuku`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `daftarbuku`  AS SELECT `buku`.`id` AS `id`, `buku`.`judul` AS `judul`, `buku`.`jumlah` AS `jumlah` FROM `buku``buku`  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `daftarbukuanggota`
--
DROP TABLE IF EXISTS `daftarbukuanggota`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `daftarbukuanggota`  AS SELECT `buku`.`id` AS `id`, `buku`.`judul` AS `judul`, `buku`.`pengarang` AS `pengarang`, `buku`.`penerbit` AS `penerbit`, `buku`.`jumlah` AS `jumlah` FROM `buku``buku`  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `daftarpeminjaman`
--
DROP TABLE IF EXISTS `daftarpeminjaman`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `daftarpeminjaman`  AS SELECT `a`.`id` AS `id`, `a`.`tanggal_pinjam` AS `tglPinjam`, `a`.`anggota_id` AS `idAnggota`, `a`.`petugas_id` AS `idPetugas`, `b`.`buku_id` AS `idBuku` FROM (`peminjaman` `a` join `peminjaman_detail` `b` on(`a`.`id` = `b`.`peminjaman_id`))  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `daftarpengembalian`
--
DROP TABLE IF EXISTS `daftarpengembalian`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `daftarpengembalian`  AS SELECT `a`.`peminjaman_id` AS `id`, `a`.`tanggal_pengembalian` AS `tglPengembalian`, `a`.`denda` AS `denda`, `a`.`anggota_id` AS `idAnggota`, `a`.`petugas_id` AS `idPetugas`, `b`.`buku_id` AS `idBuku` FROM (`pengembalian` `a` join `pengembalian_detail` `b` on(`a`.`id` = `b`.`pengembalian_id`))  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `daftarpetugas`
--
DROP TABLE IF EXISTS `daftarpetugas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `daftarpetugas`  AS SELECT `petugas`.`id` AS `idAdmin`, `petugas`.`nama` AS `nama`, `petugas`.`telp` AS `hp`, `petugas`.`alamat` AS `alamat` FROM `petugas``petugas`  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `dashboardadmin`
--
DROP TABLE IF EXISTS `dashboardadmin`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `dashboardadmin`  AS SELECT (select count(`petugas`.`id`) from `petugas`) AS `jumlahPetugas`, (select count(`anggota`.`id`) from `anggota`) AS `jumlahAnggota`, (select count(`buku`.`id`) from `buku`) AS `jumlahBuku``jumlahBuku`  ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggota_id` (`anggota_id`),
  ADD KEY `petugas_id` (`petugas_id`);

--
-- Indeks untuk tabel `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  ADD KEY `peminjaman_id` (`peminjaman_id`),
  ADD KEY `buku_id` (`buku_id`);

--
-- Indeks untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjaman_id` (`peminjaman_id`),
  ADD KEY `anggota_id` (`anggota_id`),
  ADD KEY `petugas_id` (`petugas_id`);

--
-- Indeks untuk tabel `pengembalian_detail`
--
ALTER TABLE `pengembalian_detail`
  ADD KEY `pengembalian_id` (`pengembalian_id`),
  ADD KEY `buku_id` (`buku_id`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`id`);

--
-- Ketidakleluasaan untuk tabel `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  ADD CONSTRAINT `peminjaman_detail_ibfk_1` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id`),
  ADD CONSTRAINT `peminjaman_detail_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`);

--
-- Ketidakleluasaan untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id`),
  ADD CONSTRAINT `pengembalian_ibfk_2` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`),
  ADD CONSTRAINT `pengembalian_ibfk_3` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`id`);

--
-- Ketidakleluasaan untuk tabel `pengembalian_detail`
--
ALTER TABLE `pengembalian_detail`
  ADD CONSTRAINT `pengembalian_detail_ibfk_1` FOREIGN KEY (`pengembalian_id`) REFERENCES `pengembalian` (`id`),
  ADD CONSTRAINT `pengembalian_detail_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
