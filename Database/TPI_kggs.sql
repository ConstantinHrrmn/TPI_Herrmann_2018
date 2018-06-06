{\rtf1\ansi\ansicpg1252\cocoartf1561\cocoasubrtf400
{\fonttbl\f0\fswiss\fcharset0 Helvetica;}
{\colortbl;\red255\green255\blue255;}
{\*\expandedcolortbl;;}
\paperw11900\paperh16840\margl1440\margr1440\vieww10800\viewh8400\viewkind0
\pard\tx566\tx1133\tx1700\tx2267\tx2834\tx3401\tx3968\tx4535\tx5102\tx5669\tx6236\tx6803\pardirnatural\partightenfactor0

\f0\fs24 \cf0 -- phpMyAdmin SQL Dump\
-- version 4.7.3\
-- https://www.phpmyadmin.net/\
--\
-- H\'f4te : localhost:8889\
-- G\'e9n\'e9r\'e9 le :  mer. 06 juin 2018 \'e0 16:23\
-- Version du serveur :  5.6.35\
-- Version de PHP :  7.0.22\
\
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";\
SET time_zone = "+00:00";\
\
--\
-- Base de donn\'e9es :  `TPI_kggs`\
--\
CREATE DATABASE IF NOT EXISTS `TPI_kggs` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;\
USE `TPI_kggs`;\
\
-- --------------------------------------------------------\
\
--\
-- Structure de la table `Day`\
--\
\
CREATE TABLE `Day` (\
  `id` int(11) NOT NULL,\
  `nomJour` varchar(300) NOT NULL\
) ENGINE=InnoDB DEFAULT CHARSET=utf8;\
\
--\
-- D\'e9chargement des donn\'e9es de la table `Day`\
--\
\
INSERT INTO `Day` (`id`, `nomJour`) VALUES\
(1, 'Lundi'),\
(2, 'Mardi'),\
(3, 'Mercredi'),\
(4, 'Jeudi'),\
(5, 'Vendredi'),\
(6, 'Samedi');\
\
-- --------------------------------------------------------\
\
--\
-- Structure de la table `Field`\
--\
\
CREATE TABLE `Field` (\
  `id` int(11) NOT NULL,\
  `Nom` varchar(300) NOT NULL\
) ENGINE=InnoDB DEFAULT CHARSET=utf8;\
\
--\
-- D\'e9chargement des donn\'e9es de la table `Field`\
--\
\
INSERT INTO `Field` (`id`, `Nom`) VALUES\
(1, 'C1'),\
(2, 'C2'),\
(3, 'C3'),\
(4, 'T1'),\
(5, 'T2'),\
(6, 'T3'),\
(7, 'T4'),\
(8, 'T5'),\
(9, 'T6'),\
(10, 'K1'),\
(11, 'K2'),\
(12, 'K3'),\
(13, 'A1 / A2'),\
(14, 'A3 / A4'),\
(15, 'A5 / A6');\
\
-- --------------------------------------------------------\
\
--\
-- Structure de la table `Games`\
--\
\
CREATE TABLE `Games` (\
  `id` int(11) NOT NULL,\
  `idArbitre` int(11) NOT NULL,\
  `idTerrain` int(11) NOT NULL,\
  `idJour` int(11) NOT NULL,\
  `idTime` int(11) NOT NULL,\
  `idSport` int(11) NOT NULL,\
  `played` tinyint(1) NOT NULL DEFAULT '0'\
) ENGINE=InnoDB DEFAULT CHARSET=utf8;\
\
-- --------------------------------------------------------\
\
--\
-- Structure de la table `plays`\
--\
\
CREATE TABLE `plays` (\
  `id` int(11) NOT NULL,\
  `idTeam` int(11) NOT NULL,\
  `idGame` int(11) NOT NULL,\
  `score` int(11) NOT NULL DEFAULT '0'\
) ENGINE=InnoDB DEFAULT CHARSET=utf8;\
\
-- --------------------------------------------------------\
\
--\
-- Structure de la table `Role`\
--\
\
CREATE TABLE `Role` (\
  `id` int(11) NOT NULL,\
  `intitule` varchar(200) NOT NULL\
) ENGINE=InnoDB DEFAULT CHARSET=utf8;\
\
--\
-- D\'e9chargement des donn\'e9es de la table `Role`\
--\
\
INSERT INTO `Role` (`id`, `intitule`) VALUES\
(1, 'Admin'),\
(3, 'Arbitre'),\
(4, 'Benevole'),\
(2, 'Coach');\
\
-- --------------------------------------------------------\
\
--\
-- Structure de la table `Sport`\
--\
\
CREATE TABLE `Sport` (\
  `id` int(11) NOT NULL,\
  `Nom` varchar(200) NOT NULL,\
  `nbEquipes` int(11) NOT NULL\
) ENGINE=InnoDB DEFAULT CHARSET=utf8;\
\
--\
-- D\'e9chargement des donn\'e9es de la table `Sport`\
--\
\
INSERT INTO `Sport` (`id`, `Nom`, `nbEquipes`) VALUES\
(1, 'Tchouckball', 2),\
(2, 'Kinball', 3),\
(3, 'Course-Agile', 3),\
(4, 'Atelier', 1);\
\
-- --------------------------------------------------------\
\
--\
-- Structure de la table `Staff`\
--\
\
CREATE TABLE `Staff` (\
  `id` int(11) NOT NULL,\
  `nom` varchar(200) NOT NULL,\
  `prenom` varchar(200) NOT NULL,\
  `age` int(11) DEFAULT '0',\
  `idRole` int(11) NOT NULL,\
  `phone` varchar(15) NOT NULL\
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;\
\
--\
-- D\'e9chargement des donn\'e9es de la table `Staff`\
--\
\
INSERT INTO `Staff` (`id`, `nom`, `prenom`, `age`, `idRole`, `phone`) VALUES\
(0, 'No', 'PERSONNE', 0, 3, ''),\
(2, 'Herrmann', 'Constantin', 17, 1, '41798828925'),\
(35, 'admin', 'Administrateur', 0, 1, ''),\
(36, 'coach', 'Coach', 0, 2, ''),\
(37, 'arbitre', 'Arbitre', 0, 3, ''),\
(38, 'benevole', 'Benevole', 0, 4, ''),\
(43, 'Marco', 'Polo', 0, 4, ''),\
(45, 'Joye', 'Sabrina', 0, 2, '');\
\
-- --------------------------------------------------------\
\
--\
-- Structure de la table `Teams`\
--\
\
CREATE TABLE `Teams` (\
  `id` int(11) NOT NULL,\
  `nom` varchar(200) NOT NULL DEFAULT 'No Name',\
  `idCoach` int(11) NOT NULL DEFAULT '0',\
  `p_A` int(11) NOT NULL DEFAULT '0',\
  `m_A` int(11) NOT NULL DEFAULT '0',\
  `r_A` int(11) NOT NULL DEFAULT '0',\
  `p_B` int(11) NOT NULL DEFAULT '0',\
  `m_B` int(11) NOT NULL DEFAULT '0',\
  `r_B` int(11) NOT NULL DEFAULT '0',\
  `p_C` int(11) NOT NULL DEFAULT '0',\
  `m_C` int(11) NOT NULL DEFAULT '0',\
  `r_C` int(11) NOT NULL DEFAULT '0'\
) ENGINE=InnoDB DEFAULT CHARSET=utf8;\
\
--\
-- D\'e9chargement des donn\'e9es de la table `Teams`\
--\
\
INSERT INTO `Teams` (`id`, `nom`, `idCoach`, `p_A`, `m_A`, `r_A`, `p_B`, `m_B`, `r_B`, `p_C`, `m_C`, `r_C`) VALUES\
(1, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(2, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(3, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(4, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(5, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(6, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(7, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(8, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(9, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(10, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(11, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(12, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(13, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(14, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(15, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(16, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(17, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),\
(18, 'No name', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);\
\
-- --------------------------------------------------------\
\
--\
-- Structure de la table `Time`\
--\
\
CREATE TABLE `Time` (\
  `id` int(11) NOT NULL,\
  `start` time NOT NULL,\
  `end` time NOT NULL\
) ENGINE=InnoDB DEFAULT CHARSET=utf8;\
\
--\
-- D\'e9chargement des donn\'e9es de la table `Time`\
--\
\
INSERT INTO `Time` (`id`, `start`, `end`) VALUES\
(1, '11:00:00', '12:00:00'),\
(2, '13:20:00', '14:15:00'),\
(3, '14:20:00', '15:15:00'),\
(4, '15:40:00', '16:35:00'),\
(5, '16:40:00', '17:15:00');\
\
--\
-- Index pour les tables d\'e9charg\'e9es\
--\
\
--\
-- Index pour la table `Day`\
--\
ALTER TABLE `Day`\
  ADD PRIMARY KEY (`id`);\
\
--\
-- Index pour la table `Field`\
--\
ALTER TABLE `Field`\
  ADD UNIQUE KEY `numero` (`id`);\
\
--\
-- Index pour la table `Games`\
--\
ALTER TABLE `Games`\
  ADD PRIMARY KEY (`id`),\
  ADD KEY `Arbitrage` (`idArbitre`),\
  ADD KEY `Jour` (`idJour`),\
  ADD KEY `Terrain` (`idTerrain`),\
  ADD KEY `Heure` (`idTime`),\
  ADD KEY `LeSport` (`idSport`);\
\
--\
-- Index pour la table `plays`\
--\
ALTER TABLE `plays`\
  ADD PRIMARY KEY (`id`),\
  ADD KEY `Team` (`idTeam`),\
  ADD KEY `Game` (`idGame`);\
\
--\
-- Index pour la table `Role`\
--\
ALTER TABLE `Role`\
  ADD PRIMARY KEY (`id`),\
  ADD UNIQUE KEY `intitule` (`intitule`),\
  ADD KEY `id` (`id`);\
\
--\
-- Index pour la table `Sport`\
--\
ALTER TABLE `Sport`\
  ADD PRIMARY KEY (`id`);\
\
--\
-- Index pour la table `Staff`\
--\
ALTER TABLE `Staff`\
  ADD PRIMARY KEY (`id`),\
  ADD KEY `id` (`id`),\
  ADD KEY `idRole` (`idRole`);\
\
--\
-- Index pour la table `Teams`\
--\
ALTER TABLE `Teams`\
  ADD PRIMARY KEY (`id`),\
  ADD KEY `Coach` (`idCoach`);\
\
--\
-- Index pour la table `Time`\
--\
ALTER TABLE `Time`\
  ADD PRIMARY KEY (`id`),\
  ADD KEY `id` (`id`);\
\
--\
-- AUTO_INCREMENT pour les tables d\'e9charg\'e9es\
--\
\
--\
-- AUTO_INCREMENT pour la table `Games`\
--\
ALTER TABLE `Games`\
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;\
--\
-- AUTO_INCREMENT pour la table `plays`\
--\
ALTER TABLE `plays`\
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;\
--\
-- AUTO_INCREMENT pour la table `Role`\
--\
ALTER TABLE `Role`\
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;\
--\
-- AUTO_INCREMENT pour la table `Sport`\
--\
ALTER TABLE `Sport`\
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;\
--\
-- AUTO_INCREMENT pour la table `Staff`\
--\
ALTER TABLE `Staff`\
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;\
--\
-- AUTO_INCREMENT pour la table `Teams`\
--\
ALTER TABLE `Teams`\
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;\
--\
-- AUTO_INCREMENT pour la table `Time`\
--\
ALTER TABLE `Time`\
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;\
--\
-- Contraintes pour les tables d\'e9charg\'e9es\
--\
\
--\
-- Contraintes pour la table `Games`\
--\
ALTER TABLE `Games`\
  ADD CONSTRAINT `Arbitrage` FOREIGN KEY (`idArbitre`) REFERENCES `Staff` (`id`),\
  ADD CONSTRAINT `Heure` FOREIGN KEY (`idTime`) REFERENCES `Time` (`id`),\
  ADD CONSTRAINT `Jour` FOREIGN KEY (`idJour`) REFERENCES `Day` (`id`),\
  ADD CONSTRAINT `LeSport` FOREIGN KEY (`idSport`) REFERENCES `Sport` (`id`),\
  ADD CONSTRAINT `Terrain` FOREIGN KEY (`idTerrain`) REFERENCES `Field` (`id`);\
\
--\
-- Contraintes pour la table `plays`\
--\
ALTER TABLE `plays`\
  ADD CONSTRAINT `Game` FOREIGN KEY (`idGame`) REFERENCES `Games` (`id`) ON DELETE CASCADE,\
  ADD CONSTRAINT `Team` FOREIGN KEY (`idTeam`) REFERENCES `Teams` (`id`);\
\
--\
-- Contraintes pour la table `Staff`\
--\
ALTER TABLE `Staff`\
  ADD CONSTRAINT `role` FOREIGN KEY (`idRole`) REFERENCES `Role` (`id`);\
}