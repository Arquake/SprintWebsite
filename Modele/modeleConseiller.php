<?php


    //
    // NV
    //
    // inscription d'un client
    //

    function inscriptionClientConseiller() {
        $connexion = getConnect();

        $query = "UPDATE client SET 
        
        nomClient='".$_POST['nomClientInscription']."',
        prenomClient='".$_POST['prenomClientInscription']."',
        dateNaissance='".$_POST['dateNaissanceClientInscription']."',
        estInscrit='1',numeroTelephone='".$_POST['telephoneClientInscription']."',
        mail='".$_POST['mailClientInscription']."',adresse='".$_POST['adresseClientInscription']."',
        codePostale='".$_POST['codePostalClientInscription']."',
        profession='".$_POST['professionClientInscription']."',
        situation='".$_POST['situationClientInscription']."',
        dateInscription = CURRENT_DATE
        
        WHERE idClient='".$_SESSION['idClient']."'";

        $connexion->query($query);

    }


    //
    // NV
    //
    // récupère tout les types de compte
    //

    function getAllTypeCompte() {
        $connexion = getConnect();

        $resultat = ($connexion->query("SELECT * FROM compte"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // NV
    //
    // créé le compte en accordance avec les paramètres fourni et vérifié
    //

    function creerCompteConseiller() {
        $connexion = getConnect();

        $query = "INSERT INTO compteclient(idClient, dateOuverture, solde, interet, montantDecouvert, plafond, typeCompte) VALUES('".$_SESSION['idClient']."',CURRENT_DATE,'".$_POST['soldeInitial']."','".$_POST['interetCreation']."','".$_POST['decouvertCreation']."','".$_POST['plafondCreation']."','".$_POST['compteType']."')";

        $connexion->query($query);

        $res = ($connexion -> query("SELECT MAX(idCompte)'max' FROM compteclient")) -> fetch(PDO::FETCH_ASSOC)['max'];

        $res = $connexion -> query("INSERT INTO operation(idCompte, typeOperation, montant, dateOperation) VALUES ('".$res."','dépot','".$_POST['soldeInitial']."', CURRENT_DATE)");
    }


    //
    // NV
    //
    // récupère tout les types de contrats
    //

    function getAllTypeContrat() {
        $connexion = getConnect();

        $resultat = ($connexion->query("SELECT * FROM contrat"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // NV
    //
    // créé le compte en accordance avec les paramètres fourni et vérifié
    //

    function creerContratConseiller() {
        $connexion = getConnect();

        $query = "INSERT INTO contratclient(idClient, dateVente, tarifMensuel, typeContrat) VALUES ('".$_SESSION['idClient']."',CURRENT_DATE,'".$_POST['tarifCreation']."','".$_POST['contratType']."')";

        $connexion->query($query);
    }


    //
    // NV
    //
    // récupère tout les comptes du client
    //

    function getAllCompteClient() {
        $connexion = getConnect();

        $resultat = ($connexion->query("SELECT * FROM compteclient WHERE idClient='".$_SESSION['idClient']."'"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // NV
    //
    // récupère tout les contrats du client
    //

    function getAllContratClient() {
        $connexion = getConnect();

        $resultat = ($connexion->query("SELECT * FROM contratclient WHERE idClient='".$_SESSION['idClient']."'"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // NV
    //
    // modifie le découvert du compte choisi
    //

    function modifierDecouvert() {
        $connexion = getConnect();

        $resultat = $connexion->query("UPDATE compteclient SET montantDecouvert='".$_POST['decouvertModification']."' WHERE idCompte='".$_POST['listeComptes']."'");

        return $resultat;
    }


    //
    // NV
    //
    // récupère le solde du compte
    //

    function getSoldeClient() {
        $connexion = getConnect();

        $resultat = ($connexion->query("SELECT solde FROM compteclient WHERE idCompte='".$_POST['resiliationCompte']."'"))->fetch(PDO::FETCH_ASSOC)['solde'];

        return $resultat;
    }


    //
    // NV
    //
    // résilie le contrat selectionner
    //

    function resilierContrat() {
        $connexion = getConnect();

        $connexion->query("DELETE FROM contratclient WHERE idContrat='".$_POST['resiliationContrat']."'");
    }


    //
    // NV
    //
    // résilie le compte selectionner
    //

    function resilierCompte() {
        $connexion = getConnect();

        $connexion->query("DELETE FROM compteclient WHERE idCompte='".$_POST['resiliationCompte']."'");
    }


    //
    // NV
    //
    // récupère le client lié au rdv
    //

    function getclientByRDV() {
        $connexion = getConnect();

        $res = ($connexion->query("SELECT idClient FROM rendezvous WHERE idRDV='".$_POST['clientButtonResearch']."'"))->fetch(PDO::FETCH_ASSOC)['idClient'];

        return $res;
    }


    //
    // NV
    //
    // récupère tout les RDV liés au client
    //

    function getAllRdvOfClient() {
        $connexion = getConnect();

        $res = ($connexion->query("SELECT * FROM rendezvous WHERE idClient='".$_SESSION['idClient']."' ORDER BY jourReunion ASC, heureDebut ASC"))->fetchAll(PDO::FETCH_ASSOC);

        return $res;
    }


    //
    // NV
    //
    // récupère toutes les transactions d'un client
    //

    function getAllOperationsClient() {
        $connexion = getConnect();

        $query = "SELECT * FROM operation WHERE idCompte IN (SELECT idCompte FROM compteclient WHERE idClient='".$_SESSION['idClient']."') ORDER BY idOperation ASC";

        $res = ($connexion->query($query))->fetchAll(PDO::FETCH_ASSOC);

        return $res;
    }