-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2019 at 07:53 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grobenk`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('root', 'root');

-- --------------------------------------------------------

--
-- Table structure for table `bolnica`
--

CREATE TABLE `bolnica` (
  `idbolnica` int(10) UNSIGNED NOT NULL,
  `naziv_bolnice` varchar(45) COLLATE utf8mb4_croatian_ci NOT NULL,
  `grad` varchar(45) COLLATE utf8mb4_croatian_ci NOT NULL,
  `adresa_bolnice` varchar(45) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `postanski_broj` int(11) DEFAULT NULL,
  `password` varchar(10) COLLATE utf8mb4_croatian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `bolnica`
--

INSERT INTO `bolnica` (`idbolnica`, `naziv_bolnice`, `grad`, `adresa_bolnice`, `postanski_broj`, `password`) VALUES
(101, 'KBC Sušak', 'Zagreb', ' Ul. Tome Strižića 3', 51001, '101'),
(102, 'KBC Sisak', 'Sisak', 'Ul. Josipa Jurja Strossmayera 59', 57474, 'kbcri56'),
(103, 'KBC Zagreb', 'Zagreb', 'Kišpatićeva ul. 12', 50000, 'zajc45'),
(104, 'KBC', 'Zadar', 'Ul. Bože Peričića 5', 43000, 'dubdub'),
(105, 'KBC Dubrava', 'Zagreb', 'Avenija Gojka Šuška 6', 51088, 'kbc89');

-- --------------------------------------------------------

--
-- Table structure for table `donacija`
--

CREATE TABLE `donacija` (
  `id_donacija` int(11) UNSIGNED NOT NULL,
  `kolicina_krvi_donacije` float UNSIGNED NOT NULL,
  `krvna_grupa_zal` varchar(45) COLLATE utf8mb4_croatian_ci NOT NULL,
  `OIB_donora` double UNSIGNED NOT NULL,
  `idlokacija` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `donacija`
--

INSERT INTO `donacija` (`id_donacija`, `kolicina_krvi_donacije`, `krvna_grupa_zal`, `OIB_donora`, `idlokacija`) VALUES
(21, 0.5, '0+', 29389527738, 1),
(22, 0.5, '0-', 92279595902, 1),
(23, 0.5, 'AB+', 10528147607, 1),
(24, 0.5, 'B-', 24821182322, 1),
(27, 0.7, 'AB-', 25905508615, 14),
(28, 0.5, 'B+', 18814952778, 14),
(29, 0.5, 'B-', 46834013129, 14),
(30, 0.5, 'A-', 13115585171, 15),
(31, 0.6, 'A+', 99218368216, 15),
(34, 0.5, 'A-', 13115585171, 15),
(35, 0.5, '0+', 29389527738, 15),
(36, 0.5, 'AB+', 10528147607, 16),
(37, 0.5, 'AB+', 13115585172, 16),
(38, 0.5, 'B-', 24821182322, 16),
(39, 0.7, 'A-', 13115585171, 18),
(40, 0.5, 'AB+', 79220235879, 18),
(41, 0.5, 'B+', 18814952778, 19),
(42, 0.7, 'B-', 46834013129, 18),
(43, 0.6, 'AB-', 57523379503, 19),
(44, 0.5, 'AB-', 57523379503, 19),
(45, 0.7, 'B-', 24821182322, 20),
(46, 0.5, 'B+', 18814952778, 20),
(47, 0.7, 'A+', 6781251619, 1),
(48, 0.6, 'B-', 24821182322, 1),
(49, 0.5, 'A-', 13115585171, 1),
(50, 0.5, 'A+', 99218368216, 1),
(51, 0.5, 'AB-', 25905508615, 1),
(52, 0.5, 'AB-', 25905508615, 15);

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `OIB_donora` double UNSIGNED NOT NULL,
  `krvna_grupa_don` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL,
  `ime_prezime_donora` varchar(45) COLLATE utf8mb4_croatian_ci NOT NULL,
  `datum_rodenja` date NOT NULL,
  `prebivaliste` varchar(45) COLLATE utf8mb4_croatian_ci NOT NULL,
  `postanski_broj` int(10) UNSIGNED NOT NULL,
  `broj_mobitela` int(10) UNSIGNED NOT NULL,
  `mail_donora` varchar(45) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `spol` varchar(2) COLLATE utf8mb4_croatian_ci NOT NULL,
  `adresa_donora` varchar(45) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `username` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL,
  `password` varchar(10) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `br_donacija` int(11) DEFAULT NULL,
  `image` varchar(300) COLLATE utf8mb4_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`OIB_donora`, `krvna_grupa_don`, `ime_prezime_donora`, `datum_rodenja`, `prebivaliste`, `postanski_broj`, `broj_mobitela`, `mail_donora`, `spol`, `adresa_donora`, `username`, `password`, `br_donacija`, `image`) VALUES
(6781251619, 'A+', 'Romano Polić', '1998-01-05', 'Rijeka', 51000, 998861132, 'romano@gmail.com', 'M', 'Rastočine 8', 'romano12', 'romano', 1, 'romano_polic.jpg'),
(10528147607, 'AB+', 'Domagoj Buljubašić', '1995-02-03', 'Zagreb', 51000, 954472385, 'dodoz43@gmail.com', 'M', 'Turnići 12', 'domagoj', 'dodo123', 7, 'image2.jpg'),
(13115585171, 'A-', 'Marko Stojaković', '1960-02-12', 'Zagreb', 51000, 924563789, 'marko_stokjo@gmail.com', 'M', 'Grabovac', 'marko', 'marko123', 23, 'image3.jpg'),
(13115585172, 'AB+', 'Maja Vrsaljko', '1998-11-01', 'Rijeka', 23000, 924563780, 'mvrsaljko@riteh.hr', 'Z', 'Benkovac 22', 'maja2', 'majab91', 0, 'image11.png'),
(18814952778, 'B+', 'Tyrion Lannister', '1968-06-10', 'Rijeka', 51000, 997763321, 'tyrion123@gmail.com', 'M', 'Casterly Rock', 'tyrion', 'got123', 27, 'image12.jpg'),
(24821182322, 'B-', 'Patricija Dadić', '1992-05-23', 'Rijeka', 51000, 998751246, 'patry@gmail.com', 'Z', 'Kapelska', 'patricija', '123456', 11, 'image5.png'),
(25905508615, 'AB-', 'Katarina Anić', '2019-01-12', 'Rijeka', 51000, 914537810, 'anica_frketic@gmail.com', 'Z', 'Vojni put 15', 'katarina', 'anica123', 17, 'katarina_anic.jpg'),
(29389527738, '0+', 'Maja Vukelić', '1987-12-21', 'Kaštel Sućurac', 21213, 924789234, 'majavuk@hotmail.com', 'Z', 'Suvača 10', 'maja', 'maja123', 14, 'image6.jpg'),
(46834013129, 'B-', 'Marija Čupić', '2018-08-31', 'Zagreb', 51000, 567345, 'cucic@gmail.com', 'Z', 'Ilica 12', 'mare', 'marica', 0, 'image5.png'),
(47903334648, '0-', 'Jasmin Stanković', '1990-05-08', 'Rijeka', 51000, 925563594, 'jasmin456@gmail.com', 'Z', 'Adamićeva 3', 'jasmin', 'jasmin123', 14, 'image8.jpg'),
(57523379503, 'AB-', 'Dalibor Trumbetić', '1972-06-12', 'Split', 21000, 998845574, 'dalibor_trumbetic@gmail.com', 'M', 'Trumbićeva obala 13', 'dali12', '12345', 12, 'image4.jpg'),
(62039216922, 'A+', 'Irma Plantak', '1992-06-18', 'Zagreb', 21000, 953341523, 'irma123@gmail.com', 'Z', 'Ante Starčević 10', 'irma', 'irma123', 15, 'image7.jpg'),
(79220235879, 'AB+', 'Vinko Sabić', '1983-08-05', 'Split', 21000, 991132563, 'vino_sab@gmail.com', 'M', 'Šabanova 24', 'vinko', 'vinko123', 10, 'image10.jpg'),
(92279595902, '0-', 'Karolina Tušek', '1965-09-06', 'Split', 21000, 991142589, 'karolina_tusek@gmail.com', 'Z', 'Hercegovačka 1', 'karolina', 'karolina', 23, 'image6.jpg'),
(99218368216, 'A+', 'Klara Vidaković', '1970-05-02', 'Split', 21000, 994573109, 'klara1234@gmail.com', 'Z', 'Pojišanska 18', 'klara', 'klara213', 21, 'image9.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `donor_OIB_donora` double UNSIGNED NOT NULL,
  `OIB_prijatelja` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`donor_OIB_donora`, `OIB_prijatelja`) VALUES
(29389527738, 62039216922),
(25905508615, 62039216922),
(25905508615, 57523379503),
(29389527738, 62039216922),
(25905508615, 62039216922),
(25905508615, 57523379503),
(57523379503, 13115585171),
(25905508615, 13115585172),
(62039216922, 25905508615),
(29389527738, 25905508615),
(57523379503, 25905508615),
(13115585172, 25905508615),
(13115585172, 10528147607),
(25905508615, 10528147607),
(10528147607, 25905508615),
(25905508615, 6781251619),
(10528147607, 6781251619),
(24821182322, 6781251619),
(79220235879, 6781251619),
(92279595902, 6781251619),
(47903334648, 6781251619),
(6781251619, 25905508615),
(24821182322, 25905508615),
(25905508615, 46834013129),
(25905508615, 47903334648),
(10528147607, 47903334648);

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE `following` (
  `donor_OIB_donora` double UNSIGNED NOT NULL,
  `OIB_prijatelja` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `following`
--

INSERT INTO `following` (`donor_OIB_donora`, `OIB_prijatelja`) VALUES
(62039216922, 74678436),
(62039216922, 29389527738),
(62039216922, 25905508615),
(62039216922, 74678436),
(62039216922, 29389527738),
(62039216922, 25905508615),
(13115585171, 57523379503),
(13115585172, 25905508615),
(25905508615, 62039216922),
(25905508615, 29389527738),
(25905508615, 57523379503),
(25905508615, 13115585172),
(10528147607, 13115585172),
(10528147607, 25905508615),
(25905508615, 10528147607),
(6781251619, 25905508615),
(6781251619, 10528147607),
(6781251619, 24821182322),
(6781251619, 79220235879),
(6781251619, 92279595902),
(6781251619, 47903334648),
(25905508615, 6781251619),
(25905508615, 24821182322),
(46834013129, 25905508615),
(47903334648, 25905508615),
(47903334648, 10528147607);

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

CREATE TABLE `komentari` (
  `user_autora` varchar(300) COLLATE utf8mb4_croatian_ci NOT NULL,
  `autor` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL,
  `idbolnica_bol` int(10) UNSIGNED NOT NULL,
  `tekst_komentara` varchar(300) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `datum_kom` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`user_autora`, `autor`, `idbolnica_bol`, `tekst_komentara`, `datum_kom`) VALUES
('domagoj', 'Domagoj Buljubašić', 101, 'Nekreativni komentar1', '2019-01-30 20:43:14'),
('domagoj', 'Domagoj Buljubašić', 101, 'Nekreativni komentar2', '2019-01-30 20:43:18'),
('domagoj', 'Domagoj Buljubašić', 101, 'Nekreativni komentar3', '2019-01-30 20:43:21'),
('domagoj', 'Domagoj Buljubašić', 101, 'Nekreativni komentar4', '2019-01-30 20:43:27'),
('vinko', 'Vinko Sabić', 101, 'Pozdrav, koliko vremena treba proći između dvije donacije ? ', '2019-01-30 20:44:06'),
('tyrion', 'Tyrion Lannister', 101, 'Valar morgulis! Za muškarce 3, za žene 4', '2019-01-30 20:44:52'),
('101', 'KBC Sušak', 101, 'Pozivamo sve naše donore i zainteresirane na sutrašnje predavanje na temu DONACIJA ORGANA', '2019-01-30 20:45:29'),
('101', 'KBC Sušak', 101, '12345', '2019-02-02 10:38:06'),
('101', 'KBC Sušak', 101, '12345', '2019-02-02 10:38:08'),
('101', 'KBC Sušak', 101, '12354', '2019-02-02 10:38:12'),
('101', 'KBC Sušak', 101, 'rjtzjhsrtjhf', '2019-02-02 10:38:21'),
('101', 'KBC Sušak', 101, 'fghjsfghsfg', '2019-02-02 10:38:22'),
('101', 'KBC Sušak', 101, 'sfghsfgh', '2019-02-02 10:38:24'),
('katarina', 'Katarina Anić', 101, 'bok', '2019-02-02 10:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `lokacija`
--

CREATE TABLE `lokacija` (
  `id_lokacije` int(11) UNSIGNED NOT NULL,
  `grad` varchar(45) COLLATE utf8mb4_croatian_ci NOT NULL,
  `naziv_lokacije` varchar(45) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `adresa_lokacije` varchar(45) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `postanski_broj` int(10) UNSIGNED DEFAULT NULL,
  `datum_dogadaja` date NOT NULL,
  `start` time NOT NULL,
  `kraj` time NOT NULL,
  `image` varchar(300) COLLATE utf8mb4_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `lokacija`
--

INSERT INTO `lokacija` (`id_lokacije`, `grad`, `naziv_lokacije`, `adresa_lokacije`, `postanski_broj`, `datum_dogadaja`, `start`, `kraj`, `image`) VALUES
(1, 'Rijeka', 'Studentski Centar Rijeka', 'Radmile Matejcic 6', 51000, '2018-12-28', '10:00:00', '12:00:00', 'studentski_centar.jpg'),
(14, 'Zagreb', 'Fakultet Elektrotehnike i Računarstva', 'Unska ul. 3', 10000, '2019-01-15', '15:00:00', '16:00:00', 'fer_02.jpg'),
(15, 'Rijeka', 'Tehnički fakultet Rijeka', 'Vukovarska 58', 51000, '2018-12-10', '15:00:00', '17:00:00', 'tehnicki.jpg'),
(16, 'Rijeka', 'Filozofski fakultet Rijeka', 'Sveučilišna Avenija 4', 51000, '2018-09-12', '12:00:00', '15:00:00', 'filozofski.jpg'),
(17, 'Benkovac', 'Gradska Knjiznica Benkovac', ' Šetalište kneza Branimira 46', 23420, '2018-03-08', '15:00:00', '19:00:00', 'benkovac.jpg'),
(18, 'Rijeka', 'Crveni križ Rijeka', 'Trg Republike Hrvatske 2', 51000, '2018-06-12', '12:00:00', '15:00:00', 'crveni_kriz.png'),
(19, 'Rijeka', 'Filozofski fakultet Rijeka', ' Sveučilišna Avenija 4', 51000, '2017-10-10', '15:00:00', '18:00:00', 'fzs_ri.JPG'),
(20, 'Rijeka', 'Gradska knjižnica Rijeka', ' Ul. Matije Gupca 23', 51000, '2018-10-15', '13:00:00', '14:00:00', 'Gorana-Tuskan-v.d.-ravnateljice-Gradske-knjiznice-Rijeka_ca_large.jpg'),
(21, 'Rijeka', 'Tehnički Fakultet Rijeka', 'Vukovarska 58', 51000, '2019-01-31', '10:00:00', '12:00:00', 'tehnicki.jpg'),
(22, 'Rijeka', 'Gradska Knjižnica Rijeka', 'Ul. Matije Gupca 23', 51000, '2019-01-31', '16:00:00', '18:00:00', 'Gorana-Tuskan-v.d.-ravnateljice-Gradske-knjiznice-Rijeka_ca_large.jpg'),
(23, 'Rijeka', 'Medicinski Fakultet Rijeka', 'Ul. Braće Branchetta 20/1', 51000, '2019-01-30', '08:00:00', '09:00:00', 'medri.jpg'),
(24, 'Rijeka', 'Studentski Centar Rijeka', 'Ul. Radmile Matejčić 5', 51000, '2019-02-22', '16:00:00', '16:00:00', 'scri.jpg'),
(25, 'Rijeka', 'Crveni Križ Rijeka', 'Trg Republike Hrvatske 2', 51000, '2019-03-08', '12:00:00', '15:00:00', 'crveni_kriz.jpg'),
(26, 'Zagreb', 'Prehrambeno tehnološki fakultet', 'Pierottijeva ul. 6', 10000, '2019-02-12', '15:00:00', '16:00:00', 'pbf_zg.jpg'),
(27, 'Zagreb', 'Medicinski fakultet Zagreb', 'Šalata ul. 2', 10000, '2019-02-14', '16:00:00', '19:00:00', 'med_zg.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `moj_event`
--

CREATE TABLE `moj_event` (
  `OIB_donora_don` double UNSIGNED NOT NULL,
  `id_lokacije` int(11) UNSIGNED NOT NULL,
  `prisutnost` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `moj_event`
--

INSERT INTO `moj_event` (`OIB_donora_don`, `id_lokacije`, `prisutnost`) VALUES
(29389527738, 1, 1),
(47903334648, 1, 1),
(29389527738, 1, 1),
(92279595902, 1, 1),
(62039216922, 1, -1),
(10528147607, 1, 1),
(24821182322, 1, 1),
(25905508615, 14, 1),
(18814952778, 14, 1),
(46834013129, 14, 1),
(13115585171, 14, -1),
(13115585171, 15, 1),
(99218368216, 15, 1),
(13115585171, 15, 1),
(29389527738, 15, 1),
(29389527738, 15, 1),
(13115585171, 15, 1),
(47903334648, 15, 1),
(62039216922, 15, 1),
(99218368216, 15, -1),
(13115585171, 15, -1),
(10528147607, 16, 1),
(13115585172, 16, 1),
(24821182322, 16, 1),
(13115585171, 18, -1),
(79220235879, 18, 1),
(18814952778, 18, 1),
(46834013129, 18, 1),
(57523379503, 19, 1),
(57523379503, 19, 1),
(24821182322, 20, 1),
(18814952778, 20, 1),
(6781251619, 1, 1),
(24821182322, 1, 1),
(13115585171, 1, 1),
(99218368216, 1, 1),
(10528147607, 26, 0),
(25905508615, 21, 0),
(25905508615, 16, 1),
(25905508615, 14, 1),
(6781251619, 22, 0),
(6781251619, 23, 0),
(13115585172, 21, 0),
(13115585172, 23, 0),
(13115585172, 24, 0),
(13115585171, 26, 0),
(18814952778, 21, 0),
(18814952778, 23, 0),
(46834013129, 26, 0),
(47903334648, 21, 0),
(47903334648, 23, 0),
(47903334648, 24, 0),
(25905508615, 23, 0);

-- --------------------------------------------------------

--
-- Table structure for table `obavijesti`
--

CREATE TABLE `obavijesti` (
  `id_obavijesti` int(11) NOT NULL,
  `OIBdonora` double NOT NULL,
  `ID_posiljatelja` double UNSIGNED NOT NULL,
  `tekst_obav` varchar(1000) COLLATE utf8mb4_croatian_ci NOT NULL,
  `datum_obav` datetime NOT NULL,
  `procitano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `obavijesti`
