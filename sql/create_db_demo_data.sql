-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 27 juin 2022 à 15:29
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `p5phpblog`
--

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
(1, 1, 'Jane123', 'approved', 'This is Jane and I find this simply delightful !', '2022-05-08 13:46:59'),
(2, 1, 'John Doe', 'waiting_approval', 'This is John and this post is so bad I lost all hope in humanity.', '2022-05-08 13:48:20');

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
(1, 'ggo', 'Premier post par GGO !', 'Ceci est le chapo du post (Lorem ipsum dolor sit amet, consectetur adipiscing elit.)', 'Le contenu du post.\r\nQuisque mollis pellentesque orci eu laoreet. Maecenas in enim libero. Nunc cursus erat hendrerit massa ornare, vel faucibus justo molestie. Sed eget nulla a sapien volutpat rutrum venenatis ut sem. Nulla a nisi sit amet lectus auctor venenatis et non nisi. \r\n\r\nEtiam at varius purus. Phasellus lectus neque, mattis quis tempus et, gravida non mauris. Nullam pellentesque feugiat gravida. Nulla at cursus purus, ac venenatis turpis. Phasellus dictum dolor sit amet libero tincidunt, quis laoreet magna posuere. \r\n\r\nSuspendisse potenti. Sed vel ligula iaculis, cursus felis at, sollicitudin nibh. Aenean varius placerat iaculis. Phasellus fringilla lacinia odio eget congue.', '2022-05-08 13:44:07', NULL);

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
('demo', 'demo@demo.fr', '62cc2d8b4bf2d8728120d052163a77df', 'visitor', NULL, NULL),
('demo2', 'demo2@demo.fr', '202cb962ac59075b964b07152d234b70', 'visitor', NULL, NULL),
('demo3', 'demo3@fr.fr', '202cb962ac59075b964b07152d234b70', 'visitor', NULL, NULL),
('eee', 'ee@e.ee', '202cb962ac59075b964b07152d234b70', 'signing_up', '37092d2291c8e18367dd35bcf68652f6d2b670c6a3061981bcc0ab90eb836853', '2022-06-16 17:33:24'),
('ggo', 'ggo@p5phpblog.net', '202cb962ac59075b964b07152d234b70', 'admin', NULL, NULL),
('Jane123', 'jane_doe@gmail.com', '202cb962ac59075b964b07152d234b70', 'visitor', NULL, NULL),
('John Doe', 'jdoe@hotmail.fr', '202cb962ac59075b964b07152d234b70', 'visitor', NULL, NULL),
('nouveaugars', 'ng@ng.ng', '202cb962ac59075b964b07152d234b70', 'visitor', '48bfe8d17670b1a8ddaa9de6e98fee1ec2e788e6bb78f983d3b417e7888efa96', '2022-06-22 17:13:37');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
