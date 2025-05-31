-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 13 mai 2025 à 09:24
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutique`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `year` int NOT NULL,
  `console` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `idGame` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idProduct` (`idGame`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `console`
--

DROP TABLE IF EXISTS `console`;
CREATE TABLE IF NOT EXISTS `console` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `console`
--

INSERT INTO `console` (`id`, `name`, `description`) VALUES
(1, 'NES', 'Console de jeu de salon développée par Nintendo'),
(2, 'SNES', 'Console de jeu de salon développée par Nintendo');

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `info` varchar(191) NOT NULL,
  `image` varchar(191) NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `availability` tinyint(1) NOT NULL,
  `idUser` int NOT NULL,
  `idConsole` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `game`
--

INSERT INTO `game` (`id`, `name`, `info`, `image`, `price`, `quantity`, `availability`, `idUser`, `idConsole`) VALUES
(3, 'Super Mario Bros', 'Jeu de plate-forme créé par Shigeru Miyamoto', 'https://github.com/jeffry-khalife/boutique-en-ligne/blob/Images/preview/images/NES/marioNES.jpg?raw=true', 10, 10, 1, 0, 1),
(4, 'The Legend of Zelda', 'Jeu d\'aventure créé par Shigeru Miyamoto', 'https://github.com/jeffry-khalife/boutique-en-ligne/blob/Images/preview/images/NES/ZeldaNES.jpg?raw=true', 13, 5, 1, 0, 1),
(5, 'Metroid', 'Jeu de plate-forme et exploration créé par Gunpei Yokoi', 'https://github.com/jeffry-khalife/boutique-en-ligne/blob/Images/preview/images/NES/metroidNES.jpg?raw=true', 15, 3, 1, 0, 1),
(6, 'Mega Man 2', 'Jeu de plate-forme créé par Keiji Inafune et Yasuaki Katō', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/megaman2NES.jpg', 10, 8, 1, 0, 1),
(7, 'Castlevania', 'Jeu d\'action créé par Toru Igarashi et Kinji Fukasaku', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/castlevaniaNES.jpg', 11, 7, 1, 0, 1),
(8, 'Duck Hunt', 'Jeu de tir au pistolet créé par Gunpei Yokoi', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/duckhuntNES.jpg', 6, 12, 1, 0, 1),
(9, 'Punch-Out!!', 'Jeu de boxe créé par Genyo Takeda et Yoshiki Okamoto', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/PunchoutNES.jpg', 12, 4, 1, 0, 1),
(10, 'Contra', 'Jeu de tir en scrolling vertical créé par Kinji Fukasaku', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/contraNES.jpg', 14, 2, 1, 0, 1),
(11, 'Ninja Gaiden', 'Jeu d\'action et plate-forme créé par Hiroshi Matsuyama', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/ninjagaidenNES.jpg', 15, 6, 1, 0, 1),
(12, 'Double Dragon II', 'Jeu de combat et plate-forme créé par Yoshihiko Oka', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/doubledragon2NES.jpg', 11, 9, 1, 0, 1),
(13, 'Excitebike', 'Jeu de course créé par Toru Igarashi et Kinji Fukasaku', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/excitebikeNES.jpg', 6, 11, 1, 0, 1),
(14, 'Kirby’s Adventure', 'Jeu de plate-forme et exploration créé par Masahiro Sakurai', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/kirby\'sNES.jpg', 10, 10, 1, 0, 1),
(15, 'Bubble Bobble', 'Jeu de plate-forme et puzzle créé par Toru Igarashi', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/bubbleNES.jpg', 9, 15, 1, 0, 1),
(16, 'Kid Icarus', 'Jeu d\'aventure et plate-forme créé par Masahiro Sakurai', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/kidicarusNES.jpg', 13, 5, 1, 0, 1),
(17, 'Battletoads', 'Jeu de combat et plate-forme créé par Geoff Skellington et Tim Sweeney', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/battletoadsNES.jpg', 14, 2, 1, 0, 1),
(18, 'Ice Climber', 'Jeu de plate-forme créé par Toru Igarashi et Kinji Fukasaku', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/iceclimberNES.jpg', 7, 14, 1, 0, 1),
(19, 'Blaster Master', 'Jeu d\'aventure et exploration créé par Hiroshi Matsuyama', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/blastermasterNES.jpg', 12, 4, 1, 0, 1),
(20, 'River City Ransom', 'Jeu de combat et plate-forme créé par Yoshihiko Oka', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/rivercityNES.jpg', 11, 9, 1, 0, 1),
(21, 'Tetris', 'Jeu de puzzle créé par Alexey Pajitnov', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/tetrisNES.jpg', 8, 16, 1, 0, 1),
(22, 'Dr. Mario', 'Jeu de puzzle créé par Gunpei Yokoi et Nintendo', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/NES/drmarioNES.jpg', 9, 10, 1, 0, 1),
(23, 'The Legend of Zelda: A Link to the Past', 'Jeu d\'aventure créé par Shigeru Miyamoto et Nintendo', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/zeldaSNES.jpg', 15, 5, 1, 0, 2),
(24, 'Super Mario World', 'Jeu de plate-forme créé par Shigeru Miyamoto et Nintendo', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/supermarioSNES.jpg', 13, 8, 1, 0, 2),
(25, 'Super Metroid', 'Jeu de plate-forme et exploration créé par Gunpei Yokoi et Nintendo', 'https://i.servimg.com/u/f56/18/82/80/05/tm/2014-011.jpg', 15, 3, 1, 0, 2),
(26, 'Donkey Kong Country', 'Jeu de plate-forme créé par Rare et Nintendo', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/donkeykongSNES.jpg', 14, 2, 1, 0, 2),
(27, 'Final Fantasy VI (III en US)', 'Jeu de rôle créé par Hironobu Sakaguchi et Square', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/finalfantasySNES.jpg', 16, 1, 1, 0, 2),
(28, 'Chrono Trigger', 'Jeu de rôle créé par Yuji Horii et Square', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/chronotriggerSNES.jpg', 17, 1, 1, 0, 2),
(29, 'Super Mario Kart', 'Jeu de course créé par Shigeru Miyamoto et Nintendo', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/mariokartSNES.jpg', 11, 12, 1, 0, 2),
(30, 'Secret of Mana', 'Jeu de rôle actionnel créé par Koichi Ishii et Square', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/secretofmanaSNES.jpg', 15, 4, 1, 0, 2),
(31, 'EarthBound (Mother 2)', 'Jeu de rôle créé par Shigesato Itoi et Nintendo', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/earthboundSNES.jpg', 14, 2, 1, 0, 2),
(32, 'Street Fighter II Turbo', 'Jeu de combat créé par Noritaka Funamizu et Capcom', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/streetfighter2SNES.jpg', 13, 6, 1, 0, 2),
(33, 'F-Zero', 'Jeu de course créé par Tadashi Bridle et Nintendo', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/fzeroSNES.jpg', 10, 10, 1, 0, 2),
(34, 'Yoshi’s Island', 'Jeu de plate-forme créé par Shigeru Miyamoto et Nintendo', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/yoshiSNES.jpg', 12, 5, 1, 0, 2),
(35, 'Super Castlevania IV', 'Jeu d\'action créé par Toru Sugimoto et Konami', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/supercastlevaniaSNES.jpg', 11, 8, 1, 0, 2),
(36, 'Mega Man X', 'Jeu de plate-forme créé par Keiji Inafune et Capcom', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/megamanSNES.jpg', 13, 3, 1, 0, 2),
(37, 'Star Fox', 'Jeu de course créé par Tadashi Bridle et Nintendo', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/starfoxSNES.jpg', 12, 4, 1, 0, 2),
(38, 'Super Ghouls ’n Ghosts', 'Jeu d\'action créé par Masami Ueda et Capcom', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/ghoulSNES.jpg', 10, 10, 1, 0, 2),
(39, 'Illusion of Gaia', 'Jeu de rôle créé par Shigeru Aramaki et Enix', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/gaiaSNES.jpg', 15, 2, 1, 0, 2),
(40, 'ActRaiser', 'Jeu de simulation créé par Keiichi Yano et Quintet', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/actraiserSNES.jpg', 14, 3, 1, 0, 2),
(41, 'Terranigma', 'Jeu d\'aventure créé par Takehiro Izushi et Nintendo', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/terranigmaSNES.jpg', 13, 5, 1, 0, 2),
(42, 'Pilotwings', 'Jeu de simulation créé par Toru Sugimoto et Nintendo', 'https://raw.githubusercontent.com/jeffry-khalife/boutique-en-ligne/refs/heads/Images/preview/images/SNES/pilotwingsSNES.jpg', 11, 9, 0, 0, 2);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `idPayment` int NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) NOT NULL DEFAULT 'en attente',
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping_adress` varchar(255) DEFAULT NULL,
  `notes` text,
  `order_number` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `idProduct` (`idUser`,`idPayment`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `idUser`, `idPayment`, `order_date`, `status`, `total_amount`, `shipping_adress`, `notes`, `order_number`) VALUES
(8, 20, 1, '2025-05-10 10:57:38', 'en attente', 38.00, NULL, NULL, 'RG8'),
(9, 20, 1, '2025-05-10 10:57:54', 'annulée', 6.00, NULL, NULL, 'RG9'),
(10, 20, 1, '2025-05-10 10:58:07', 'annulée', 13.00, NULL, NULL, 'RG10'),
(11, 20, 1, '2025-05-10 10:58:23', 'annulée', 21.00, NULL, NULL, 'RG11'),
(12, 20, 1, '2025-05-10 11:33:33', 'expédiée', 14.00, NULL, NULL, 'RG20250510-095D94'),
(13, 20, 1, '2025-05-10 14:20:56', 'en attente', 33.00, NULL, NULL, 'RG20250510-E1AFAD'),
(14, 20, 1, '2025-05-12 10:17:56', 'en attente', 13.00, NULL, NULL, 'RG20250512-B54115'),
(15, 20, 1, '2025-05-12 10:19:34', 'annulée', 15.00, NULL, NULL, 'RG20250512-D9B34A');

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `game_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `game_id` (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `game_id`, `quantity`, `price`) VALUES
(9, 8, 3, 1, 10.00),
(10, 8, 4, 1, 13.00),
(11, 8, 5, 1, 15.00),
(12, 9, 8, 1, 6.00),
(13, 10, 4, 1, 13.00),
(14, 11, 5, 1, 15.00),
(15, 11, 8, 1, 6.00),
(16, 12, 40, 1, 14.00),
(17, 13, 27, 1, 16.00),
(18, 13, 28, 1, 17.00),
(19, 14, 4, 1, 13.00),
(20, 15, 5, 1, 15.00);

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(191) NOT NULL,
  `info` int NOT NULL,
  `idOrder` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idOrder` (`idOrder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `shoppingcart`
--

DROP TABLE IF EXISTS `shoppingcart`;
CREATE TABLE IF NOT EXISTS `shoppingcart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idGame` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idProduct` (`idGame`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(191) NOT NULL,
  `mail` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `adress` varchar(191) NOT NULL,
  `phone_number` int NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `idGame` int NOT NULL,
  `idOrder` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idProduct` (`idGame`,`idOrder`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `mail`, `password`, `adress`, `phone_number`, `role`, `idGame`, `idOrder`) VALUES
(6, 'test', 'test@gmail', '$2y$10$zjHh13ufaEVv7XzLnZE4d.pl1KCTxlCPNs4TaFv4ZYjeyMScQcsyy', 'test ', 3, 'admin', 0, 0),
(20, 'b', 'b@b', '$2y$10$3qrqwkqM6grvcXMrMww3d.Wm6ipCfPQEN3RouhZymphhDTz2kcdT.', 'bb', 4, 'user', 0, 0),
(21, 'a', 'a@a', '$2y$10$EXKIa02dGJxOI5giRL0WnO0jFUybhpbt.wDjjMkgm38NeAil0e4aq', 'a', 2, 'user', 0, 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
