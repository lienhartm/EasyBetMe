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
-- Structure de la table `easybet_gifts`
--

CREATE TABLE `easybet_gifts` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `prix` int(11) NOT NULL,
  `img` varchar(25) NOT NULL,
  `partner` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `off` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `easybet_gifts`
--

INSERT INTO `easybet_gifts` (`id`, `nom`, `description`, `prix`, `img`, `partner`, `link`, `off`) VALUES
(81, 'un tour en Deusche', '[TEST] Partez avec Alsace en Deuche à la découverte de l\'Alsace !', 1000, 'Base-Logo.jpg', 'Alsace en Deusche', 'https://alsace-en-deuche.fr/', 0),
(82, 'Cadeau 2', 'Bouquet de fleur', 2500, 'Base-Logo.jpg', '', '', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `easybet_gifts`
--
ALTER TABLE `easybet_gifts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `easybet_gifts`
--
ALTER TABLE `easybet_gifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
