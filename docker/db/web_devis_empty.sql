-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 01 sep. 2018 à 13:38
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `web_devis`
--

-- --------------------------------------------------------

--
-- Structure de la table `activity`
--

DROP TABLE IF EXISTS `activity`;
CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_group_id` int(11) NOT NULL,
  `profil_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double DEFAULT NULL,
  `min_hours` int(11) DEFAULT NULL,
  `serial_number` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AC74095A5E5E6949` (`activity_group_id`),
  KEY `IDX_AC74095A275ED078` (`profil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `activity`
--

INSERT INTO `activity` (`id`, `activity_group_id`, `profil_id`, `name`, `rate`, `min_hours`, `serial_number`) VALUES
(1, 2, 2, 'Etudes et Cadrage', 25, NULL, 20),
(2, 2, 1, 'Pilotage', 50, 2, 10),
(3, 2, 2, 'Spécifications / Conception', 25, NULL, 30),
(4, 3, 6, 'Assistance VSR', 5, 0, 5),
(5, 3, 6, 'Assistance VABF', 20, 2, 4),
(6, 3, 6, 'Livraison / Packaging', 10, 0, 3),
(7, 3, 6, 'Documentation', 5, 0, 2),
(8, 3, 6, 'Recette Interne', 60, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `activity_group`
--

DROP TABLE IF EXISTS `activity_group`;
CREATE TABLE IF NOT EXISTS `activity_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double DEFAULT NULL,
  `serial_number` int(11) DEFAULT NULL,
  `automatic` tinyint(1) NOT NULL,
  `referent` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `activity_group`
--

INSERT INTO `activity_group` (`id`, `name`, `rate`, `serial_number`, `automatic`, `referent`) VALUES
(1, 'Réalisation', 65, 20, 0, 1),
(2, 'Gestion de projet', 15, 10, 1, 0),
(3, 'Livraison', 20, 30, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `application`
--

DROP TABLE IF EXISTS `application`;
CREATE TABLE IF NOT EXISTS `application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rd_ref` int(11) DEFAULT NULL,
  `alias` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A45BDDC119EB6921` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `application`
--


-- --------------------------------------------------------

--
-- Structure de la table `billing`
--

DROP TABLE IF EXISTS `billing`;
CREATE TABLE IF NOT EXISTS `billing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `billing`
--

INSERT INTO `billing` (`id`, `name`, `alias`) VALUES
(1, 'Projet', 'D'),
(2, 'Compte Temps', 'CT'),
(3, 'Maintenance Applicative', 'TMA');

-- --------------------------------------------------------

--
-- Structure de la table `certainty_level`
--

DROP TABLE IF EXISTS `certainty_level`;
CREATE TABLE IF NOT EXISTS `certainty_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `certainty_level`
--

INSERT INTO `certainty_level` (`id`, `name`, `rate`) VALUES
(1, 'Très Certain', 1),
(2, 'Certain', 2),
(3, 'Incertain', 3.5),
(4, 'Très incertain', 5);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dayly_cost` double DEFAULT NULL,
  `logo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

-- --------------------------------------------------------

--
-- Structure de la table `cyllene_person`
--

DROP TABLE IF EXISTS `cyllene_person`;
CREATE TABLE IF NOT EXISTS `cyllene_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cyllene_person`
--

INSERT INTO `cyllene_person` (`id`, `name`) VALUES
(2, 'Paul Del PRIORE'),
(3, 'David BOLLARD'),
(4, 'Damien LEJART'),
(5, 'Mickaël COLLET'),
(6, 'Olivier BARTHEZ'),
(7, 'Sylvain LAURENT'),
(8, 'César GUILLOTEL'),
(9, 'Cynthia BAYOU'),
(10, 'Daniel DOS PRAZERES'),
(11, 'Yohan VALLON'),
(12, 'Jimmy RIBEIRO'),
(13, 'Florian RODRIGUEZ');

-- --------------------------------------------------------

--
-- Structure de la table `detail`
--

DROP TABLE IF EXISTS `detail`;
CREATE TABLE IF NOT EXISTS `detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header_id` int(11) NOT NULL,
  `activity_group_id` int(11) NOT NULL,
  `profil_id` int(11) DEFAULT NULL,
  `certainty_level_id` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimated_days` double DEFAULT NULL,
  `calculated_days` double NOT NULL,
  `rd_number` int(11) DEFAULT NULL,
  `low_days` double NOT NULL,
  `high_days` double NOT NULL,
  `price` double NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `automatic` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2E067F932EF91FD8` (`header_id`),
  KEY `IDX_2E067F935E5E6949` (`activity_group_id`),
  KEY `IDX_2E067F93275ED078` (`profil_id`),
  KEY `IDX_2E067F93B3F3DCFD` (`certainty_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `detail`
--


-- --------------------------------------------------------

--
-- Structure de la table `header`
--

DROP TABLE IF EXISTS `header`;
CREATE TABLE IF NOT EXISTS `header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cyllene_person_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `in_charge_person_id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `application_version` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redmine_id` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  `estimate_version` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6E72A8C1363F2CFE` (`cyllene_person_id`),
  KEY `IDX_6E72A8C13E030ACD` (`application_id`),
  KEY `IDX_6E72A8C1B9D4015B` (`in_charge_person_id`),
  KEY `IDX_6E72A8C13B025C87` (`billing_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `header`
--

-- --------------------------------------------------------

--
-- Structure de la table `in_charge_person`
--

DROP TABLE IF EXISTS `in_charge_person`;
CREATE TABLE IF NOT EXISTS `in_charge_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D858F1F319EB6921` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `in_charge_person`
--

-- --------------------------------------------------------

--
-- Structure de la table `in_charge_person_application`
--

DROP TABLE IF EXISTS `in_charge_person_application`;
CREATE TABLE IF NOT EXISTS `in_charge_person_application` (
  `in_charge_person_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  PRIMARY KEY (`in_charge_person_id`,`application_id`),
  KEY `IDX_84A4CEEAB9D4015B` (`in_charge_person_id`),
  KEY `IDX_84A4CEEA3E030ACD` (`application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `in_charge_person_application`
--

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

DROP TABLE IF EXISTS `profil`;
CREATE TABLE IF NOT EXISTS `profil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dayly_cost` double NOT NULL,
  `default_selected` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`id`, `name`, `dayly_cost`, `default_selected`) VALUES
(1, 'Directeur de Projets', 850, 0),
(2, 'Chef de Projets', 750, 0),
(3, 'Graphiste', 750, 0),
(4, 'Intégrateur', 500, 0),
(5, 'Développeur 3D', 750, 0),
(6, 'Développeur Back', 650, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `FK_AC74095A275ED078` FOREIGN KEY (`profil_id`) REFERENCES `profil` (`id`),
  ADD CONSTRAINT `FK_AC74095A5E5E6949` FOREIGN KEY (`activity_group_id`) REFERENCES `activity_group` (`id`);

--
-- Contraintes pour la table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `FK_A45BDDC119EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

--
-- Contraintes pour la table `detail`
--
ALTER TABLE `detail`
  ADD CONSTRAINT `FK_2E067F93275ED078` FOREIGN KEY (`profil_id`) REFERENCES `profil` (`id`),
  ADD CONSTRAINT `FK_2E067F932EF91FD8` FOREIGN KEY (`header_id`) REFERENCES `header` (`id`),
  ADD CONSTRAINT `FK_2E067F935E5E6949` FOREIGN KEY (`activity_group_id`) REFERENCES `activity_group` (`id`),
  ADD CONSTRAINT `FK_2E067F93B3F3DCFD` FOREIGN KEY (`certainty_level_id`) REFERENCES `certainty_level` (`id`);

--
-- Contraintes pour la table `header`
--
ALTER TABLE `header`
  ADD CONSTRAINT `FK_6E72A8C1363F2CFE` FOREIGN KEY (`cyllene_person_id`) REFERENCES `cyllene_person` (`id`),
  ADD CONSTRAINT `FK_6E72A8C13B025C87` FOREIGN KEY (`billing_id`) REFERENCES `billing` (`id`),
  ADD CONSTRAINT `FK_6E72A8C13E030ACD` FOREIGN KEY (`application_id`) REFERENCES `application` (`id`),
  ADD CONSTRAINT `FK_6E72A8C1B9D4015B` FOREIGN KEY (`in_charge_person_id`) REFERENCES `in_charge_person` (`id`);

--
-- Contraintes pour la table `in_charge_person`
--
ALTER TABLE `in_charge_person`
  ADD CONSTRAINT `FK_D858F1F319EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

--
-- Contraintes pour la table `in_charge_person_application`
--
ALTER TABLE `in_charge_person_application`
  ADD CONSTRAINT `FK_84A4CEEA3E030ACD` FOREIGN KEY (`application_id`) REFERENCES `application` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_84A4CEEAB9D4015B` FOREIGN KEY (`in_charge_person_id`) REFERENCES `in_charge_person` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
