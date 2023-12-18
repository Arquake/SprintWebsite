<?php

    //
    // MP
    //
    // Retire le montant inscrit en parametre du compte passé en session
    //

    function retraitAgentClient($montantRetrait){
        $connexion = getConnect();

        $connexion -> query("UPDATE compteclient SET solde = solde - ".$montantRetrait." WHERE idCompte='".$_SESSION['idCompteClient']."'");
    }


    //
    // MP
    //
    // Depose le montant inscrit en parametre au compte passé en session
    //
    
    function depotAgentClient($montantDepot){
        $connexion = getConnect();
        
        $connexion -> query("UPDATE compteclient SET solde = solde + ".$montantDepot." WHERE idCompte='".$_SESSION['idCompteClient']."'");
    }


    //
    // NV
    //
    // créé un rdv
    //

    function createRDVAgent() {
        $connexion = getConnect();

        $connexion->query("INSERT INTO rendezvous(jourReunion, heureDebut, heureFin, dateCreationRdv, login, idClient, idMotif) VALUES ('".$_POST['date']."','".$_POST['heureDebut']."','".$_POST['heureFin']."',CURRENT_DATE,'".getConseillerRattacherAuClient($_SESSION['idClient'])."','".$_SESSION['idClient']."','".$_POST['motifRDV']."')");
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

        $resultat = ($connexion->query("SELECT estInscrit FROM client WHERE idClient='".$_SESSION['idClient']."'"))->fetch(PDO::FETCH_ASSOC)['estInscrit'];

        return $resultat;
    }