-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 22. Dez 2023 um 19:56
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `kniffel`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `activeround`
--

CREATE TABLE `activeround` (
  `dicelocked1` tinyint(1) NOT NULL DEFAULT 0,
  `dicelocked2` tinyint(1) NOT NULL DEFAULT 0,
  `dicelocked3` tinyint(1) NOT NULL DEFAULT 0,
  `dicelocked4` tinyint(1) NOT NULL DEFAULT 0,
  `dicelocked5` tinyint(1) NOT NULL DEFAULT 0,
  `rollCounter` int(11) NOT NULL DEFAULT 0,
  `diceScore1` int(11) NOT NULL DEFAULT 1,
  `diceScore2` int(11) NOT NULL DEFAULT 2,
  `diceScore3` int(11) NOT NULL DEFAULT 3,
  `diceScore4` int(11) NOT NULL DEFAULT 4,
  `diceScore5` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `activeround`
--

INSERT INTO `activeround` (`dicelocked1`, `dicelocked2`, `dicelocked3`, `dicelocked4`, `dicelocked5`, `rollCounter`, `diceScore1`, `diceScore2`, `diceScore3`, `diceScore4`, `diceScore5`) VALUES
(0, 0, 0, 0, 0, 0, 1, 2, 3, 4, 5);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
