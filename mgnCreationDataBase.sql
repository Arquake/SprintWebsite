CREATE TABLE Client (
    idClient int NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,nomClient VARCHAR(45) NOT NULL
    ,prenomClient VARCHAR(45) NOT NULL
    ,dateNaissance date NOT NULL
    ,estInscrit boolean NOT NULL
    ,numeroTelephone int
    ,mail VARCHAR(45)
    ,adresse VARCHAR(45)
    ,codePostale int
    ,profession VARCHAR(45)
    ,situation VARCHAR(45)
    ,revenuMensuel decimal(15,2)
    ,montantDecouvert int
);

CREATE TABLE Employe (
    login VARCHAR(45) NOT NULL PRIMARY KEY
    ,password VARCHAR(64) NOT NULL
    ,poste VARCHAR(45) NOT NULL
    ,nomEmploye VARCHAR(45) NOT NULL
    ,prenomEmploye VARCHAR(45) NOT NULL
    ,dateEmbauche date NOT NULL
);

CREATE TABLE HoraireAgence (
    jour VARCHAR(45) PRIMARY KEY
    ,horaireOuverture time NOT NULL
    ,horaireFermeture time NOT NULL
);

CREATE TABLE CreerClient (
    idClient int NOT NULL REFERENCES Client(idClient)
    ,login VARCHAR(45) NOT NULL REFERENCES Employe(login)
    ,dateCreation date NOT NULL
);

CREATE TABLE RattacherA (
    idClient int NOT NULL REFERENCES Client(idClient)
    ,login VARCHAR(45) NOT NULL REFERENCES Employe(login)
    ,dateRattachement date NOT NULL
);

CREATE TABLE ModifierType (
    dateModificationType date NOT NULL
    ,login VARCHAR(45) NOT NULL REFERENCES Employe(login)
);

CREATE TABLE Type (
    type VARCHAR(45) NOT NULL PRIMARY KEY
);

CREATE TABLE TypeContrat (
    typeContrat VARCHAR(45) NOT NULL PRIMARY KEY
  	REFERENCES Type(type)
);

CREATE TABLE TypeCompte (
    typeCompte VARCHAR(45) NOT NULL PRIMARY KEY
     REFERENCES Type(type)
    ,decouvert int
    ,plafond int 
    ,interet decimal(2,3) NOT NULL
    ,propose boolean NOT NULL
);

CREATE TABLE PieceType (
    type VARCHAR(45) NOT NULL REFERENCES Type(type)
    ,pieces VARCHAR(45) NOT NULL
);

CREATE TABLE Compte (
    idCompte int NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,solde int NOT NULL
    ,type VARCHAR(45) NOT NULL REFERENCES TypeCompte(type)
);

CREATE TABLE PossedeCompte (
    idClient int NOT NULL REFERENCES Client(idClient)
    ,idContrat int NOT NULL REFERENCES Contrat(idContrat)
    ,login VARCHAR(45) NOT NULL REFERENCES Employe(login)
    ,dateCreation date NOT NULL
);

CREATE TABLE Contrat (
    idContrat int NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,type VARCHAR(45) NOT NULL REFERENCES TypeContrat(type)
);

CREATE TABLE Contracte (
    idClient int NOT NULL REFERENCES Client(idClient)
    ,idContrat int NOT NULL REFERENCES Contrat(idContrat)
    ,login VARCHAR(45) NOT NULL REFERENCES Employe(login)
    ,dateVente date NOT NULL
);

CREATE TABLE RendezVous (
    idRdv int NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,jourReunion date NOT NULL
    ,heureDebut time NOT NULL
    ,heureFin time NOT NULL  
    ,dateCreationRdv date NOT NULL 
    ,login VARCHAR(45) NOT NULL REFERENCES Employe(login)
    ,idClient int NOT NULL REFERENCES Client(idClient)
    ,Motif VARCHAR(45) NOT NULL REFERENCES Type(type)
);