-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Hôte : db5001933572.hosting-data.io
-- Généré le : jeu. 15 mai 2025 à 07:21
-- Version du serveur : 5.7.42-log
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbs1582075`
--

-- --------------------------------------------------------

--
-- Structure de la table `easybet_gifts_users`
--

CREATE TABLE `easybet_gifts_users` (
  `id` int(11) NOT NULL,
  `id_gifts` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `coins` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `easybet_gifts_users`
--

INSERT INTO `easybet_gifts_users` (`id`, `id_gifts`, `id_users`, `coins`) VALUES
(5, 81, 1, 10),
(6, 81, 31, 438);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `easybet_gifts_users`
--
ALTER TABLE `easybet_gifts_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_IdUsers_UsersCoins` (`id_users`),
  ADD KEY `fk_IdGifts_UsersCoins` (`id_gifts`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `easybet_gifts_users`
--
ALTER TABLE `easybet_gifts_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `easybet_gifts_users`
--
ALTER TABLE `easybet_gifts_users`
  ADD CONSTRAINT `fk_IdGifts_UsersCoins` FOREIGN KEY (`id_gifts`) REFERENCES `easybet_gifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_IdUsers_UsersCoins` FOREIGN KEY (`id_users`) REFERENCES `easybet_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
