<?php
    require_once("connect.php");

    function getConnect() {
        try {
            $connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connexion->query('SET NAMES UTF8');

            return $connexion;
        } catch ( Exception $e ){
            echo "<script>console.log('".var_dump($e)."')</script>";
        }
        

        
    }

    function formConnexion( $login, $password ){

        $connexion = getConnect();

        /*WHERE login='" . $login . "'*/
        $resultat = $connexion -> query("SELECT * FROM Employe WHERE login='" . $login . "'");
        $resultat = $resultat->fetch(PDO::FETCH_ASSOC);

        if ( $resultat != false ){

            //
            // password will be checked according to the hash given from the database
            //

            if ( password_verify($password, $resultat['password']) ) {

                return $resultat;

            }

        }

        return false;

    }

    function employeInformations( $login ){

        $connexion = getConnect();
        
        $resultat = ($connexion -> query("SELECT nomEmploye, prenomEmploye FROM Employe WHERE login='" . $login . "'"))->fetch(PDO::FETCH_ASSOC);

        return $resultat;

    }

    function createEmploye( $login, $password, $poste, $nomEmploye, $prenomEmploye ){

        $connexion = getConnect();
        $resultat = $connexion -> query("SELECT login FROM Employe WHERE login='" . $login . "'");
        
        if ( $resultat != false && empty($resultat) == 0 ){

            $connexion -> query("INSERT INTO Employe(login,password,poste,nomEmploye,prenomEmploye,dateEmbauche) VALUES('" . $login . "', '" . password_hash($password, PASSWORD_DEFAULT, ['cost' => 12] ) . "', '" . $poste . "', '" . $nomEmploye . "', '" . $prenomEmploye . "', '" . date('Ymd') . "')");

            return true;

        }

        return false;

    }


    function createClient($nomClient,$prenomClient,$dateNaissance) {

        $connexion = getConnect();

        $connexion -> query("INSERT INTO Client(nomClient, prenomClient, dateNaissance, estInscrit) VALUES('".$nomClient."', '".$prenomClient."' ,'".$dateNaissance."', 0)");

        $resultat = (($connexion -> query("SELECT idClient FROM Client WHERE idClient=(SELECT MAX(idClient) FROM Client)"))->fetch(PDO::FETCH_ASSOC))['idClient'];

        $connexion -> query("INSERT INTO CreerClient(idClient, login, dateCreation) VALUES('".$resultat."', '".$_SESSION['login']."' , CURRENT_DATE)");

        return $resultat;
    }


    function getAllConseillers() {

        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT login, nomEmploye, prenomEmploye FROM Employe WHERE poste='Conseiller'"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }

    // Recupere tout les compte du client enrengistrer dans la session
    function getAllComptes() { 

        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT idCompte, type, solde FROM Compte NATURAL JOIN PossedeCompte WHERE idClient='".$_SESSION['idClient']."'"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }

    // Recupere les infos du compte dont l'id est passé en paramètre 
    function getCompteViaId($compte) {
        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT type, solde FROM Compte WHERE idCompte='".$compte."'"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;

    }

    function rattacherClientAgent() {

        $connexion = getConnect();

        $connexion -> query("INSERT INTO RattacherA(idClient, login, dateRattachement) VALUES('".$_SESSION['idClient']."', '".$_POST['posteRattachement']."' ,CURRENT_DATE) ");

        return true;
    }


    function getClientByID($id){

        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT nomClient, prenomClient, dateNaissance FROM client WHERE idClient='".$id."'"))->fetch(PDO::FETCH_ASSOC);

        $resultat['idClient'] = $id;

        return $resultat;
    }


    function rechercherClientAgent($clientInformartionList) {

        $connexion = getConnect();


        if ( isset($clientInformartionList['ID']) ) {

            return getClientByID($clientInformartionList['ID']);

        }

        if ( !isset($clientInformartionList['nomClient']) && !isset($clientInformartionList['prenomClient']) && !isset($clientInformartionList['naissanceClient']) ) {
            return false;
        }

        $req = 'SELECT idClient, nomClient, prenomClient, dateNaissance, estInscrit, numeroTelephone, mail, adresse, codePostale, profession, situation, revenuMensuel FROM client WHERE';

        if ( isset($clientInformartionList['nomClient']) ) {
            $req .= " nomClient='".$clientInformartionList['nomClient']."'";
        }

        if ( isset($clientInformartionList['nomClient']) && isset($clientInformartionList['prenomClient']) ) {
            $req .= " AND ";
        }

        if ( isset($clientInformartionList['prenomClient']) ) {

            $req .= " prenomClient='".$clientInformartionList['prenomClient']."' ";

        }

        if ( (isset($clientInformartionList['nomClient']) || isset($clientInformartionList['prenomClient'])) && isset($clientInformartionList['naissanceClient']) ) {
            $req .= " AND ";
        }

        if ( isset($clientInformartionList['naissanceClient']) ) {

            $req .= " dateNaissance='".$clientInformartionList['naissanceClient']."' ";

        }

        $resultat = ($connexion -> query($req))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //Retire le montant inscrit en parametre du compte passé en session
    function retraitAgentClient($montantRetrait){
        $connexion = getConnect();

        $connexion -> query("UPDATE Compte SET solde = solde - ".$montantRetrait." WHERE idCompte='".$_SESSION['compteClient']."'");
    }

    //Depose le montant inscrit en parametre au compte passé en session
    function depotAgentClient($montantDepot){
        $connexion = getConnect();
        
        $connexion -> query("UPDATE Compte SET solde = solde + ".$montantDepot." WHERE idCompte='".$_SESSION['compteClient']."'");
    }

  

    function DataClient($idClient) {
            
        $connexion = getConnect();
    
            $query = "SELECT * FROM client WHERE idClient = '".$idClient;

            echo "<scrip>console.log(".var_dump($query).")</script>";
    
            // Exécution de la requête
            $resultat = ($connexion->query($query))->fetch(PDO::FETCH_ASSOC);

            echo "<scrip>console.log(".var_dump($resultat).")</script>";
    
            // Retourner les données du client
            return $resultat;
    }
    
    