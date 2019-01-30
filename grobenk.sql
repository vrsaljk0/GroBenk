-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 30, 2019 at 06:47 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

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

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL,
  PRIMARY KEY (`username`)
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

DROP TABLE IF EXISTS `bolnica`;
CREATE TABLE IF NOT EXISTS `bolnica` (
  `idbolnica` int(10) UNSIGNED NOT NULL,
  `naziv_bolnice` varchar(45) COLLATE utf8mb4_croatian_ci NOT NULL,
  `grad` varchar(45) COLLATE utf8mb4_croatian_ci NOT NULL,
  `adresa_bolnice` varchar(45) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `postanski_broj` int(11) DEFAULT NULL,
  `password` varchar(10) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`idbolnica`),
  UNIQUE KEY `idbolnica_UNIQUE` (`idbolnica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `bolnica`
--

INSERT INTO `bolnica` (`idbolnica`, `naziv_bolnice`, `grad`, `adresa_bolnice`, `postanski_broj`, `password`) VALUES
(101, 'KBC Susak', 'Zagreb', ' Ul. Tome Strižića 3', 51001, '101'),
(102, 'KBC Sisak', 'Sisak', 'Ul. Josipa Jurja Strossmayera 59', 57474, 'kbcri56'),
(103, 'KBC Zagreb', 'Zagreb', 'Kišpatićeva ul. 12', 50000, 'zajc45'),
(104, 'KBC', 'Zadar', 'Ul. Bože Peričića 5', 43000, 'dubdub'),
(105, 'KBC Dubrava', 'Zagreb', 'Avenija Gojka Šuška 6', 51088, 'kbc89');

-- --------------------------------------------------------

--
-- Table structure for table `donacija`
--

DROP TABLE IF EXISTS `donacija`;
CREATE TABLE IF NOT EXISTS `donacija` (
  `id_donacija` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kolicina_krvi_donacije` float UNSIGNED NOT NULL,
  `krvna_grupa_zal` varchar(45) COLLATE utf8mb4_croatian_ci NOT NULL,
  `OIB_donora` double UNSIGNED NOT NULL,
  `idlokacija` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_donacija`),
  UNIQUE KEY `id_donacija_UNIQUE` (`id_donacija`),
  KEY `fk_donacija_donor_idx` (`OIB_donora`),
  KEY `fk_donacija_lokacija1_idx` (`idlokacija`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

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

DROP TABLE IF EXISTS `donor`;
CREATE TABLE IF NOT EXISTS `donor` (
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
  `image` varchar(300) COLLATE utf8mb4_croatian_ci NOT NULL,
  PRIMARY KEY (`OIB_donora`),
  UNIQUE KEY `OIB_donora_UNIQUE` (`OIB_donora`),
  UNIQUE KEY `username` (`username`)
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
(25905508615, 'AB-', 'Katarina Anić', '2019-01-12', 'Zagreb', 51000, 914537810, 'anica_frketic@gmail.com', 'Z', 'Vojni put 15', 'katarina', 'anica123', 17, 'katarina_anic.jpg'),
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

DROP TABLE IF EXISTS `followers`;
CREATE TABLE IF NOT EXISTS `followers` (
  `donor_OIB_donora` double UNSIGNED NOT NULL,
  `OIB_prijatelja` double DEFAULT NULL,
  KEY `fk_followers_donor1` (`donor_OIB_donora`)
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

DROP TABLE IF EXISTS `following`;
CREATE TABLE IF NOT EXISTS `following` (
  `donor_OIB_donora` double UNSIGNED NOT NULL,
  `OIB_prijatelja` double DEFAULT NULL,
  KEY `donor_OIB_donora` (`donor_OIB_donora`) USING BTREE
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

DROP TABLE IF EXISTS `komentari`;
CREATE TABLE IF NOT EXISTS `komentari` (
  `user_autora` varchar(300) COLLATE utf8mb4_croatian_ci NOT NULL,
  `autor` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL,
  `idbolnica_bol` int(10) UNSIGNED NOT NULL,
  `tekst_komentara` varchar(300) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `datum_kom` datetime NOT NULL,
  KEY `id_bolnica_fk` (`idbolnica_bol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`user_autora`, `autor`, `idbolnica_bol`, `tekst_komentara`, `datum_kom`) VALUES
