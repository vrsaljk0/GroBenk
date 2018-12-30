-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 30, 2018 at 03:56 PM
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
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `naziv_bolnice` varchar(45) NOT NULL,
  `grad` varchar(45) NOT NULL,
  `adresa_bolnice` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `poštanski broj` int(11) DEFAULT NULL,
  `password` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idbolnica`),
  UNIQUE KEY `idbolnica_UNIQUE` (`idbolnica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bolnica`
--

INSERT INTO `bolnica` (`idbolnica`, `naziv_bolnice`, `grad`, `adresa_bolnice`, `poštanski broj`, `password`) VALUES
(101, 'KBC Rijeka', 'Rijeka', 'Krešimirova 42', 51000, 'kbcri12'),
(102, 'KBC Rijeka Sušak', 'Rijeka', 'Tome Strižića 3', 51000, 'kbcri56'),
(103, 'KB Merkur', 'Zagreb', 'Zajčeva 19', 10000, 'zajc45'),
(104, 'KB Dubrava', 'Zagreb', 'Avenija Gojka Suška', 10000, 'dubdub'),
(105, 'KBC Zagreb', 'Zagreb', 'Šalata 2', 1000, 'kbc89');

-- --------------------------------------------------------

--
-- Table structure for table `donacija`
--

DROP TABLE IF EXISTS `donacija`;
CREATE TABLE IF NOT EXISTS `donacija` (
  `id_donacija` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kolicina_krvi_donacije` float UNSIGNED NOT NULL,
  `krvna_grupa_zal` varchar(45) NOT NULL,
  `OIB_donora` double UNSIGNED NOT NULL,
  `idlokacija` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_donacija`),
  UNIQUE KEY `id_donacija_UNIQUE` (`id_donacija`),
  KEY `fk_donacija_donor_idx` (`OIB_donora`),
  KEY `fk_donacija_lokacija1_idx` (`idlokacija`),
  KEY `fk_donacija_krvna_grupa_zal_idx` (`krvna_grupa_zal`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `donacija`
--

INSERT INTO `donacija` (`id_donacija`, `kolicina_krvi_donacije`, `krvna_grupa_zal`, `OIB_donora`, `idlokacija`) VALUES
(1, 0.5, 'A+', 25905508615, 3),
(2, 0.5, 'A+', 25905508615, 4),
(6, 0.3, 'AB-', 57523379503, 22),
(7, 0.3, 'AB-', 57523379503, 22),
(8, 0.3, 'AB-', 57523379503, 22);

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

DROP TABLE IF EXISTS `donor`;
CREATE TABLE IF NOT EXISTS `donor` (
  `OIB_donora` double UNSIGNED NOT NULL,
  `krvna_grupa_don` varchar(100) NOT NULL,
  `ime_prezime_donora` varchar(45) NOT NULL,
  `datum_rodenja` date NOT NULL,
  `prebivaliste` varchar(45) NOT NULL,
  `postanski_broj` int(10) UNSIGNED NOT NULL,
  `broj_mobitela` int(10) UNSIGNED NOT NULL,
  `mail_donora` varchar(45) DEFAULT NULL,
  `spol` varchar(2) NOT NULL,
  `adresa_donora` varchar(45) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(10) DEFAULT NULL,
  `br_donacija` int(11) DEFAULT NULL,
  `image` varchar(300) NOT NULL,
  PRIMARY KEY (`OIB_donora`),
  UNIQUE KEY `OIB_donora_UNIQUE` (`OIB_donora`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`OIB_donora`, `krvna_grupa_don`, `ime_prezime_donora`, `datum_rodenja`, `prebivaliste`, `postanski_broj`, `broj_mobitela`, `mail_donora`, `spol`, `adresa_donora`, `username`, `password`, `br_donacija`, `image`) VALUES
(10528147607, 'A+', 'Domagoj Buljubasic', '1995-02-03', 'Zagreb', 51000, 954472385, 'dodoz43@gmail.com', 'M', 'Turni?i 12', 'domagoj', 'dodo123', 7, ''),
(13115585171, 'A-', 'Marko Stojakovi?', '1960-02-12', 'Zagreb', 51000, 924563789, 'marko_stokjo@gmail.com', 'M', 'Grabovac', 'marko', 'marko123', 23, ''),
(13115585172, 'AB+', 'Maja Vrsaljko', '1998-11-01', 'Zadar', 23000, 924563780, 'mvrsaljko@riteh.hr', 'Z', 'Benkovac 22', 'maja2', 'majab91', 0, ''),
(18814952778, 'B+', 'Tyrion Lannister', '1968-06-10', 'Kings Landing', 51000, 997763321, 'tyrion123@gmail.com', 'M', 'Casterly Rock', 'tyrion', 'got123', 0, 'Tyrion_main_s7_e6.jpg'),
(24821182322, 'B-', 'Patricija Dadi?', '1992-05-23', 'Rijeka', 51000, 998751246, 'patry@gmail.com', 'Z', 'Kapelska', 'patricija', '123456', 11, 'good-profile-pictures-for-girls-to-use-9.png'),
(25905508615, 'AB-', 'Katarina Frketic', '1962-06-21', 'Zagreb', 51000, 914537810, 'anica_frketic@gmail.com', 'Z', 'Vojni put 12', 'katarina', 'anica123', 15, '2b023a2ebf5618c90b89288d38e56872.jpg'),
(29389527738, '0+', 'Maja Vukelix', '1987-12-21', 'Kaï¿½tel Su?urac', 21213, 924789234, 'majavuk@hotmail.com', 'Z', 'Suva?a 10', 'maja', 'maja123', 14, '300px-SpongeBob_SquarePants_Squidward_Tentacles_Transparent_PNG.png'),
(47903334648, '0-', 'Jasmin Stankovi?', '1990-05-08', 'Rijeka', 51000, 925563594, 'jasmin456@gmail.com', 'Z', 'Adami?eva 3', 'jasmin', 'jasmin123', 14, 'jasmin_stankovic.jpg'),
(57523379503, 'AB-', 'Dalibor Trumbeti?', '1972-06-12', 'Split', 21000, 998845574, 'dalibor_trumbetic@gmail.com', 'M', 'Trumbi?eva obala 13', 'dalibor\r\n', 'dali123', 11, 'dalibor_trumbetic.jpg'),
(62039216922, 'A+', 'Irma Plantak', '1992-06-18', 'Zagreb', 21000, 953341523, 'irma123@gmail.com', 'Z', 'Ante Star?evi?a 10', 'irma', 'irma123', 11, 'irma_plantak.jpg'),
(79220235879, 'AB+', 'Vinko ï¿½abi?', '1983-08-05', 'Split', 21000, 991132563, 'vino_sab@gmail.com', 'M', 'ï¿½abanova 24', 'vinko', 'vinko123', 10, 'marko_stojakovic.jpg'),
(92279595902, '0-', 'Karolina Tuï¿½ek', '1965-09-06', 'Split', 21000, 991142589, 'karolina_tusek@gmail.com', 'Z', 'Hercegova?ka 1', 'karolina', 'karolina', 23, 'images (6).jpg'),
(99218368216, 'A+', 'Klara Vidaković', '1970-05-02', 'Split', 21000, 994573109, 'klara1234@gmail.com', 'Z', 'Pojišanska 18', 'klara', 'klara213', 21, '');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

DROP TABLE IF EXISTS `followers`;
CREATE TABLE IF NOT EXISTS `followers` (
  `donor_OIB_donora` double UNSIGNED NOT NULL,
  `OIB_prijatelja` double DEFAULT NULL,
  KEY `fk_followers_donor1` (`donor_OIB_donora`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`donor_OIB_donora`, `OIB_prijatelja`) VALUES
(29389527738, 62039216922),
(62039216922, 25905508615),
(25905508615, 62039216922),
(25905508615, 57523379503),
(57523379503, 25905508615),
(29389527738, 25905508615),
(29389527738, 62039216922),
(62039216922, 25905508615),
(25905508615, 62039216922),
(25905508615, 57523379503),
(57523379503, 25905508615),
(29389527738, 25905508615),
(57523379503, 13115585171);

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

DROP TABLE IF EXISTS `following`;
CREATE TABLE IF NOT EXISTS `following` (
  `donor_OIB_donora` double UNSIGNED NOT NULL,
  `OIB_prijatelja` double DEFAULT NULL,
  KEY `donor_OIB_donora` (`donor_OIB_donora`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `following`
--

INSERT INTO `following` (`donor_OIB_donora`, `OIB_prijatelja`) VALUES
(62039216922, 74678436),
(62039216922, 29389527738),
(25905508615, 62039216922),
(62039216922, 25905508615),
(25905508615, 57523379503),
(25905508615, 29389527738),
(62039216922, 74678436),
(62039216922, 29389527738),
(25905508615, 62039216922),
(62039216922, 25905508615),
(25905508615, 57523379503),
(25905508615, 29389527738),
(13115585171, 57523379503);

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

DROP TABLE IF EXISTS `komentari`;
CREATE TABLE IF NOT EXISTS `komentari` (
  `idbolnica_bol` int(10) UNSIGNED NOT NULL,
  `tekst_komentara` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`idbolnica_bol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`idbolnica_bol`, `tekst_komentara`) VALUES
