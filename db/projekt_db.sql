-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: Pi 24.Máj 2024, 14:03
-- Verzia serveru: 10.4.27-MariaDB
-- Verzia PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `projekt_db`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `kategorie`
--

CREATE TABLE `kategorie` (
  `id` int(11) NOT NULL,
  `kategoria_id` int(11) NOT NULL,
  `kategoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `kategorie`
--

INSERT INTO `kategorie` (`id`, `kategoria_id`, `kategoria`) VALUES
(1, 1, 'zver'),
(2, 2, 'budovy'),
(3, 3, 'priroda'),
(4, 4, 'auta'),
(5, 5, 'psy'),
(6, 6, 'ludia');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `obrazky`
--

CREATE TABLE `obrazky` (
  `id` int(11) NOT NULL,
  `kategoria_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nazov` varchar(100) NOT NULL,
  `popis` varchar(1000) DEFAULT NULL,
  `cesta` varchar(100) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `obrazky`
--

INSERT INTO `obrazky` (`id`, `kategoria_id`, `user_id`, `nazov`, `popis`, `cesta`, `datum`) VALUES
(1, 3, 3, 'bicykel', 'ffktuft', 'obrazky/IMG_0065-2-2.jpg', '2024-05-24 08:47:35'),
(2, 6, 4, 'ertyu', 'ertyujoihjgfd', 'obrazky/_MG_0014.jpg', '2024-05-24 09:13:27');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `reg_date`) VALUES
(1, 'test', 'test@test.com', '$2y$10$R3gsvCbzIjfG/18DmnZHn.GSF6ccRQfx65GlelcP5BzL2NRLHHFMm', '2024-05-24 10:36:11'),
(2, 'test1', 'test1@test.com', '$2y$10$87Jfskd6F5webe8Pos9X7.ngXyLgh1IjFnPHoKupRCpdrUeXnfDD6', '2024-05-24 10:40:19'),
(3, 'test2', 'test2@test.sk', '$2y$10$pqJOjJ0BkG/zZmaahTyRWe.JMny8WHNAzUgssdwTTB9vrg9W8Qxmq', '2024-05-24 10:43:15'),
(4, 'test3', 'test3@test.sk', '$2y$10$qDqpDuf2wrx9V/M4zD2Npu4v.Ob58tWJ7wwbleF1ST6ZmS8t.iYpS', '2024-05-24 11:10:47');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `obrazky`
--
ALTER TABLE `obrazky`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pre tabuľku `obrazky`
--
ALTER TABLE `obrazky`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pre tabuľku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
