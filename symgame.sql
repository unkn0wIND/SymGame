-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 20 mars 2023 à 11:08
-- Version du serveur : 8.0.27
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `symgame`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230306113427', '2023-03-06 11:35:00', 128),
('DoctrineMigrations\\Version20230310112815', '2023-03-10 11:28:22', 145);

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `game`
--

INSERT INTO `game` (`id`, `name`, `price`, `description`, `created_at`, `user_id`) VALUES
(233, 'Naruto shippuden ultimate ninja storm 4', 50, 'Naruto Shippūden: Ultimate Ninja Storm 4 est un jeu vidéo de combat adapté du manga Naruto, développé par CyberConnect2 et édité par Bandai Namco', '2023-03-20 10:12:26', 7),
(234, 'Red dead redemption 2', 20, 'Red Dead Redemption II est un jeu vidéo d\'action-aventure en monde ouvert et de western multiplateforme, développé par Rockstar Studios et édité par Rockstar Games', '2023-03-20 10:15:34', 7),
(235, 'NBA 2K23', 50, 'NBA 2K23 est un jeu vidéo de basket-ball de 2022 développé par Visual Concepts et publié par 2K Sports, basé sur la National Basketball Association', '2023-03-20 10:17:01', 7),
(236, 'Fifa 23', 20, 'FIFA 23 est un jeu vidéo de simulation de football développé par EA Vancouver et édité par Electronic Arts, il s\'agit du 30ᵉ volet de la série FIFA', '2023-03-20 10:18:23', 7),
(237, 'Call of duty modern warfare 2', 50, 'Call of Duty: Modern Warfare II est un jeu vidéo de tir à la première personne développé par le studio Infinity Ward, et édité par Activision', '2023-03-20 10:20:20', 5),
(238, 'Demon Slayer : The Hinokami Chronicles', 50, 'Demon Slayer: Kimetsu no Yaiba - The Hinokami Chronicles est un jeu vidéo d\'action-aventure développé par CyberConnect2 et édité par Aniplex', '2023-03-20 10:21:12', 5),
(239, 'Grand Theft Auto V', 20, 'Grand Theft Auto V est un jeu vidéo d\'action-aventure, développé par Rockstar North et édité par Rockstar Games', '2023-03-20 10:22:51', 5),
(240, 'Star Wars : Fallen Order', 20, 'Star Wars Jedi: Fallen Order est un jeu vidéo d\'action-aventure, basé sur la licence Star Wars, développé par Respawn Entertainment et édité par le studios Electronic Arts', '2023-03-20 10:24:04', 5);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `full_name`, `pseudo`, `created_at`) VALUES
(5, 'itachi@gmail.com', '[\"ROLE_USER\"]', '$2y$13$HoetaATodWrHCqPie/pTb.X9STn/yVMqEwavK8nFBa9w4WGDpkL7.', 'Uchiwa Itachu', 'Itachi02', '2023-03-15 12:54:24'),
(7, 'madara@gmail.com', '[\"ROLE_USER\"]', '$2y$13$XNWoCSLTMjUnYiIyiPR0ZO.LMHuyWadRxLvp0mV2OWYfqf69D5k/m', 'HelloMan', 'HelloBro', '2023-03-19 12:56:04');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
