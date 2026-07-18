-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2026 at 06:42 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kkn_webgis`
--

-- --------------------------------------------------------

--
-- Table structure for table `arsitek_rumah`
--

CREATE TABLE `arsitek_rumah` (
  `id_arsitek` int(11) NOT NULL,
  `id_rumah` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `budaya`
--

CREATE TABLE `budaya` (
  `id_budaya` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas_wisata`
--

CREATE TABLE `fasilitas_wisata` (
  `id_fasilitas` int(11) NOT NULL,
  `id_jorong` int(11) DEFAULT NULL,
  `id_kampung` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `kategori` enum('Pendidikan','Pusat Informasi','Umum') DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas_wisata`
--

INSERT INTO `fasilitas_wisata` (`id_fasilitas`, `id_jorong`, `id_kampung`, `nama`, `kategori`, `deskripsi`) VALUES
(1, 1, 1, 'Tempat Berkaul Adat Nagari Sijunjung', 'Umum', 'Tempat Berkaul Adat Nagari Sijunjung merupakan sarana yang digunakan untuk pelaksanaan upacara dan kegiatan adat masyarakat Nagari Sijunjung. Tempat ini menjadi pusat penyelenggaraan tradisi, musyawarah, serta berbagai kegiatan budaya yang berperan penting dalam menjaga dan melestarikan nilai-nilai adat serta mempererat kebersamaan masyarakat.'),
(2, 1, 1, 'Pangkalan LPG 3 Kg', NULL, 'Pangkalan LPG 3 Kg CV. M. Rizki merupakan fasilitas distribusi gas LPG bersubsidi yang melayani kebutuhan energi rumah tangga masyarakat sekitar. Keberadaan pangkalan ini berperan penting dalam memastikan ketersediaan dan kemudahan akses masyarakat terhadap kebutuhan bahan bakar rumah tangga.'),
(3, 1, 1, 'Pendidikan Anak Usia Dini KB Ranah Bundo', 'Pendidikan', 'PAUD KB Ranah Bundo adalah lembaga pendidikan anak usia dini yang berlokasi di Jorong Padang Ranah, Nagari Sijunjung, yang berfungsi sebagai tempat pembinaan dan pengembangan potensi anak sejak usia dini melalui kegiatan belajar dan bermain.'),
(4, 1, 1, 'Warung Evi', 'Umum', 'Warung Evi merupakan salah satu usaha kecil masyarakat yang menyediakan berbagai kebutuhan sehari-hari serta makanan dan minuman bagi warga sekitar. Warung ini juga menjadi tempat singgah dan berinteraksi bagi masyarakat setempat sehingga memiliki peran penting dalam mendukung aktivitas ekonomi dan sosial di lingkungan sekitar.'),
(5, 1, 1, 'Sekretariat Home Stay', 'Pusat Informasi', 'Sekretariat Home Stay Perkampungan Adat Nagari Sijunjung merupakan fasilitas yang berfungsi sebagai pusat informasi dan pengelolaan homestay bagi wisatawan yang berkunjung ke kawasan Perkampungan Adat Nagari Sijunjung. Tempat ini mendukung pengembangan pariwisata berbasis budaya serta menjadi sarana koordinasi dalam pelayanan wisata di kawasan adat.'),
(6, 1, 1, 'Balai Nikah', NULL, 'Balai Nikah Nagari Sijunjung merupakan fasilitas yang digunakan sebagai tempat pelaksanaan dan pelayanan administrasi pernikahan bagi masyarakat. Gedung ini juga berfungsi sebagai sarana kegiatan keagamaan dan sosial yang mendukung pelayanan kepada masyarakat di Nagari Sijunjung.'),
(7, 1, 1, 'Lapangan Voli', 'Umum', 'Lapangan voli ini merupakan salah satu sarana olahraga yang digunakan oleh masyarakat untuk kegiatan olahraga, rekreasi, serta penyelenggaraan berbagai kegiatan sosial dan perlombaan. Keberadaan lapangan ini mendukung aktivitas fisik serta mempererat interaksi dan kebersamaan antarwarga di lingkungan sekitar.'),
(8, 1, 1, 'Azizah Motor', NULL, 'Warung dan bengkel ini merupakan salah satu usaha masyarakat yang menyediakan kebutuhan sehari-hari serta layanan perbaikan dan perawatan kendaraan bermotor. Keberadaannya mendukung aktivitas ekonomi lokal dan memberikan kemudahan bagi masyarakat dalam memperoleh barang kebutuhan serta jasa servis kendaraan di lingkungan sekitar.'),
(9, 1, 1, 'Sekretariat Desa Wisata Perkampungan Adat', 'Umum', 'Sekretariat Desa Wisata Perkampungan Adat Nagari Sijunjung merupakan pusat informasi dan koordinasi pengelolaan kawasan wisata budaya di Nagari Sijunjung. Sekretariat ini berfungsi sebagai sarana administrasi, promosi, serta pelayanan bagi wisatawan, sekaligus mendukung upaya pelestarian nilai-nilai adat dan budaya setempat.'),
(10, 2, 1, 'Sekretariat Kampung Adat', 'Pusat Informasi', 'Sekretariat Kampung Adat Mendunia Jorong Tanah Bato merupakan pusat kegiatan dan koordinasi dalam pengelolaan kawasan kampung adat. Bangunan ini berfungsi sebagai sarana pelestarian budaya, tempat administrasi, serta pusat informasi bagi masyarakat dan wisatawan yang berkunjung ke kawasan Perkampungan Adat Nagari Sijunjung.'),
(11, 2, 1, 'Rumah Tahfiz', 'Pendidikan', 'Rumah Tahfiz merupakan lembaga pendidikan keagamaan yang berfokus pada pembelajaran, pembinaan, dan penghafalan Al-Qur\'an bagi anak-anak dan masyarakat. Keberadaannya berperan dalam meningkatkan pendidikan agama serta membentuk generasi yang berakhlak dan memiliki pemahaman keislaman yang baik.'),
(12, 2, 1, 'Masjid no.88', 'Umum', 'Masjid No. 88 merupakan salah satu sarana ibadah yang digunakan oleh masyarakat untuk melaksanakan kegiatan keagamaan, seperti salat berjamaah, pengajian, dan kegiatan sosial keislaman lainnya. Keberadaan masjid ini menjadi pusat pembinaan spiritual serta mempererat hubungan dan kebersamaan antarwarga di lingkungan sekitar.'),
(13, 2, 1, 'Masjid Al-Furqon', 'Umum', 'Masjid Al-Furqon merupakan salah satu sarana ibadah dan pusat kegiatan keagamaan masyarakat setempat. Masjid ini digunakan untuk pelaksanaan salat berjamaah, pengajian, pendidikan keagamaan, serta berbagai kegiatan sosial kemasyarakatan yang mendukung pembinaan spiritual dan mempererat ukhuwah antarwarga.'),
(14, 1, 1, 'Surau Mufellah', 'Umum', 'Surau Mufellah merupakan salah satu sarana ibadah masyarakat yang digunakan untuk melaksanakan salat berjamaah, kegiatan pengajian, serta berbagai aktivitas keagamaan lainnya. Keberadaan surau ini berperan penting sebagai pusat pembinaan spiritual dan mempererat hubungan sosial serta kebersamaan masyarakat di sekitarnya.'),
(15, 1, 1, 'Balai adat nagari SIJUNJUNG', 'Umum', 'Balai Adat Nagari Sijunjung merupakan bangunan bersejarah yang berfungsi sebagai pusat kegiatan adat dan musyawarah masyarakat Nagari Sijunjung. Balai adat ini digunakan untuk penyelenggaraan berbagai upacara adat, pertemuan ninik mamak, serta kegiatan pelestarian budaya yang menjadi identitas dan warisan budaya masyarakat setempat.'),
(16, 1, 1, 'Masjid Mustaqim', 'Umum', 'Masjid Mustaqim merupakan salah satu sarana ibadah masyarakat yang digunakan untuk melaksanakan salat berjamaah, kegiatan pengajian, serta berbagai aktivitas keagamaan lainnya. Keberadaan surau ini berperan penting sebagai pusat pembinaan spiritual dan mempererat hubungan sosial serta kebersamaan masyarakat di sekitarnya.'),
(17, 1, 1, 'Kedai Oriza', 'Umum', 'Kedai Oriza merupakan salah satu usaha kecil masyarakat yang menyediakan berbagai kebutuhan sehari-hari serta makanan dan minuman bagi warga sekitar. Warung ini juga menjadi tempat singgah dan berinteraksi bagi masyarakat setempat sehingga memiliki peran penting dalam mendukung aktivitas ekonomi dan sosial di lingkungan sekitar.'),
(18, 2, 1, 'Bengkel Motor Fauzan', 'Umum', 'Bengkel Motor Fauzan merupakan usaha jasa yang bergerak di bidang perbaikan dan perawatan kendaraan bermotor. Bengkel ini menyediakan berbagai layanan servis serta perbaikan kendaraan bagi masyarakat sekitar, sehingga mendukung mobilitas dan aktivitas sehari-hari masyarakat di Jorong Tanah Bato.'),
(19, 3, 1, 'Surau Simauang', 'Pendidikan', 'Surau Simauang merupakan salah satu pusat pendidikan dan pengembangan ajaran Tarekat Syathariyah di Nagari Sijunjung. Surau ini berfungsi sebagai tempat ibadah, pembelajaran agama, serta pelaksanaan kegiatan keagamaan dan tradisi tarekat yang berperan penting dalam menjaga nilai-nilai spiritual dan warisan keislaman masyarakat setempat.'),
(20, 1, 1, 'Surau Zallshabilla', 'Umum', 'Masjid Mustaqim merupakan salah satu sarana ibadah masyarakat yang digunakan untuk melaksanakan salat berjamaah, kegiatan pengajian, serta berbagai aktivitas keagamaan lainnya. Keberadaan surau ini berperan penting sebagai pusat pembinaan spiritual dan mempererat hubungan sosial serta kebersamaan masyarakat di sekitarnya.');

-- --------------------------------------------------------

--
-- Table structure for table `jorong`
--

CREATE TABLE `jorong` (
  `id_jorong` int(11) NOT NULL,
  `nama_jorong` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jorong`
--

INSERT INTO `jorong` (`id_jorong`, `nama_jorong`) VALUES
(1, 'Padang Ranah'),
(2, 'Tanah Bato'),
(3, 'Tapian Diaro');

-- --------------------------------------------------------

--
-- Table structure for table `kampung_adat`
--

CREATE TABLE `kampung_adat` (
  `id_kampung` int(11) NOT NULL,
  `nama_kampung` varchar(150) NOT NULL,
  `nagari` varchar(100) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kampung_budaya`
--

CREATE TABLE `kampung_budaya` (
  `id_kampung` int(11) NOT NULL,
  `id_budaya` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_rumah`
--

CREATE TABLE `kategori_rumah` (
  `id_kategori` int(11) NOT NULL,
  `nama` enum('Rumah Tinggal','Rumah Adat','Rumah Pusaka','Rumah Kaum') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kondisi_rumah`
--

CREATE TABLE `kondisi_rumah` (
  `id_kondisi` int(11) NOT NULL,
  `id_rumah` int(11) NOT NULL,
  `bagian_rusak` varchar(255) DEFAULT NULL,
  `tingkat_kerusakan` varchar(50) DEFAULT NULL,
  `status_renovasi` enum('Pernah','Belum') DEFAULT 'Belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kondisi_rumah`
--

INSERT INTO `kondisi_rumah` (`id_kondisi`, `id_rumah`, `bagian_rusak`, `tingkat_kerusakan`, `status_renovasi`) VALUES
(1, 3, 'pondasi', 'Baik', 'Belum'),
(2, 4, 'tiang, dinding, atap', 'Rusak Ringan', 'Belum'),
(3, 5, 'lantai, atap, dinding, pondasi', 'Rusak Ringan', 'Belum'),
(4, 6, 'lantai', 'Sedang', 'Belum'),
(5, 8, 'atap : agak bocor\ntiang : aman \nlantai : pernah di perbaiki\npondasi : aman\ntangga : aman', 'Sedang', 'Pernah'),
(6, 9, NULL, 'Baik', 'Pernah'),
(7, 10, 'dinding', 'Baik', 'Pernah'),
(8, 11, NULL, 'Sangat Baik', 'Pernah'),
(9, 12, 'Dinding', 'Baik', 'Pernah'),
(10, 13, 'Atap : Renov, dulu Ijuk karena lapuk menjadi seng, tambah plafon\nTiang : Tidak\nLantai : aman\nPondasi : aman\ntangga : batu', 'Sangat Baik', 'Pernah'),
(11, 14, 'Atap, dinding', 'Sedang', 'Belum'),
(12, 15, 'atap dan dinding', 'Rusak Ringan', 'Belum'),
(13, 16, 'dinding, lantai', 'Sedang', 'Pernah'),
(14, 17, 'Dinding, atap dan lantai', 'Rusak Ringan', 'Pernah'),
(15, 18, NULL, 'Baik', 'Belum'),
(16, 19, 'Dinding dan atap', 'Sedang', 'Pernah'),
(17, 20, 'Dinding dan atap', 'Sedang', 'Pernah'),
(18, 21, 'Tangga, lantai(?)', 'Sedang', 'Belum'),
(19, 22, 'Semua', 'Rusak Berat', 'Belum'),
(20, 23, NULL, 'Baik', 'Belum'),
(21, 24, 'Dinding, lantai dan atap', 'Sedang', 'Pernah'),
(22, 25, 'Atap, dinding, lantai', 'Sedang', 'Pernah'),
(23, 26, NULL, 'Sedang', 'Belum'),
(24, 27, 'Atap, dinding, tangga dan lantai', 'Baik', 'Pernah'),
(25, 28, 'Dinding, kolom, jendela', 'Sedang', 'Pernah'),
(26, 30, 'Lantai kayu kropos', 'Sedang', 'Belum'),
(27, 32, NULL, 'Baik', 'Pernah'),
(28, 34, 'Beberapa dinding sudah mulai menghitam dan lapuk, ada beberapa yang bolong.', 'Rusak Ringan', 'Pernah'),
(29, 36, 'Beberapa bagian dinding sudah mulai menghitam. Ada bagian beberapa atap bocor.', 'Baik', 'Pernah'),
(30, 38, 'Beberapa bagian kayu sudah ada yang mulai menggelap dan lapuk.', 'Baik', 'Pernah'),
(31, 39, NULL, 'Baik', 'Pernah'),
(32, 40, NULL, 'Baik', 'Pernah'),
(33, 41, 'kondisi sekarang cat yang sudah memudar, dan beberapa dinding kayu di makan rayap', 'Baik', 'Pernah'),
(34, 42, NULL, 'Baik', 'Pernah'),
(35, 43, NULL, 'Baik', 'Pernah'),
(36, 44, NULL, 'Baik', 'Pernah'),
(37, 45, NULL, 'Baik', 'Pernah'),
(38, 46, 'Atap', 'Baik', 'Pernah'),
(39, 47, 'Atap bocor, Tiang kayu lapuk, Lantai', 'Sedang', 'Pernah'),
(40, 48, 'Atap', 'Baik', 'Pernah'),
(41, 49, 'Atap Bocor, Tiang Pondasi Lapuk', 'Sedang', 'Pernah'),
(42, 50, 'Atap bocor, dinding kayu lapuk', 'Rusak Ringan', 'Pernah'),
(43, 52, 'Dinding lapuk, tiang lapuk', 'Sedang', 'Pernah'),
(44, 53, 'Tiang Lapuk, Dinding Lapuk', 'Sedang', 'Pernah'),
(45, 54, 'Atap Bocor, Dinding Lapuk', 'Sedang', 'Pernah'),
(46, 55, NULL, 'Baik', 'Belum'),
(47, 56, 'Tiang kayu lapuk', 'Sangat Baik', 'Pernah'),
(48, 57, 'Atap Bocor, Tiang kayu lapuk', 'Sedang', 'Pernah'),
(49, 58, 'Tiang', 'Baik', 'Pernah'),
(50, 59, 'Tiang Kayu Lapuk', 'Baik', 'Pernah'),
(51, 60, 'Atap Bocor, Tiang kayu lapuk', 'Sedang', 'Pernah'),
(52, 61, NULL, 'Sedang', 'Belum'),
(53, 62, NULL, 'Baik', 'Pernah'),
(54, 63, 'Dinding, Singkok', 'Sedang', 'Pernah'),
(55, 64, NULL, 'Baik', 'Pernah'),
(56, 65, 'Dinding, Atap', 'Rusak Ringan', 'Belum'),
(57, 66, NULL, 'Baik', 'Pernah'),
(58, 67, 'Pintu', 'Sedang', 'Belum'),
(59, 68, NULL, 'Baik', 'Pernah'),
(60, 69, NULL, 'Baik', 'Pernah'),
(61, 71, NULL, 'Baik', 'Pernah'),
(62, 73, NULL, 'Baik', 'Pernah'),
(63, 74, NULL, 'Baik', 'Pernah'),
(64, 75, NULL, 'Baik', 'Pernah'),
(65, 76, 'Dinding', 'Sedang', 'Belum'),
(66, 77, 'Lantai sudah lapuk\natap aman tapi usang, dan bocor\ndinding lama jadi renggang\npondasi agak terbuka\npintu rusak\n\ndulu 5 ruang jadi 4 ruang', 'Rusak Ringan', 'Belum'),
(67, 78, 'Atap Bagus\nLantai bagus\nDinding Aman\nPondasi aman', 'Sangat Baik', 'Pernah'),
(68, 79, 'plafon aman\natap oke\nlantai aman\npondasi aman \ndinding bolong dikit', 'Baik', 'Pernah'),
(69, 80, 'Kayu Terlihat Lapuk', 'Sedang', 'Pernah'),
(70, 81, 'Dinding ada sedikit yang dimakan rayap', 'Baik', 'Pernah'),
(71, 82, 'Cat dinding yang sudah pudar', 'Baik', 'Pernah'),
(72, 83, 'dinding yang ada beberapa yang dimakan rayap, cat rumah yang sedikit memudar', 'Baik', 'Pernah'),
(73, 84, 'Atap Bocor, Tiang kayu lapuk', 'Sedang', 'Pernah'),
(74, 86, 'dinding, lantai', 'Sedang', 'Pernah'),
(75, 87, NULL, 'Baik', 'Pernah');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_fasilitas`
--

CREATE TABLE `media_fasilitas` (
  `id_medfas` int(11) NOT NULL,
  `id_fasilitas` int(11) NOT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  `file` varchar(255) NOT NULL,
  `jenis_media` enum('foto','video') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_rumah`
--

CREATE TABLE `media_rumah` (
  `id_media` int(11) NOT NULL,
  `id_rumah` int(11) NOT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  `file` varchar(255) NOT NULL,
  `jenis_media` enum('foto','video') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemilik`
--

CREATE TABLE `pemilik` (
  `id_pemilik` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemilik`
--

INSERT INTO `pemilik` (`id_pemilik`, `nama`, `pekerjaan`, `alamat`) VALUES
(1, 'dani', 'irt', 'perkampungan adat rumah gadang nomor 03'),
(2, 'efisarni', 'pedagang', 'perkampungan adat rumah gadang nomor 04'),
(3, 'Pak sudir', 'Petani', NULL),
(4, 'hendrayeni', 'irt', 'perkampungan adat rumah gadang nomor 11'),
(5, 'Linda', 'irt', 'perkampungan adat rumah gadang nomor 10'),
(6, 'hendrayani', 'ibu rumah tangga', 'perkampungan adat rumah gadang nomor 11'),
(7, 'Henri', 'Petani dan motong karet', 'Rumah gadang 12'),
(8, 'Buk Ramadanita', 'IRT', NULL),
(9, 'Jesmarni', 'Petani', '14.0'),
(10, 'resti munengsi', 'petani', 'perkampungan adat rumah gadang nomor 16'),
(11, 'Buk ita', 'IRT', 'Sijunjung'),
(12, 'Buk Reni', 'IRT', 'Sijunjung'),
(13, 'Bapak budiman', 'Petani', 'Sijunjung'),
(14, 'Kak monalisa', 'IRT', 'Sijunjung'),
(15, 'Lipati', NULL, NULL),
(16, 'Intan Pono', NULL, 'sijunjung'),
(17, 'Ibuk Nurini', 'IRT', 'Sijunjung'),
(18, 'Ibuk Sarmis', NULL, NULL),
(19, 'Bagindo Tannome', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.40, Jorong Padang Ranah, Sijunjung'),
(20, 'Pak Muspian', NULL, 'Sijunjung'),
(21, 'Dahliana', NULL, NULL),
(22, 'Acep', NULL, NULL),
(23, 'Buk Anisa', NULL, NULL),
(24, 'Nurhaida', 'Petani', NULL),
(25, 'Rani Oktakarunia', 'Guru/PNS', 'Belakang rumah gadang 48'),
(26, 'Mawardi', 'Pemotong Karet', NULL),
(27, 'Jalinam', 'Ibu Rumah Tangga', NULL),
(28, 'Desi', 'Ibu Rumah Tangga', NULL),
(29, 'Rahma Yulis', 'Tani', NULL),
(30, 'Hawatif', 'Tani', NULL),
(31, 'Nurmadianti', 'Ibu Rumah Tangga', NULL),
(32, 'Ani', 'Ibu Rumah Tangga', NULL),
(33, 'Sri', 'ASN', NULL),
(34, 'Yetni Hastati', NULL, 'Batam'),
(35, 'Sutan Gemilang', 'Tani', NULL),
(36, 'Hartimi', NULL, 'Perkampungan Adat Sijunjung, Jorong Padang Ranah'),
(37, 'Samsul Bahri', 'Petani', NULL),
(38, 'Muriati', 'Petani', NULL),
(39, 'Marita', 'Pedagang', 'Jorong Tanah Bato, Nagari Sijunjung, Di belakang Rumah Gadang No 66'),
(40, 'Wiwik', NULL, 'Jorong Tanah Bato, Nagari Sijunjung, Di belakang Rumah Gadang No 69'),
(41, 'Hanif', NULL, NULL),
(42, 'Dasni', NULL, NULL),
(43, 'Helfa Yulita', 'Ibu Rumah Tangga', NULL),
(44, 'Jusnimar', 'Ibu Rumah Tangga', NULL),
(45, 'Ibu Syafridati', 'Ibu rumah tangga dan penjual', NULL),
(46, 'Ibu Astati', 'Dirunah/IRT', NULL),
(47, 'Ibu lili', 'Buat kalamai & kue talam', NULL),
(48, 'Buk Ican', NULL, NULL),
(49, 'Bapak Alvian', 'Petani', 'Sijunjung'),
(50, 'Yuliyuandra', NULL, NULL),
(51, 'Samsinar', 'Buka Warung', NULL),
(52, 'Wahyuni', NULL, 'Belakang Rumah Gadang 84'),
(53, 'epi', 'petani', 'perkampungan adat rumah gadang nomor 86'),
(54, 'ides', 'peternak dan pemilik umkm aqiqah', 'perkampungan adat rumah gadang nomor 87');

-- --------------------------------------------------------

--
-- Table structure for table `penghuni_rumah`
--

CREATE TABLE `penghuni_rumah` (
  `id_penghuni` int(11) NOT NULL,
  `id_rumah` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `umur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penghuni_rumah`
--

INSERT INTO `penghuni_rumah` (`id_penghuni`, `id_rumah`, `nama`, `jenis_kelamin`, `umur`) VALUES
(1, 3, 'dani', NULL, 53),
(2, 3, 'idrus', NULL, 83),
(3, 4, 'efisarni', NULL, 48),
(4, 4, 'wirdati', NULL, 73),
(5, 4, 'm. ikhsan', NULL, 21),
(6, 8, 'Pak sudir', NULL, 73),
(7, 8, 'anak nya fajri', NULL, 45),
(8, 10, 'Linda', NULL, NULL),
(9, 10, 'zulmukti', NULL, 65),
(10, 10, 'abdul rasyid', NULL, 24),
(11, 10, 'rahma', NULL, 21),
(12, 11, 'jamalus', NULL, 65),
(13, 11, 'hendrayani', NULL, 53),
(14, 11, 'gilang ilyas saputra', NULL, 23),
(15, 11, 'rendi', NULL, 21),
(16, 11, 'm. dipo', NULL, 17),
(17, 11, 'nuri latifah hasanah', NULL, 15),
(18, 12, 'Henri', NULL, 52),
(19, 12, 'Apit', NULL, 17),
(20, 13, 'Ibu ramadanita', NULL, 48),
(21, 13, 'Pak Sofianora', NULL, 55),
(22, 13, 'Arvansofia', NULL, 9),
(23, 13, 'Indah Wahyuni', NULL, 20),
(24, 14, 'Ompliadi', NULL, 54),
(25, 14, 'Jesmarni', NULL, 58),
(26, 14, 'Ruguni', NULL, 45),
(27, 16, 'resti munengsi', NULL, 45),
(28, 16, 'nofrizal', NULL, 46),
(29, 16, 'azizah', NULL, 15),
(30, 16, 'artan', NULL, 5),
(31, 17, 'Istri', NULL, 48),
(32, 17, 'Suami', NULL, 50),
(33, 17, 'Amak', NULL, 90),
(34, 17, 'Anak cowo 1', NULL, 21),
(35, 17, 'Anak cowo 2', NULL, 13),
(36, 19, 'Suami', NULL, 55),
(37, 19, 'Istri', NULL, 50),
(38, 19, 'Nenek', NULL, 70),
(39, 19, 'Anak laki laki', NULL, 14),
(40, 27, 'anak perempuan(yang diwawancara) 1', NULL, 26),
(41, 27, 'suaminya', NULL, 28),
(42, 27, 'cucu 1 (perempuan)', NULL, 5),
(43, 27, 'cucu 2 (perempuan)', NULL, 1),
(44, 27, 'kakak ibuk(kakak narasumber)', NULL, 72),
(45, 27, 'ibuk (yang diwawancara)', NULL, 49),
(46, 27, 'anak pertama laki-laki', NULL, 18),
(47, 27, 'anak kedua laki-laki', NULL, 14),
(48, 28, 'Ibu', NULL, 61),
(49, 28, 'Anak cowo 1', NULL, 28),
(50, 28, 'Anak cowo 2', NULL, 24),
(51, 30, 'Buk eni', NULL, 60),
(52, 30, 'Bapak', NULL, 58),
(53, 30, 'Anak', NULL, 24),
(54, 32, 'Bapak Sainal Effendi (Suami)', NULL, NULL),
(55, 32, 'Ibuk Nurini', NULL, NULL),
(56, 32, 'Anak Putri', NULL, NULL),
(57, 32, 'Anak Putri', NULL, NULL),
(58, 36, 'Bapak', NULL, NULL),
(59, 36, 'Ibuk', NULL, NULL),
(60, 36, 'Anak', NULL, NULL),
(61, 36, 'Anak', NULL, NULL),
(62, 36, 'Anak', NULL, NULL),
(63, 36, 'Anak', NULL, NULL),
(64, 38, 'Titik', NULL, NULL),
(65, 38, 'Feb. Ilham', NULL, NULL),
(66, 38, 'Maret Lintang', NULL, NULL),
(67, 39, 'Ibuk Sarmis', NULL, 65),
(68, 44, 'Dahliana', NULL, 54),
(69, 44, 'Dusri', NULL, 63),
(70, 44, 'Fitra', NULL, 30),
(71, 44, 'Dinda', NULL, 26),
(72, 45, 'Kundu', NULL, NULL),
(73, 45, 'Buyuang', NULL, NULL),
(74, 45, 'Acep', NULL, NULL),
(75, 49, 'Mawardi', NULL, 40),
(76, 49, 'Safrida', NULL, 37),
(77, 49, 'Zaki Abdillah', NULL, 15),
(78, 50, 'Jalinam', NULL, 70),
(79, 50, 'Eri', NULL, 40),
(80, 50, 'Atoferi', NULL, 30),
(81, 52, 'Desi', NULL, 42),
(82, 52, 'Jumriyo', NULL, 42),
(83, 52, 'Irsyad', NULL, 8),
(84, 52, 'Ridwan', NULL, 5),
(85, 53, 'Rahma Yulis', NULL, 73),
(86, 53, 'Deyeni', NULL, 54),
(87, 53, 'Febi', NULL, 17),
(88, 54, 'Hawatif', NULL, 81),
(89, 56, 'Nurmadianti', NULL, 70),
(90, 56, 'Nurmidarsam', NULL, 58),
(91, 56, 'Betria Melda', NULL, 45),
(92, 56, 'Rismaidi', NULL, 53),
(93, 56, 'Yuliusparme', NULL, 62),
(94, 56, 'Vinsa', NULL, 10),
(95, 57, 'Ani', NULL, 40),
(96, 57, 'Marwan', NULL, 71),
(97, 57, 'Bunga', NULL, 14),
(98, 57, 'Naya', NULL, 7),
(99, 57, 'Icon', NULL, 38),
(100, 58, 'Sri', NULL, 44),
(101, 58, 'Kartunus', NULL, 75),
(102, 58, 'Hendrizal', NULL, 49),
(103, 58, 'Rahmat', NULL, 30),
(104, 59, 'Yetni Hastati', NULL, 54),
(105, 63, 'Samsul Bahri', NULL, 76),
(106, 63, 'Aziar', NULL, 58),
(107, 63, 'Gini Amanda', NULL, 23),
(108, 64, 'Muriati', NULL, 67),
(109, 64, 'Gusti Lena', NULL, 70),
(110, 64, 'Mawardi', NULL, 35),
(111, 64, 'Romi Laksamana', NULL, 50),
(112, 64, 'Nursamsi Ramadonah', NULL, 30),
(113, 64, 'Fahim Rashdan', NULL, 4),
(114, 64, 'Mafaza Shabira', NULL, 2),
(115, 71, 'Hanif', NULL, 24),
(116, 71, 'Letdewi', NULL, 48),
(117, 71, 'Yalnofri', NULL, 53),
(118, 73, 'Dasni', NULL, 70),
(119, 73, 'Ridho Wildan', NULL, 27),
(120, 74, 'Helfa Yulita', NULL, 40),
(121, 74, 'Alisar', NULL, 76),
(122, 74, 'Wendra', NULL, 49),
(123, 74, 'M. Andika Pratama Weha', NULL, 17),
(124, 74, 'Nazeera Azmi Namiyah Weha', NULL, 6),
(125, 75, 'Jusnimar', NULL, 53),
(126, 75, 'Chairul Anwar', NULL, 57),
(127, 75, 'Safri Anwar', NULL, 27),
(128, 75, 'Sakinah Anwar', NULL, 20),
(129, 77, 'Ibu Syafirdati', NULL, 47),
(130, 77, 'Pak Riswandi', NULL, 53),
(131, 77, 'Revano', NULL, 16),
(132, 78, 'ASTATI', NULL, 69),
(133, 78, 'Esnidarti', NULL, 48),
(134, 79, 'Ibu Lili (53_', NULL, NULL),
(135, 79, 'nenek daniar', NULL, 75),
(136, 79, 'joni', NULL, 39),
(137, 79, 'Ibu noni', NULL, 48),
(138, 80, 'Buk Ican', NULL, 74),
(139, 81, 'putra', NULL, 19),
(140, 81, 'putri', NULL, 22),
(141, 81, 'Pak Alvian', NULL, NULL),
(142, 81, 'Buk Rahmawati', NULL, NULL),
(143, 82, 'Pak Yuliyuandra', NULL, NULL),
(144, 82, 'Ibuk Puji Astuti', NULL, NULL),
(145, 83, 'Cucu', NULL, NULL),
(146, 83, 'Ibuk Samsinar', NULL, 75),
(147, 86, 'epi', NULL, 38),
(148, 86, 'm. yunis', NULL, 46),
(149, 86, 'ebi', NULL, 17),
(150, 86, 'selin', NULL, 12),
(151, 86, 'rena', NULL, 6),
(152, 86, 'randa', NULL, 1),
(153, 87, 'yulhendri', NULL, 45),
(154, 87, 'ides', NULL, 53),
(155, 87, 'islahul qhouriah', NULL, 20),
(156, 87, 'm. shodiq', NULL, 16),
(157, 87, 'naira', NULL, 14),
(158, 87, 'nekisya', NULL, 9);

-- --------------------------------------------------------

--
-- Table structure for table `peta_kawasan`
--

CREATE TABLE `peta_kawasan` (
  `id_batas` int(11) NOT NULL,
  `id_kampung` int(11) NOT NULL,
  `polygon` geometry NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rumah_adat`
--

CREATE TABLE `rumah_adat` (
  `id_rumah` int(11) NOT NULL,
  `id_kampung` int(11) NOT NULL,
  `id_pemilik` int(11) DEFAULT NULL,
  `id_suku` int(11) DEFAULT NULL,
  `id_jorong` int(11) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `nomor_rumah` varchar(20) DEFAULT NULL,
  `nama_rumah` varchar(150) DEFAULT NULL,
  `alamat_rumah` text DEFAULT NULL,
  `jumlah_kk` int(11) DEFAULT 0,
  `jumlah_penghuni_laki` int(11) DEFAULT 0,
  `jumlah_penghuni_perempuan` int(11) DEFAULT 0,
  `ninik_mamak` varchar(150) DEFAULT NULL,
  `luas_tanah` decimal(10,2) DEFAULT NULL,
  `tahun_dibangun` varchar(100) DEFAULT NULL,
  `jumlah_ruang` int(11) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rumah_adat`
--

INSERT INTO `rumah_adat` (`id_rumah`, `id_kampung`, `id_pemilik`, `id_suku`, `id_jorong`, `id_status`, `nomor_rumah`, `nama_rumah`, `alamat_rumah`, `jumlah_kk`, `jumlah_penghuni_laki`, `jumlah_penghuni_perempuan`, `ninik_mamak`, `luas_tanah`, `tahun_dibangun`, `jumlah_ruang`, `latitude`, `longitude`) VALUES
(3, 1, 1, 1, 1, 1, '03', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.03, Jorong Padang Ranah, Sijunjung', 1, 1, 1, 'paduko sati', NULL, NULL, NULL, '-0.7111490', '100.9880860'),
(4, 1, 2, 1, 1, 1, '04', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.04, Jorong Padang Ranah, Sijunjung', 2, 1, 2, 'ploto piliang', NULL, NULL, NULL, '-0.7106340', '100.9873950'),
(5, 1, NULL, 1, 1, 2, '05', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.05, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '-0.7108600', '100.9877180'),
(6, 1, NULL, 1, 1, 2, '06', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.06, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, 'paduko alam', NULL, NULL, NULL, '-0.7105700', '100.9872870'),
(8, 1, 3, 1, 1, 1, '08', 'Piliang', 'Perkampungan Adat Sijunjung, Rumah Gadang No.08, Jorong Padang Ranah, Sijunjung', 1, 2, 0, NULL, NULL, '1979', NULL, '-0.7092870', '100.9872870'),
(9, 1, 4, 2, 1, 2, '09', 'rumah 7 ruang', 'Perkampungan Adat Sijunjung, Rumah Gadang No.09, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, 'datuk badarok sakti dan datuk gober', NULL, NULL, NULL, '-0.7095940', '100.9860290'),
(10, 1, 5, 1, 1, 1, '10', 'Rumah Gadang Khatib Alam', 'Perkampungan Adat Sijunjung, Rumah Gadang No.10, Jorong Padang Ranah, Sijunjung', 1, 2, 2, 'Hj.Abbas', NULL, '1931', NULL, '-0.7103810', '100.9869810'),
(11, 1, 6, 2, 1, 1, '11', 'rumah 7 ruang / rumah ukir', 'Perkampungan Adat Sijunjung, Rumah Gadang No.11, Jorong Padang Ranah, Sijunjung', 1, 4, 2, 'datuk badarok sakti dan datuk gober', NULL, NULL, NULL, '-0.7092870', '100.9872870'),
(12, 1, 7, 1, 1, 1, '12', 'Rumah banjong Piliang', 'Perkampungan Adat Sijunjung, Rumah Gadang No.12, Jorong Padang Ranah, Sijunjung', 1, 2, NULL, NULL, NULL, NULL, NULL, '-0.7102481', '100.9867691'),
(13, 1, 8, 3, 1, 1, '13', 'Rumah Gadang Suku Panai', 'Perkampungan Adat Sijunjung, Rumah Gadang No.13, Jorong Padang Ranah, Sijunjung', 1, 2, 2, 'Monti : Penghulu bosar, Sulbi Anwar', NULL, NULL, NULL, '-0.7090970', '100.9856870'),
(14, 1, 9, 1, 1, 1, '14', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.14, Jorong Padang Ranah, Sijunjung', 2, 2, 1, NULL, NULL, NULL, NULL, '-0.7101091', '100.9865939'),
(15, 1, NULL, 3, 1, 2, '15', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.15, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '-0.7088890', '100.9855260'),
(16, 1, 10, 1, 1, 1, '16', 'rumah gadang 3 ruang', 'Perkampungan Adat Sijunjung, Rumah Gadang No.16, Jorong Padang Ranah, Sijunjung', 1, 2, 2, 'peto molieh dan paduka alam', NULL, NULL, NULL, '-0.7099470', '100.9863970'),
(17, 1, 11, 4, 1, 1, '17', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.17, Jorong Padang Ranah, Sijunjung', 2, 3, 2, 'Gawai', NULL, NULL, NULL, '-0.7086268', '100.9853278'),
(18, 1, NULL, 1, 1, 2, '18', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.18, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '-0.7097838', '100.9862445'),
(19, 1, 12, 4, 1, 1, '19', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.19, Jorong Padang Ranah, Sijunjung', 2, 2, 2, 'Sultan maha rajo', NULL, NULL, NULL, '-0.7085907', '100.9852829'),
(20, 1, 13, 5, 1, 1, '20', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.20, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, 'Pandekar bungsu', NULL, NULL, NULL, '-0.7093408', '100.9860108'),
(21, 1, NULL, 4, 1, 2, '21', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.21, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 1, NULL, 2, 1, 2, '22', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.22, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '-0.7091691', '100.9857861'),
(23, 1, NULL, 4, 1, 2, '23', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.23, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 1, 14, 4, 1, 2, '24', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.24, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, 'Gawai', NULL, NULL, NULL, '-0.7087440', '100.9861363'),
(25, 1, NULL, 4, 1, 2, '25', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.25, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, 'Konomajo', NULL, NULL, NULL, '-0.7077681', '100.9848514'),
(26, 1, NULL, 6, 1, 1, '26', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.26, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '-0.7090516', '100.9857502'),
(27, 1, 15, 4, 1, 2, '27', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.27, Jorong Padang Ranah, Sijunjung', 3, 3, 5, 'Nubalang', NULL, NULL, NULL, '-0.7077139', '100.9846718'),
(28, 1, NULL, 6, 1, 2, '28', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.28, Jorong Padang Ranah, Sijunjung', 1, 2, 1, 'Godqng lelo/ malin baduko', NULL, NULL, NULL, '-0.7089341', '100.9857052'),
(30, 1, 16, 6, 1, 1, '30', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.30, Jorong Padang Ranah, Sijunjung', 1, 1, 2, 'Penghulu sampono', NULL, NULL, NULL, '-0.7087352', '100.9855884'),
(32, 1, 17, 4, 1, 1, '32', 'Rumah Gadang Suku Melayu', 'Perkampungan Adat Sijunjung, Rumah Gadang No.32, Jorong Padang Ranah, Sijunjung', 1, 1, 3, NULL, NULL, '1800', NULL, '-0.7085032', '100.9855627'),
(34, 1, NULL, 4, 1, 1, '34', 'Homestay Suku Melayu', 'Perkampungan Adat Sijunjung, Rumah Gadang No.34, Jorong Padang Ranah, Sijunjung', 2, 1, 2, 'Dubalang, mamak rajo nan sati', NULL, '1800', NULL, '-0.7083490', '100.9854340'),
(36, 1, NULL, 3, 1, 1, '36', 'Homestay Suku Panai', 'Perkampungan Adat Sijunjung, Rumah Gadang No.36, Jorong Padang Ranah, Sijunjung', 2, NULL, NULL, 'Mamak m.n peto mansur (palito panai)', NULL, NULL, NULL, '-0.7080830', '100.9852610'),
(38, 1, NULL, 2, 1, 1, '38', 'Rumah Adat Suku Chaniago', 'Perkampungan Adat Sijunjung, Rumah Gadang No.38, Jorong Padang Ranah, Sijunjung', 1, 2, 1, 'Bagindo Ratu', NULL, '1800', NULL, '-0.7076570', '100.9849730'),
(39, 1, 18, 2, 1, 1, '39', 'Rumah gadang suku caniago', 'Perkampungan Adat Sijunjung, Rumah Gadang No.39, Jorong Padang Ranah, Sijunjung', 1, NULL, 1, 'Ninik mamak rajo palembang, datuk gagar', NULL, NULL, NULL, '-0.7074683', '100.9837331'),
(40, 1, 19, 2, 1, 1, '40', 'R.J Nan Panjang', 'Perkampungan Adat Sijunjung, Rumah Gadang No.40, Jorong Padang Ranah, Sijunjung', 2, 2, 3, 'bandar sati, mamak rajo nan panjang', NULL, NULL, NULL, '-0.7075920', '100.9848643'),
(41, 1, 20, 2, 1, 2, '41', 'Sekretariat', 'Perkampungan Adat Sijunjung, Rumah Gadang No.41, Jorong Padang Ranah, Sijunjung', 0, 0, 0, 'Datuk bandaro sati', NULL, NULL, NULL, '-0.7073130', '100.9845340'),
(42, 1, NULL, 7, 1, 2, '42', 'Rumah gadang patopang', 'Perkampungan Adat Sijunjung, Rumah Gadang No.42, Jorong Tanah Bato, Sijunjung', 2, 1, 3, 'Datuk monti yg bernama piri', NULL, NULL, NULL, '-0.7072618', '100.9847108'),
(43, 1, NULL, 2, 1, 1, '43', 'Rumah Gadang Caniago', 'Perkampungan Adat Sijunjung, Rumah Gadang No.43, Jorong Padang Ranah, Sijunjung', 1, 2, NULL, 'Malin Palowan', NULL, NULL, NULL, '-0.7072095', '100.9844777'),
(44, 1, 21, 8, 1, 1, '44', 'Rumah Gadang Suku Bodi', 'Perkampungan Adat Sijunjung, Rumah Gadang No.44, Jorong Padang Ranah, Sijunjung', 1, 2, 2, 'Datuk Bandaro Sati/ Mamak Raja Malano', NULL, NULL, NULL, '-0.7071257', '100.9845605'),
(45, 1, 22, 9, 1, 1, '45', 'Rumah Gadang Suku Painan', 'Perkampungan Adat Sijunjung, Rumah Gadang No.45, Jorong Padang Ranah, Sijunjung', 1, 3, 0, 'Datuk Penghulu Besar bernama Motir / Tungganai bergelar Mongek Sati', NULL, NULL, NULL, '-0.7067250', '100.9843761'),
(46, 1, 23, 5, 1, 2, '46', 'Rumah Gadang Suku Bodi', 'Perkampungan Adat Sijunjung, Rumah Gadang No.46, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, 'Paduko Rajo', NULL, '1933', NULL, '-0.7070030', '100.9845374'),
(47, 1, 24, 10, 1, 2, '47', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.47, Jorong Padang Ranah, Sijunjung', 0, 0, 0, 'Dt. Ulak Cumano', NULL, '1920', NULL, '-0.7064843', '100.9843479'),
(48, 1, 25, 3, 1, 2, '48', 'Homestay Rumah Gadang 48', 'Perkampungan Adat Sijunjung, Rumah Gadang No.48, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, 'Dt. Penghulu Bosel', NULL, NULL, NULL, '-0.7067736', '100.9844468'),
(49, 1, 26, 2, 1, 1, '49', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.49, Jorong Padang Ranah, Sijunjung', 1, 2, 1, 'Malin Batua', NULL, '1954', NULL, '-0.7062131', '100.9842939'),
(50, 1, 27, 3, 1, 1, '50', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.50, Jorong Padang Ranah, Sijunjung', 1, 2, 1, 'Muhardi', NULL, '1880', NULL, '-0.7062131', '100.9842939'),
(52, 1, 28, 10, 1, 1, '52', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.52, Jorong Padang Ranah, Sijunjung', 1, 3, 1, 'Dt. Ulak Cumano', NULL, '1900', NULL, '-0.7063849', '100.9843658'),
(53, 1, 29, 11, 1, 1, '53', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.53, Jorong Padang Ranah, Sijunjung', 2, 1, 2, 'Penghulu Sati', NULL, '1880', NULL, '-0.7051190', '100.9842844'),
(54, 1, 30, 1, 1, 1, '54', 'Rumah Gadang Suku Piliang', 'Perkampungan Adat Sijunjung, Rumah Gadang No.54, Jorong Padang Ranah, Sijunjung', 1, 0, 1, 'Palito Sinaroh', NULL, '1880', NULL, '-0.7054988', '100.9843026'),
(55, 1, NULL, 11, 1, 2, '55', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.55, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, 'Penghulu Sati', NULL, NULL, NULL, '-0.7049111', '100.9843382'),
(56, 1, 31, 11, 1, 1, '56', 'Homestay Rumah Gadang 56', 'Perkampungan Adat Sijunjung, Rumah Gadang No.56, Jorong Padang Ranah, Sijunjung', 3, 3, 3, 'Penghulu Sati', NULL, '1900', NULL, '-0.7048839', '100.9844460'),
(57, 1, 32, 11, 1, 1, '57', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.57, Jorong Padang Ranah, Sijunjung', 2, 2, 3, 'Penghulu Sati', NULL, '1880', NULL, '-0.7046398', '100.9843022'),
(58, 1, 33, 8, 1, 1, '58', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.58, Jorong Padang Ranah, Sijunjung', 2, 3, 1, 'Sutan Nan Gadang', NULL, '1900', NULL, '-0.7045132', '100.9844818'),
(59, 1, 34, 11, 1, 2, '59', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.59, Jorong Padang Ranah, Sijunjung', 1, 0, 1, 'Tan Marajo', NULL, '1900', NULL, '-0.7044680', '100.9844189'),
(60, 1, 35, 5, 1, 2, '60', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.60, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, NULL, NULL, '1880', NULL, '-0.7042599', '100.9846254'),
(61, 1, NULL, 2, 1, 2, '61', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.61, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '-0.7039796', '100.9847780'),
(62, 1, 36, 2, 1, 2, '62', 'Rumah Dt. Tan Mantari', 'Perkampungan Adat Sijunjung, Rumah Gadang No.62, Jorong Padang Ranah, Sijunjung', NULL, NULL, NULL, 'Datuk Tan Mantari', NULL, '1945', NULL, '-0.7040973', '100.9847654'),
(63, 1, 37, 2, 2, 1, '63', 'Rumah Gadang Chaniago', 'Perkampungan Adat Sijunjung, Rumah Gadang No.63, Jorong Tanah Bato, Sijunjung', 1, 1, 2, 'Palito Chaniago Khatib Sinaro', NULL, '1900', NULL, '-0.7003808', '100.9862302'),
(64, 1, 38, 12, 1, 1, '64', 'Rumah Melayu Kopa', 'Perkampungan Adat Sijunjung, Rumah Gadang No.64, Jorong Tanah Bato, Sijunjung', 3, 3, 4, 'Datuak Paduko Samo', NULL, '1900', NULL, '-0.7037316', '100.9852174'),
(65, 1, NULL, 2, 2, 2, '65', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.65, Jorong Tanah Bato, Sijunjung', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '-0.7001152', '100.9862041'),
(66, 1, 39, 2, 2, 2, '66', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.66, Jorong Tanah Bato, Sijunjung', NULL, NULL, NULL, 'Rajo Bandaro', NULL, '1945', NULL, '-0.7003985', '100.9862839'),
(67, 1, NULL, 2, 2, 2, '67', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.67, Jorong Tanah Bato, Sijunjung', NULL, NULL, NULL, NULL, NULL, '1945', NULL, '-0.6999329', '100.9861843'),
(68, 1, NULL, 2, 2, 2, '68', 'Sekretariat Kampung Adat Mendunia Jorong Tanah Bato', 'Perkampungan Adat Sijunjung, Rumah Gadang No.68, Jorong Tanah Bato, Sijunjung', NULL, NULL, NULL, NULL, NULL, '1945', NULL, '-0.6997203', '100.9861769'),
(69, 1, 40, 2, 2, 2, '69', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.69, Jorong Tanah Bato, Sijunjung', NULL, NULL, NULL, 'Pahlawan Garang', NULL, '1945', NULL, '-0.6996640', '100.9860975'),
(71, 1, 41, 2, 2, 1, '71', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.71, Jorong Tanah Bato, Sijunjung', 1, 2, 1, 'Ompang Limo', NULL, '1945', NULL, '-0.6993690', '100.9859633'),
(73, 1, 42, 2, 2, 1, '73', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.73, Jorong Tanah Bato, Sijunjung', 1, 1, 1, 'Monti Tungga', NULL, '1900', NULL, '-0.6989885', '100.9857293'),
(74, 1, 43, 6, 2, 1, '74', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.74, Jorong Tanah Bato, Sijunjung', 2, 3, 2, 'Orang Kayo Bungsu', NULL, '1945', NULL, '-0.6975543', '100.9848660'),
(75, 1, 44, 7, 2, 1, '75', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.75, Jorong Tanah Bato, Sijunjung', 1, 2, 2, 'Monti Tungga', NULL, '1945', NULL, '-0.6989885', '100.9857293'),
(76, 1, NULL, 4, 2, 2, '76', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.76, Jorong Tanah Bato, Sijunjung', NULL, NULL, NULL, NULL, NULL, '1945', NULL, '-0.6974446', '100.9846755'),
(77, 1, 45, 13, 2, 1, '77', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.77, Jorong Tanah Bato, Sijunjung', 1, 2, 1, NULL, NULL, NULL, NULL, '-0.6988890', '100.9853510'),
(78, 1, 46, 1, 2, 1, '78', 'Rumah adat Suku Piliang', 'Perkampungan Adat Sijunjung, Rumah Gadang No.78, Jorong Tanah Bato, Sijunjung', 1, 0, 2, 'Peto Mulieh', NULL, '1931', NULL, '-0.6965480', '100.9844070'),
(79, 1, 47, 6, 2, 1, '79', 'Rumah 79 rang kayo bungsu', 'Perkampungan Adat Sijunjung, Rumah Gadang No.79, Jorong Tanah Bato, Sijunjung', 1, 1, 3, 'rang kayo bungsu', NULL, '1982', NULL, '-0.6989350', '100.9849550'),
(80, 1, 48, 14, 2, 1, '80', 'Rumah Gadang Suku Tobo', 'Perkampungan Adat Sijunjung, Rumah Gadang No.80, Jorong Tanah Bato, Sijunjung', 1, 0, 1, 'Datuk Malin Kayo / Tungganai Bagak Sidiak', NULL, NULL, NULL, '-0.6980578', '100.9855121'),
(81, 1, 49, 6, 2, 1, '81', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.81, Jorong Tanah Bato, Sijunjung', 1, 1, 2, 'Datuk penghulu sampono', NULL, '1814', NULL, '-0.6977050', '100.9850130'),
(82, 1, 50, 4, 2, 1, '82', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.82, Jorong Tanah Bato, Sijunjung', 1, 2, 3, 'Datuk Panghulu sampono', NULL, '1914', NULL, '-0.6975460', '100.9848020'),
(83, 1, 51, 1, 2, 1, '83', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.83, Jorong Tanah Bato, Sijunjung', 2, 0, 2, 'Batuk Pondi', NULL, NULL, NULL, '-0.6970600', '100.9844570'),
(84, 1, 52, 1, 2, 2, '84', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.84, Jorong Tanah Bato, Sijunjung', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '-0.6969904', '100.9843529'),
(86, 1, 53, 2, 1, 1, '86', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.86, Jorong Tanah Bato, Sijunjung', 1, 3, 3, NULL, NULL, NULL, NULL, '-0.6981390', '100.9836170'),
(87, 1, 54, 2, 1, 1, '87', NULL, 'Perkampungan Adat Sijunjung, Rumah Gadang No.87, Jorong Tanah Bato, Sijunjung', 1, 2, 4, NULL, NULL, NULL, NULL, '-0.6987810', '100.9844700');

-- --------------------------------------------------------

--
-- Table structure for table `rumah_kategori`
--

CREATE TABLE `rumah_kategori` (
  `id` int(11) NOT NULL,
  `id_rumah` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rumah_kategori`
--

INSERT INTO `rumah_kategori` (`id`, `id_rumah`, `id_kategori`) VALUES
(1, 3, 1),
(2, 3, 2),
(3, 3, 3),
(4, 4, 1),
(5, 4, 2),
(6, 4, 3),
(7, 5, 3),
(8, 6, 2),
(9, 6, 3),
(10, 8, 1),
(11, 8, 2),
(12, 8, 3),
(13, 9, 2),
(14, 9, 3),
(15, 10, 1),
(16, 10, 2),
(17, 10, 3),
(18, 11, 1),
(19, 11, 2),
(20, 11, 3),
(21, 12, 1),
(22, 12, 2),
(23, 12, 3),
(24, 13, 1),
(25, 13, 2),
(26, 13, 3),
(27, 14, 1),
(28, 14, 2),
(29, 14, 3),
(30, 15, 2),
(31, 16, 1),
(32, 16, 2),
(33, 16, 3),
(34, 17, 1),
(35, 18, 2),
(36, 19, 1),
(37, 20, 2),
(38, 21, 2),
(39, 22, 2),
(40, 22, 3),
(41, 23, 2),
(42, 23, 3),
(43, 24, 3),
(44, 25, 3),
(45, 26, 3),
(46, 27, 2),
(47, 28, 3),
(48, 30, 1),
(49, 32, 1),
(50, 32, 2),
(51, 32, 3),
(52, 34, 1),
(53, 34, 2),
(54, 36, 1),
(55, 36, 2),
(56, 36, 3),
(57, 38, 1),
(58, 38, 2),
(59, 38, 3),
(60, 39, 1),
(61, 39, 2),
(62, 40, 1),
(63, 40, 2),
(64, 40, 3),
(65, 41, 2),
(66, 42, 1),
(67, 42, 2),
(68, 43, 1),
(69, 43, 2),
(70, 44, 1),
(71, 44, 2),
(72, 44, 3),
(73, 45, 1),
(74, 45, 2),
(75, 45, 3),
(76, 46, 2),
(77, 47, 1),
(78, 47, 2),
(79, 48, 2),
(80, 49, 1),
(81, 49, 2),
(82, 50, 1),
(83, 50, 2),
(84, 52, 1),
(85, 52, 2),
(86, 53, 1),
(87, 53, 2),
(88, 54, 1),
(89, 54, 2),
(90, 55, 2),
(91, 56, 1),
(92, 56, 2),
(93, 57, 1),
(94, 57, 2),
(95, 58, 1),
(96, 58, 2),
(97, 59, 2),
(98, 60, 1),
(99, 60, 2),
(100, 61, 2),
(101, 62, 2),
(102, 63, 1),
(103, 63, 2),
(104, 64, 1),
(105, 64, 2),
(106, 65, 2),
(107, 66, 2),
(108, 67, 2),
(109, 68, 2),
(110, 69, 2),
(111, 71, 1),
(112, 71, 2),
(113, 73, 1),
(114, 73, 2),
(115, 74, 1),
(116, 74, 2),
(117, 75, 1),
(118, 75, 2),
(119, 76, 2),
(120, 77, 1),
(121, 77, 2),
(122, 77, 3),
(123, 78, 1),
(124, 78, 2),
(125, 78, 3),
(126, 79, 1),
(127, 79, 2),
(128, 79, 3),
(129, 80, 1),
(130, 80, 2),
(131, 80, 3),
(132, 81, 1),
(133, 81, 2),
(134, 81, 3),
(135, 82, 1),
(136, 82, 2),
(137, 82, 3),
(138, 83, 1),
(139, 83, 2),
(140, 83, 3),
(141, 84, 2),
(142, 86, 1),
(143, 86, 2),
(144, 86, 3),
(145, 87, 1),
(146, 87, 2),
(147, 87, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sejarah_rumah`
--

CREATE TABLE `sejarah_rumah` (
  `id_sejarah` int(11) NOT NULL,
  `id_rumah` int(11) NOT NULL,
  `sejarah` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sejarah_rumah`
--

INSERT INTO `sejarah_rumah` (`id_sejarah`, `id_rumah`, `sejarah`) VALUES
(1, 9, 'Sejarah: sama dengan rumah nomor 11.'),
(2, 10, 'Pendiri/Asal Usul: Hj. Abbas'),
(3, 11, 'Sejarah: pada awal dibangun rumah ini disebut sebagai rumah 7 ruang, namun karna pengelola sedikit dan ruang terlampau banyak maka rumah ini kemudian dipisah menjadi dua rumah.'),
(4, 32, 'Pendiri/Asal Usul: Kaum | Sejarah: Pernah karna terbakar waktu belanda smpai berubah ukuran yg dulunya lebih luas dari sekarang, dengan satu kali rehab/renovasi.'),
(5, 36, 'Sejarah: Fungsi rumahnya selain tempay tinggal: siriah, tando, utk acara nikah. Kalu pesta seterah mau dirmh masing2. Selain tempat tinggal, 3 thn pameran budaya matrilineal (utk pameran fotografi) foto2 acara adat ada semua dirumh ini.'),
(6, 41, 'Sejarah: gonjong hampir patah, lantai sebelah kiri hmpir hancur karna hujan, karna letaknya stategis dibantu dari dana desa diperbaiki yg rusak, kemudian ada temu ramah dengan pihak rumah dengan pihak nagari. Kemudian pihak rumah menanyakan siapa yg mau tinggal disitu karna pemilik rumah tersebut sudah ada rumah masing-masing karna itu rumah tersebut diserahkan kepada pihak nagari.'),
(7, 44, 'Pendiri/Asal Usul: Kaum Suku Bodi | Sejarah: Pembangunan rumah dilakukan secara gotong royong dengan semua suku'),
(8, 45, 'Pendiri/Asal Usul: Didirikan oleh Kaum Suku Melayu Panai. Nenek moyang dari penghuni rumah ini berasal dari Suku Melayu Panai yang asalnya dari Pariangan, Tanah Datar. | Sejarah: Rumah gadang ini dipimpin oleh seorang Tungganai (saudara laki-laki tertua saparuik) yang menjadi penanggung jawab urusan cucu kemenakan dan wakil ninik mamak suku dengan gelar Mongek Sati. Rumah ini berfungsi sebagai tempat tinggal, tempat mengurus adat terdekat dengan mamak, serta prosesi tando Rabu, sirih Jumat.'),
(9, 46, 'Sejarah: Menyimpan tongkat keramat yg mjdkan tabek, mislnya tdk ada air, lalu tongkat itu ditancapkan ke tabek langsung keluar air.'),
(10, 75, 'Pendiri/Asal Usul: Kaum Patopang'),
(11, 78, 'Pendiri/Asal Usul: Lamiah'),
(12, 79, 'Sejarah: renov 1x besar2an karena tinggi. awal keluarga migrasi dari talawi di sawah lunto, trus bepindah2 lalu berkungjung dan menetap'),
(13, 80, 'Pendiri/Asal Usul: Kaum Suku Tobo | Sejarah: Rumah gadang ini merupakan rumah paling tua yang berdiri di Jorong Tanah Bato.');

-- --------------------------------------------------------

--
-- Table structure for table `status_rumah`
--

CREATE TABLE `status_rumah` (
  `id_status` int(11) NOT NULL,
  `status` enum('Aktif Dihuni','Kosong') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suku`
--

CREATE TABLE `suku` (
  `id_suku` int(11) NOT NULL,
  `nama_suku` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suku`
--

INSERT INTO `suku` (`id_suku`, `nama_suku`) VALUES
(1, 'Piliang'),
(2, 'Caniago'),
(3, 'Panai'),
(4, 'Melayu'),
(5, 'Bodi Caniago'),
(6, 'Melayu Tak Timbago'),
(7, 'Patopang'),
(8, 'Bodi'),
(9, 'Melayu Panai'),
(10, 'Bendang'),
(11, 'Tobo'),
(12, 'Melayu Kopa'),
(13, 'Melayu Tanjung'),
(14, 'Melayu Tobo');

-- --------------------------------------------------------

--
-- Table structure for table `users_admin`
--

CREATE TABLE `users_admin` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arsitek_rumah`
--
ALTER TABLE `arsitek_rumah`
  ADD PRIMARY KEY (`id_arsitek`),
  ADD KEY `fk_arsitek_rumah` (`id_rumah`);

--
-- Indexes for table `budaya`
--
ALTER TABLE `budaya`
  ADD PRIMARY KEY (`id_budaya`);

--
-- Indexes for table `fasilitas_wisata`
--
ALTER TABLE `fasilitas_wisata`
  ADD PRIMARY KEY (`id_fasilitas`),
  ADD KEY `fk_fasilitas_kampung` (`id_kampung`),
  ADD KEY `fk_fasilitas_jorong` (`id_jorong`);

--
-- Indexes for table `jorong`
--
ALTER TABLE `jorong`
  ADD PRIMARY KEY (`id_jorong`);

--
-- Indexes for table `kampung_adat`
--
ALTER TABLE `kampung_adat`
  ADD PRIMARY KEY (`id_kampung`);

--
-- Indexes for table `kampung_budaya`
--
ALTER TABLE `kampung_budaya`
  ADD PRIMARY KEY (`id_kampung`,`id_budaya`),
  ADD KEY `fk_kb_budaya` (`id_budaya`);

--
-- Indexes for table `kategori_rumah`
--
ALTER TABLE `kategori_rumah`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kondisi_rumah`
--
ALTER TABLE `kondisi_rumah`
  ADD PRIMARY KEY (`id_kondisi`),
  ADD KEY `fk_kondisi_rumah` (`id_rumah`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `fk_log_user` (`id_user`);

--
-- Indexes for table `media_fasilitas`
--
ALTER TABLE `media_fasilitas`
  ADD PRIMARY KEY (`id_medfas`),
  ADD KEY `fk_medfas_fasilitas` (`id_fasilitas`);

--
-- Indexes for table `media_rumah`
--
ALTER TABLE `media_rumah`
  ADD PRIMARY KEY (`id_media`),
  ADD KEY `fk_media_rumah` (`id_rumah`);

--
-- Indexes for table `pemilik`
--
ALTER TABLE `pemilik`
  ADD PRIMARY KEY (`id_pemilik`);

--
-- Indexes for table `penghuni_rumah`
--
ALTER TABLE `penghuni_rumah`
  ADD PRIMARY KEY (`id_penghuni`),
  ADD KEY `fk_penghuni_rumah` (`id_rumah`);

--
-- Indexes for table `peta_kawasan`
--
ALTER TABLE `peta_kawasan`
  ADD PRIMARY KEY (`id_batas`),
  ADD KEY `fk_peta_kampung` (`id_kampung`),
  ADD SPATIAL KEY `idx_peta_polygon` (`polygon`);

--
-- Indexes for table `rumah_adat`
--
ALTER TABLE `rumah_adat`
  ADD PRIMARY KEY (`id_rumah`),
  ADD KEY `fk_rumah_kampung` (`id_kampung`),
  ADD KEY `fk_rumah_pemilik` (`id_pemilik`),
  ADD KEY `fk_rumah_suku` (`id_suku`),
  ADD KEY `fk_rumah_jorong` (`id_jorong`),
  ADD KEY `fk_rumah_status` (`id_status`),
  ADD KEY `idx_rumah_latlong` (`latitude`,`longitude`);

--
-- Indexes for table `rumah_kategori`
--
ALTER TABLE `rumah_kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_rumah_kategori` (`id_rumah`,`id_kategori`),
  ADD KEY `fk_rk_kategori` (`id_kategori`);

--
-- Indexes for table `sejarah_rumah`
--
ALTER TABLE `sejarah_rumah`
  ADD PRIMARY KEY (`id_sejarah`),
  ADD KEY `fk_sejarah_rumah` (`id_rumah`);

--
-- Indexes for table `status_rumah`
--
ALTER TABLE `status_rumah`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `suku`
--
ALTER TABLE `suku`
  ADD PRIMARY KEY (`id_suku`);

--
-- Indexes for table `users_admin`
--
ALTER TABLE `users_admin`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arsitek_rumah`
--
ALTER TABLE `arsitek_rumah`
  MODIFY `id_arsitek` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budaya`
--
ALTER TABLE `budaya`
  MODIFY `id_budaya` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fasilitas_wisata`
--
ALTER TABLE `fasilitas_wisata`
  MODIFY `id_fasilitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `jorong`
--
ALTER TABLE `jorong`
  MODIFY `id_jorong` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kampung_adat`
--
ALTER TABLE `kampung_adat`
  MODIFY `id_kampung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori_rumah`
--
ALTER TABLE `kategori_rumah`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kondisi_rumah`
--
ALTER TABLE `kondisi_rumah`
  MODIFY `id_kondisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_fasilitas`
--
ALTER TABLE `media_fasilitas`
  MODIFY `id_medfas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_rumah`
--
ALTER TABLE `media_rumah`
  MODIFY `id_media` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pemilik`
--
ALTER TABLE `pemilik`
  MODIFY `id_pemilik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `penghuni_rumah`
--
ALTER TABLE `penghuni_rumah`
  MODIFY `id_penghuni` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `peta_kawasan`
--
ALTER TABLE `peta_kawasan`
  MODIFY `id_batas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rumah_adat`
--
ALTER TABLE `rumah_adat`
  MODIFY `id_rumah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `rumah_kategori`
--
ALTER TABLE `rumah_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `sejarah_rumah`
--
ALTER TABLE `sejarah_rumah`
  MODIFY `id_sejarah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `status_rumah`
--
ALTER TABLE `status_rumah`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suku`
--
ALTER TABLE `suku`
  MODIFY `id_suku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users_admin`
--
ALTER TABLE `users_admin`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arsitek_rumah`
--
ALTER TABLE `arsitek_rumah`
  ADD CONSTRAINT `fk_arsitek_rumah` FOREIGN KEY (`id_rumah`) REFERENCES `rumah_adat` (`id_rumah`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fasilitas_wisata`
--
ALTER TABLE `fasilitas_wisata`
  ADD CONSTRAINT `fk_fasilitas_jorong` FOREIGN KEY (`id_jorong`) REFERENCES `jorong` (`id_jorong`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fasilitas_kampung` FOREIGN KEY (`id_kampung`) REFERENCES `kampung_adat` (`id_kampung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kampung_budaya`
--
ALTER TABLE `kampung_budaya`
  ADD CONSTRAINT `fk_kb_budaya` FOREIGN KEY (`id_budaya`) REFERENCES `budaya` (`id_budaya`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kb_kampung` FOREIGN KEY (`id_kampung`) REFERENCES `kampung_adat` (`id_kampung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kondisi_rumah`
--
ALTER TABLE `kondisi_rumah`
  ADD CONSTRAINT `fk_kondisi_rumah` FOREIGN KEY (`id_rumah`) REFERENCES `rumah_adat` (`id_rumah`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`id_user`) REFERENCES `users_admin` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `media_fasilitas`
--
ALTER TABLE `media_fasilitas`
  ADD CONSTRAINT `fk_medfas_fasilitas` FOREIGN KEY (`id_fasilitas`) REFERENCES `fasilitas_wisata` (`id_fasilitas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `media_rumah`
--
ALTER TABLE `media_rumah`
  ADD CONSTRAINT `fk_media_rumah` FOREIGN KEY (`id_rumah`) REFERENCES `rumah_adat` (`id_rumah`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penghuni_rumah`
--
ALTER TABLE `penghuni_rumah`
  ADD CONSTRAINT `fk_penghuni_rumah` FOREIGN KEY (`id_rumah`) REFERENCES `rumah_adat` (`id_rumah`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `peta_kawasan`
--
ALTER TABLE `peta_kawasan`
  ADD CONSTRAINT `fk_peta_kampung` FOREIGN KEY (`id_kampung`) REFERENCES `kampung_adat` (`id_kampung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rumah_adat`
--
ALTER TABLE `rumah_adat`
  ADD CONSTRAINT `fk_rumah_jorong` FOREIGN KEY (`id_jorong`) REFERENCES `jorong` (`id_jorong`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rumah_kampung` FOREIGN KEY (`id_kampung`) REFERENCES `kampung_adat` (`id_kampung`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rumah_pemilik` FOREIGN KEY (`id_pemilik`) REFERENCES `pemilik` (`id_pemilik`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rumah_status` FOREIGN KEY (`id_status`) REFERENCES `status_rumah` (`id_status`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rumah_suku` FOREIGN KEY (`id_suku`) REFERENCES `suku` (`id_suku`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `rumah_kategori`
--
ALTER TABLE `rumah_kategori`
  ADD CONSTRAINT `fk_rk_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_rumah` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rk_rumah` FOREIGN KEY (`id_rumah`) REFERENCES `rumah_adat` (`id_rumah`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sejarah_rumah`
--
ALTER TABLE `sejarah_rumah`
  ADD CONSTRAINT `fk_sejarah_rumah` FOREIGN KEY (`id_rumah`) REFERENCES `rumah_adat` (`id_rumah`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
