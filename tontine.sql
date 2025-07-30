-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 25 juil. 2025 à 12:22
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tontine`
--

-- --------------------------------------------------------

--
-- Structure de la table `cotisation`
--

DROP TABLE IF EXISTS `cotisation`;
CREATE TABLE IF NOT EXISTS `cotisation` (
  `id_coti` int(11) NOT NULL AUTO_INCREMENT,
  `id_uti` int(11) NOT NULL,
  `id_rec` int(11) NOT NULL,
  `id_method` int(11) NOT NULL,
  `montant` varchar(200) NOT NULL,
  `date` timestamp NOT NULL,
  PRIMARY KEY (`id_coti`),
  KEY `id_uti` (`id_uti`),
  KEY `id_rec` (`id_rec`),
  KEY `id_method` (`id_method`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cotisation`
--

INSERT INTO `cotisation` (`id_coti`, `id_uti`, `id_rec`, `id_method`, `montant`, `date`) VALUES
(1, 1, 0, 1, '2000', '2025-07-22 14:47:30'),
(2, 1, 2, 1, '2000', '2025-07-22 14:55:12'),
(3, 1, 2, 1, '2000', '2025-07-22 14:55:37'),
(4, 1, 2, 1, '2000', '2025-07-22 14:55:48'),
(5, 1, 3, 1, '5000', '2025-07-22 15:02:44'),
(6, 1, 3, 1, '5000', '2025-07-22 15:08:18'),
(7, 1, 2, 1, '4000', '2025-07-22 15:10:17'),
(8, 1, 2, 1, '1984', '2025-07-23 10:42:44'),
(9, 4, 2, 1, '200', '2025-07-23 10:47:36'),
(10, 4, 2, 1, '8000', '2025-07-23 10:48:33'),
(11, 4, 3, 1, '2000000000', '2025-07-23 10:58:58'),
(12, 4, 1, 1, '5000', '2025-07-23 12:11:23'),
(13, 4, 3, 1, '7997', '2025-07-23 12:42:43'),
(14, 4, 3, 1, '888', '2025-07-25 08:07:23'),
(15, 4, 2, 3, '550', '2025-07-25 11:20:16'),
(16, 4, 2, 6, '88', '2025-07-25 11:20:44'),
(17, 4, 2, 1, '8559', '2025-07-25 11:21:06'),
(18, 4, 2, 1, '877888', '2025-07-25 11:21:48');

-- --------------------------------------------------------

--
-- Structure de la table `infocoti`
--

