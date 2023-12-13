<?php

    function CtlAgentHomePage() {
        accueilAgent();
    }

    function CtlAgentResearchClient() {

        rechercheClientAgentView();

    }



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

        $res = rechercherClientAgent($clientInfo);

        if ($res != false ) {
            if ( isset($res['idClient']) && isset($res['nomClient']) ) {

                $_SESSION['clientNom'] = $res['nomClient'];
                $_SESSION['clientPrenom'] = $res['prenomClient'];
                $_SESSION['clientNaissance'] = $res['dateNaissance'];
                $_SESSION['idClient'] = $res['idClient'];

                mainPageClientAgent();
            } else if ( isset($res[0]['nomClient']) ) {
                $_SESSION['clientNom'] = $res[0]['nomClient'];
                $_SESSION['clientPrenom'] = $res[0]['prenomClient'];
                $_SESSION['clientNaissance'] = $res[0]['dateNaissance'];
                $_SESSION['idClient'] = $res[0]['idClient'];

                mainPageClientAgent();
            } else if ( isset($res[1]) ) {
                rechercheApprofondiClient($res);
            } else {
                rechercheClientAgentView(false);
            }

        } else {
            rechercheClientAgentView(false);
        }
    
    }


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



        mainPageClientAgent();
    }


    function CtlAgentCreateationClient(){
        creationClientAgent();
    }



    //
    // Creation de client par un agent
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
    // rattachement d'un client
    //


    function CtlRattacherClient() {

        $_SESSION['conseillerRattacherClient'] = $_POST['posteRattachement'];

        rattacherClientAgent();
        mainPageClientAgent();
    }

    function CtlClientDisconnect() {
        unset($_SESSION['clientNom']);
        unset($_SESSION['clientPrenom']);
        unset($_SESSION['clientNaissance']);
        unset($_SESSION['idClient']);
        unset($_SESSION['idCompte']);
        accueilAgent();
    }

    // Lance de quoi afficher la liste des comptes du client en session
    function CtlAgentTransactionClientChoice(){
        $compteList = getAllComptes();
        if ( empty($compteList) ) {
            errorTransactionNoAccountFound();
        } else {
            transactionChoixClientAgentView($compteList);
        }
    }

    //Lance de quoi afficher les choix pour retirer/deposer sur le compte
    function CtlAgentTransactionClient(){
        $_SESSION['idCompteClient'] = $_POST['compteSelection'];
        $_SESSION['typeCompteClient'] = getTypeCompteViaId($_SESSION['idCompteClient'] );
        $_SESSION['soldeCompteClient'] = getSoldeCompteViaId($_SESSION['idCompteClient'] );

        if ($_POST['radioTransaction'] == "retrait") {
            transactionRetraitClientAgentView();
        }
        else if ($_POST['radioTransaction'] == "depot") {
            transactionDepotClientAgentView();
        }
    }

    //Lance de quoi retirer l'argent voulu sur le compte en session et retourne a l'acceuil
    function CtlAgentOutPutTransactionDepotCompteClient(){
        $soldeActuel = getSoldeCompteViaId($_SESSION['idCompteClient']);
        $plafond = getPlafondViaType($_SESSION['typeCompteClient']);

        if (isset($_POST['depot']) && (intval($_POST['depot'] > 0))) {
            if ( $soldeActuel + $_POST['depot'] <= $plafond ) {
                depotAgentClient($_POST['depot']);
            } else{
                echo '<script>alert("Plafond depassé");</script>';
            }
        } else {
            echo '<script>alert("Indiquer le montant voulu");</script>';
        }
        CtlAgentTransactionClientChoice();
    }

    //Lance de quoi deposer l'argent voulu sur le compte en session et retourne a l'acceuil
    function CtlAgentOutPutTransactionRetraitCompteClient(){
        $soldeActuel = getSoldeCompteViaId($_SESSION['idCompteClient']);
        $decouvert = getDecouvert($_SESSION['idClient']);

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



    function CtlAgentSyntheseClientPage() {
        // Récupérer les informations du client
        $clientData = DataClient();
    
        // Vérifier si les données du client existent
        if ($clientData) {
            // Afficher les informations du client dans la page de synthèse

            clientSynthesis($clientData);
    
        } else {
            // Gérer le cas où les données du client ne peuvent pas être récupérées
            echo "Impossible de récupérer les informations du client.";
        }
    }
    

    function CtlModificationClient() {
        AgentclientModificationPage();
    }

    function CtlPriseDeRendezVousAgents() {
        getAndSetConseillerLoginDuClientDansSession($_SESSION['idClient']);
        priseDeRendezVousAgents( getMotifsType() );
    }


    //
    // récupère le login du conseiller selon l'id du client donné
    // le login est mit dans la session
    //

    function getAndSetConseillerLoginDuClientDansSession($idClient) {
        $SESSION['conseillerRattacherClient'] = getConseillerRattacherAuClient($idClient);
        return employeInformations($SESSION['conseillerRattacherClient']);
    }


    function CtlCreationRendezVousAgent() {
        //
        // on verifie si les information sont remplient puis on vérifie si la date se trouve bien après la date du jour
        // on vérifie au ssi si les heures sont bien dans l'ordre
        //

        echo "<script>console.log('".empty(checkRDVCreation())."')</script>";

        if ( $_POST['motifRDV'] == '' || $_POST['date'] == '' || $_POST['heureDebut'] == '' || $_POST['heureFin'] == '' || $_POST['date'] <= date("Y-m-d") || $_POST['heureDebut'] > $_POST['heureFin'] || !empty(checkRDVCreation()) ) {
            getAndSetConseillerLoginDuClientDansSession($_SESSION['idClient']);
            priseDeRendezVousAgents( getMotifsType(), true );
        }
        
        else {
            createRDVAgent();
            getAndSetConseillerLoginDuClientDansSession($_SESSION['idClient']);
            priseDeRendezVousAgents( getMotifsType(), false, true );
        }
        
    }


    function CtlSupprimerRendezVousAgent() {
        
    }