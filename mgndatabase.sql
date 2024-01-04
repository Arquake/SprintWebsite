-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 04 jan. 2024 à 17:18
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mgndatabase`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `idClient` int NOT NULL AUTO_INCREMENT,
  `nomClient` varchar(45) NOT NULL,
  `prenomClient` varchar(45) NOT NULL,
  `dateNaissance` date NOT NULL,
  `estInscrit` tinyint(1) NOT NULL,
  `numeroTelephone` int DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `codePostale` int DEFAULT NULL,
  `profession` varchar(45) DEFAULT NULL,
  `situation` varchar(45) DEFAULT NULL,
  `dateInscription` date DEFAULT NULL,
  PRIMARY KEY (`idClient`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`idClient`, `nomClient`, `prenomClient`, `dateNaissance`, `estInscrit`, `numeroTelephone`, `mail`, `adresse`, `codePostale`, `profession`, `situation`, `dateInscription`) VALUES
(9, 'Martin', 'Kys', '2023-12-14', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Test', 'Test', '2023-12-12', 1, 1234567891, 'kys@kys.com', 'kys', 93270, 'kys', 'kys', NULL),
(7, 'Jonny', 'Doe', '2023-12-19', 1, 787173223, 'kys@kys.kys', 'kys', 91000, 'prof de kys', 'mort', NULL),
(10, 'feur', 'Doe', '2024-01-01', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'testi', 'testi', '2024-01-01', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `typeCompte` varchar(45) NOT NULL,
  PRIMARY KEY (`typeCompte`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`typeCompte`) VALUES
('CCP'),
('CEL'),
('Livret A'),
('PEL');

-- --------------------------------------------------------

--
-- Structure de la table `compteclient`
--

DROP TABLE IF EXISTS `compteclient`;
CREATE TABLE IF NOT EXISTS `compteclient` (
  `idCompte` int NOT NULL AUTO_INCREMENT,
  `idClient` int NOT NULL,
  `dateOuverture` date NOT NULL,
  `solde` float NOT NULL,
  `interet` float NOT NULL,
  `montantDecouvert` int NOT NULL,
  `plafond` int NOT NULL,
  `typeCompte` varchar(45) NOT NULL,
  PRIMARY KEY (`idCompte`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `compteclient`
--

INSERT INTO `compteclient` (`idCompte`, `idClient`, `dateOuverture`, `solde`, `interet`, `montantDecouvert`, `plafond`, `typeCompte`) VALUES
(11, 7, '2024-01-01', 360, 0, -300, 0, 'CCP'),
(12, 8, '2024-01-03', 0, 3, 0, 22950, 'Livret A'),
(9, 8, '2023-12-31', 12500, 0, -400, 0, 'CCP');

-- --------------------------------------------------------

--
-- Structure de la table `contrat`
--

DROP TABLE IF EXISTS `contrat`;
CREATE TABLE IF NOT EXISTS `contrat` (
  `typeContrat` varchar(45) NOT NULL,
  PRIMARY KEY (`typeContrat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contrat`
--

INSERT INTO `contrat` (`typeContrat`) VALUES
('Assurance Vie'),
('Assurance Voiture');

-- --------------------------------------------------------

--
-- Structure de la table `contratclient`
--

DROP TABLE IF EXISTS `contratclient`;
CREATE TABLE IF NOT EXISTS `contratclient` (
  `idContrat` int NOT NULL AUTO_INCREMENT,
  `idClient` int NOT NULL,
  `dateVente` date NOT NULL,
  `tarifMensuel` float NOT NULL,
  `typeContrat` varchar(45) NOT NULL,
  PRIMARY KEY (`idContrat`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contratclient`
--

INSERT INTO `contratclient` (`idContrat`, `idClient`, `dateVente`, `tarifMensuel`, `typeContrat`) VALUES
(4, 7, '2024-01-01', 360, 'Assurance Voiture'),
(5, 8, '2024-01-03', 25, 'Assurance Vie');

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

