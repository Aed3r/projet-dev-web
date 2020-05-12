-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 12 Mai 2020 à 21:43
-- Version du serveur :  10.1.44-MariaDB-0+deb9u1
-- Version de PHP :  7.0.33-0+deb9u7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `disponibilié`
--

CREATE TABLE `disponibilié` (
  `id` int(11) NOT NULL,
  `quantité` int(11) NOT NULL,
  `taille` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `disponibilié`
--

INSERT INTO `disponibilié` (`id`, `quantité`, `taille`) VALUES
(1, 5, 'L'),
(1, 10, 'M'),
(2, 50, 'XL'),
(2, 60, 'M');

-- --------------------------------------------------------

--
-- Structure de la table `Produits`
--

CREATE TABLE `Produits` (
  `id` int(11) NOT NULL,
  `type` varchar(25) NOT NULL,
  `couleur` varchar(15) NOT NULL,
  `description` varchar(60) NOT NULL,
  `lien_image` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `Produits`
--

INSERT INTO `Produits` (`id`, `type`, `couleur`, `description`, `lien_image`) VALUES
(1, 't-shirt', 'noir', 't-shirt du groupe de musique metallica logo basique', 'Images/metallica_basique.jpg'),
(2, 't-shirt', 'noir', 't-shirt hardcore angerfist', 'Images/angerfist.jpg'),
(3, 't-shirt', 'noir', 't-shirt du groupe de musique iron maiden logo rond', 'Images/iron_maiden.jpg'),
(17, 'marcel', 'violet', 'un peu petit', 'chemin');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `disponibilié`
--
ALTER TABLE `disponibilié`
  ADD PRIMARY KEY (`id`,`quantité`,`taille`) USING BTREE;

--
-- Index pour la table `Produits`
--
ALTER TABLE `Produits`
  ADD PRIMARY KEY (`id`,`lien_image`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Produits`
--
ALTER TABLE `Produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `disponibilié`
--
ALTER TABLE `disponibilié`
  ADD CONSTRAINT `id_dispo_produit` FOREIGN KEY (`id`) REFERENCES `Produits` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
