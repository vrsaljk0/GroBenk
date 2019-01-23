-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2019 at 11:56 AM
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
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
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

CREATE TABLE `bolnica` (
  `idbolnica` int(10) UNSIGNED NOT NULL,
  `naziv_bolnice` varchar(45) NOT NULL,
  `grad` varchar(45) NOT NULL,
  `adresa_bolnice` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `postanski_broj` int(11) DEFAULT NULL,
  `password` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bolnica`
--

INSERT INTO `bolnica` (`idbolnica`, `naziv_bolnice`, `grad`, `adresa_bolnice`, `postanski_broj`, `password`) VALUES
(101, 'KBC Susak', 'Rijeka', 'Kreï¿½imirova 42', 51001, '101'),
(102, 'KBC Sisak', 'Sisak', 'Sisacka 13', 57474, 'kbcri56'),
(103, 'KBC Zagreb', 'Zagreb', 'Ilica 15', 50000, 'zajc45'),
(104, 'KBC', 'Zadar', 'Zadarska 13', 43000, 'dubdub'),
(105, 'KBC Draga', 'Draga', 'Kelinova 14', 51088, 'kbc89');

-- --------------------------------------------------------

--
-- Table structure for table `donacija`
--

CREATE TABLE `donacija` (
  `id_donacija` int(11) UNSIGNED NOT NULL,
  `kolicina_krvi_donacije` float UNSIGNED NOT NULL,
  `krvna_grupa_zal` varchar(45) NOT NULL,
  `OIB_donora` double UNSIGNED NOT NULL,
  `idlokacija` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `donor` (
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
  `image` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(25905508615, 'AB-', 'Katarina Ani?', '2019-01-12', 'Zagreb', 51000, 914537810, 'anica_frketic@gmail.com', 'Z', 'Vojni put 14', 'katarina', 'anica123', 17, 'image1.jpg'),
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

CREATE TABLE `followers` (
  `donor_OIB_donora` double UNSIGNED NOT NULL,
  `OIB_prijatelja` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(13115585172, 25905508615),
(29389527738, 25905508615);

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE `following` (
  `donor_OIB_donora` double UNSIGNED NOT NULL,
  `OIB_prijatelja` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(25905508615, 13115585172),
(25905508615, 29389527738);

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

CREATE TABLE `komentari` (
  `id_autora` int(11) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `idbolnica_bol` int(10) UNSIGNED NOT NULL,
  `tekst_komentara` varchar(300) DEFAULT NULL,
  `datum_kom` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`id_autora`, `autor`, `idbolnica_bol`, `tekst_komentara`, `datum_kom`) VALUES
(0, 'KBC Rijeka', 101, 'Hvala svima na donacijama! Ovdje možete ostavljati svoje komentare, prijedloge i slično!', '2018-12-27'),
(0, 'Katarina Frketic', 101, 'Svaka čast na organizaciji, moje omiljeno mjesto za doniranje krvi', '2019-01-02'),
(0, 'Domagoj Buljubasic', 101, 'Pozdrav plavoj sestri sa šaltera 5 hehe xD', '2019-01-02'),
(0, 'Domagoj Buljubasic', 101, 'gegep', '2019-01-04'),
(0, 'Ana Anic', 103, 'hiiii', '2019-01-08'),
(0, 'Ana Anic', 103, 'hiiii', '2019-01-08'),
(0, 'Ana Anic', 102, 'bok bok', '2019-01-08'),
(0, 'Katarina Ani?', 101, 'test test\r\n', '2019-01-08'),
(0, 'KBC Susak', 101, 'dobro jutro', '2019-01-09'),
(0, 'Katarina Ani?', 101, 'test12', '2019-01-09'),
(0, 'KBC Susak', 101, 'lalalalla', '2019-01-09'),
(0, 'Katarina Ani?', 103, 'nenenen', '2019-01-09'),
(0, 'KBC Susak', 101, 'HEHE\r\n', '2019-01-10'),
(0, 'KBC Susak', 101, 'test 12', '2019-01-10'),
(0, 'KBC Susak', 101, 'lalala', '2019-01-10'),
(0, 'Katarina Ani?', 101, 'fztztfzt', '2019-01-10');

-- --------------------------------------------------------

--
-- Table structure for table `lokacija`
--

CREATE TABLE `lokacija` (
  `id_lokacije` int(11) UNSIGNED NOT NULL,
  `grad` varchar(45) NOT NULL,
  `naziv_lokacije` varchar(45) DEFAULT NULL,
  `adresa_lokacije` varchar(45) DEFAULT NULL,
  `postanski_broj` int(10) UNSIGNED DEFAULT NULL,
  `datum_dogadaja` date NOT NULL,
  `start` time NOT NULL,
  `kraj` time NOT NULL,
  `image` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `moj_event` (
  `OIB_donora_don` double UNSIGNED NOT NULL,
  `id_lokacije` int(11) UNSIGNED NOT NULL,
  `prisutnost` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `obavijesti` (
  `id_obavijesti` int(11) NOT NULL,
  `OIBdonora` double NOT NULL,
  `tekst_obav` varchar(100) COLLATE utf8_croatian_ci NOT NULL,
  `datum_obav` date NOT NULL,
  `procitano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `obavijesti`
--

INSERT INTO `obavijesti` (`id_obavijesti`, `OIBdonora`, `tekst_obav`, `datum_obav`, `procitano`) VALUES
(1, 24821182322, 'heyyy', '2019-01-05', 0),
(2, 47903334648, 'heyyy', '2019-01-05', 0),
(3, 24821182322, 'heyyy', '2019-01-05', 0),
(4, 47903334648, 'heyyy', '2019-01-05', 0),
(5, 10528147607, 'A++++', '2019-01-05', 0),
(6, 62039216922, 'A++++', '2019-01-05', 0),
(7, 99218368216, 'A++++', '2019-01-05', 0),
(8, 10528147607, 'A++++', '2019-01-05', 0),
(9, 62039216922, 'A++++', '2019-01-05', 0),
(10, 99218368216, 'A++++', '2019-01-05', 0),
(11, 10528147607, 'bok ja sam obavijest za zagreb', '2019-01-05', 0),
(12, 13115585171, 'bok ja sam obavijest za zagreb', '2019-01-05', 0),
(13, 25905508615, 'bok ja sam obavijest za zagreb', '2019-01-05', 1),
(14, 62039216922, 'bok ja sam obavijest za zagreb', '2019-01-05', 0),
(15, 10528147607, 'lalalala', '2019-01-07', 0),
(16, 62039216922, 'lalalala', '2019-01-07', 0),
(17, 99218368216, 'lalalala', '2019-01-07', 0),
(18, 10528147607, 'Obavijest 1', '2019-01-07', 0),
(19, 13115585171, 'Obavijest 1', '2019-01-07', 0),
(20, 25905508615, 'Obavijest 1', '2019-01-07', 1),
(21, 62039216922, 'Obavijest 1', '2019-01-07', 0),
(22, 10528147607, 'Obavijest2', '2019-01-07', 0),
(23, 13115585171, 'Obavijest2', '2019-01-07', 0),
(24, 25905508615, 'Obavijest2', '2019-01-07', 1),
(25, 62039216922, 'Obavijest2', '2019-01-07', 0),
(26, 10528147607, 'Obavijest3', '2019-01-07', 0),
(27, 13115585171, 'Obavijest3', '2019-01-07', 0),
(28, 13115585172, 'Obavijest3', '2019-01-07', 0),
(29, 18814952778, 'Obavijest3', '2019-01-07', 0),
(30, 24821182322, 'Obavijest3', '2019-01-07', 0),
(31, 25905508615, 'Obavijest3', '2019-01-07', 1),
(32, 29389527738, 'Obavijest3', '2019-01-07', 0),
(33, 47903334648, 'Obavijest3', '2019-01-07', 0),
(34, 57523379503, 'Obavijest3', '2019-01-07', 0),
(35, 62039216922, 'Obavijest3', '2019-01-07', 0),
(36, 79220235879, 'Obavijest3', '2019-01-07', 0),
(37, 92279595902, 'Obavijest3', '2019-01-07', 0),
(38, 99218368216, 'Obavijest3', '2019-01-07', 0),
(364, 10528147607, 'zahrebca', '2019-01-09', 0),
(365, 13115585171, 'zahrebca', '2019-01-09', 0),
(366, 25905508615, 'zahrebca', '2019-01-09', 1),
(367, 62039216922, 'zahrebca', '2019-01-09', 0),
(368, 10528147607, 'zahrebca', '2019-01-09', 0),
(369, 13115585171, 'zahrebca', '2019-01-09', 0),
(370, 25905508615, 'zahrebca', '2019-01-09', 1),
(371, 62039216922, 'zahrebca', '2019-01-09', 0),
(372, 18814952778, 'got', '2019-01-09', 0),
(373, 57523379503, 'ae', '2019-01-09', 0),
(374, 79220235879, 'ae', '2019-01-09', 0),
(375, 92279595902, 'ae', '2019-01-09', 0),
(376, 99218368216, 'ae', '2019-01-09', 0),
(377, 6781251619, 'apoz', '2019-01-09', 0),
(378, 10528147607, 'apoz', '2019-01-09', 0),
(379, 62039216922, 'apoz', '2019-01-09', 0),
(380, 99218368216, 'apoz', '2019-01-09', 0),
(381, 10528147607, 'apozag', '2019-01-09', 0),
(382, 62039216922, 'apozag', '2019-01-09', 0),
(383, 10528147607, 'lalal', '2019-01-10', 0),
(384, 13115585171, 'lalal', '2019-01-10', 0),
(385, 25905508615, 'lalal', '2019-01-10', 1),
(386, 46834013129, 'lalal', '2019-01-10', 0),
(387, 62039216922, 'lalal', '2019-01-10', 0),
(388, 57523379503, '', '2019-01-10', 0),
(389, 79220235879, '', '2019-01-10', 0),
(390, 92279595902, '', '2019-01-10', 0),
(391, 99218368216, '', '2019-01-10', 0),
(392, 10528147607, 'lalalalallala', '2019-01-10', 0),
(393, 13115585171, 'lalalalallala', '2019-01-10', 0),
(394, 25905508615, 'lalalalallala', '2019-01-10', 0),
(395, 46834013129, 'lalalalallala', '2019-01-10', 0),
(396, 62039216922, 'lalalalallala', '2019-01-10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `poruke`
--

CREATE TABLE `poruke` (
  `OIB_primatelja` double UNSIGNED NOT NULL,
  `OIB_prijatelja` int(11) NOT NULL,
  `tekst_poruke` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `zahtjev`
--

CREATE TABLE `zahtjev` (
  `idzahtjev` int(8) UNSIGNED NOT NULL,
  `id_bolnica` int(10) UNSIGNED NOT NULL,
  `kolicina_krvi_zaht` float UNSIGNED NOT NULL,
  `krvna_grupa_zaht` varchar(45) NOT NULL,
  `datum_zahtjeva` date DEFAULT NULL,
  `odobreno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(31, 101, 0.5, 'A+', '2019-01-10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `zaliha`
--

CREATE TABLE `zaliha` (
  `krvna_grupa` varchar(10) NOT NULL,
  `kolicina_grupe` varchar(45) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zaliha`
--

INSERT INTO `zaliha` (`krvna_grupa`, `kolicina_grupe`) VALUES
('A+', '0.7'),
('A-', '0'),
('AB+', '0'),
('AB-', '1.6'),
('B+', '0.6000000000000001'),
('B-', '0'),
('0+', '0'),
('0-', '0');

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
  ADD KEY `OIBdonor_fk` (`OIBdonora`);

--
-- Indexes for table `poruke`
--
ALTER TABLE `poruke`
  ADD PRIMARY KEY (`OIB_primatelja`),
  ADD UNIQUE KEY `OIB_donora_UNIQUE` (`OIB_primatelja`);

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
  MODIFY `id_donacija` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `lokacija`
--
ALTER TABLE `lokacija`
  MODIFY `id_lokacije` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `obavijesti`
--
ALTER TABLE `obavijesti`
  MODIFY `id_obavijesti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=397;

--
-- AUTO_INCREMENT for table `zahtjev`
--
ALTER TABLE `zahtjev`
  MODIFY `idzahtjev` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
