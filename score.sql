-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 01. Jan 2024 um 15:41
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
-- Tabellenstruktur für Tabelle `score`
--

CREATE TABLE `score` (
  `id` int(11) NOT NULL,
  `playername` text NOT NULL DEFAULT '\'0\'',
  `1er` int(11) DEFAULT NULL,
  `2er` int(11) DEFAULT NULL,
  `3er` int(11) DEFAULT NULL,
  `4er` int(11) DEFAULT NULL,
  `5er` int(11) DEFAULT NULL,
  `6er` int(11) DEFAULT NULL,
  `summe_oben` int(11) DEFAULT 0,
  `bonus` int(11) DEFAULT 0,
  `gesamt_oben` int(11) DEFAULT 0,
  `3er_pasch` int(11) DEFAULT NULL,
  `4er_pasch` int(11) DEFAULT NULL,
  `full_house` int(11) DEFAULT NULL,
  `kleine_strasse` int(11) DEFAULT NULL,
  `grosse_strasse` int(11) DEFAULT NULL,
  `kniffel` int(11) DEFAULT NULL,
  `chance` int(11) DEFAULT NULL,
  `gesamt_unten` int(11) DEFAULT 0,
  `gesamt` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `score`
--

INSERT INTO `score` (`id`, `playername`, `1er`, `2er`, `3er`, `4er`, `5er`, `6er`, `summe_oben`, `bonus`, `gesamt_oben`, `3er_pasch`, `4er_pasch`, `full_house`, `kleine_strasse`, `grosse_strasse`, `kniffel`, `chance`, `gesamt_unten`, `gesamt`) VALUES
(1, 'Player1', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(2, 'Player2', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(3, 'Player1', 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(4, 'Player2', 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(5, 'Player1', 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(6, 'Player2', 0, 2, NULL, NULL, NULL, NULL, 2, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2),
(7, 'Player1', 0, 0, 6, NULL, NULL, NULL, 6, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 6);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `score`
--
ALTER TABLE `score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