(101, 'Odličan provod, svaka čast na organizaciji');

-- --------------------------------------------------------

--
-- Table structure for table `lokacija`
--

DROP TABLE IF EXISTS `lokacija`;
CREATE TABLE IF NOT EXISTS `lokacija` (
  `idlokacija` int(10) UNSIGNED NOT NULL,
  `grad` varchar(45) NOT NULL,
  `naziv_lokacije` varchar(45) DEFAULT NULL,
  `adresa_lokacije` varchar(45) DEFAULT NULL,
  `postanski_broj` int(10) UNSIGNED DEFAULT NULL,
  `datum_dogadaja` date NOT NULL,
  PRIMARY KEY (`idlokacija`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lokacija`
--

INSERT INTO `lokacija` (`idlokacija`, `grad`, `naziv_lokacije`, `adresa_lokacije`, `postanski_broj`, `datum_dogadaja`) VALUES
(4, 'Rijeka', 'Građevinski fakultet ', 'Radmile Matejcic 3', 51000, '2018-03-14'),
(12, 'Rijeka', 'RiTeh', 'Vukovarska', 51000, '2018-12-06'),
(13, 'Rijeka', 'Riteh', 'Vukovarska', 51000, '2018-11-01'),
(15, 'Rijeka', 'Studentski Centar Rijeka', 'Radmile Matejcic 5', 51000, '2018-12-28'),
(16, 'Rijeka', 'Studentski Centar Rijeka', 'Radmile Matejcic 5', 51000, '2019-01-05'),
(17, 'Rijeka', 'Fakultet Zdravstvenih studija', 'Viktora cara Emina 5', 51000, '2019-01-15'),
(18, 'Zagreb', 'Fakultet elektrotehnike i računarstva', 'Unska ul. 3', 10000, '2019-01-05'),
(19, 'Zagreb', 'Klinicki bolnicki cetar Sestre milosrdnice', 'Vinogradska cesta 29', 10000, '2019-01-08'),
(22, 'Rijeka', 'Gradska knjižnica Rijeka', 'Ul. Matije Gupca 23', 51000, '2018-12-30'),
(23, 'Rijeka', 'Filozofski fakultet Rijeka', 'Sveučilišna Avenija 4', 51000, '2018-12-30');

-- --------------------------------------------------------

--
-- Table structure for table `moj_event`
--

DROP TABLE IF EXISTS `moj_event`;
CREATE TABLE IF NOT EXISTS `moj_event` (
  `OIB_donora_don` double UNSIGNED NOT NULL,
  `id_lokacije` int(10) UNSIGNED NOT NULL,
  `prisutnost` tinyint(4) NOT NULL,
  KEY `OIB_donora_idx` (`OIB_donora_don`),
  KEY `id_lokacije_idx` (`id_lokacije`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `moj_event`
--

INSERT INTO `moj_event` (`OIB_donora_don`, `id_lokacije`, `prisutnost`) VALUES
(25905508615, 12, 1),
(57523379503, 12, 0),
(62039216922, 12, 1),
(25905508615, 4, 1),
(25905508615, 15, 0),
(25905508615, 12, 1),
(57523379503, 12, 0),
(62039216922, 12, 1),
(25905508615, 4, 1),
(25905508615, 15, 0),
(57523379503, 22, 1),
(57523379503, 22, 1),
(18814952778, 22, 0),
(10528147607, 23, -1),
(62039216922, 22, 0),
(47903334648, 23, 0);

-- --------------------------------------------------------

--
-- Table structure for table `poruke`
--

DROP TABLE IF EXISTS `poruke`;
CREATE TABLE IF NOT EXISTS `poruke` (
  `OIB_primatelja` double UNSIGNED NOT NULL,
  `OIB_prijatelja` int(11) NOT NULL,
  `tekst_poruke` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`OIB_primatelja`),
  UNIQUE KEY `OIB_donora_UNIQUE` (`OIB_primatelja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `zahtjev`
--

DROP TABLE IF EXISTS `zahtjev`;
CREATE TABLE IF NOT EXISTS `zahtjev` (
  `idzahtjev` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_bolnica` int(10) UNSIGNED NOT NULL,
  `krvna_grupa_zal` varchar(45) DEFAULT NULL,
  `količina_krvi_zaht` float UNSIGNED NOT NULL,
  `krvna_grupa_zaht` varchar(45) NOT NULL,
  `datum_zahtjeva` date DEFAULT NULL,
  PRIMARY KEY (`idzahtjev`),
  UNIQUE KEY `idzahtjev_UNIQUE` (`idzahtjev`),
  UNIQUE KEY `bolnica_idbolnica_UNIQUE` (`id_bolnica`),
  KEY `fk_zahtjev_bolnica1_idx` (`id_bolnica`),
  KEY `fk_zahtjev_krvna_grupa_zal_idx` (`krvna_grupa_zal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `zaliha_krvi`
--

DROP TABLE IF EXISTS `zaliha_krvi`;
CREATE TABLE IF NOT EXISTS `zaliha_krvi` (
  ` krvna_grupa_zal` varchar(45) NOT NULL,
  `kolicina_grupe` float UNSIGNED DEFAULT '0',
  PRIMARY KEY (` krvna_grupa_zal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zaliha_krvi`
--

INSERT INTO `zaliha_krvi` (` krvna_grupa_zal`, `kolicina_grupe`) VALUES
('0+', 0),
('0-', 0.8),
('A+', 1),
('A-', 0),
('AB+', 2),
('AB-', 1.5),
('B+', 1),
('B-', 2);

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
  ADD CONSTRAINT `id_bolnica_bol` FOREIGN KEY (`idbolnica_bol`) REFERENCES `bolnica` (`idbolnica`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `moj_event`
--
ALTER TABLE `moj_event`
  ADD CONSTRAINT `OIB_donora_don` FOREIGN KEY (`OIB_donora_don`) REFERENCES `donor` (`OIB_donora`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_lokacije` FOREIGN KEY (`id_lokacije`) REFERENCES `lokacija` (`idlokacija`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `poruke`
--
ALTER TABLE `poruke`
  ADD CONSTRAINT `OIB_primatelja` FOREIGN KEY (`OIB_primatelja`) REFERENCES `donor` (`OIB_donora`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
