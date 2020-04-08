-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 05 apr 2020 om 11:44
-- Serverversie: 5.7.17
-- PHP-versie: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stempelkaartapp`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten`
--

CREATE TABLE `klanten` (
  `klant_id` int(16) NOT NULL,
  `naam_klant` varchar(16) NOT NULL,
  `gebr_naam` varchar(16) NOT NULL,
  `wachtwoord` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `tel_nr` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ondernemers`
--

CREATE TABLE `ondernemers` (
  `ondernemer_id` int(16) NOT NULL,
  `bedrijfsnaam_ond` varchar(32) NOT NULL,
  `gebr_naam` varchar(16) NOT NULL,
  `wachtwoord` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `tel_nr` varchar(10) NOT NULL,
  `stemp_afb` varchar(32) NOT NULL,
  `kvk` varchar(16) NOT NULL,
  `logo` varchar(64) NOT NULL DEFAULT 'images/default-logo.jpg',
  `kleur1` varchar(7) NOT NULL DEFAULT 'ffffff',
  `kleur2` varchar(7) NOT NULL DEFAULT '000000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `stempelkaarten`
--

CREATE TABLE `stempelkaarten` (
  `stempelkaart_id` int(16) NOT NULL,
  `ondernemer_id` int(16) NOT NULL,
  `beloning_aantstemps` int(16) NOT NULL,
  `beloning_label` varchar(32) NOT NULL,
  `beloning_beschrijving` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `stempelkaart_klant`
--

CREATE TABLE `stempelkaart_klant` (
  `klant_id` int(16) NOT NULL,
  `stempelkaart_id` int(16) NOT NULL,
  `aant_stemps` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `klanten`
--
ALTER TABLE `klanten`
  ADD KEY `klant_id` (`klant_id`);

--
-- Indexen voor tabel `ondernemers`
--
ALTER TABLE `ondernemers`
  ADD PRIMARY KEY (`ondernemer_id`);

--
-- Indexen voor tabel `stempelkaarten`
--
ALTER TABLE `stempelkaarten`
  ADD PRIMARY KEY (`stempelkaart_id`),
  ADD KEY `ondernemer_id` (`ondernemer_id`);

--
-- Indexen voor tabel `stempelkaart_klant`
--
ALTER TABLE `stempelkaart_klant`
  ADD PRIMARY KEY (`klant_id`),
  ADD KEY `stempelkaart_id` (`stempelkaart_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `klanten`
--
ALTER TABLE `klanten`
  MODIFY `klant_id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `ondernemers`
--
ALTER TABLE `ondernemers`
  MODIFY `ondernemer_id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `stempelkaarten`
--
ALTER TABLE `stempelkaarten`
  MODIFY `stempelkaart_id` int(16) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `stempelkaart_klant`
--
ALTER TABLE `stempelkaart_klant`
  MODIFY `klant_id` int(16) NOT NULL AUTO_INCREMENT;
--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `stempelkaarten`
--
ALTER TABLE `stempelkaarten`
  ADD CONSTRAINT `stempelkaarten_ibfk_1` FOREIGN KEY (`ondernemer_id`) REFERENCES `ondernemers` (`ondernemer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `stempelkaart_klant`
--
ALTER TABLE `stempelkaart_klant`
  ADD CONSTRAINT `stempelkaart_klant_ibfk_1` FOREIGN KEY (`klant_id`) REFERENCES `klanten` (`klant_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stempelkaart_klant_ibfk_2` FOREIGN KEY (`stempelkaart_id`) REFERENCES `stempelkaarten` (`stempelkaart_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