DROP TABLE IF EXISTS `employe`;
CREATE TABLE IF NOT EXISTS `employe` (
  `login` varchar(45) NOT NULL,
  `password` varchar(64) NOT NULL,
  `poste` varchar(45) NOT NULL,
  `nomEmploye` varchar(45) NOT NULL,
  `prenomEmploye` varchar(45) NOT NULL,
  `dateEmbauche` date NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`login`, `password`, `poste`, `nomEmploye`, `prenomEmploye`, `dateEmbauche`) VALUES
('JeanneDoe', '$2y$12$NR2lbzU0cSynHJvUPKFUxO.DO13D1KoElXgNR4rSprjkubmMM99BK', 'Directeur', 'Doe', 'Jeanne', '2023-12-02'),
('JohnDoe', '$2y$12$NR8c3phliX2HcwexgiduMOcXc1PLBOfoyahrYJV72iP8Ez/HgTsx2', 'Agent', 'Doe', 'John', '2023-12-02'),
('JeanMichel', '$2y$12$5qfBla3n1wBIoSL8dTnqVeXGRcY.mX/o5oTK8/oHxMfRH74RNf1li', 'Conseiller', 'Jean', 'Michel', '2023-12-02');

-- --------------------------------------------------------

--
-- Structure de la table `motif`
--

