-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 13 déc. 2024 à 09:46
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `prjtweb`
--

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id_cours` int(250) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `fichier` varchar(250) NOT NULL,
  `domaine_id` int(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id_cours`, `nom`, `fichier`, `domaine_id`) VALUES
(18, 'Data.', '../../view/backoff/Templates/uploads/COURS DE GENIE LOGICIEL By Pof. YENDE R. (2) (1) (3).docx', 11),
(27, 'eya', '../../view/backoff/Templates/uploads/COURS DE GENIE LOGICIEL By Pof. YENDE R. (2) (1) (7) (1).docx', 9),
(28, 'eya', '../../view/backoff/Templates/uploads/COURS DE GENIE LOGICIEL By Pof. YENDE R. (2) (1) (6) (1).docx', 10),
(30, 'test', '../../view/backoff/Templates/uploads/COURS DE GENIE LOGICIEL By Pof. YENDE R. (2) (1) (7) (1) (3).docx', 13),
(32, 'technologie ', '../../view/backoff/Templates/uploads/COURS DE GENIE LOGICIEL By Pof. YENDE R. (2) (1) (7) (1) (2).docx', 11);

-- --------------------------------------------------------

--
-- Structure de la table `domaines`
--

CREATE TABLE `domaines` (
  `id` int(250) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `competence` varchar(250) NOT NULL,
  `rating` decimal(3,2) DEFAULT 0.00,
  `total_votes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `domaines`
--

INSERT INTO `domaines` (`id`, `nom`, `description`, `image`, `competence`, `rating`, `total_votes`) VALUES
(9, 'Le Cloud Computing ', 'Le Cloud Computing est une technologie permettant d’utiliser les ressources de serveurs informatiques à distance, via internet', '../../view/backoff/Templates/uploads/OIP (1).jpg', 'Les competences: IA -Reseau', 0.00, 0),
(10, 'La Business Intelligence (BI)', 'La Business Intelligence est un ensemble de processus technologiques permettant d’analyser les données de l’entreprise.', '../../view/backoff/Templates/uploads/télécharger (1).jpg', 'Les compétences: Power Bi', 0.00, 0),
(11, 'Le génie logiciel', 'Le génie logiciel est défini comme un processus d\'analyse des besoins des utilisateurs afin de créer une application logicielle ', '../../view/backoff/Templates/uploads/télécharger.jpg', 'Les compétences: ORACLE', 0.00, 0),
(12, 'La Data science', 'La data science est une discipline en plein essor qui consiste à collecter, gérer, analyser et interpréter des données numériques pour en tirer des informations pertinentes', '../../view/backoff/Templates/uploads/OIP (3).jpg', 'Les compétences: Base de donnée', 0.00, 0),
(13, 'La cybersécurité', 'La cybersécurité est la pratique consistant à protéger les systèmes, les réseaux et les programmes contre les attaques numériques.', '../../view/backoff/Templates/uploads/télécharger (2).jpg', 'Les compétences: Informatique embarquée', 0.00, 0),
(27, 'test', 'test', '../../view/backoff/Templates/uploads/télécharger (1).jpg', 'test', 0.00, 0),
(33, 'La vvvv science', 'bbb', '../../view/backoff/Templates/uploads/télécharger (2).jpg', 'bbb', 0.00, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `cours_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ratings`
--

INSERT INTO `ratings` (`id`, `cours_id`, `user_id`, `rating`, `created_at`) VALUES
(1, 27, 1, 5, '2024-12-09 08:49:27.459570'),
(2, 28, 1, 3, '2024-12-09 01:06:42.462442'),
(3, 18, 1, 3, '2024-12-09 09:53:53.833690'),
(4, 30, 1, 2, '2024-12-09 01:27:08.224887'),
(5, 32, 1, 2, '2024-12-09 09:53:48.770684');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(1) NOT NULL,
  `date_creation` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `verification` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id_cours`),
  ADD KEY `fk_cours_domaine` (`domaine_id`);

--
-- Index pour la table `domaines`
--
ALTER TABLE `domaines`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rating_cours` (`cours_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `id_cours` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `domaines`
--
ALTER TABLE `domaines`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `fk_cours_domaine` FOREIGN KEY (`domaine_id`) REFERENCES `domaines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `fk_rating_cours` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id_cours`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
