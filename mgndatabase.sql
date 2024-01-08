-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 08 jan. 2024 à 14:41
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
(1, 'Daunat', 'Jean', '1999-03-13', 1, 736976334, 'Jean-Daunat@orange.fr', '13 rue des pommiers', 93270, 'dentiste', 'célibataire', '2017-03-14'),
(2, 'Daunat', 'Kyllian', '2003-12-02', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Daunat', 'Ramsès', '2005-02-13', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'kamel', 'Patrick', '2007-10-11', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Kysberly', 'Dannette', '2004-07-26', 1, 239648579, 'kys-berly-Dannette@sfr.fr', '26 avenue du raisin sec', 45100, 'fossoyeuse', 'marié', '2004-07-30'),
(6, 'Kysberly', 'Napoléon', '2003-09-17', 1, 798653421, 'kys-berly-Napoleon@sfr.fr', '26 avenue du raisin sec', 45100, 'croquemort', 'marié', '2020-10-23');

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `compteclient`
--

INSERT INTO `compteclient` (`idCompte`, `idClient`, `dateOuverture`, `solde`, `interet`, `montantDecouvert`, `plafond`, `typeCompte`) VALUES
(13, 1, '2024-01-08', 4640, 0, -300, 0, 'CCP'),
(14, 1, '2024-01-08', 1860, 3, 0, 22950, 'Livret A');

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
('Assurance Maison'),
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contratclient`
--

INSERT INTO `contratclient` (`idContrat`, `idClient`, `dateVente`, `tarifMensuel`, `typeContrat`) VALUES
(6, 1, '2024-01-08', 25, 'Assurance Vie'),
(7, 1, '2024-01-08', 300, 'Assurance Maison');

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
('DannyViannet', '$2y$12$duBbtGusMAYhEo9iev.ud.LtagOawA762sgUC8D1dYwElnKIgSGIW', 'Conseiller', 'Viannet', 'Danny', '2024-08-01'),
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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `motif`
--

INSERT INTO `motif` (`idMotif`, `libelleMotif`, `listePiece`) VALUES
(2, 'Ouverture CCP', '- carte d\'identité\r\n- justificatif d\'identité\r\n- justificatif de revenu'),
(3, 'Ouverture Livret A', '- carte d\'identité\r\n- justificatif d\'identité\r\n- justificatif de revenu'),
(4, 'Ouverture CEL', '- carte d\'identité\r\n- justificatif d\'identité\r\n- justificatif de revenu\r\n- justificatif de domicile'),
(5, 'Ouverture PEL', '- carte d\'identité\r\n- justificatif d\'identité\r\n- justificatif de revenu\r\n- justificatif de domicile\r\n- justificatif de travail CDI'),
(6, 'Résiliation CCP', ''),
(7, 'Résiliation Livret A', ''),
(8, 'Résiliation CEL', ''),
(9, 'Résiliation PEL', ''),
(10, 'Ouverture Assurance Vie', '- justificatif d\'identité'),
(11, 'Ouverture Assurance Maison', '- justificatif d\'identité\r\n- justificatif de domicile'),
(12, 'Ouverture Assurance Voiture', '- justificatif d\'identité\r\n- justificatif de revenu\r\n- carte grise'),
(13, 'Resiliation Assurance Vie', ''),
(14, 'Resiliation Assurance Maison', ''),
(15, 'Resiliation Assurance Voiture', ''),
(16, 'Inscription', '- justificatif de domicile\r\n- justificatif de revenu\r\n- justificatif d\'emploi\r\n- justificatif d\'identité');

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
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `operation`
--

INSERT INTO `operation` (`idOperation`, `idCompte`, `typeOperation`, `montant`, `dateOperation`) VALUES
(33, 13, 'dépot', 750, '2023-01-08'),
(34, 14, 'dépot', 1860, '2023-03-08'),
(35, 13, 'dépot', 600, '2024-01-08'),
(36, 13, 'dépot', 600, '2024-01-08'),
(37, 13, 'dépot', 600, '2024-01-08'),
(38, 13, 'dépot', 600, '2024-01-08'),
(39, 13, 'dépot', 600, '2024-01-08'),
(40, 13, 'dépot', 600, '2024-01-08'),
(41, 13, 'retrait', -1350, '2024-01-08'),
(42, 13, 'dépot', 300, '2024-01-08'),
(43, 13, 'dépot', 300, '2024-01-08'),
(44, 13, 'retrait', -150, '2024-01-08'),
(45, 13, 'retrait', -330, '2024-01-08'),
(46, 13, 'retrait', -50, '2024-01-08'),
(47, 13, 'dépot', 1570, '2024-01-08');

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
(1, 'JeanMichel'),
(2, 'DannyViannet'),
(3, 'JeanMichel'),
(4, 'DannyViannet'),
(5, 'JeanMichel'),
(6, 'JeanMichel');

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
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `rendezvous`
--

INSERT INTO `rendezvous` (`idRdv`, `jourReunion`, `heureDebut`, `heureFin`, `dateCreationRdv`, `login`, `idClient`, `idMotif`) VALUES
(52, '2024-01-12', '10:00:00', '11:00:00', '2024-01-08', 'DannyViannet', 2, '16'),
(53, '2023-10-09', '11:00:00', '12:00:00', '2024-01-08', 'JeanMichel', 1, '16'),
(54, '2023-11-11', '14:00:00', '15:00:00', '2024-01-08', 'JeanMichel', 1, '2'),
(56, '2023-12-16', '15:00:00', '16:00:00', '2024-01-08', 'JeanMichel', 1, '3');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
