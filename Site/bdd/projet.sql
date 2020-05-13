-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 13, 2020 at 07:58 PM
-- Server version: 10.4.12-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;

-- --------------------------------------------------------

--
-- Table structure for table `disponibilité`
--

DROP TABLE IF EXISTS `disponibilié`;
DROP TABLE IF EXISTS `disponibilité`;
CREATE TABLE `disponibilité` (
  `id` int(11) NOT NULL,
  `quantité` int(11) NOT NULL,
  `taille` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `disponibilité`
--

INSERT INTO `disponibilité` (`id`, `quantité`, `taille`) VALUES
(1, 5, 'L'),
(1, 10, 'M'),
(2, 50, 'XL'),
(2, 60, 'M');

-- --------------------------------------------------------

--
-- Table structure for table `Produits`
--

DROP TABLE IF EXISTS `Produits`;
CREATE TABLE `Produits` (
  `id` int(11) NOT NULL,
  `type` varchar(25) NOT NULL,
  `couleur` varchar(15) NOT NULL,
  `description` varchar(60) NOT NULL,
  `lien_image` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Produits`
--

INSERT INTO `Produits` (`id`, `type`, `couleur`, `description`, `lien_image`) VALUES
(1, 't-shirt', 'noir', 't-shirt du groupe de musique metallica logo basique', 'Images/metallica_basique.jpg'),
(2, 't-shirt', 'noir', 't-shirt hardcore angerfist', 'Images/angerfist.jpg'),
(3, 't-shirt', 'noir', 't-shirt du groupe de musique iron maiden logo rond', 'Images/iron_maiden.jpg'),
(17, 'marcel', 'violet', 'un peu petit', 'chemin');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE `utilisateurs` (
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(32) NOT NULL,
  `statut` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Gestion des utilisateurs';

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`pseudo`, `mdp`, `statut`) VALUES
('aeder', '7903b02fa1b4bb1d7936adb0ce7e7a58', 0),
('test', '098f6bcd4621d373cade4e832627b4f6', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `disponibilité`
--
ALTER TABLE `disponibilité`
  ADD PRIMARY KEY (`id`,`quantité`,`taille`) USING BTREE;

--
-- Indexes for table `Produits`
--
ALTER TABLE `Produits`
  ADD PRIMARY KEY (`id`,`lien_image`) USING BTREE;

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD UNIQUE KEY `Nom Unique` (`pseudo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Produits`
--
ALTER TABLE `Produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `disponibilité`
--
ALTER TABLE `disponibilité`
  ADD CONSTRAINT `id_dispo_produit` FOREIGN KEY (`id`) REFERENCES `Produits` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
