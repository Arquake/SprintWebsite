<?php

    //
    // MP
    //
    // Retire le montant inscrit en parametre du compte passé en session
    //

    function retraitAgentClient($montantRetrait){
        $connexion = getConnect();

        $connexion -> query("UPDATE compteclient SET solde = solde - ".$montantRetrait." WHERE idCompte='".$_SESSION['idCompteClient']."'");
        
        $connexion -> query("INSERT INTO operation(idCompte, typeOperation, montant, dateOperation) VALUES ('".$_SESSION['idCompteClient']."','retrait','".-$montantRetrait."', CURRENT_DATE)");
    }


    //
    // MP
    //
    // Depose le montant inscrit en parametre au compte passé en session
    //
    
    function depotAgentClient($montantDepot){
        $connexion = getConnect();
        
        $connexion -> query("UPDATE compteclient SET solde = solde + ".$montantDepot." WHERE idCompte='".$_SESSION['idCompteClient']."'");

        $connexion -> query("INSERT INTO operation(idCompte, typeOperation, montant, dateOperation) VALUES ('".$_SESSION['idCompteClient']."','dépot','".$montantDepot."', CURRENT_DATE)");
    }


    //
    // NV
    //
    // créé le lien de rattachement Client / Conseiller
    //

    function rattacherClientAgent() {

        $connexion = getConnect();

        $connexion -> query("INSERT INTO RattacherA(idClient, login) VALUES('".$_SESSION['idClient']."', '".$_POST['posteRattachement']."') ");

        return true;
    }


    //
    // NV
    //
    // On crée un nouveau client
    //

    function createClient($nomClient,$prenomClient,$dateNaissance) {

        $connexion = getConnect();

        $connexion -> query("INSERT INTO Client(nomClient, prenomClient, dateNaissance, estInscrit) VALUES('".$nomClient."', '".$prenomClient."' ,'".$dateNaissance."', 0)");

        $resultat = (($connexion -> query("SELECT idClient FROM Client WHERE idClient=(SELECT MAX(idClient) FROM Client)"))->fetch(PDO::FETCH_ASSOC))['idClient'];

        return $resultat;
    }


    //
    // NV
    //
    // vérifie si le client est Inscrit
    //

    function clientInscritCheck() {
        $connexion = getConnect();

        $resultat = ($connexion->query("SELECT estInscrit FROM client WHERE idClient='".$_SESSION['idClient']."'"))->fetch(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // NV
    //
    // retourne true si l'employe existe
    //

    function getEmployeExist($idClient) {
        $connexion = getConnect();

        $resultat = ($connexion->query("SELECT login FROM RattacherA WHERE idClient='".$idClient."'"))->fetch(PDO::FETCH_ASSOC);

        if ( !empty( $resultat ) ) {
            $resultat=$resultat['login'];
        } else {
            return false;
        }

        $resultat = ($connexion->query("SELECT login FROM Employe WHERE login='".$resultat."'"))->fetch(PDO::FETCH_ASSOC);
        if ( !empty( $resultat ) ) {
            return true;
        } else {
            $connexion->query("DELETE FROM rattachera WHERE idClient='".$idClient."'");
            return false;
        }
    }