--

INSERT INTO `obavijesti` (`id_obavijesti`, `OIBdonora`, `ID_posiljatelja`, `tekst_obav`, `datum_obav`, `procitano`) VALUES
(624, 6781251619, 1, '16.1 Predavanje na temu doniranja organa', '2019-01-15 16:28:25', 0),
(625, 13115585172, 1, '16.1 Predavanje na temu doniranja organa', '2019-01-15 16:28:25', 0),
(626, 18814952778, 1, '16.1 Predavanje na temu doniranja organa', '2019-01-15 16:28:25', 0),
(627, 24821182322, 1, '16.1 Predavanje na temu doniranja organa', '2019-01-15 16:28:25', 0),
(628, 25905508615, 1, '16.1 Predavanje na temu doniranja organa', '2019-01-15 16:28:25', 1),
(629, 47903334648, 1, '16.1 Predavanje na temu doniranja organa', '2019-01-15 16:28:25', 0),
(630, 6781251619, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(631, 10528147607, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(632, 13115585171, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(633, 13115585172, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(634, 18814952778, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(635, 24821182322, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(636, 25905508615, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 1),
(637, 29389527738, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(638, 46834013129, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(639, 47903334648, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(640, 57523379503, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(641, 62039216922, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(642, 79220235879, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(643, 92279595902, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(644, 99218368216, 1, 'Sretan Božić i Nova Godina', '2019-01-30 16:28:47', 0),
(645, 6781251619, 1, '17.12 Humanitarni koncert za Stipu', '2019-01-30 16:29:28', 0),
(646, 6781251619, 1, 'Trenutno je manjak vaše krvne grupe u zalihi. Razmislite o donaciji! Hvala!', '2019-01-30 16:29:37', 0),
(647, 25905508615, 6781251619, 'Hej Kato..kako si?', '2019-01-29 17:08:41', 1),
(648, 6781251619, 25905508615, 'Dobro, kako si ti ? ', '2019-01-29 17:19:18', 0),
(649, 13115585172, 25905508615, 'hej', '2019-01-27 17:19:46', 0),
(650, 25905508615, 13115585172, 'hej', '2019-01-27 17:19:52', 1),
(651, 13115585172, 25905508615, 'jel dolaziš sutra na rwa prezentaciju ? ', '2019-01-27 17:21:30', 0),
(652, 25905508615, 13115585172, 'naravno!!', '2019-01-27 17:41:59', 1),
(653, 25905508615, 6781251619, 'evo ide...sutra doniram hehe', '2019-01-29 17:44:07', 1),
(654, 10528147607, 25905508615, 'hej dodo', '2019-01-30 17:44:51', 0),
(655, 25905508615, 10528147607, 'hej kato', '2019-01-30 17:45:10', 1),
(656, 10528147607, 25905508615, 'oćeš sutra u menzu poslije doniranja ? ', '2019-01-30 17:45:32', 0),
(657, 25905508615, 10528147607, 'neću...žurim učiti', '2019-01-30 17:45:46', 1),
(658, 10528147607, 25905508615, 'ajde samo daj...sretno!', '2019-01-30 17:53:18', 1),
(659, 13115585172, 25905508615, 'xD', '2019-01-27 18:15:25', 1),
(660, 25905508615, 13115585172, 'onda se vidimo!', '2019-01-27 18:16:45', 1),
(661, 13115585172, 25905508615, 'Može kava poslije ? ', '2019-01-27 18:21:37', 1),
(662, 25905508615, 13115585172, 'da u alienu!', '2019-01-27 18:22:29', 1),
(663, 6781251619, 1, 'Sutra svi u 10:15 na prezentaciju GROBENKA', '2019-01-30 18:52:59', 0),
(664, 13115585172, 1, 'Sutra svi u 10:15 na prezentaciju GROBENKA', '2019-01-30 18:52:59', 0),
(665, 18814952778, 1, 'Sutra svi u 10:15 na prezentaciju GROBENKA', '2019-01-30 18:52:59', 0),
(666, 24821182322, 1, 'Sutra svi u 10:15 na prezentaciju GROBENKA', '2019-01-30 18:52:59', 0),
(667, 47903334648, 1, 'Sutra svi u 10:15 na prezentaciju GROBENKA', '2019-01-30 18:52:59', 0),
(668, 10528147607, 25905508615, 'ps. imaš materijale ? ', '2019-01-30 19:43:14', 0),
(669, 13115585172, 25905508615, 'Može', '2019-01-27 19:54:27', 1),
(670, 25905508615, 13115585172, ':)', '2019-01-27 19:55:14', 1),
(671, 6781251619, 25905508615, 'gdje ? ', '2019-01-29 20:03:53', 0),
(672, 6781251619, 1, '15.2 godišnja dodjela nagrada najistaknutijim donorima', '2019-01-30 21:02:09', 0),
(673, 13115585172, 1, '15.2 godišnja dodjela nagrada najistaknutijim donorima', '2019-01-30 21:02:09', 0),
(674, 18814952778, 1, '15.2 godišnja dodjela nagrada najistaknutijim donorima', '2019-01-30 21:02:09', 0),
(675, 24821182322, 1, '15.2 godišnja dodjela nagrada najistaknutijim donorima', '2019-01-30 21:02:09', 0),
(676, 25905508615, 1, '15.2 godišnja dodjela nagrada najistaknutijim donorima', '2019-01-30 21:02:09', 1),
(677, 47903334648, 1, '15.2 godišnja dodjela nagrada najistaknutijim donorima', '2019-01-30 21:02:09', 0),
(678, 13115585172, 25905508615, 'di si majo', '2019-02-02 10:42:22', 0),
(679, 6781251619, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(680, 10528147607, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(681, 13115585171, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(682, 13115585172, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(683, 18814952778, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(684, 24821182322, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(685, 25905508615, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(686, 29389527738, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(687, 46834013129, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(688, 47903334648, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(689, 57523379503, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(690, 62039216922, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(691, 79220235879, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(692, 92279595902, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(693, 99218368216, 1, 'jhgjhgzi7t', '2019-02-02 10:44:38', 0),
(694, 18814952778, 1, 'drfhdrhrdf', '2019-02-02 10:44:44', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pregled`
--

CREATE TABLE `pregled` (
  `pk_pregled` int(11) NOT NULL,
  `bpm` int(11) NOT NULL,
  `sistolicki` int(11) NOT NULL,
  `datum` datetime NOT NULL,
  `dijastolicki` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `pregled`
--

INSERT INTO `pregled` (`pk_pregled`, `bpm`, `sistolicki`, `datum`, `dijastolicki`) VALUES
(1, 68, 120, '2019-04-03 06:21:22', 80),
(2, 89, 130, '2019-04-03 05:19:14', 79),
(3, 98, 140, '2019-04-03 00:15:00', 90),
(4, 55, 110, '2019-04-03 08:09:00', 50),
(5, 77, 113, '2019-04-04 04:24:00', 69),
(6, 99, 115, '2019-04-04 06:00:00', 47),
(7, 88, 146, '2019-04-04 06:08:00', 77),
(8, 47, 139, '2019-04-04 10:00:00', 75),
(9, 100, 106, '2019-04-04 10:16:00', 65),
(10, 110, 80, '2019-04-04 12:09:00', 30),
(11, 76, 130, '2019-04-04 11:09:00', 80),
(12, 77, 130, '2019-04-04 16:12:00', 100),
(13, 70, 110, '2019-04-04 06:30:00', 70),
(14, 66, 115, '2019-04-04 03:19:11', 78),
(15, 50, 120, '2019-04-04 00:00:34', 80),
(16, 66, 113, '2019-04-04 19:44:58', 79),
(17, 50, 111, '2019-04-04 19:46:50', 89),
(18, 80, 90, '2019-04-04 19:48:43', 70),
(19, 80, 90, '2019-04-04 19:48:55', 80),
(20, 88, 88, '2019-04-04 19:49:21', 88),
(21, 78, 130, '2019-04-04 19:52:19', 77),
(22, 78, 130, '2019-04-04 19:53:06', 77),
(23, 66, 110, '2019-04-04 19:53:16', 90);

-- --------------------------------------------------------

--
-- Table structure for table `zahtjev`
--

CREATE TABLE `zahtjev` (
  `idzahtjev` int(8) UNSIGNED NOT NULL,
  `id_bolnica` int(10) UNSIGNED NOT NULL,
  `kolicina_krvi_zaht` float UNSIGNED NOT NULL,
  `krvna_grupa_zaht` varchar(45) COLLATE utf8mb4_croatian_ci NOT NULL,
  `datum_zahtjeva` date DEFAULT NULL,
  `odobreno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `zahtjev`
--

INSERT INTO `zahtjev` (`idzahtjev`, `id_bolnica`, `kolicina_krvi_zaht`, `krvna_grupa_zaht`, `datum_zahtjeva`, `odobreno`) VALUES
(1, 101, 1.5, 'A+', '2019-01-02', 1),
(5, 102, 2, 'AB-', '2019-01-02', -1),
(6, 104, 2, 'A+', '2019-01-02', -1),
(7, 103, 0.2, 'A+', '2019-01-02', -1),
(25, 101, 0.5, 'AB+', '2019-01-02', -1),
(26, 101, 1.5, 'B+', '2018-12-27', 1),
(27, 101, 5.5, 'A-', '2018-12-12', 1),
(29, 101, 0.4, 'B+', '2019-01-09', 1),
(30, 101, 0.4, 'B+', '2019-01-09', 1),
(31, 101, 0.5, 'A+', '2019-01-10', 1),
(33, 101, 0.5, 'A+', '2019-01-23', 0),
(34, 101, 0.5, 'A+', '2019-01-25', 0),
(36, 101, 52, 'B-', '2019-01-26', 0),
(37, 101, 5, 'B+', '2019-01-29', 1),
(38, 101, 15, 'AB+', '2019-01-30', 1),
(39, 101, 50, 'A+', '2019-01-30', 0),
(41, 104, 50, 'AB-', '2019-01-30', 1),
(42, 103, 40, 'AB+', '2019-01-22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `zaliha`
--

CREATE TABLE `zaliha` (
  `krvna_grupa` varchar(10) COLLATE utf8mb4_croatian_ci NOT NULL,
  `kolicina_grupe` varchar(45) COLLATE utf8mb4_croatian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `zaliha`
--

INSERT INTO `zaliha` (`krvna_grupa`, `kolicina_grupe`) VALUES
('A+', '10'),
('A-', '35.8'),
('AB+', '29.5'),
('AB-', '60.5'),
('B+', '65'),
('B-', '0'),
('0+', '63.5'),
('0-', '21.3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `bolnica`
--
ALTER TABLE `bolnica`
  ADD PRIMARY KEY (`idbolnica`),
  ADD UNIQUE KEY `idbolnica_UNIQUE` (`idbolnica`);

--
-- Indexes for table `donacija`
--
ALTER TABLE `donacija`
  ADD PRIMARY KEY (`id_donacija`),
  ADD UNIQUE KEY `id_donacija_UNIQUE` (`id_donacija`),
  ADD KEY `fk_donacija_donor_idx` (`OIB_donora`),
  ADD KEY `fk_donacija_lokacija1_idx` (`idlokacija`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`OIB_donora`),
  ADD UNIQUE KEY `OIB_donora_UNIQUE` (`OIB_donora`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD KEY `fk_followers_donor1` (`donor_OIB_donora`);

--
-- Indexes for table `following`
--
ALTER TABLE `following`
  ADD KEY `donor_OIB_donora` (`donor_OIB_donora`) USING BTREE;

--
-- Indexes for table `komentari`
--
ALTER TABLE `komentari`
  ADD KEY `id_bolnica_fk` (`idbolnica_bol`);

--
-- Indexes for table `lokacija`
--
ALTER TABLE `lokacija`
  ADD PRIMARY KEY (`id_lokacije`);

--
-- Indexes for table `moj_event`
--
ALTER TABLE `moj_event`
  ADD KEY `OIB_donora_idx` (`OIB_donora_don`),
  ADD KEY `lokacija_fk` (`id_lokacije`);

--
-- Indexes for table `obavijesti`
--
ALTER TABLE `obavijesti`
  ADD PRIMARY KEY (`id_obavijesti`),
  ADD KEY `OIB_donora_fk` (`OIBdonora`);

--
-- Indexes for table `pregled`
--
ALTER TABLE `pregled`
  ADD PRIMARY KEY (`pk_pregled`);

--
-- Indexes for table `zahtjev`
--
ALTER TABLE `zahtjev`
  ADD PRIMARY KEY (`idzahtjev`),
  ADD UNIQUE KEY `idzahtjev_UNIQUE` (`idzahtjev`),
  ADD KEY `fk_zahtjev_bolnica1_idx` (`id_bolnica`);

--
-- Indexes for table `zaliha`
--
ALTER TABLE `zaliha`
  ADD PRIMARY KEY (`krvna_grupa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donacija`
--
ALTER TABLE `donacija`
  MODIFY `id_donacija` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `lokacija`
--
ALTER TABLE `lokacija`
  MODIFY `id_lokacije` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `obavijesti`
--
ALTER TABLE `obavijesti`
  MODIFY `id_obavijesti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=695;

--
-- AUTO_INCREMENT for table `pregled`
--
ALTER TABLE `pregled`
  MODIFY `pk_pregled` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `zahtjev`
--
ALTER TABLE `zahtjev`
  MODIFY `idzahtjev` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `fk_followers_donor1` FOREIGN KEY (`donor_OIB_donora`) REFERENCES `donor` (`OIB_donora`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `following`
--
ALTER TABLE `following`
  ADD CONSTRAINT `fk_following_donor1` FOREIGN KEY (`donor_OIB_donora`) REFERENCES `donor` (`OIB_donora`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `komentari`
--
ALTER TABLE `komentari`
  ADD CONSTRAINT `id_bolnica_fk` FOREIGN KEY (`idbolnica_bol`) REFERENCES `bolnica` (`idbolnica`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `moj_event`
--
ALTER TABLE `moj_event`
  ADD CONSTRAINT `OIB_donora_don` FOREIGN KEY (`OIB_donora_don`) REFERENCES `donor` (`OIB_donora`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lokacija_fk` FOREIGN KEY (`id_lokacije`) REFERENCES `lokacija` (`id_lokacije`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `obavijesti`
--
ALTER TABLE `obavijesti`
  ADD CONSTRAINT `OIB_donora_fk` FOREIGN KEY (`OIBdonora`) REFERENCES `donor` (`OIB_donora`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zahtjev`
--
ALTER TABLE `zahtjev`
  ADD CONSTRAINT `id_bolnice_fk` FOREIGN KEY (`id_bolnica`) REFERENCES `bolnica` (`idbolnica`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
