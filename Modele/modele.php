<?php
    require_once("connect.php");


    //
    // Créé la connexion à la BDD
    //

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
    // On crée un nouveau client
    //

    function createClient($nomClient,$prenomClient,$dateNaissance) {

        $connexion = getConnect();

        $connexion -> query("INSERT INTO Client(nomClient, prenomClient, dateNaissance, estInscrit) VALUES('".$nomClient."', '".$prenomClient."' ,'".$dateNaissance."', 0)");

        $resultat = (($connexion -> query("SELECT idClient FROM Client WHERE idClient=(SELECT MAX(idClient) FROM Client)"))->fetch(PDO::FETCH_ASSOC))['idClient'];

        $connexion -> query("INSERT INTO CreerClient(idClient, login, dateCreation) VALUES('".$resultat."', '".$_SESSION['login']."' , CURRENT_DATE)");

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

        $resultat = ($connexion -> query("SELECT idCompte, type, solde FROM Compte NATURAL JOIN PossedeCompte WHERE idClient='".$_SESSION['idClient']."'"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }

    //
    // MP
    //
    // Recupere les infos du compte dont l'id est passé en paramètre 
    //

    function getTypeCompteViaId($idCompte) {
        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT type FROM Compte WHERE idCompte='".$idCompte."'"))->fetch(PDO::FETCH_ASSOC);

        return $resultat['type'];
    }


    //
    // MP
    //
    // Recupere le solde du compte dont l'$idCompte est passé en paramètre 
    //
    // -Renvoie un int correspondant au solde actuel du compte
    //

    function getSoldeCompteViaId($idCompte){
        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT solde FROM Compte where idCompte='".$idCompte."'"))->fetch(PDO::FETCH_ASSOC);

        return $resultat['solde'];
    }


    //
    // MP
    //
    // Récupere le plafond du $typeCompte passé en paramètre
    //
    // -Renvoie un int correspondant au plafond lié au type de compte
    //

    function getPlafondViaType($typeCompte){
        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT plafond FROM TypeCompte where typeCompte='".$typeCompte."'"))->fetch(PDO::FETCH_ASSOC);

        return $resultat['plafond'];
    }


    //
    // MP
    //
    // Recupere le decouvert du $typeCompte passé en paramètre
    //
    // -Renvoie un int correspondant au montant de decouvert lié au type de compte
    //

    function getDecouvertCompte($typeCompte){
        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT decouvert FROM TypeCompte where typeCompte='".$typeCompte."'"))->fetch(PDO::FETCH_ASSOC);

        return $resultat['decouvert'];
    }


    //
    // MP
    //
    // Recupere le decouvert personnel du client dont l'$idClient est passé en paramètre 
    //
    // -Renvoie un int correspondant au montant de decouvert du client
    //

    function getDecouvertClient($idClient){
        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT montantDecouvert FROM Client where idClient='".$idClient."'"))->fetch(PDO::FETCH_ASSOC);

        return $resultat['montantDecouvert'];
    }


    //
    // MP
    //
    // Gere si le type du compte séléctionné à un decouvert : 
    //  si oui prendre celui-ci pour limité les actions liés au solde
    //  sinon prendre celui du client
    // 
    // -Renvoie un int correspondant au montant de decouvert 
    //

    function getDecouvert(){
        $decouvertCompte = intval(getDecouvertCompte($_SESSION['typeCompteClient']));
       
        if ( $decouvertCompte != Null ){
            return $decouvertCompte;
        } else {
            return getDecouvertClient($_SESSION['idClient']);
        }
    }


    //
    // NV
    //
    // créé le lien de rattachement Client / Conseiller
    //

    function rattacherClientAgent() {

        $connexion = getConnect();

        $connexion -> query("INSERT INTO RattacherA(idClient, login, dateRattachement) VALUES('".$_SESSION['idClient']."', '".$_POST['posteRattachement']."' ,CURRENT_DATE) ");

        return true;
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
    // MP
    //
    // Retire le montant inscrit en parametre du compte passé en session
    //

    function retraitAgentClient($montantRetrait){
        $connexion = getConnect();

        $connexion -> query("UPDATE Compte SET solde = solde - ".$montantRetrait." WHERE idCompte='".$_SESSION['idCompteClient']."'");
    }


    //
    // MP
    //
    // Depose le montant inscrit en parametre au compte passé en session
    //
    
    function depotAgentClient($montantDepot){
        $connexion = getConnect();
        
        $connexion -> query("UPDATE Compte SET solde = solde + ".$montantDepot." WHERE idCompte='".$_SESSION['idCompteClient']."'");
    }

    
    //
    // G
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

        $connexion = getConnect();
    
        $query = "SELECT login FROM rattachera WHERE idClient = '".$idClient."'";

        $resultat = ($connexion->query($query))->fetch(PDO::FETCH_ASSOC)['login'];

        return $resultat;
    }


    //
    // NV
    //
    // Renvoi les type de motifs
    //
    
    function getMotifsType() {

        $connexion = getConnect();

        $resultat = ($connexion->query("SELECT * FROM type"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // NV
    //
    // créé un rdv
    //

    function createRDVAgent() {
        $connexion = getConnect();

        $connexion->query("INSERT INTO rendezvous(jourReunion, heureDebut, heureFin, dateCreationRdv, login, idClient, Motif) VALUES ('".$_POST['date']."','".$_POST['heureDebut']."','".$_POST['heureFin']."',CURRENT_DATE,'".getConseillerRattacherAuClient($_SESSION['idClient'])."','".$_SESSION['idClient']."','".$_POST['motifRDV']."')");
    }


    //
    // NV
    //
    // Vérifie si un autre rendez-vous ne risque pas de chevaucher
    //

    function checkRDVCreation() {
        $connexion = getConnect();

        $query = "SELECT idRdv FROM rendezvous WHERE (jourReunion = '".$_POST['date']."') AND ((CAST('".$_POST['heureDebut'].":00' AS time) >= heureDebut AND CAST('".$_POST['heureDebut'].":00' AS time) < heureFin) OR (CAST('".$_POST['heureFin'].":00' AS time) > heureDebut AND CAST('".$_POST['heureFin'].":00' AS time) <= heureFin))";
        
        $resultat = ($connexion->query($query))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // NV
    //
    // Supprime le RDV
    //

    function deleteRDVAgent() {
        $connexion = getConnect();

        $connexion->query("DELETE FROM rendezvous WHERE idRDV=".$_POST['rdvDel']); 
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
            $query = "SELECT idRdv, idClient, heureDebut, heureFin, Motif FROM rendezvous WHERE jourReunion = CAST('".$date->format("Y-m-d")."' AS date) AND login='".$_SESSION['conseillerRattacherClient']."'";

            $weekArr[$i] = ($connexion->query($query))->fetchAll(PDO::FETCH_ASSOC);

            $date->modify('+1 days');
        }

        return $weekArr;
    }