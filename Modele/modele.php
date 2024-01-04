<?php
    require_once("connect.php");
    require_once("Modele/modeleAgent.php");
    require_once("Modele/modeleDirecteur.php");
    require_once("Modele/modeleConseiller.php");


    //
    // Créé la connexion à la BDD
    //

    function getConnect() {
        try {
            $connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            $connexion->query('SET NAMES UTF8');

            return $connexion;
        } catch ( Exception $e ){
            throw new Exception('Erreur lors de la connexion à la base de données');
        }
    }


    //
    // NV
    //
    // On récupère toutes les infos de l'employe
    // si il esxiste on utilise la méthode de vérification de mot de passe pour le comparé à celui donné
    // si ils correspondent on retourne les informations récupérés
    //

    function formConnexion( $login, $password ){

        $connexion = getConnect();

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


    //
    // NV
    //
    // On récupère le nom et prénom de l'Employe
    //

    function employeInformations( $login ){

        $connexion = getConnect();
        
        $resultat = ($connexion -> query("SELECT nomEmploye, prenomEmploye FROM Employe WHERE login='" . $login . "'"))->fetch(PDO::FETCH_ASSOC);

        return $resultat;

    }


    //
    // NV
    //
    // récupère la liste de tout les conseillers
    //

    function getAllConseillers() {

        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT login, nomEmploye, prenomEmploye FROM Employe WHERE poste='Conseiller'"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // MP
    //
    // Recupere tout les compte du client enrengistrer dans la session
    //
    function getAllComptes() { 

        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT idCompte, typeCompte, solde FROM compteclient WHERE idClient='".$_SESSION['idClient']."'"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }

    //
    // MP
    //
    // Recupere les infos du compte dont l'id est passé en paramètre 
    //

    function getCompteViaId($idCompte) {
        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT typeCompte, solde, plafond, montantDecouvert FROM CompteClient WHERE idCompte='".$idCompte."'"))->fetch(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // MP - NV
    //
    // Modifie les informations du client en session avec celle fournie
    //

    function editInformationClient(){
        $connexion = getConnect();

        $connexion->query("UPDATE Client SET nomClient = '".$_POST['nomClientModification']."', prenomClient = '".$_POST['prenomClientModification']."', dateNaissance = '".$_POST['dateNaissanceClientModification']."' WHERE idClient='".$_SESSION['idClient']."'");
    }


    //
    // NV
    //
    // Recupere les infos du client selon l'id 
    //

    function getClientByID($id){

        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT * FROM client WHERE idClient='".$id."'"))->fetch(PDO::FETCH_ASSOC);

        $resultat['idClient'] = $id;

        return $resultat;
    }


    //
    // NV
    //
    // Recherche le client selon les infos donnés en paramètre
    //
    // si l'id est donné il sera rentourné
    //
    // si l'id n'est pas donné il retournera la liste les clients avec leurs informations qui ont les mêmes caractéristiques
    //

    function rechercherClient($clientInformartionList) {

        $connexion = getConnect();


        if ( isset($clientInformartionList['ID']) ) {

            return getClientByID($clientInformartionList['ID']);

        }

        if ( !isset($clientInformartionList['nomClient']) && !isset($clientInformartionList['prenomClient']) && !isset($clientInformartionList['naissanceClient']) ) {
            return false;
        }

        $req = 'SELECT * FROM client WHERE';

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

    
    //
    // NV
    //
    // Recupere les infos du client selon l'id client de la session
    //

    function DataClient() {
            
        $connexion = getConnect();
    
        $query = "SELECT * FROM client WHERE idClient = '".$_SESSION['idClient']."'";

        // Exécution de la requête
        $resultat = ($connexion->query($query))->fetch(PDO::FETCH_ASSOC);

        // Retourner les données du client
        return $resultat;
    }


    //
    // NV
    //
    // Renvoi le login de l'agent rattacher au client
    //
    
    function getConseillerRattacherAuClient($idClient) {

        if ( $idClient == -1 ) {
            return $_SESSION['login'];
        }

        $connexion = getConnect();
    
        $query = "SELECT login FROM rattachera WHERE idClient = '".$idClient."'";

        $resultat = ($connexion->query($query))->fetch(PDO::FETCH_ASSOC)['login'];

        return $resultat;
    }


    //
    // NV
    //
    // créé un rdv
    //

    function createRDV() {
        $connexion = getConnect();

        $connexion->query("INSERT INTO rendezvous(jourReunion, heureDebut, heureFin, dateCreationRdv, login, idClient, idMotif) VALUES ('".$_POST['date']."','".$_POST['heureDebut']."','".$_POST['heureFin']."',CURRENT_DATE,'".getConseillerRattacherAuClient($_SESSION['idClient'])."','".$_SESSION['idClient']."','".$_POST['motifRDV']."')");
    }


    //
    // NV
    //
    // Renvoi les type de motifs
    //
    
    function getMotifsType() {

        $connexion = getConnect();

        $resultat = ($connexion->query("SELECT * FROM Motif"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // NV
    //
    // Vérifie si un autre rendez-vous ne risque pas de chevaucher
    //

    function checkRDVCreation() {
        $connexion = getConnect();

        $query = "SELECT idRdv FROM rendezvous WHERE (jourReunion = '".$_POST['date']."') AND ((CAST('".$_POST['heureDebut'].":00' AS time) >= heureDebut AND CAST('".$_POST['heureDebut'].":00' AS time) < heureFin) OR (CAST('".$_POST['heureFin'].":00' AS time) > heureDebut AND CAST('".$_POST['heureFin'].":00' AS time) <= heureFin)) AND login='".$_SESSION['conseillerRattacherClient']."'";

        $resultat = ($connexion->query($query))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // NV
    //
    // retourne tout les rdv de la semaine du conseiller
    //

    function getEDTConseillerByDate(){
        $connexion = getConnect();

        $ddate = date("y-m-d",strtotime("this week"));
        $date = new DateTime($ddate);
        
        if ( isset($_POST['weekMinusOne']) ) {
            $_SESSION['$week'] -= 1;
        } else if ( isset($_POST['weekAddOne']) ) {
            $_SESSION['$week'] += 1;
        } else {
            $_SESSION['$week'] = 0;
        }

        $date->modify('+'.($_SESSION['$week']*7).' days');

        $weekArr = [];

        for ( $i=0 ; $i < 7 ; $i++) {
            $query = "SELECT idRdv, idClient, heureDebut, heureFin, idMotif FROM rendezvous WHERE jourReunion = CAST('".$date->format("Y-m-d")."' AS date) AND login='".$_SESSION['conseillerRattacherClient']."' ORDER BY heureDebut ASC";

            $weekArr[$i] = ($connexion->query($query))->fetchAll(PDO::FETCH_ASSOC);

            $date->modify('+1 days');
        }

        return $weekArr;
    }


    //
    // NV
    //
    // récupère toutes les infos du motif
    //

    function getMotifsAll() {
        $connexion = getConnect();

        $resultat = ($connexion->query("SELECT * FROM Motif WHERE idMotif='".$_POST['motifRDV']."'"))->fetch(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // NV
    //
    // Supprime le RDV
    //

    function deleteRDV() {
        $connexion = getConnect();

        $connexion->query("DELETE FROM rendezvous WHERE idRDV=".$_POST['rdvDel']); 
    }


    //
    // NV
    //
    // Récupère l'id client du rdv
    //

    function rdvToIdClient() {
        $connexion = getConnect();

        return ($connexion->query("SELECT idClient FROM rendezvous WHERE idRDV='".$_POST['rdvDel']."' "))->fetch(PDO::FETCH_ASSOC); 
    }