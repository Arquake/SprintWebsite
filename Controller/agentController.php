<?php

    //
    // NV
    //
    // Charge la page d'accueil de l'agent
    //

    function CtlAgentHomePage() {
        accueilAgent();
    }


    //
    // NV
    //
    // Charge la page de recher client de l'agent
    //

    function CtlAgentResearchClient() {

        CtlClientDisconnect();

        rechercheClientAgentView();

    }


    //
    // NV
    //
    // Recherche le client selon les critères donnés
    // sur la page de recherche client des Agents
    //

    function CtlAgentResearchClientSubmitted() {

        $clientInfo = array ();

        if ( $_POST['idClientRecherche'] != '' ) {
            $clientInfo['ID'] = $_POST['idClientRecherche'];
        }
        
        if ( $_POST['nomClientRecherche'] != '' ) {
            $clientInfo['nomClient'] = $_POST['nomClientRecherche'];
        }

        if ( $_POST['prenomClientRecherche'] != '') {
            $clientInfo['prenomClient'] = $_POST['prenomClientRecherche'];
        }

        if ( $_POST['dateNaissanceClientRecherche'] != '') {
            $clientInfo['naissanceClient'] = $_POST['dateNaissanceClientRecherche'];
        }

        $res = rechercherClient($clientInfo);

        if ($res != false ) {
            if ( isset($res['idClient']) && isset($res['nomClient']) ) {

                $_SESSION['clientNom'] = $res['nomClient'];
                $_SESSION['clientPrenom'] = $res['prenomClient'];
                $_SESSION['clientNaissance'] = $res['dateNaissance'];
                $_SESSION['idClient'] = $res['idClient'];

                accueilAgent();
            } else if ( isset($res[1]) ) {
                rechercheApprofondiClientAgent($res);
            } else if ( isset($res[0]['nomClient']) ) {
                $_SESSION['clientNom'] = $res[0]['nomClient'];
                $_SESSION['clientPrenom'] = $res[0]['prenomClient'];
                $_SESSION['clientNaissance'] = $res[0]['dateNaissance'];
                $_SESSION['idClient'] = $res[0]['idClient'];

                accueilAgent();
            } else {
                rechercheClientAgentView(false);
            }

        } else {
            rechercheClientAgentView(false);
        }
    
    }


    //
    // NV
    //
    // Recherche appronfondi des client si plusieurs
    // sont trouvés avec les mêmes critères
    //

    function CtlAgentResearchClientChoices() {

        $res = getClientByID($_POST['clientRechercheChoice']);

        $_SESSION['clientNom'] = $res['nomClient'];
        $_SESSION['clientPrenom'] = $res['prenomClient'];
        $_SESSION['clientNaissance'] = $res['dateNaissance'];
        $_SESSION['idClient'] = $_POST['clientRechercheChoice'];



        accueilAgent();
    }


    //
    // NV
    //
    // charge la page de création client
    //

    function CtlAgentCreateationClient(){
        creationClientAgent();
    }


    //
    // NV
    //
    // Creation de client par un agent
    // Renvoi sur la page de rattachement du client à un conseiller
    //

    function CtlAgentCreateClient() {

        if ( $_POST['nomClientCreation'] =='' || $_POST['prenomClientCreation'] =='' || $_POST['dateNaissanceClientCreation'] =='' ) {
            creationClientAgent(false);
        } else {

            $idClient = createClient($_POST['nomClientCreation'], $_POST['prenomClientCreation'], $_POST['dateNaissanceClientCreation']);

            $_SESSION['clientNom'] = $_POST['nomClientCreation'];
            $_SESSION['clientPrenom'] = $_POST['prenomClientCreation'];
            $_SESSION['clientNaissance'] = $_POST['dateNaissanceClientCreation'];
            $_SESSION['idClient'] = $idClient;

            $conseillersList = getAllConseillers();

            

            rattacherClient($conseillersList);

        }

    }


    //
    // NV
    //
    // rattachement d'un client au conseiller selectionné
    // charge la page d'accueil de l'agent connecté au client créé
    //

    function CtlRattacherClient() {

        $_SESSION['conseillerRattacherClient'] = $_POST['posteRattachement'];

        rattacherClientAgent();
        accueilAgent();
    }


    //
    // NV
    //
    // déconnecte le client et affiche la page d'accueil de l'agent
    //

    function CtlClientDisconnect() {
        unset($_SESSION['clientNom']);
        unset($_SESSION['clientPrenom']);
        unset($_SESSION['clientNaissance']);
        unset($_SESSION['idClient']);
    }


    //
    // MP
    //
    // Lance de quoi afficher la liste des comptes du client en session
    //

    function CtlAgentTransactionClientChoice(){
        $compteList = getAllComptes();
        if ( empty($compteList) ) {
            errorTransactionNoAccountFound();
        } else {
            transactionChoixClientAgentView($compteList);
        }
    }

    //
    // MP
    //
    //Lance de quoi afficher les choix pour retirer/deposer sur le compte
    //

    function CtlAgentTransactionClient(){
        $_SESSION['idCompteClient'] = $_POST['compteSelection'];
        $res = getCompteViaId($_SESSION['idCompteClient']);
        echo "<script>console.log('".var_dump($res)."')</script>";
        $_SESSION['typeCompteClient'] = $res['typeCompte'];
        $_SESSION['soldeCompteClient'] = $res['solde'];
        $_SESSION['plafondCompteClient'] = $res['plafond'];
        $_SESSION['decouvertCompteClient'] = $res['montantDecouvert'];

        if ($_POST['radioTransaction'] == "retrait") {
            transactionRetraitClientAgentView();
        }
        else if ($_POST['radioTransaction'] == "depot") {
            transactionDepotClientAgentView();
        }
    }

    //
    // MP
    //
    // Lance de quoi retirer l'argent voulu sur le compte en session et retourne a l'acceuil
    //
    
    function CtlAgentOutPutTransactionDepotCompteClient(){
        $soldeActuel = $_SESSION['soldeCompteClient'];
        $plafond = $_SESSION['plafondCompteClient'];

        if (isset($_POST['depot']) && (intval($_POST['depot'] > 0))) {
            if ( $soldeActuel + $_POST['depot'] <= $plafond || $plafond == 0 ) {
                depotAgentClient($_POST['depot']);
            } else{
                echo '<script>alert("Plafond depassé");</script>';
            }
        } else {
            echo '<script>alert("Indiquer le montant voulu");</script>';
        }
        CtlAgentTransactionClientChoice();
    }

    //
    // MP
    //
    // Lance de quoi deposer l'argent voulu sur le compte en session et retourne a l'acceuil
    //

    function CtlAgentOutPutTransactionRetraitCompteClient(){
        $soldeActuel = $_SESSION['soldeCompteClient'];
        $decouvert = $_SESSION['decouvertCompteClient'];

        if (isset($_POST['retrait']) && (intval($_POST['retrait'] > 0))) {
            if ( $soldeActuel - $_POST['retrait'] >= $decouvert ) {
                retraitAgentClient($_POST['retrait']);
            } else{
                echo '<script>alert("Decouvert depassé");</script>';
            }
        } else {
            echo '<script>alert("Indiquer le montant positif voulu");</script>';
        }
        CtlAgentTransactionClientChoice();
    }
    

    //
    // MP
    //
    // Bouton "Modification Client" present dans le ASIDE.
    //

    function CtlModificationClient() {
        AgentclientModificationPage($_SESSION['clientNom'], $_SESSION['clientPrenom'], $_SESSION['clientNaissance']);
    }

    //
    // MP
    //
    // Bouton "Modifier" de la modification des infos clients.
    // Appel la page et sauvegarde la modification des informations du client. 
    //
    function CtlAgentModificationClient(){
        $_SESSION['nomClientModification'] = $_POST['nomClientModification'];
        $_SESSION['prenomClientModification'] = $_POST['prenomClientModification'];
        $_SESSION['dateNaissanceClientModification'] = $_POST['dateNaissanceClientModification'];
        
        AgentclientModificationPageVerification();
    }

    //
    // MP
    //
    // Bouton "Valider" de la modification des infos clients
    // Retour a l'acceuil et effectue les modification sur la base de donnée et dans la session
    //
    function CtlAgentValiderModificationClient() {
        editInformationClient();

        $_SESSION['clientNom'] = $_SESSION['nomClientModification'];
        $_SESSION['clientPrenom'] = $_SESSION['prenomClientModification']; 
        $_SESSION['clientNaissance'] = $_SESSION['dateNaissanceClientModification'];

        unset($_SESSION['nomClientModification']);
        unset($_SESSION['prenomClientModification']);
        unset($_SESSION['dateNaissanceClientModification']);

        accueilAgent();
    }
    
    //
    // MP
    //
    // Bouton "Editer" de la modification des infos clients
    // 
    //
    function CtlAgentReModificationClient(){
        AgentclientModificationPage($_SESSION['nomClientModification'],$_SESSION['prenomClientModification'],$_SESSION['dateNaissanceClientModification']);
    }


    //
    // NV
    //
    // On retourne l'edt de l'agent relié au client
    // puis on l'affiche avec les motifs et les forms de créations et suppression de rdv
    //

    function CtlPriseDeRendezVousAgents() {

        getAndSetConseillerLoginDuClientDansSession($_SESSION['idClient']);

        $arr=getEDTConseillerByDate();

        priseDeRendezVousAgents( getMotifsType(), $arr );
    }

    //
    // NV
    //
    // récupère le login du conseiller selon l'id du client donné
    // le login est mit dans la session
    //

    function getAndSetConseillerLoginDuClientDansSession($idClient) {
        $_SESSION['conseillerRattacherClient'] = getConseillerRattacherAuClient($idClient);
        return employeInformations($_SESSION['conseillerRattacherClient']);
    }


    //
    // NV
    //
    // on créé le RDV ou non puis on affiche à nouveau la page avec l'emploi du temps du conseiller
    //

    function CtlCreationRendezVousAgent() {
        //
        // on verifie si les information sont remplient puis on vérifie si la date se trouve bien après la date du jour
        // on vérifie au ssi si les heures sont bien dans l'ordre
        //

        if ( $_POST['motifRDV'] == '' || $_POST['date'] == '' || $_POST['heureDebut'] == '' || $_POST['heureFin'] == '' || $_POST['date'] <= date("Y-m-d") || $_POST['heureDebut'] > $_POST['heureFin'] || !empty(checkRDVCreation()) ) {
            getAndSetConseillerLoginDuClientDansSession($_SESSION['idClient']);
            $arr=getEDTConseillerByDate();
            priseDeRendezVousAgents( getMotifsType(), $arr, true );
        }
        
        else {
            createRDV();
            $motif = getMotifsAll();
            affichageRDVPieceNecessaires( $motif );
        }
        
    }


    //
    // NV
    //
    // supprime le rdv puis on affiche à nouveau la page avec l'emploi du temps du conseiller
    //

    function CtlSupprimerRendezVousAgent() {

        $arr=getEDTConseillerByDate();

        if ($_POST['rdvDel'] != '' ) {

            if ( !empty( rdvToIdClient() ) ) {
                priseDeRendezVousAgents( getMotifsType(), $arr, false, false, false,true );
            } else {
                deleteRDV();
                priseDeRendezVousAgents( getMotifsType(), $arr, false, false, true );
            }

        } else {
            priseDeRendezVousAgents( getMotifsType(), $arr, true );
        }

    }