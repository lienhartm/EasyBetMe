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
-- Structure de la table `easybet_users`
--

CREATE TABLE `easybet_users` (
  `id` int(11) NOT NULL,
  `date_inscription` datetime NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `auth` varchar(15) NOT NULL,
  `off` tinyint(1) NOT NULL,
  `coins` int(11) NOT NULL,
  `credits` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `last_nl` date NOT NULL,
  `nl_off` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `easybet_users`
--

INSERT INTO `easybet_users` (`id`, `date_inscription`, `pseudo`, `email`, `password`, `auth`, `off`, `coins`, `credits`, `points`, `last_nl`, `nl_off`) VALUES
(1, '2023-05-04 09:35:34', 'Fetide68', 'bigober@gmail.com', '$2y$10$SXTG9cjUevphZd.BfJZ7uOY18A6LcVhtXzFYscj/06qiud6ZXTBIG', 'jtr82AqPANVj', 0, 1, 204, 10, '2025-02-17', 0),
(2, '2023-05-04 11:32:44', 'Ana', 'anapantojaruivo@gmail.com', '$2y$10$qDE6qFTrb04Qq/ZwIvgSb.i0MX2iSBG73WNrZdHu6mZAyqPDo/TMe', '6GiyDmt1pq9FqHH', 0, 0, 952, 0, '2025-02-17', 0),
(3, '2024-01-03 10:05:03', 'Tony', 'patchenko.2804@gmail.com', '$2y$10$QagMcu6EiNCoXwaLMtC5VeJpimcntw1uw8MRd7l9KrgGbYGYvcQHi', 'Pt1jdvcnD2nqxeJ', 0, 0, 73, 0, '2025-02-17', 0),
(4, '2024-01-02 09:13:21', 'Léo', 'leobrault005@gmail.com', '$2y$10$Mm1RCbcjph2wC3xhkKiLE.f0fAlbtiOCVLNs2zdjbgfrnNVmiP.mO', 'Mvx4VczGtrbVEzq', 0, 0, 30, 0, '2025-02-17', 0),
(5, '2024-01-02 11:24:41', 'Léo Brault ', 'peluzziestelle@msn.com', '$2y$10$NSG8QYgBDgQCpzWYmpETF.sFrS5kPycGmno2MtVEr/.XLwr9Y8F7.', 'fZxNTjLAcCrtci8', 0, 0, 10, 0, '2025-02-17', 0),
(6, '2024-01-07 19:58:16', 'Alinx', 'alain.heitzler@wanadoo.fr', '$2y$10$Stsy1RgzCdRHiRhOpsHAfuwt9vOvzFG/yOnBmRBhFEftLQuisubNy', 'EcjSYyyh1bRjtBj', 0, 0, 31, 0, '2025-02-17', 0),
(7, '2024-01-10 18:53:16', 'Trompette66', 'jeanlucsirac5@gmail.com', '$2y$10$7sYi3CPI1FhP0ZHaqVTFVucUuZfai4EcSakEzFAyHA2Zyj6Vnl/A2', 'Sh8mR2sbNv7YJii', 0, 0, 20, 0, '2025-02-17', 0),
(8, '2024-01-15 13:12:34', 'levyano', 'marcoslevyp1@gmail.com', '$2y$10$JtxV/7Pk6NRlcSAjg6KaAexZG2VEtQJWZxyumbhPs02yo7p6mETVq', 'sKY2FLerQ6aJ2t5', 0, 0, 81, 0, '2025-02-17', 0),
(9, '2024-01-15 13:15:43', 'Levy', 'rcontador53@gmail.com', '$2y$10$2ri1npQNG9wmj6RSGj8SH.H9.yoEyc/inl3ewZsdM9iUJlIOziGrG', 'b1i63cxPMVQxRbB', 0, 0, 30, 0, '2025-02-17', 0),
(10, '2024-01-15 13:57:16', 'Maderinho67', 'corentinmader5@gmail.com', '$2y$10$M4nyxyYZ3X8HILNfIT5zeul6nwncuJw9rbi1OdqCR5PpKQJA2cGPK', 'uhANAJGyKasfz1D', 0, 0, 29, 0, '2025-02-17', 0),
(11, '2024-01-15 12:13:11', 'McFrans ', 'colinmcfrans@hotmail.fr', '$2y$10$KxhbANCCX4wJ1vxXxvQ4zef4x1hY5PBK.ID3RBzF53EJbHgbg0VKa', '8PasrZMEz6jARNn', 1, 0, 29, 0, '2024-07-09', 1),
(12, '2024-02-10 01:17:19', 'AMA', 'mauvais-artistes@hotmail.fr', '$2y$10$8ojK7jPn4zyF4BeyAZ5NW.CrNoEwGHkNUUIn91fMevN3s6CP2blae', 'pDhi8XciargxeCi', 1, 0, 109, 0, '2024-07-09', 0),
(13, '2024-01-15 15:47:58', 'JC', 'jeancharles.oberle@gmail.com', '$2y$10$pdHdtLfe6zpvWHC7LIhYs.04eVsVjOKRJjb2ufTrh8DUNNEXVAK2a', '6dTL4PY71CTju8P', 1, 0, 164, 0, '2024-07-09', 0),
(14, '2024-01-15 16:19:19', 'Barcette', 'anapantojaoberle@gmail.com', '$2y$10$p5iYJVElpD/0zXA66U0SyuIkWL9vKyPf/bhl1QGrz.CHo5P6VH7Xy', 'ESd5pPUjsiYD7js', 0, 0, 984, 0, '2025-02-17', 0),
(15, '2024-01-15 16:22:36', 'zepelin', 'mlpsdosantos@gmail.com', '$2y$10$QG9pG5Stz5YYbUP7gC599e0rMvSFgVGFdwMYz43AvY5XLquJ83Qd.', 'XM9vy4b72tLfdtD', 0, 0, 30, 0, '2025-02-17', 0),
(16, '2024-01-22 11:26:41', 'Regman ', 'manoughislain9@gmail.com', '$2y$10$gpFjPmb0pV8ceF96kwYaEuwiwQ2OgTEGqYjkfznL9ajlekWJUzcsy', 'ecjiU2BUeHdYs1t', 0, 0, 10, 0, '2025-02-17', 0),
(17, '2024-01-17 20:40:21', 'Filibert68', 'penterle@wanadoo.fr', '$2y$10$3N9Py7QB0LvHX.GKEvKe6OTw3xqkgCEZLj2MA.MfikhSw1s9VgOTG', 'EcHQm9cghSJdDCM', 0, 0, 28, 0, '2025-02-17', 0),
(18, '2024-01-18 21:23:07', 'Adolf ', 'kloepfer.elec@gmail.com', '$2y$10$p.SClppLuRSuTe1Z295jjuhYJ.Qw6KOdgoZETjARz8rivBjonYh0q', 'CuMdq7GxsLTdSm6', 0, 0, 31, 0, '2025-02-17', 0),
(19, '2024-06-14 12:33:55', 'Vogel', 'theo.vogel@orange.fr', '$2y$10$90Lp42dWfHflXkP0Lgt.eurO.jb/fdcnD82IfZVTsfakNiD8FZUN6', 'zKS3AUNPmnUNGSm', 0, 0, 28, 0, '2025-02-17', 0),
(20, '2024-06-14 12:40:55', 'Gayël ', 'gaelmeal@gmail.com', '$2y$10$HTlv3EV5VNxBJFhobT0lEOrTRLk.44xfS9mLEp6lcyiMcGp8XEK7q', 'njRxPit7djDeGbL', 0, 0, 9, 0, '2025-02-17', 0),
(21, '2024-06-14 12:48:55', 'Antonybobo ', 'antony.bosshard@orange.fr', '$2y$10$dpxTeo7LhqsDiQdYNaKk/OyXZvkVHEq/W0BDdrF4RSM3ztfhmynmC', '5usz1YNvxjYBUju', 1, 0, 30, 0, '2024-07-09', 0),
(22, '2024-06-14 13:13:54', 'Steve', 'steveruban75@gmail.com', '$2y$10$RTGALeMRjMv4gznaRFcJOuRFIDfcCfZ.84Me3rJg05kkcZw8kpF0i', 'prKgi79KmLD4bXe', 0, 0, 59, 0, '2025-02-17', 0),
(24, '2024-06-14 17:20:42', 'LJ', 'jaegler.luc@gmail.com', '$2y$10$Qe703lOexGtdDfjjT3NfPe60alJsDWVXA0fXEM2iWbLctjEQNtKbu', 'nfPivzq4PBQSBXa', 0, 0, 23, 0, '2025-02-17', 0),
(25, '2024-06-14 20:52:55', 'Jambon', 'jambon1108@gmail.com', '$2y$10$Lw59E99jd/NCeZOjCxzTHuFwDIg0m/0.2eGjN/Oq9ujHUJPjS/Fjq', 'Px46812BLnePC4T', 0, 0, 28, 0, '2025-02-17', 0),
(26, '2024-06-15 11:54:33', 'Juljuljul', 'julien.sch688@gmail.com', '$2y$10$pJVUGLQjF/5/gUKer5Z7TOb7pYtbn8FQYv4qqkeftDBn6mn34KzlK', '8JFdRQxPnX1acJM', 0, 0, 29, 0, '2025-02-17', 0),
(27, '2024-06-15 14:18:23', 'Titi from Grussa', 'thierry.streitmatter@hotmail.fr', '$2y$10$uxVsTTRfQMyVvFB.WDa0aurXXzSoYk5Cx3nyA5UWLjVICqLmaAjou', 'ZN29sxffFb8yjTF', 0, 0, 29, 0, '2025-02-17', 1),
(28, '2024-06-15 18:53:24', 'Momo', 'mimouni685@gmail.com', '$2y$10$Zw18WiRfmufJkuqOcQW0MudiVzA5bjG6yAG5Kezmf.V7Hk4MoRB06', 'Citi8QqFVFCqChx', 0, 0, 29, 0, '2025-02-17', 0),
(29, '2024-06-16 20:44:09', 'djoudjou', 'pherrscher@hotmail.com', '$2y$10$Kj1iqShAca3ENusXb93L8OeJqbQQNuJg.ZfbSWAHswUk1P0elpOH2', 'xMiJXaUiRjGUu7n', 0, 0, 20, 0, '2025-02-17', 0),
(30, '2024-06-17 08:40:35', 'Popol', 'paul-andre.oberle@hotmail.fr', '$2y$10$2XRBIJ2VRl/Xu6GYtHt9degU38C2x176OmW6Czelu4oNTC033y02u', 'fEKegbYz6nPyHUE', 0, 0, 28, 0, '2025-02-17', 0),
(31, '2025-01-23 16:21:15', 'alias', 'lienhartm8@gmail.com', '$2y$10$WOzbYuIa1UksfVchjBHrQuBlvFZDCgIe0vyDtiI6j6y1gaZwEc6.q', 'uxXXZ3j59NZcqCh', 0, 0, 20, 362, '2025-02-17', 1),
(32, '2025-02-03 00:52:13', 'jonh12', 'yzijdgzltmxgtejeul@hthlm.com', '$2y$10$UeXyrQmi6oh/icdZxnrxoeN8pNpI6EMKum1Oy.Vdta1OJKMqNzvN2', 'CtaiauDiDeuJ', 0, 0, 30, 0, '2025-02-17', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `easybet_users`
--
ALTER TABLE `easybet_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `easybet_users`
--
ALTER TABLE `easybet_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
