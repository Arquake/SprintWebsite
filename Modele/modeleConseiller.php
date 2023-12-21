<?php


    //
    // NV
    //
    // inscription d'un client
    //

    function inscriptionClientConseiller() {
        $connexion = getConnect();

        $query = "UPDATE client SET nomClient='".$_POST['nomClientInscription']."',prenomClient='".$_POST['prenomClientInscription']."',dateNaissance='".$_POST['dateNaissanceClientInscription']."',estInscrit='1',numeroTelephone='".$_POST['telephoneClientInscription']."',mail='".$_POST['mailClientInscription']."',adresse='".$_POST['adresseClientInscription']."',codePostale='".$_POST['codePostalClientInscription']."',profession='".$_POST['professionClientInscription']."',situation='".$_POST['situationClientInscription']."' WHERE idClient='".$_SESSION['idClient']."'";

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
    }