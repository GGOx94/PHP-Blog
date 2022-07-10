-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 10 juil. 2022 à 17:21
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.4

-- INFOS SUR LES UTILISATEURS :
-- 		2 comptes administrateurs : ggo@p5phpblog.net & admin_2@p5phpblog.net 
--		3 comptes visiteurs : jdoe@hotmail.fr / jane_doe@gmail.com / do@doe.do
-- Tous les utilisateurs ont pour mot de passe : '123'

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `p5phpblogDEMO`
--
CREATE DATABASE IF NOT EXISTS `p5phpblogDEMO` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `p5phpblogDEMO`;

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `fk_post_id` int(11) NOT NULL,
  `fk_user_name` varchar(50) NOT NULL,
  `fk_comment_status` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `fk_post_id`, `fk_user_name`, `fk_comment_status`, `content`, `creation_date`) VALUES
(44, 13, 'Jane123', 'approved', 'Ce post a changé ma vie.\r\nMerci pour tout.', '2022-07-10 17:10:03'),
(45, 13, 'John Doe', 'waiting_approval', 'Tout ceci était fort peu inspiré !\r\nJ&#039;ajouterai que : \r\n\r\nQuisque ac euismod neque. Donec sed metus ac sem eleifend suscipit. Aliquam ligula velit, laoreet vel diam et, tristique dictum sapien. Proin varius, erat a efficitur gravida, felis eros sollicitudin libero, quis laoreet turpis neque ac ipsum.', '2022-07-10 17:11:36'),
(46, 14, 'admin_2', 'approved', 'Je ne connais pas cet auteur, mais il m&#039;a l&#039;air fort intelligent.', '2022-07-10 17:15:44');

-- --------------------------------------------------------

--
-- Structure de la table `comment_status`
--

CREATE TABLE `comment_status` (
  `label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comment_status`
--

INSERT INTO `comment_status` (`label`) VALUES
('approved'),
('waiting_approval');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `fk_user_name` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `head` varchar(400) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `modification_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `fk_user_name`, `title`, `head`, `content`, `creation_date`, `modification_date`) VALUES
(13, 'ggo', 'Premier Post par GGO', 'Ceci est un chapô...\r\nTrès inspiré.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec urna ut urna congue posuere. Pellentesque lacinia finibus viverra. Quisque vel libero vitae libero condimentum pulvinar id semper tellus. Mauris eu molestie ex. Quisque quis sem nec libero semper fermentum. Aliquam lacinia, libero vitae dignissim ornare, ipsum elit blandit leo, placerat faucibus nisi quam vel neque. Aenean scelerisque velit vitae diam vehicula tempus. Duis et accumsan turpis.\r\n\r\nModification !\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec urna ut urna congue posuere. Pellentesque lacinia finibus viverra. Quisque vel libero vitae libero condimentum pulvinar id semper tellus. Mauris eu molestie ex. Quisque quis sem nec libero semper fermentum. \r\n\r\nAliquam lacinia, libero vitae dignissim ornare, ipsum elit blandit leo, placerat faucibus nisi quam vel neque. Aenean scelerisque velit vitae diam vehicula tempus. Duis et accumsan turpis.', '2022-07-10 17:09:16', '2022-07-10 17:16:20'),
(14, 'admin_2', 'Admin2 a son mot à dire...', 'Avec un chapô de qualité.', 'Et un contenu qui coupe le souffle :\r\n- Donec fringilla nec tortor sed mattis. Donec molestie mauris mi, eget aliquet velit pulvinar eu. Phasellus ac orci scelerisque, bibendum est a, tempor dolor. Vivamus id felis elit. Proin dui metus, luctus nec aliquam ac, pharetra nec turpis. Fusce vestibulum vel massa vitae auctor. Suspendisse vitae erat a risus eleifend mollis. Suspendisse cursus sollicitudin odio at interdum. Duis libero nunc, tristique in arcu at, ultricies aliquet nisl. Nulla mattis id tortor non gravida.\r\n\r\nDe plus :\r\n- Sed et tincidunt dolor. Suspendisse at nunc quis turpis gravida varius. Morbi imperdiet augue vel magna ornare, non ullamcorper turpis scelerisque. Vestibulum non neque lacinia, facilisis nisl eget, blandit nisl. Aenean sed est id metus feugiat tristique eu vitae lorem. Duis sed lacinia lacus. Nulla ut lacus ac ante pharetra dignissim vitae ut tortor. Aliquam posuere blandit dolor, non ullamcorper turpis viverra quis. Phasellus sed ante sed eros bibendum dapibus. \r\n\r\n- Vivamus quis euismod nisi. Morbi commodo pulvinar lectus sed vehicula. Nunc non mauris vitae turpis varius eleifend in volutpat arcu. Donec venenatis enim fermentum dolor lacinia lobortis. Suspendisse vestibulum est a ex elementum fringilla.', '2022-07-10 17:14:41', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fk_user_status` varchar(50) NOT NULL,
  `token` varchar(64) DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`name`, `email`, `password`, `fk_user_status`, `token`, `expire_date`) VALUES
('admin_2', 'admin_2@p5phpblog.net', '202cb962ac59075b964b07152d234b70', 'admin', NULL, NULL),
('Do Doe', 'do@doe.do', '202cb962ac59075b964b07152d234b70', 'banned', '43ce44b0ba23cd1de959e6c350c08eb01eb0afc1f2821d9f89f5aa98d630fa78', '2022-07-12 17:18:05'),
('ggo', 'ggo@p5phpblog.net', '202cb962ac59075b964b07152d234b70', 'admin', NULL, NULL),
('Jane123', 'jane_doe@gmail.com', '202cb962ac59075b964b07152d234b70', 'visitor', NULL, NULL),
('John Doe', 'jdoe@hotmail.fr', '202cb962ac59075b964b07152d234b70', 'visitor', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_status`
--

CREATE TABLE `user_status` (
  `label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user_status`
--

INSERT INTO `user_status` (`label`) VALUES
('admin'),
('banned'),
('signing_up'),
('visitor');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_name` (`fk_user_name`),
  ADD KEY `fk_comment_status` (`fk_comment_status`),
  ADD KEY `comment_ibfk_1` (`fk_post_id`);

--
-- Index pour la table `comment_status`
--
ALTER TABLE `comment_status`
  ADD PRIMARY KEY (`label`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_name` (`fk_user_name`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_status` (`fk_user_status`);

--
-- Index pour la table `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`label`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`fk_post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`fk_user_name`) REFERENCES `user` (`name`),
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`fk_comment_status`) REFERENCES `comment_status` (`label`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`fk_user_name`) REFERENCES `user` (`name`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`fk_user_status`) REFERENCES `user_status` (`label`);
COMMIT;
