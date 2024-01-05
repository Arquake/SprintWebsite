<?php

    //
    // NV
    //
    // on vérifie si le login n'existe pas déjà
    // Si il n'existe pas on créé l'employé en chiffrant le mot de passe avec un coût de 12
    //

    function createEmploye( $login, $password, $poste, $nomEmploye, $prenomEmploye ){

        $connexion = getConnect();

        $query = "SELECT login FROM Employe WHERE login=:login";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':login', $login, PDO::PARAM_STR);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);
        
        if ( $prepare != false && empty($prepare) == 0 ){

            $query = "INSERT INTO Employe(login,password,poste,nomEmploye,prenomEmploye,dateEmbauche) VALUES(:login, :password, :poste, :nom, :prenom, '" . date('Ymd') . "')";

            $prepare = $connexion->prepare($query);

            $prepare->bindValue(':login', $login, PDO::PARAM_STR);
            $prepare->bindValue(':password', password_hash($password, PASSWORD_DEFAULT, ['cost' => 12] ), PDO::PARAM_STR);
            $prepare->bindValue(':poste', $poste, PDO::PARAM_STR);
            $prepare->bindValue(':nom', $nomEmploye, PDO::PARAM_STR);
            $prepare->bindValue(':prenom', $prenomEmploye, PDO::PARAM_STR);

            $prepare -> execute();

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
            $employe = $_POST['modifierLemploye'];
        }

        $query = "SELECT login, nomEmploye, prenomEmploye, poste FROM Employe WHERE login=:login";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':login', $employe, PDO::PARAM_STR);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);

        return $prepare -> fetch(PDO::FETCH_ASSOC);
    }


    //
    // NV
    //
    // modifie les informations de l'employe selectionné
    //

    function modificationInformationEmployeDirecteur() {
        $connexion = getConnect();
        if ( isset($_POST['passwordCheckbox'])) {
            $query = "UPDATE employe SET login=:login,password='".password_hash($_POST['passwordCreation'], PASSWORD_DEFAULT, ['cost' => 12] )."',poste=:poste,nomEmploye=:nom,prenomEmploye=:prenom WHERE login=:loginSec";
        } else {
            $query = "UPDATE employe SET login=:login,poste=:poste,nomEmploye=:nom,prenomEmploye=:prenom WHERE login=:loginSec";
        }

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':login', $_POST['loginCreation'], PDO::PARAM_STR);
        $prepare->bindValue(':poste', $_POST['posteCreation'], PDO::PARAM_STR);
        $prepare->bindValue(':nom', $_POST['nomCreation'], PDO::PARAM_STR);
        $prepare->bindValue(':prenom', $_POST['loginCreation'], PDO::PARAM_STR);
        $prepare->bindValue(':loginSec', $_SESSION['employeChoisiInformationLogin'], PDO::PARAM_STR);

        $prepare -> execute();
    }


    //
    // NV
    //
    // vérifie si le login n'existe pas encore
    // false n'esxiste pas | true existe déjà
    //

    function loginCheckIfExistDirecteur() {
        $connexion = getConnect();

        $query = "SELECT login FROM Employe WHERE login=:login";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':login', $_POST['loginCreation'], PDO::PARAM_STR);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);

        if ( !empty($prepare -> fetch(PDO::FETCH_ASSOC)) ) { return true; }
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

        $query = "SELECT idCompte FROM CompteClient WHERE typeCompte=:type";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':type', $type, PDO::PARAM_STR);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);
        
        return empty($prepare -> fetchAll(PDO::FETCH_ASSOC));
    }


    //
    // MP
    //
    // Retourne vrai si le type de compte n'existe pas  
    // Retourne faux si le type de compte existe 
    //

    function VerificationExistanceTypeCompte($type){
        $connexion = getConnect();
        
        $query = "SELECT typeCompte FROM Compte WHERE typeCompte=:type";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':type', $type, PDO::PARAM_STR);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);
        
        return empty($prepare -> fetchAll(PDO::FETCH_ASSOC));
    }


    //
    // MP
    //
    // Ajoute le type aux types de compte  
    // 

    function ajouterLeTypeCompte($type){
        $connexion = getConnect();

        $query = "INSERT INTO Compte(typeCompte) VALUES(:type)";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':type', $type, PDO::PARAM_STR);

        $prepare -> execute();
    }


    //
    // MP
    //
    // Supprime le type des types de compte  
    // 

    function supprimerLeTypeCompte($type){
        $connexion = getConnect();

        $query = "DELETE FROM Compte WHERE typeCompte=':type";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':type', $type, PDO::PARAM_STR);

        $prepare -> execute();
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
        
        $query = "SELECT idContrat FROM ContratClient WHERE typeContrat='".$type."'";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':type', $type, PDO::PARAM_STR);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);
        
        return empty($prepare -> fetchAll(PDO::FETCH_ASSOC));
    }


    //
    // MP
    //
    // Retourne vrai si le type de contrat n'existe pas  
    // Retourne faux si le type de contrat existe 
    //

    function VerificationExistanceTypeContrat($type){
        $connexion = getConnect();
        
        $connexion = getConnect();
        
        $query = "SELECT typeContrat FROM Contrat WHERE typeContrat=:type";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':type', $type, PDO::PARAM_STR);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);
        
        return empty($prepare -> fetchAll(PDO::FETCH_ASSOC));
    }


    //
    // MP
    //
    // Ajoute le type aux types de contrat 
    // 

    function ajouterLeTypeContrat($type){
        $connexion = getConnect();

        $query = "INSERT INTO Contrat(typeContrat) VALUES(:type)";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':type', $type, PDO::PARAM_STR);

        $prepare -> execute();
    }


    //
    // MP
    //
    // Supprime le type des types de contrat
    // 

    function supprimerLeTypeContrat($type){
        $connexion = getConnect();

        $query = "DELETE FROM Contrat WHERE typeContrat=:type";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':type', $type, PDO::PARAM_STR);

        $prepare -> execute();
    }


    //
    // MP
    //
    // Ajoute le motif a la base de donné avec le libelle et les pieces inscrites
    //
    function ajoutMotif($motif,$piece){
        $connexion = getConnect();

        $query = "INSERT INTO motif(idMotif, libelleMotif, listePiece) VALUES(0, :motif, :piece)";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':motif', $motif, PDO::PARAM_STR);
        $prepare->bindValue(':piece', $piece, PDO::PARAM_STR);

        $prepare -> execute();
    }


    //
    // NV
    //
    // compte le nombre de contrat entre 2 dates
    //

    function nombreContrat() {
        $connexion = getConnect();

        $query = "SELECT Count(*)'count' FROM contratClient WHERE dateVente <= :fin AND dateVente >= :deb";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':fin', $_POST['dateFinStatscontrats'], PDO::PARAM_STR);
        $prepare->bindValue(':deb', $_POST['dateDebutStatscontrats'], PDO::PARAM_STR);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);

        return $prepare->fetch(PDO::FETCH_ASSOC)['count'];
    }


    //
    // NV
    //
    // compte le nombre de comptes entre 2 dates
    //

    function nombreCompte() {
        $connexion = getConnect();

        $query = "SELECT Count(*)'count' FROM compteClient WHERE dateOuverture <= :fin AND dateOuverture >= :deb";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':fin', $_POST['dateFinStatscomptes'], PDO::PARAM_STR);
        $prepare->bindValue(':deb', $_POST['dateDebutStatscomptes'], PDO::PARAM_STR);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);

        return $prepare->fetch(PDO::FETCH_ASSOC)['count'];
    }


    //
    // NV
    //
    // compte le nombre de RDV entre 2 dates
    //

    function nombreRdv() {
        $connexion = getConnect();

        $query = "SELECT Count(*)'count' FROM rendezvous WHERE dateCreationRdv <= :fin AND dateCreationRdv >= :deb AND idClient!='-1'";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':fin', $_POST['dateFinStatsrdv'], PDO::PARAM_STR);
        $prepare->bindValue(':deb', $_POST['dateDebutStatsrdv'], PDO::PARAM_STR);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);

        return $prepare->fetch(PDO::FETCH_ASSOC)['count'];
    }


    //
    // NV
    //
    // compte le nombre de client inscrit à la date
    //

    function nombreClient() {
        $connexion = getConnect();

        $query = "SELECT Count(*)'count' FROM client WHERE dateInscription <= :date AND idClient!='-1'";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':date', $_POST['dateStatsnbClient'], PDO::PARAM_STR);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);

        return $prepare->fetch(PDO::FETCH_ASSOC)['count'];
    }


    //
    // NV
    //
    // compte le solde total dans la banque à la date
    //

    function soldeTotal() {
        $connexion = getConnect();

        $query = "SELECT IFNULL(SUM(montant), 0)'resultat' FROM operation WHERE operation.dateOperation <= :solde";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':solde', $_POST['dateStatssoldeTotal'], PDO::PARAM_STR);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);

        return $prepare->fetch(PDO::FETCH_ASSOC)['resultat'];
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
    