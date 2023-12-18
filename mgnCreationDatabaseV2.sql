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
);

CREATE TABLE Employe (
    login VARCHAR(45) NOT NULL PRIMARY KEY
    ,password VARCHAR(64) NOT NULL
    ,poste VARCHAR(45) NOT NULL
    ,nomEmploye VARCHAR(45) NOT NULL
    ,prenomEmploye VARCHAR(45) NOT NULL
    ,dateEmbauche date NOT NULL
);

CREATE TABLE Motif (
    idMotif int NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,libelleMotif VARCHAR(45)
    ,listePiece VARCHAR(2000)
);


CREATE TABLE RattacherA (
    idClient int NOT NULL REFERENCES Client(idClient)
    ,login VARCHAR(45) NOT NULL REFERENCES Employe(login)
);

CREATE TABLE RendezVous (
    idRdv int NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,jourReunion date NOT NULL
    ,heureDebut time NOT NULL
    ,heureFin time NOT NULL  
    ,dateCreationRdv date NOT NULL 
    ,login VARCHAR(45) NOT NULL REFERENCES Employe(login)
    ,idClient int NOT NULL REFERENCES Client(idClient)
    ,idMotif VARCHAR(45) NOT NULL REFERENCES Motif(idMotif)
);


CREATE TABLE Compte (
    typeCompte varchar(45) NOT NULL PRIMARY KEY
);

CREATE TABLE Contrat (
    typeContrat VARCHAR(45) NOT NULL PRIMARY KEY
);


CREATE TABLE CompteClient (
    idCompte int NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,idClient int NOT NULL REFERENCES Client(idClient)
    ,dateOuverture date NOT NULL
    ,solde float NOT NULL
    ,interet float NOT NULL
    ,montantDecouvert int NOT NULL
    ,plafond int NOT NULL
    ,typeCompte VARCHAR(45) NOT NULL REFERENCES Compte(typeCompte)
);

CREATE TABLE ContratClient (
    idContrat int NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,idClient int NOT NULL REFERENCES Client(idClient)
    ,dateVente date NOT NULL
    ,tarifMensuel float NOT NULL
    ,typeContrat VARCHAR(45) NOT NULL REFERENCES Contrat(typeContrat)
);


CREATE TABLE Operation (
    idOperation int NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,idCompte int NOT NULL REFERENCES CompteClient(idCompte)
    ,typeOperation VARCHAR(45) NOT NULL
    ,montant float NOT NULL
);

