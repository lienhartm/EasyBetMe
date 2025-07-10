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
-- Structure de la table `easybet_events`
--

CREATE TABLE `easybet_events` (
  `id` int(11) NOT NULL,
  `datedebut` date NOT NULL,
  `datefin` date NOT NULL,
  `competition` varchar(50) NOT NULL,
  `cadeau` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `easybet_events`
--

INSERT INTO `easybet_events` (`id`, `datedebut`, `datefin`, `competition`, `cadeau`, `description`, `img`) VALUES
(1, '2025-05-13', '2025-05-15', 'Essai Evénement #1', 'Evenement de test', 'Test événement #1', 'bg.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `easybet_events`
--
ALTER TABLE `easybet_events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `easybet_events`
--
ALTER TABLE `easybet_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