('katarina', 'Katarina Anić', 101, 'komenar1\r\n', '2019-01-30 16:45:05'),
('katarina', 'Katarina Anić', 101, 'komentar2', '2019-01-30 16:45:10'),
('katarina', 'Katarina Anić', 101, 'komentar3', '2019-01-30 16:45:13'),
('katarina', 'Katarina Anić', 101, 'komentar4', '2019-01-30 16:45:18'),
('katarina', 'Katarina Anić', 101, 'komentar5', '2019-01-30 16:45:23'),
('katarina', 'Katarina Anić', 101, 'komentar6', '2019-01-30 16:45:27'),
('romano12', 'Romano Polić', 101, 'komentar7', '2019-01-30 16:46:09'),
('romano12', 'Romano Polić', 101, 'test1', '2019-01-30 16:46:12'),
('domagoj', 'Domagoj Buljubašić', 101, 'Danas je oblačan dan', '2019-01-30 16:46:36'),
('domagoj', 'Domagoj Buljubašić', 101, 'komentar10', '2019-01-30 16:46:42'),
('domagoj', 'Domagoj Buljubašić', 101, 'Koliko vremena treba proći između dvije donacije ?', '2019-01-30 16:47:00'),
('katarina', 'Katarina Anić', 101, 'Za muškarce 4 mjeseca, a za žene 3 ', '2019-01-30 17:05:13'),
('101', 'KBC Susak', 101, 'Ne draga Katarina, za muškarce je 3 mjeseca, a za žene 4 :)', '2019-01-30 17:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `lokacija`
--

DROP TABLE IF EXISTS `lokacija`;
CREATE TABLE IF NOT EXISTS `lokacija` (
  `id_lokacije` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `grad` varchar(45) COLLATE utf8mb4_croatian_ci NOT NULL,
  `naziv_lokacije` varchar(45) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `adresa_lokacije` varchar(45) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `postanski_broj` int(10) UNSIGNED DEFAULT NULL,
  `datum_dogadaja` date NOT NULL,
  `start` time NOT NULL,
  `kraj` time NOT NULL,
  `image` varchar(300) COLLATE utf8mb4_croatian_ci NOT NULL,
  PRIMARY KEY (`id_lokacije`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

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

DROP TABLE IF EXISTS `moj_event`;
CREATE TABLE IF NOT EXISTS `moj_event` (
  `OIB_donora_don` double UNSIGNED NOT NULL,
  `id_lokacije` int(11) UNSIGNED NOT NULL,
  `prisutnost` tinyint(4) NOT NULL,
  KEY `OIB_donora_idx` (`OIB_donora_don`),
  KEY `lokacija_fk` (`id_lokacije`)
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
(47903334648, 24, 0);

-- --------------------------------------------------------

--
-- Table structure for table `obavijesti`
--

DROP TABLE IF EXISTS `obavijesti`;
CREATE TABLE IF NOT EXISTS `obavijesti` (
  `id_obavijesti` int(11) NOT NULL AUTO_INCREMENT,
  `OIBdonora` double NOT NULL,
  `ID_posiljatelja` double UNSIGNED NOT NULL,
  `tekst_obav` varchar(100) COLLATE utf8mb4_croatian_ci NOT NULL,
  `datum_obav` datetime NOT NULL,
  `procitano` int(11) NOT NULL,
  PRIMARY KEY (`id_obavijesti`),
  KEY `OIB_donora_fk` (`OIBdonora`)
) ENGINE=InnoDB AUTO_INCREMENT=663 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

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
(647, 25905508615, 6781251619, 'Hej Kato..kako si?', '2019-01-30 17:08:41', 1),
(648, 6781251619, 25905508615, 'Dobro, kako si ti ? ', '2019-01-30 17:19:18', 0),
(649, 13115585172, 25905508615, 'hej', '2019-01-30 17:19:46', 0),
(650, 25905508615, 13115585172, 'hej', '2019-01-30 17:19:52', 1),
(651, 13115585172, 25905508615, 'jel dolaziš sutra na rwa prezentaciju ? ', '2019-01-30 17:21:30', 0),
(652, 25905508615, 13115585172, 'naravno!!', '2019-01-30 17:41:59', 1),
(653, 25905508615, 6781251619, 'evo ide...sutra doniram hehe', '2019-01-30 17:44:07', 1),
(654, 10528147607, 25905508615, 'hej dodo', '2019-01-30 17:44:51', 0),
(655, 25905508615, 10528147607, 'hej kato', '2019-01-30 17:45:10', 1),
(656, 10528147607, 25905508615, 'oćeš sutra u menzu poslije doniranja ? ', '2019-01-30 17:45:32', 0),
(657, 25905508615, 10528147607, 'neću...žurim učiti', '2019-01-30 17:45:46', 1),
(658, 10528147607, 25905508615, 'ajde samo daj...sretno!', '2019-01-30 17:53:18', 1),
(659, 13115585172, 25905508615, 'xD', '2019-01-30 18:15:25', 1),
(660, 25905508615, 13115585172, 'onda se vidimo!', '2019-01-30 18:16:45', 1),
(661, 13115585172, 25905508615, 'Može kava poslije ? ', '2019-01-30 18:21:37', 1),
(662, 25905508615, 13115585172, 'da u alienu!', '2019-01-30 18:22:29', 0);

-- --------------------------------------------------------

--
-- Table structure for table `zahtjev`
--

DROP TABLE IF EXISTS `zahtjev`;
CREATE TABLE IF NOT EXISTS `zahtjev` (
  `idzahtjev` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_bolnica` int(10) UNSIGNED NOT NULL,
  `kolicina_krvi_zaht` float UNSIGNED NOT NULL,
  `krvna_grupa_zaht` varchar(45) COLLATE utf8mb4_croatian_ci NOT NULL,
  `datum_zahtjeva` date DEFAULT NULL,
  `odobreno` int(11) NOT NULL,
  PRIMARY KEY (`idzahtjev`),
  UNIQUE KEY `idzahtjev_UNIQUE` (`idzahtjev`),
  KEY `fk_zahtjev_bolnica1_idx` (`id_bolnica`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

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
(39, 101, 50, 'A+', '2019-01-30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `zaliha`
--

DROP TABLE IF EXISTS `zaliha`;
CREATE TABLE IF NOT EXISTS `zaliha` (
  `krvna_grupa` varchar(10) COLLATE utf8mb4_croatian_ci NOT NULL,
  `kolicina_grupe` varchar(45) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`krvna_grupa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `zaliha`
--

INSERT INTO `zaliha` (`krvna_grupa`, `kolicina_grupe`) VALUES
('A+', '10'),
('A-', '35.8'),
('AB+', '29.5'),
('AB-', '110.5'),
('B+', '65'),
('B-', '0'),
('0+', '63.5'),
('0-', '21.3');

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
