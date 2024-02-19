-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 19, 2024 alle 12:12
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestione_macchine`
--

--
-- Dump dei dati per la tabella `car`
--

INSERT INTO `car` (`id`, `username`, `brand`, `model`, `description`, `price`) VALUES
(65, 'Pozza136', 'Toyota', 'Yaris', 'Anno modello: 1999-2006\r\nPosti: 5\r\nPorte: 3-5\r\nSerbatoio: 45l\r\nAltezzaAltezza: 148-172 cm\r\nLarghezzaLarghezza: 166-169 cm\r\nLunghezzaLunghezza: 361-388 cm', 7000),
(66, 'Pozza136', 'Rolls-Royce', 'Silver Ghost', 'La Silver Ghost, in origine chiamata 40/50 hp, è un\'autovettura prodotta dalla Rolls-Royce dal 1907 al 1926. La denominazione si riferisce sia ad un esemplare preciso che ad una serie di automobili.', 35000000),
(69, 'Gioele', 'BMW', 'Serie 3', 'Una berlina sportiva con un motore potente e un design elegante.', 40000),
(70, 'Gioele', 'Tesla', 'Model S', 'Auto elettrica di ultima generazione, con tecnologia all\'avanguardia e autonomia eccezionale', 50000),
(71, 'Gioele', 'Ford', 'F-150', 'Robusta e adatta al fuoristrada, ideale per le avventure all\'aperto', 30000);

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`username`, `email`, `password`) VALUES
('Gioele', 'gio@gmail.com', '$2y$10$mlGDAAU3/VUqzKhFk2CCNeQ/qWovBX.WbZ0n/O7CLMfSEvEYgu/xa'),
('guerra', 'guerra@gmail.com', '$2y$10$r/PX47M4gmkwVbt4dFHJreXXV6Vcni6QqSB682LxpMjDbwARh1Vgi'),
('Pozza136', 'dpgioele@gmail.com', '$2y$10$YMcICv.5zj42g2zezHax.eI/zNwEPURl/pi.xbwHl6Sbm8tiLp296');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