DROP TABLE IF EXISTS `motif`;
CREATE TABLE IF NOT EXISTS `motif` (
  `idMotif` int NOT NULL AUTO_INCREMENT,
  `libelleMotif` varchar(45) DEFAULT NULL,
  `listePiece` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`idMotif`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `motif`
--

INSERT INTO `motif` (`idMotif`, `libelleMotif`, `listePiece`) VALUES
(1, 'test', 'truc');

-- --------------------------------------------------------

--
-- Structure de la table `operation`
--

DROP TABLE IF EXISTS `operation`;
CREATE TABLE IF NOT EXISTS `operation` (
  `idOperation` int NOT NULL AUTO_INCREMENT,
  `idCompte` int NOT NULL,
  `typeOperation` varchar(45) NOT NULL,
  `montant` float NOT NULL,
  `dateOperation` date NOT NULL,
  PRIMARY KEY (`idOperation`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `operation`
--

INSERT INTO `operation` (`idOperation`, `idCompte`, `typeOperation`, `montant`, `dateOperation`) VALUES
(32, 9, 'dépot', 100, '2024-01-03'),
(31, 12, 'retrait', -300, '2024-01-03'),
(30, 12, 'dépot', 300, '2024-01-03'),
(29, 10, 'retrait', -400, '2024-01-01'),
(28, 9, 'dépot', 400, '2024-01-01'),
(27, 11, 'dépot', 360, '2024-01-01'),
(26, 10, 'dépot', 100, '2023-12-31'),
(25, 9, 'retrait', -360, '2023-12-31'),
(24, 10, 'dépot', 300, '2023-12-31'),
(23, 9, 'dépot', 12360, '2023-12-30');

-- --------------------------------------------------------

--
-- Structure de la table `rattachera`
--

DROP TABLE IF EXISTS `rattachera`;
CREATE TABLE IF NOT EXISTS `rattachera` (
  `idClient` int NOT NULL,
  `login` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `rattachera`
--

INSERT INTO `rattachera` (`idClient`, `login`) VALUES
(9, 'JeanMichel'),
(7, 'JeanMichel'),
(8, 'JeanMichel'),
(13, 'JeanMichel'),
(14, 'JeanMichel');

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

DROP TABLE IF EXISTS `rendezvous`;
CREATE TABLE IF NOT EXISTS `rendezvous` (
  `idRdv` int NOT NULL AUTO_INCREMENT,
  `jourReunion` date NOT NULL,
  `heureDebut` time NOT NULL,
  `heureFin` time NOT NULL,
  `dateCreationRdv` date NOT NULL,
  `login` varchar(45) NOT NULL,
  `idClient` int NOT NULL,
  `idMotif` varchar(45) NOT NULL,
  PRIMARY KEY (`idRdv`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `rendezvous`
--

INSERT INTO `rendezvous` (`idRdv`, `jourReunion`, `heureDebut`, `heureFin`, `dateCreationRdv`, `login`, `idClient`, `idMotif`) VALUES
(1, '2023-12-19', '12:00:00', '13:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(2, '2023-12-19', '13:00:00', '14:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(3, '2023-12-19', '14:00:00', '15:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(4, '2023-12-19', '15:00:00', '16:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(5, '2023-12-19', '16:00:00', '17:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(6, '2023-12-19', '17:00:00', '18:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(7, '2023-12-20', '08:00:00', '09:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(8, '2023-12-20', '09:00:00', '10:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(9, '2023-12-20', '10:00:00', '11:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(10, '2023-12-20', '11:00:00', '12:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(11, '2023-12-20', '12:00:00', '13:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(12, '2023-12-20', '13:00:00', '14:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(13, '2023-12-21', '08:00:00', '09:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(14, '2023-12-21', '09:00:00', '10:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(15, '2023-12-21', '10:00:00', '11:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(16, '2023-12-21', '11:00:00', '12:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(17, '2023-12-21', '13:00:00', '14:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(18, '2023-12-21', '14:00:00', '15:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(19, '2023-12-22', '08:00:00', '09:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(20, '2023-12-22', '09:00:00', '10:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(21, '2023-12-22', '10:00:00', '11:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(22, '2023-12-22', '11:00:00', '12:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(23, '2023-12-22', '12:00:00', '13:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(24, '2023-12-22', '13:00:00', '14:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(25, '2023-12-23', '08:00:00', '09:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(26, '2023-12-23', '09:00:00', '10:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(27, '2023-12-23', '10:00:00', '11:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(28, '2023-12-23', '11:00:00', '12:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(29, '2023-12-23', '12:00:00', '13:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(30, '2023-12-23', '13:00:00', '14:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(31, '2023-12-24', '08:00:00', '09:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(32, '2023-12-24', '09:00:00', '10:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(33, '2023-12-24', '10:00:00', '11:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(34, '2023-12-24', '11:00:00', '12:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(35, '2023-12-24', '12:00:00', '13:00:00', '2023-12-18', 'JeanMichel', 7, '1'),
(39, '2023-12-24', '15:00:00', '16:00:00', '2023-12-19', 'jonnytest', -1, 'formation'),
(38, '2023-12-22', '15:00:00', '16:00:00', '2023-12-19', 'jonnytest', 8, '1'),
(40, '2023-12-24', '15:00:00', '16:00:00', '2023-12-19', 'JeanMichel', -1, 'formation'),
(41, '2023-12-23', '15:00:00', '16:00:00', '2023-12-19', 'JeanMichel', -1, 'formation'),
(42, '2023-12-26', '10:00:00', '12:00:00', '2023-12-25', 'JeanMichel', 8, '1'),
(44, '2023-12-24', '14:00:00', '16:00:00', '2023-12-25', 'JeanMichel', 8, '1'),
(45, '2023-12-29', '16:00:00', '17:00:00', '2023-12-28', 'JeanMichel', 8, '1'),
(46, '2024-01-02', '12:00:00', '14:00:00', '2024-01-01', 'JeanMichel', 14, '1'),
(47, '2024-01-02', '14:00:00', '16:00:00', '2024-01-01', 'JeanMichel', 14, '1'),
(48, '2024-01-02', '16:00:00', '18:00:00', '2024-01-01', 'JeanMichel', 14, '1'),
(49, '2024-01-02', '18:00:00', '20:00:00', '2024-01-01', 'JeanMichel', 14, '1'),
(51, '2024-01-03', '10:00:00', '12:00:00', '2024-01-01', 'JeanMichel', 14, '1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
