<?php

    //
    // NV
    //
    // on vérifie si le login n'existe pas déjà
    // Si il n'existe pas on créé l'employé en chiffrant le mot de passe avec un coût de 12
    //

    function createEmploye( $login, $password, $poste, $nomEmploye, $prenomEmploye ){

        $connexion = getConnect();
        $resultat = $connexion -> query("SELECT login FROM Employe WHERE login='" . $login . "'");
        
        if ( $resultat != false && empty($resultat) == 0 ){

            $connexion -> query("INSERT INTO Employe(login,password,poste,nomEmploye,prenomEmploye,dateEmbauche) VALUES('" . $login . "', '" . password_hash($password, PASSWORD_DEFAULT, ['cost' => 12] ) . "', '" . $poste . "', '" . $nomEmploye . "', '" . $prenomEmploye . "', '" . date('Ymd') . "')");

            return true;

        }

        return false;

    }


    //
    // NV
    //
    // récupère les logins, noms, prenoms, postes de tout les employes
    // 

    function informationConnexionDirecteur() {
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT login, nomEmploye, prenomEmploye, poste FROM Employe"))->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }


    //
    // NV
    //
    // récupère le login, nom, prenom, poste de l'employe selectionné
    //

    function informationConnexionEmployeDirecteur( $employe = false ) {
        $connexion = getConnect();
        
        if ( $employe == false ) {
            $resultat = ($connexion -> query("SELECT login, nomEmploye, prenomEmploye, poste FROM Employe WHERE login='".$_POST['modifierLemploye']."'"))->fetch(PDO::FETCH_ASSOC);
        } else {
            $resultat = ($connexion -> query("SELECT login, nomEmploye, prenomEmploye, poste FROM Employe WHERE login='".$employe."'"))->fetch(PDO::FETCH_ASSOC);
        }

        return $resultat;
    }


    //
    // NV
    //
    // modifie les informations de l'employe selectionné
    //

    function modificationInformationEmployeDirecteur() {
        $connexion = getConnect();
        if ( isset($_POST['passwordCheckbox'])) {
            $connexion -> query("UPDATE employe SET login='".$_POST['loginCreation']."',password='".password_hash($_POST['passwordCreation'], PASSWORD_DEFAULT, ['cost' => 12] )."',poste='".$_POST['posteCreation']."',nomEmploye='".$_POST['nomCreation']."',prenomEmploye='".$_POST['prenomCreation']."' WHERE login='".$_SESSION['employeChoisiInformationLogin']."'");
        } else {
            $connexion -> query("UPDATE employe SET login='".$_POST['loginCreation']."',poste='".$_POST['posteCreation']."',nomEmploye='".$_POST['nomCreation']."',prenomEmploye='".$_POST['prenomCreation']."' WHERE login='".$_SESSION['employeChoisiInformationLogin']."'");
        }
    }


    //
    // NV
    //
    // vérifie si le login n'existe pas encore
    // false n'esxiste pas | true existe déjà
    //

    function loginCheckIfExistDirecteur() {
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT login FROM Employe WHERE login='".$_POST['loginCreation']."'"))->fetch(PDO::FETCH_ASSOC);
        if ( !empty($resultat) ) { return true; }
        return false;
    }

    ///COMPTE

    //
    // MP
    //
    // Retourne tout les type de compte existants
    //
    function getTypeCompteList(){
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT typeCompte FROM Compte"))->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }

    //
    // MP
    //
    // Retourne vrai si aucun client ne possede ce type de compte  
    // Retourne faux si qqn possede un compte de ce type
    //
    function VerificationPossessionTypeCompte($type){
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT idCompte FROM CompteClient WHERE typeCompte='".$type."'"))->fetchAll(PDO::FETCH_ASSOC);
        
        return empty($resultat);
    }

    //
    // MP
    //
    // Retourne vrai si le type de compte n'existe pas  
    // Retourne faux si le type de compte existe 
    //
    function VerificationExistanceTypeCompte($type){
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT typeCompte FROM Compte WHERE typeCompte='".$type."'"))->fetchAll(PDO::FETCH_ASSOC);
        
        return empty($resultat);
    }

    //
    // MP
    //
    // Ajoute le type aux types de compte  
    // 
    function ajouterLeTypeCompte($type){
        $connexion = getConnect();
        $connexion -> query("INSERT INTO Compte(typeCompte) VALUES('".$type."')");
    }

    //
    // MP
    //
    // Supprime le type des types de compte  
    // 
    function supprimerLeTypeCompte($type){
        $connexion = getConnect();
        $connexion -> query("DELETE FROM Compte WHERE typeCompte='".$type."'");
    }

    //
    // MP
    //
    // Retourne tout les motif ET les pieces existants
    //
    function getMotifPieceList(){
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT * FROM motif"))->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }


    ///CONTRAT


    //
    // MP
    //
    // Retourne tout les types de contrat existants
    //

    function getTypeContratList(){
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT typeContrat FROM Contrat"))->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }



    //
    // MP
    //
    // Retourne vrai si aucun client ne possede ce type de contrat 
    // Retourne faux si qqn possede un contrat de ce type
    //

    function VerificationPossessionTypeContrat($type){
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT idContrat FROM ContratClient WHERE typeContrat='".$type."'"))->fetchAll(PDO::FETCH_ASSOC);
        
        return empty($resultat);
    }


    //
    // MP
    //
    // Retourne vrai si le type de contrat n'existe pas  
    // Retourne faux si le type de contrat existe 
    //

    function VerificationExistanceTypeContrat($type){
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT typeContrat FROM Contrat WHERE typeContrat='".$type."'"))->fetchAll(PDO::FETCH_ASSOC);
        
        return empty($resultat);
    }


    //
    // MP
    //
    // Ajoute le type aux types de contrat 
    // 

    function ajouterLeTypeContrat($type){
        $connexion = getConnect();
        $connexion -> query("INSERT INTO Contrat(typeContrat) VALUES('".$type."')");
    }


    //
    // MP
    //
    // Supprime le type des types de contrat
    // 

    function supprimerLeTypeContrat($type){
        $connexion = getConnect();
        $connexion -> query("DELETE FROM Contrat WHERE typeContrat='".$type."'");
    }

    //
    // MP
    //
    // Ajoute le motif a la base de donné avec le libelle et les pieces inscrites
    //
    function ajoutMotif($motif,$piece){
        $connexion = getConnect();
        $connexion -> query("INSERT INTO motif(idMotif, libelleMotif, listePiece) VALUES(0,'".$motif."','".$piece."')");
    }

    //
    // NV
    //
    // compte le nombre de contrat entre 2 dates
    //

    function nombreContrat() {
        $connexion = getConnect();

        $query = "SELECT Count(*)'count' FROM contratClient WHERE dateVente <= '".$_POST['dateFinStatscontrats']."' AND dateVente >= '".$_POST['dateDebutStatscontrats']."'";

        $resultat = ($connexion -> query($query))->fetch(PDO::FETCH_ASSOC)['count'];

        return $resultat;
    }


    //
    // NV
    //
    // compte le nombre de comptes entre 2 dates
    //

    function nombreCompte() {
        $connexion = getConnect();

        $query = "SELECT Count(*)'count' FROM compteClient WHERE dateOuverture <= '".$_POST['dateFinStatscomptes']."' AND dateOuverture >= '".$_POST['dateDebutStatscomptes']."'";

        $resultat = ($connexion -> query($query))->fetch(PDO::FETCH_ASSOC)['count'];

        return $resultat;
    }


    //
    // NV
    //
    // compte le nombre de RDV entre 2 dates
    //

    function nombreRdv() {
        $connexion = getConnect();

        $query = "SELECT Count(*)'count' FROM rendezvous WHERE dateCreationRdv <= '".$_POST['dateFinStatsrdv']."' AND dateCreationRdv >= '".$_POST['dateDebutStatsrdv']."' AND idClient!='-1'";

        $resultat = ($connexion -> query($query))->fetch(PDO::FETCH_ASSOC)['count'];

        return $resultat;
    }


    //
    // NV
    //
    // compte le nombre de RDV entre 2 dates
    //

    function nombreClient() {
        $connexion = getConnect();

        $query = "SELECT Count(*)'count' FROM client WHERE dateInscription <= '".$_POST['dateStatsnbClient']."' AND idClient!='-1'";

        $resultat = ($connexion -> query($query))->fetch(PDO::FETCH_ASSOC)['count'];

        return $resultat;
    }


    //
    // NV
    //
    // compte le nombre de RDV entre 2 dates
    //

    //
    // SELECT solde - montant'resultat' FROM (SELECT SUM(solde)'solde' FROM compteClient)v1,(SELECT IFNULL(SUM(montant), 0)'montant' FROM operation WHERE operation.dateOperation > '2023-12-27')v2;
    //
    //
    // SELECT IFNULL(SUM(montant), 0)'resultat' FROM operation WHERE operation.dateOperation <= '".$_POST['dateStatssoldeTotal']."'
    //

    function soldeTotal() {
        $connexion = getConnect();

        $query = "SELECT IFNULL(SUM(montant), 0)'resultat' FROM operation WHERE operation.dateOperation <= '".$_POST['dateStatssoldeTotal']."'";

        $resultat = ($connexion -> query($query))->fetch(PDO::FETCH_ASSOC)['resultat'];

        return $resultat;
    }

    //
    // MP
    //
    // Get les information via l'id pour la modification des information (les montrer a l'utilisateur)
    //
    function getMotifViaId($id){
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT libelleMotif, listePiece FROM motif WHERE idMotif='".intval($id)."'"))->fetch(PDO::FETCH_ASSOC);
        return $resultat;
    }

    //
    // MP
    //
    // modif les information du client via l'id placé en session
    //
    function modifierMotifViaIdSession($libelle, $pieces){
        $connexion = getConnect();
        $connexion -> query("UPDATE motif SET libelleMotif='".$libelle."', listePiece='".$pieces."' WHERE idMotif='".$_SESSION['idMotif']."'");
        
    }

    //
    // MP
    //
    // Retourne vrai si aucun motif ne possede ce nom et que le champ nom est set   
    // Retourne faux si un motif existe deja avec ce nom ou s'il n'est pas rempli
    //

    function VerificationExistanceMotif($motif){
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT idMotif FROM motif WHERE libelleMotif='".$motif."'"))->fetch(PDO::FETCH_ASSOC);
        
        return !empty($motif) && (empty($resultat) || $resultat['idMotif'] == $_SESSION['idMotif']);
    }

    //
    // MP
    //
    //
    function VerificationMofificationTypeCompte($type){
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT typeCompte FROM compte WHERE typeCompte='".$type."'"))->fetch(PDO::FETCH_ASSOC);

        return !empty($type) && empty($resultat);
    }

    //
    // MP
    //
    //
    //
    function modifierTypeCompte($type){
        $connexion = getConnect();
        $connexion -> query("UPDATE compte SET typeCompte='".$type."' WHERE typeCompte='".$_SESSION['typeCompte']."'");
        
    }

    //
    // MP
    //
    //
    function VerificationMofificationTypeContrat($type){
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT typeContrat FROM contrat WHERE typeContrat='".$type."'"))->fetch(PDO::FETCH_ASSOC);

        return !empty($type) && empty($resultat);
    }

    //
    // MP
    //
    //
    //
    function modifierTypeContrat($type){
        $connexion = getConnect();
        $connexion -> query("UPDATE contrat SET typeContrat='".$type."' WHERE typeContrat='".$_SESSION['typeContrat']."'");
        
    }
    