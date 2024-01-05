<?php

    //
    // MP
    //
    // Retire le montant inscrit en parametre du compte passé en session
    //

    function retraitAgentClient($montantRetrait){
        $connexion = getConnect();

        $query = "
        UPDATE compteclient SET solde = solde - :montantRetraitSolde WHERE idCompte=:idCompte;

        INSERT INTO operation(idCompte, typeOperation, montant, dateOperation) VALUES ( :idCompte, 'retrait', :montantRetrait, CURRENT_DATE )";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':montantRetraitSolde', $montantRetrait, PDO::PARAM_INT);
        $prepare->bindValue(':idCompte', $_SESSION['idCompteClient'], PDO::PARAM_INT);
        $prepare->bindValue(':montantRetrait', -$montantRetrait, PDO::PARAM_INT);

        $prepare -> execute();
    }


    //
    // MP
    //
    // Depose le montant inscrit en parametre au compte passé en session
    //
    
    function depotAgentClient($montantDepot){
        $connexion = getConnect();

        $query = "
        UPDATE compteclient SET solde = solde + :montantDepot WHERE idCompte=:idCompte;
        
        INSERT INTO operation(idCompte, typeOperation, montant, dateOperation) VALUES ( :idCompte, 'dépot', :montantDepot, CURRENT_DATE )";
        
        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':montantDepot', $montantDepot, PDO::PARAM_INT);
        $prepare->bindValue(':idCompte', $_SESSION['idCompteClient'], PDO::PARAM_INT);

        $prepare -> execute();
    }


    //
    // NV
    //
    // créé le lien de rattachement Client / Conseiller
    //

    function rattacherClientAgent() {

        $connexion = getConnect();

        $query = "INSERT INTO RattacherA(idClient, login) VALUES(:idClient, :poste) ";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':idClient', $_SESSION['idClient'], PDO::PARAM_INT);
        $prepare->bindValue(':poste', $_POST['posteRattachement'], PDO::PARAM_STR);

        $prepare -> execute();
    }


    //
    // NV
    //
    // On crée un nouveau client
    //

    function createClient($nomClient,$prenomClient,$dateNaissance) {

        $connexion = getConnect();

        $query = "INSERT INTO Client(nomClient, prenomClient, dateNaissance, estInscrit) VALUES(:nomClient, :prenomClient ,:naissance , 0)";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':nomClient', $nomClient, PDO::PARAM_STR);
        $prepare->bindValue(':prenomClient', $prenomClient, PDO::PARAM_STR);
        $prepare->bindValue(':naissance', $dateNaissance, PDO::PARAM_STR);

        $prepare -> execute();

        return ($connexion->query("SELECT idClient FROM Client WHERE idClient=(SELECT MAX(idClient) FROM Client)"))->fetch(PDO::FETCH_ASSOC)['idClient'];
    }


    //
    // NV
    //
    // retourne true si l'employe existe
    //

    function getEmployeExist($idClient) {
        $connexion = getConnect();

        $query = "SELECT login FROM RattacherA WHERE idClient=:idClient";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':idClient', $idClient, PDO::PARAM_INT);

        $prepare -> execute();

        $prepare->setFetchMode(PDO::FETCH_ASSOC);

        $resultat = $prepare->fetch(PDO::FETCH_ASSOC);

        if ( !empty( $resultat ) ) {
            $resultat=$resultat['login'];
        } else {
            return false;
        }

        $query = "SELECT login FROM Employe WHERE login=:login";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':login', $resultat, PDO::PARAM_STR);

        $prepare -> execute();

        $prepare->setFetchMode(PDO::FETCH_ASSOC);

        $resultat = $prepare->fetch(PDO::FETCH_ASSOC);

        if ( !empty( $resultat ) ) {

            return true;

        } else {

            $query = "DELETE FROM rattachera WHERE idClient=:idClient";

            $prepare = $connexion->prepare($query);

            $prepare->bindValue(':idClient', $idClient, PDO::PARAM_INT);

            $prepare -> execute();

            return false;
        }
    }