DROP TABLE IF EXISTS `infocoti`;
CREATE TABLE IF NOT EXISTS `infocoti` (
  `id_info` int(11) NOT NULL AUTO_INCREMENT,
  `id_uti` int(11) NOT NULL,
  `balance_uti` varchar(200) NOT NULL DEFAULT '0',
  `id_rec` int(11) NOT NULL,
  `types` varchar(200) NOT NULL,
  `montantChoisie` varchar(200) NOT NULL,
  `date_limite` varchar(200) NOT NULL,
  `depart_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_info`),
  KEY `id_rec` (`id_rec`),
  KEY `id_uti` (`id_uti`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `infocoti`
--

INSERT INTO `infocoti` (`id_info`, `id_uti`, `balance_uti`, `id_rec`, `types`, `montantChoisie`, `date_limite`, `depart_date`) VALUES
(1, 1, '14984', 2, 'mensuel', '841000', '2025-08-22 14:12:52', '2025-07-19 12:17:08'),
(30, 1, '14000', 3, 'mensuel', '841000', '2025-08-22 08:40:30', '2025-07-21 19:46:02'),
(31, 2, '0', 1, 'mensuel', '20023', 'mardi 22 juillet 2025', '2025-07-22 07:49:30'),
(34, 4, '2000895285', 2, 'hebdomadaire', '30000', '2026-01-30 08:07:06', '2025-07-23 10:19:28'),
(36, 4, '13885', 3, 'hebdomadaire', '4444', '2027-09-22 12:14:47', '2025-07-23 12:09:13');

-- --------------------------------------------------------

--
-- Structure de la table `method_payement`
--

DROP TABLE IF EXISTS `method_payement`;
CREATE TABLE IF NOT EXISTS `method_payement` (
  `id_method` int(11) NOT NULL AUTO_INCREMENT,
  `id_uti` int(11) NOT NULL,
  `types` varchar(200) NOT NULL,
  `details` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_method`),
  KEY `id_uti` (`id_uti`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `method_payement`
--

INSERT INTO `method_payement` (`id_method`, `id_uti`, `types`, `details`, `date`) VALUES
(1, 4, 'mobile_money', '[\"52503007\",\"LABINTAN\",\"Emmanuel\"]', '2025-07-23 14:11:49'),
(3, 4, 'mobile_money', '[\"52503007\",\"LABINTAN\",\"Emmanuel\"]', '2025-07-23 14:24:16'),
(6, 4, 'Carte_Bancaire', '[\"251654999\",\"hiiiiuguy\",\"2025-07-24\",\"238\"]', '2025-07-23 14:25:48');

-- --------------------------------------------------------

--
-- Structure de la table `recompense`
--

DROP TABLE IF EXISTS `recompense`;
CREATE TABLE IF NOT EXISTS `recompense` (
  `id_rec` int(11) NOT NULL AUTO_INCREMENT,
  `nom_rec` varchar(200) NOT NULL,
  `prix_rec` varchar(200) NOT NULL,
  `img_rec` varchar(200) NOT NULL,
  PRIMARY KEY (`id_rec`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `recompense`
--

INSERT INTO `recompense` (`id_rec`, `nom_rec`, `prix_rec`, `img_rec`) VALUES
(1, 'Ordinateur de bureau', '400000', 'c1fb915c5246fc4c6a5a596907fa2231.jfif'),
(2, 'Pc gaming', '800000', 'c1fb915c5246fc4c6a5a596907fa2231.jfif'),
(3, 'test-1', '500000', 'c1fb915c5246fc4c6a5a596907fa2231.jfif');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_uti` int(11) NOT NULL AUTO_INCREMENT,
  `nom_uti` varchar(200) NOT NULL,
  `prenom_uti` varchar(200) NOT NULL,
  `img_uti` varchar(200) NOT NULL DEFAULT '../Assets/img/default.png',
  `password` varchar(200) NOT NULL,
  `balance_uti` varchar(200) DEFAULT '0',
  `progression` varchar(200) DEFAULT NULL,
  `id_rec` int(11) DEFAULT NULL,
  `email_uti` varchar(200) NOT NULL,
  `num_uti` varchar(200) NOT NULL,
  `date_uti` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_uti`),
  KEY `id_rec` (`id_rec`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_uti`, `nom_uti`, `prenom_uti`, `img_uti`, `password`, `balance_uti`, `progression`, `id_rec`, `email_uti`, `num_uti`, `date_uti`) VALUES
(1, 'LABINTAN', 'Emmanuel', 'http://localhost/tontine%20en%20ligne/public/Assets/img/c1fb915c5246fc4c6a5a596907fa2231.jfif', 'azertyu', '4000', '', 3, 'emmanuellbns@gmail.com', '+229014484284000', '2025-07-15 18:47:45'),
(2, 'bof', 'jr', 'kkk', 'fnhf', 'nnhehjf', '', 1, 'hhh', 'bnnnnn', '2025-07-16 09:15:48'),
(3, 'bof', 'jr', 'kkk', 'fnhf', 'nnhehjf', '', 1, 'hhh', 'bnnnnn', '2025-07-16 09:16:39'),
(4, 'LABINTAN', 'Emmanuel', '../Assets/img/default.png', '$2y$10$YI2TijstN7uBciLI1Yi0XenPM0/gae0V2u3ZOEpMs3R6PXQD8h6T6', '0', NULL, 1, 'olalbns@gmail.com', '52503007', '2025-07-23 07:26:29'),
(11, 'LABINTAN', 'Emmanuel', 'default.png', '$2y$10$sDRaGvnDQWPsGb8XJSoXdugx62ez8NPBQe6QkJJqUwRo7QM3cIMoa', '0', NULL, NULL, 'admin@moncapital.com', '525030070', '2025-07-23 07:37:41');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
