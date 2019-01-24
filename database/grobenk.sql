-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 24, 2019 at 02:34 PM
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
(101, 'KBC Susak', 'Rijeka', 'Kreï¿½imirova 47', 51001, '105'),
(102, 'KBC Sisak', 'Sisak', 'Sisacka 13', 57474, 'kbcri56'),
(103, 'KBC Zagreb', 'Zagreb', 'Ilica 15', 50000, 'zajc45'),
(104, 'KBC', 'Zadar', 'Zadarska 13', 43000, 'dubdub'),
(105, 'KBC Draga', 'Draga', 'Kelinova 14', 51088, 'kbc89');

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `donacija`
--

INSERT INTO `donacija` (`id_donacija`, `kolicina_krvi_donacije`, `krvna_grupa_zal`, `OIB_donora`, `idlokacija`) VALUES
(14, 0.5, 'A+', 62039216922, 2),
(15, 0.6, 'AB-', 57523379503, 2),
(16, 0.2, 'B+', 18814952778, 2),
(17, 0.5, 'AB-', 25905508615, 11),
(18, 0.5, 'AB-', 25905508615, 10),
(19, 0.2, 'A+', 62039216922, 1),
(20, 0.4, 'B+', 18814952778, 12);

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
(6781251619, 'A+', 'Romano Polix', '2019-01-11', '', 51000, 998861132, 'romano@gmail.com', 'M', 'RastoÄine 8', 'romano12', 'romano', 0, 'mario_PNG55.png'),
(10528147607, 'A+', 'Domagoj Buljubasic', '1995-02-03', 'Zagreb', 51000, 954472385, 'dodoz43@gmail.com', 'M', 'Turni?i 12', 'domagoj', 'dodo123', 7, 'image2.jpg'),
(13115585171, 'A-', 'Marko Stojakovi?', '1960-02-12', 'Zagreb', 51000, 924563789, 'marko_stokjo@gmail.com', 'M', 'Grabovac', 'marko', 'marko123', 23, 'image3.jpg'),
(13115585172, 'AB+', 'Maja Vrsaljko', '1998-11-01', 'Zadar', 23000, 924563780, 'mvrsaljko@riteh.hr', 'Z', 'Benkovac 22', 'maja2', 'majab91', 0, 'image11.png'),
(18814952778, 'B+', 'Tyrion Lannister', '1968-06-10', 'Kings Landing', 51000, 997763321, 'tyrion123@gmail.com', 'M', 'Casterly Rock', 'tyrion', 'got123', 27, 'image12.jpg'),
(24821182322, 'B-', 'Patricija Dadi?', '1992-05-23', 'Rijeka', 51000, 998751246, 'patry@gmail.com', 'Z', 'Kapelska', 'patricija', '123456', 11, 'image5.png'),
(25905508615, 'AB-', 'Katarina Ani?', '2019-01-12', 'Zagreb', 51000, 914537810, 'anica_frketic@gmail.com', 'Z', 'Vojni put 14', 'katarina', 'anica6', 17, 'image1.jpg'),
(29389527738, '0+', 'Maja Vukelix', '1987-12-21', 'Kaï¿½tel Sućurac', 21213, 924789234, 'majavuk@hotmail.com', 'Z', 'Suva?a 10', 'maja', 'maja123', 14, 'image6.jpg'),
(46834013129, 'B-', 'Marija čćčćčćč', '2018-08-31', 'Zagreb', 51000, 567345, 'cucic@gmail.com', 'Z', 'Ilica 12', 'mare', 'marica', 0, 'image5.png'),
(47903334648, '0-', 'Jasmin Stankovi?', '1990-05-08', 'Rijeka', 51000, 925563594, 'jasmin456@gmail.com', 'Z', 'Adami?eva 3', 'jasmin', 'jasmin123', 14, 'image8.jpg'),
(57523379503, 'AB-', 'Dalibor Trumbeti?', '1972-06-12', 'Split', 21000, 998845574, 'dalibor_trumbetic@gmail.com', 'M', 'Trumbi?eva obala 13', 'dali12', '12345', 12, 'image4.jpg'),
(62039216922, 'A+', 'Irma Plantak', '1992-06-18', 'Zagreb', 21000, 953341523, 'irma123@gmail.com', 'Z', 'Ante Star?evi?a 10', 'irma', 'irma123', 15, 'image7.jpg'),
(79220235879, 'AB+', 'Vinko Sabic', '1983-08-05', 'Split', 21000, 991132563, 'vino_sab@gmail.com', 'M', 'ï¿½abanova 24', 'vinko', 'vinko123', 10, 'image10.jpg'),
(92279595902, '0-', 'Karolina Tusek', '1965-09-06', 'Split', 21000, 991142589, 'karolina_tusek@gmail.com', 'Z', 'Hercegova?ka 1', 'karolina', 'karolina', 23, 'image6.jpg'),
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
(29389527738, 25905508615),
(25905508615, 13115585172),
(25905508615, 10528147607);

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
(25905508615, 29389527738),
(13115585172, 25905508615),
(10528147607, 25905508615);

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
  `datum_kom` date NOT NULL,
  KEY `id_bolnica_fk` (`idbolnica_bol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`user_autora`, `autor`, `idbolnica_bol`, `tekst_komentara`, `datum_kom`) VALUES
('', 'KBC Rijeka', 101, 'Hvala svima na donacijama! Ovdje možete ostavljati svoje komentare, prijedloge i slično!', '2018-12-27'),
('domagoj', 'Domagoj Buljubasic', 101, 'Pozdrav plavoj sestri sa šaltera 5 hehe xD', '2019-01-02'),
('domagoj', 'Domagoj Buljubasic', 101, 'gegep', '2019-01-04'),
('anica6', 'Katarina Ani?', 101, 'test test\r\n', '2019-01-08'),
('101', 'KBC Susak', 101, 'dobro jutro', '2019-01-09'),
('anica6', 'Katarina Ani?', 101, 'test12', '2019-01-09'),
('101', 'KBC Susak', 101, 'lalalalla', '2019-01-09'),
('anica6', 'Katarina Ani?', 103, 'nenenen', '2019-01-09'),
('101', 'KBC Susak', 101, 'HEHE\r\n', '2019-01-10'),
('101', 'KBC Susak', 101, 'test 12', '2019-01-10'),
('101', 'KBC Susak', 101, 'lalala', '2019-01-10'),
('anica6', 'Katarina Ani?', 101, 'fztztfzt', '2019-01-10'),
('101', 'KBC Susak', 101, 'hehehe', '2019-01-23'),
('101', 'KBC Susak', 101, 'gjhfhg', '2019-01-23'),
('101', 'KBC Susak', 101, 'gjhfhg', '2019-01-23'),
('101', 'KBC Susak', 101, 'gjhfhg', '2019-01-23'),
('anica6', 'Katarina Ani?', 101, 'hejjj', '2019-01-23'),
('domagoj', 'Domagoj Buljubasic', 101, 'lalalalal', '2019-01-23'),
('domagoj', 'Domagoj Buljubasic', 101, 'lalalalal', '2019-01-23'),
('101', 'KBC Susak', 101, 'ćao ćao', '2019-01-23'),
('101', 'KBC Susak', 101, '1 2 3 ', '2019-01-24'),
('101', 'KBC Susak', 101, '1 2 3 ', '2019-01-24'),
('101', 'KBC Susak', 101, '1 2 3 ', '2019-01-24');

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `lokacija`
--

INSERT INTO `lokacija` (`id_lokacije`, `grad`, `naziv_lokacije`, `adresa_lokacije`, `postanski_broj`, `datum_dogadaja`, `start`, `kraj`, `image`) VALUES
(1, 'Rijeka', 'Studentski Centar Rijeka', 'Radmile Matejcic 6', 51000, '2018-12-28', '07:00:00', '12:00:00', 'studentski_centar.jpg'),
(2, 'Rijeka', 'Studentski Centar Rijeka', 'Radmile Matejcic 5', 51000, '2019-01-05', '10:00:00', '14:00:00', 'studentski_centar.jpg'),
(3, 'Rijeka', 'Fakultet Zdravstvenih studija', 'Viktora cara Emina 5', 51000, '2019-01-15', '08:00:00', '09:00:00', 'fzs_ri.JPG'),
(4, 'Zagreb', 'Fakultet elektrotehnike i računarstva', 'Unska ul. 3', 10000, '2019-01-05', '11:30:00', '13:30:00', 'fer_02.jpg'),
(5, 'Zagreb', 'Klinicki bolnicki cetar Sestre milosrdnice', 'Vinogradska cesta 29', 10000, '2019-01-08', '07:15:00', '13:45:00', 'sestre_milosrdnice.jpg'),
(6, 'Rijeka', 'Gradska knjižnica Rijeka', 'Ul. Matije Gupca 23', 51000, '2019-01-02', '15:00:00', '18:30:00', 'Gorana-Tuskan-v.d.-ravnateljice-Gradske-knjiznice-Rijeka_ca_large.jpg'),
(7, 'Rijeka', 'Filozofski fakultet Rijeka', 'Sveučilišna Avenija 4', 51000, '2019-01-02', '09:00:00', '11:15:00', 'filozofski.jpg'),
(8, 'Zagreb', 'Medicinski fakultet Zagreb', 'Šalata ul. 2', 10000, '2019-01-09', '15:00:00', '17:00:00', 'med_zg.jpg'),
(9, 'Zagreb', 'Crveni križ Zagreb', 'Ilica 23', 10000, '2019-01-12', '13:00:00', '15:00:00', 'crveni_kriz.png'),
(10, 'Zagreb', 'Prehrabeno-biotehnološki fakultet', 'Pierottijeva ul. 6', 1000, '2019-01-10', '14:00:00', '19:00:00', 'pbf_zg.jpg'),
(11, 'Zagreb', 'Fakultet elektrotehnike i računarstva', 'Unska ul.3', 10000, '2019-03-15', '09:00:00', '12:00:00', 'fer_02.jpg'),
(12, 'Rijeka', 'Tehnički fakultet Rijeka', 'Vukovarska 58', 51000, '2019-01-09', '10:00:00', '13:00:00', 'tehnicki.jpg'),
(13, 'Rijeka', 'Tehnički fakultet Rijeka', 'Vukovarska 58', 51000, '2019-01-16', '10:00:00', '13:00:00', 'tehnicki.jpg'),
(14, 'dfsdf', 'sdsfsd', 'dfsfds', 23420, '2019-01-19', '17:00:00', '20:00:00', '0'),
(15, 'benkovac', 'benkovac', 'asajd', 23420, '2019-01-19', '15:00:00', '17:00:00', '0'),
(16, 'rdfgdfg', 'dgdfgf', 'dfsfds', 23420, '2019-01-19', '23:00:00', '00:00:00', ''),
(17, 'fgdgfd', 'hsahgd', 'safdhg', 23420, '2019-01-20', '17:00:00', '20:00:00', ''),
(18, 'jdfhdg', 'shjgdjshgd', 'shggjshfd', 23420, '2019-01-20', '15:00:00', '23:00:00', '');

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
(92279595902, 3, 1),
(6781251619, 6, 1),
(13115585171, 13, 1),
(79220235879, 10, -1),
(79220235879, 4, -1),
(46834013129, 4, 1),
(6781251619, 7, -1),
(18814952778, 8, -1),
(79220235879, 13, 0),
(13115585171, 5, 0),
(18814952778, 6, 0),
(13115585171, 11, 0),
(13115585171, 10, 1),
(99218368216, 5, 1),
(99218368216, 13, -1),
(13115585172, 11, 1),
(10528147607, 5, 1),
(13115585172, 10, 1),
(13115585172, 6, 1);

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
  `datum_obav` date NOT NULL,
  `procitano` int(11) NOT NULL,
  PRIMARY KEY (`id_obavijesti`),
  KEY `OIBdonor_fk` (`OIBdonora`)
) ENGINE=InnoDB AUTO_INCREMENT=494 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `obavijesti`
--

INSERT INTO `obavijesti` (`id_obavijesti`, `OIBdonora`, `ID_posiljatelja`, `tekst_obav`, `datum_obav`, `procitano`) VALUES
(1, 24821182322, 1, 'heyyy', '2019-01-05', 0),
(2, 47903334648, 1, 'heyyy', '2019-01-05', 0),
(3, 24821182322, 1, 'heyyy', '2019-01-05', 0),
(4, 47903334648, 1, 'heyyy', '2019-01-05', 0),
(5, 10528147607, 1, 'A++++', '2019-01-05', 0),
(6, 62039216922, 1, 'A++++', '2019-01-05', 0),
(7, 99218368216, 1, 'A++++', '2019-01-05', 0),
(8, 10528147607, 1, 'A++++', '2019-01-05', 0),
(9, 62039216922, 1, 'A++++', '2019-01-05', 0),
(10, 99218368216, 1, 'A++++', '2019-01-05', 0),
(11, 10528147607, 1, 'bok ja sam obavijest za zagreb', '2019-01-05', 0),
(12, 13115585171, 1, 'bok ja sam obavijest za zagreb', '2019-01-05', 0),
(13, 25905508615, 1, 'bok ja sam obavijest za zagreb', '2019-01-05', 1),
(14, 62039216922, 1, 'bok ja sam obavijest za zagreb', '2019-01-05', 0),
(15, 10528147607, 1, 'lalalala', '2019-01-07', 0),
(16, 62039216922, 1, 'lalalala', '2019-01-07', 0),
(17, 99218368216, 1, 'lalalala', '2019-01-07', 0),
(18, 10528147607, 1, 'Obavijest 1', '2019-01-07', 0),
(19, 13115585171, 1, 'Obavijest 1', '2019-01-07', 0),
(20, 25905508615, 1, 'Obavijest 1', '2019-01-07', 1),
(21, 62039216922, 1, 'Obavijest 1', '2019-01-07', 0),
(22, 10528147607, 1, 'Obavijest2', '2019-01-07', 0),
(23, 13115585171, 1, 'Obavijest2', '2019-01-07', 0),
(24, 25905508615, 1, 'Obavijest2', '2019-01-07', 1),
(25, 62039216922, 1, 'Obavijest2', '2019-01-07', 0),
(26, 10528147607, 1, 'Obavijest3', '2019-01-07', 0),
(27, 13115585171, 1, 'Obavijest3', '2019-01-07', 0),
(28, 13115585172, 1, 'Obavijest3', '2019-01-07', 0),
(29, 18814952778, 1, 'Obavijest3', '2019-01-07', 0),
(30, 24821182322, 1, 'Obavijest3', '2019-01-07', 0),
(31, 25905508615, 1, 'Obavijest3', '2019-01-07', 1),
(32, 29389527738, 1, 'Obavijest3', '2019-01-07', 0),
(33, 47903334648, 1, 'Obavijest3', '2019-01-07', 0),
(34, 57523379503, 1, 'Obavijest3', '2019-01-07', 0),
(35, 62039216922, 1, 'Obavijest3', '2019-01-07', 0),
(36, 79220235879, 1, 'Obavijest3', '2019-01-07', 0),
(37, 92279595902, 1, 'Obavijest3', '2019-01-07', 0),
(38, 99218368216, 1, 'Obavijest3', '2019-01-07', 0),
(364, 10528147607, 1, 'zahrebca', '2019-01-09', 0),
(365, 13115585171, 1, 'zahrebca', '2019-01-09', 0),
(366, 25905508615, 1, 'zahrebca', '2019-01-09', 1),
(367, 62039216922, 1, 'zahrebca', '2019-01-09', 0),
(368, 10528147607, 1, 'zahrebca', '2019-01-09', 0),
(369, 13115585171, 1, 'zahrebca', '2019-01-09', 0),
(370, 25905508615, 1, 'zahrebca', '2019-01-09', 1),
(371, 62039216922, 1, 'zahrebca', '2019-01-09', 0),
(372, 18814952778, 1, 'got', '2019-01-09', 0),
(373, 57523379503, 1, 'ae', '2019-01-09', 0),
(374, 79220235879, 1, 'ae', '2019-01-09', 0),
(375, 92279595902, 1, 'ae', '2019-01-09', 0),
(376, 99218368216, 1, 'ae', '2019-01-09', 0),
(377, 6781251619, 1, 'apoz', '2019-01-09', 0),
(378, 10528147607, 1, 'apoz', '2019-01-09', 0),
(379, 62039216922, 1, 'apoz', '2019-01-09', 0),
(380, 99218368216, 1, 'apoz', '2019-01-09', 0),
(381, 10528147607, 1, 'apozag', '2019-01-09', 0),
(382, 62039216922, 1, 'apozag', '2019-01-09', 0),
(383, 10528147607, 1, 'lalal', '2019-01-10', 0),
(384, 13115585171, 1, 'lalal', '2019-01-10', 0),
(385, 25905508615, 1, 'lalal', '2019-01-10', 1),
(386, 46834013129, 1, 'lalal', '2019-01-10', 0),
(387, 62039216922, 1, 'lalal', '2019-01-10', 0),
(388, 57523379503, 1, '', '2019-01-10', 0),
(389, 79220235879, 1, '', '2019-01-10', 0),
(390, 92279595902, 1, '', '2019-01-10', 0),
(391, 99218368216, 1, '', '2019-01-10', 0),
(392, 10528147607, 1, 'lalalalallala', '2019-01-10', 0),
(393, 13115585171, 1, 'lalalalallala', '2019-01-10', 0),
(394, 25905508615, 1, 'lalalalallala', '2019-01-10', 1),
(395, 46834013129, 1, 'lalalalallala', '2019-01-10', 0),
(396, 62039216922, 1, 'lalalalallala', '2019-01-10', 0),
(397, 6781251619, 1, 'fsdfd', '2019-01-23', 0),
(398, 10528147607, 1, 'fsdfd', '2019-01-23', 0),
(399, 13115585171, 1, 'fsdfd', '2019-01-23', 0),
(400, 13115585172, 1, 'fsdfd', '2019-01-23', 0),
(401, 18814952778, 1, 'fsdfd', '2019-01-23', 0),
(402, 24821182322, 1, 'fsdfd', '2019-01-23', 0),
(403, 25905508615, 1, 'fsdfd', '2019-01-23', 1),
(404, 29389527738, 1, 'fsdfd', '2019-01-23', 0),
(405, 46834013129, 1, 'fsdfd', '2019-01-23', 0),
(406, 47903334648, 1, 'fsdfd', '2019-01-23', 0),
(407, 57523379503, 1, 'fsdfd', '2019-01-23', 0),
(408, 62039216922, 1, 'fsdfd', '2019-01-23', 0),
(409, 79220235879, 1, 'fsdfd', '2019-01-23', 0),
(410, 92279595902, 1, 'fsdfd', '2019-01-23', 0),
(411, 99218368216, 1, 'fsdfd', '2019-01-23', 0),
(412, 6781251619, 1, '1 2 3 test', '2019-01-23', 0),
(413, 10528147607, 1, '1 2 3 test', '2019-01-23', 0),
(414, 62039216922, 1, '1 2 3 test', '2019-01-23', 0),
(415, 99218368216, 1, '1 2 3 test', '2019-01-23', 0),
(416, 25905508615, 1, 'ja sam jebena obavijest', '2019-01-23', 0),
(417, 57523379503, 1, 'ja sam jebena obavijest', '2019-01-23', 0),
(418, 25905508615, 1, 'heyyyy', '2019-01-23', 0),
(419, 57523379503, 1, 'heyyyy', '2019-01-23', 0),
(420, 25905508615, 1, 'dobra večer drugovi', '2019-01-23', 0),
(421, 57523379503, 1, 'dobra večer drugovi', '2019-01-23', 0),
(422, 25905508615, 1, 'dobra večer drugovi', '2019-01-23', 1),
(423, 57523379503, 1, 'dobra večer drugovi', '2019-01-23', 0),
(424, 6781251619, 1, 'dobra večer drugovi', '2019-01-23', 0),
(425, 10528147607, 1, 'dobra večer drugovi', '2019-01-23', 0),
(426, 13115585171, 1, 'dobra večer drugovi', '2019-01-23', 0),
(427, 13115585172, 1, 'dobra večer drugovi', '2019-01-23', 0),
(428, 18814952778, 1, 'dobra večer drugovi', '2019-01-23', 0),
(429, 24821182322, 1, 'dobra večer drugovi', '2019-01-23', 0),
(430, 25905508615, 1, 'dobra večer drugovi', '2019-01-23', 1),
(431, 29389527738, 1, 'dobra večer drugovi', '2019-01-23', 0),
(432, 46834013129, 1, 'dobra večer drugovi', '2019-01-23', 0),
(433, 47903334648, 1, 'dobra večer drugovi', '2019-01-23', 0),
(434, 57523379503, 1, 'dobra večer drugovi', '2019-01-23', 0),
(435, 62039216922, 1, 'dobra večer drugovi', '2019-01-23', 0),
(436, 79220235879, 1, 'dobra večer drugovi', '2019-01-23', 0),
(437, 92279595902, 1, 'dobra večer drugovi', '2019-01-23', 0),
(438, 99218368216, 1, 'dobra večer drugovi', '2019-01-23', 0),
(439, 6781251619, 1, 'dobra večer drugovi', '2019-01-23', 0),
(440, 10528147607, 1, 'dobra večer drugovi', '2019-01-23', 0),
(441, 13115585171, 1, 'dobra večer drugovi', '2019-01-23', 0),
(442, 13115585172, 1, 'dobra večer drugovi', '2019-01-23', 0),
(443, 18814952778, 1, 'dobra večer drugovi', '2019-01-23', 0),
(444, 24821182322, 1, 'dobra večer drugovi', '2019-01-23', 0),
(445, 25905508615, 1, 'dobra večer drugovi', '2019-01-23', 0),
(446, 29389527738, 1, 'dobra večer drugovi', '2019-01-23', 0),
(447, 46834013129, 1, 'dobra večer drugovi', '2019-01-23', 0),
(448, 47903334648, 1, 'dobra večer drugovi', '2019-01-23', 0),
(449, 57523379503, 1, 'dobra večer drugovi', '2019-01-23', 0),
(450, 62039216922, 1, 'dobra večer drugovi', '2019-01-23', 0),
(451, 79220235879, 1, 'dobra večer drugovi', '2019-01-23', 0),
(452, 92279595902, 1, 'dobra večer drugovi', '2019-01-23', 0),
(453, 99218368216, 1, 'dobra večer drugovi', '2019-01-23', 0),
(454, 6781251619, 1, 'dobra večer drugovi', '2019-01-23', 0),
(455, 10528147607, 1, 'dobra večer drugovi', '2019-01-23', 0),
(456, 13115585171, 1, 'dobra večer drugovi', '2019-01-23', 0),
(457, 13115585172, 1, 'dobra večer drugovi', '2019-01-23', 0),
(458, 18814952778, 1, 'dobra večer drugovi', '2019-01-23', 0),
(459, 24821182322, 1, 'dobra večer drugovi', '2019-01-23', 0),
(460, 25905508615, 1, 'dobra večer drugovi', '2019-01-23', 0),
(461, 29389527738, 1, 'dobra večer drugovi', '2019-01-23', 0),
(462, 46834013129, 1, 'dobra večer drugovi', '2019-01-23', 0),
(463, 47903334648, 1, 'dobra večer drugovi', '2019-01-23', 0),
(464, 57523379503, 1, 'dobra večer drugovi', '2019-01-23', 0),
(465, 62039216922, 1, 'dobra večer drugovi', '2019-01-23', 0),
(466, 79220235879, 1, 'dobra večer drugovi', '2019-01-23', 0),
(467, 92279595902, 1, 'dobra večer drugovi', '2019-01-23', 0),
(468, 99218368216, 1, 'dobra večer drugovi', '2019-01-23', 0),
(469, 24821182322, 1, 'kuda idu izgubljene djevojkeeEEee', '2019-01-23', 0),
(470, 29389527738, 25905508615, 'hejj kako si', '2019-01-24', 0),
(471, 29389527738, 25905508615, 'oj oj ', '2019-01-24', 0),
(472, 25905508615, 13115585172, 'bok ja sam tvoj novi pratitelj', '2019-01-24', 0),
(473, 25905508615, 13115585172, 'sori ak smaram', '2019-01-24', 0),
(474, 25905508615, 13115585172, ' 1  2 test', '2019-01-24', 0),
(475, 25905508615, 13115585172, 'sori ak smaram', '2019-01-24', 0),
(476, 25905508615, 10528147607, 'mala dao bi ti svu krv', '2019-01-24', 0),
(477, 25905508615, 10528147607, 'RITEH DOLJE', '2019-01-24', 0),
(478, 6781251619, 1, '1 2 3 4 4', '2019-01-24', 0),
(479, 10528147607, 1, '1 2 3 4 4', '2019-01-24', 0),
(480, 13115585171, 1, '1 2 3 4 4', '2019-01-24', 0),
(481, 13115585172, 1, '1 2 3 4 4', '2019-01-24', 0),
(482, 18814952778, 1, '1 2 3 4 4', '2019-01-24', 0),
(483, 24821182322, 1, '1 2 3 4 4', '2019-01-24', 0),
(484, 25905508615, 1, '1 2 3 4 4', '2019-01-24', 0),
(485, 29389527738, 1, '1 2 3 4 4', '2019-01-24', 0),
(486, 46834013129, 1, '1 2 3 4 4', '2019-01-24', 0),
(487, 47903334648, 1, '1 2 3 4 4', '2019-01-24', 0),
(488, 57523379503, 1, '1 2 3 4 4', '2019-01-24', 0),
(489, 62039216922, 1, '1 2 3 4 4', '2019-01-24', 0),
(490, 79220235879, 1, '1 2 3 4 4', '2019-01-24', 0),
(491, 92279595902, 1, '1 2 3 4 4', '2019-01-24', 0),
(492, 99218368216, 1, '1 2 3 4 4', '2019-01-24', 0),
(493, 18814952778, 1, 'glupa obavijest', '2019-01-24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `poruke`
--

DROP TABLE IF EXISTS `poruke`;
CREATE TABLE IF NOT EXISTS `poruke` (
  `OIB_primatelja` double UNSIGNED NOT NULL,
  `OIB_prijatelja` int(11) NOT NULL,
  `tekst_poruke` varchar(300) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  PRIMARY KEY (`OIB_primatelja`),
  UNIQUE KEY `OIB_donora_UNIQUE` (`OIB_primatelja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `zahtjev`
--

INSERT INTO `zahtjev` (`idzahtjev`, `id_bolnica`, `kolicina_krvi_zaht`, `krvna_grupa_zaht`, `datum_zahtjeva`, `odobreno`) VALUES
(1, 101, 1.5, 'A+', '2019-01-02', 1),
(5, 102, 2, 'AB-', '2019-01-02', -1),
(6, 104, 2, 'A+', '2019-01-02', -1),
(7, 103, 0.2, 'A+', '2019-01-02', -1),
(24, 101, 1.5, 'A+', '2019-01-02', 0),
(25, 101, 0.5, 'AB+', '2019-01-02', -1),
(26, 101, 1.5, 'B+', '2018-12-27', 1),
(27, 101, 5.5, 'A-', '2018-12-12', 1),
(29, 101, 0.4, 'B+', '2019-01-09', 0),
(30, 101, 0.4, 'B+', '2019-01-09', 0),
(31, 101, 0.5, 'A+', '2019-01-10', 1),
(32, 101, 0.5, 'A+', '2019-01-23', 0),
(33, 101, 0.5, 'A+', '2019-01-23', 0);

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
('A+', '0.19999999999999996'),
('A-', '0'),
('AB+', '0'),
('AB-', '1.6'),
('B+', '0.6000000000000001'),
('B-', '0'),
('0+', '0'),
('0-', '0');

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
  ADD CONSTRAINT `lokacija_fk` FOREIGN KEY (`id_lokacije`) REFERENCES `lokacija` (`id_lokacije`);

--
-- Constraints for table `obavijesti`
--
ALTER TABLE `obavijesti`
  ADD CONSTRAINT `OIBdonor_fk` FOREIGN KEY (`OIBdonora`) REFERENCES `donor` (`OIB_donora`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `poruke`
--
ALTER TABLE `poruke`
  ADD CONSTRAINT `OIB_primatelja` FOREIGN KEY (`OIB_primatelja`) REFERENCES `donor` (`OIB_donora`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zahtjev`
--
ALTER TABLE `zahtjev`
  ADD CONSTRAINT `id_bolnice_fk` FOREIGN KEY (`id_bolnica`) REFERENCES `bolnica` (`idbolnica`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
