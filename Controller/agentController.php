<?php

    function CtlAgentHomePage() {
        accueilAgent();
    }

    function CtlAgentResearchClient() {

        rechercheClientAgentView();

    }

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
            if ( isset($res['idClient']) ) {

                $_SESSION['clientNom'] = $res['nomClient'];
                $_SESSION['clientPrenom'] = $res['prenomClient'];
                $_SESSION['clientNaissance'] = $res['dateNaissance'];
                $_SESSION['idClient'] = $res['idClient'];

                mainPageClientAgent();
            } else if ( gettype($res) == 'array' && count($res) == 1 ) {
                $_SESSION['clientNom'] = $res[0]['nomClient'];
                $_SESSION['clientPrenom'] = $res[0]['prenomClient'];
                $_SESSION['clientNaissance'] = $res[0]['dateNaissance'];
                $_SESSION['idClient'] = $res[0]['idClient'];

                mainPageClientAgent();
            } else {
                rechercheApprofondiClient($res);
            }

        } else {
            rechercheClientAgentView($res);
        }
    
    }


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

    function CtlRattacherClient() {
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
        transactionChoixClientAgentView($compteList);
    }

    //Lance de quoi afficher les choix pour retirer/deposer sur le compte
    function CtlAgentTransactionClient(){
        $_SESSION['compteClient'] = $_POST['compteSelection'];
        $compte = getCompteViaId($_SESSION['compteClient']);
        transactionClientAgentView($compte);
    }

    //Lance de quoi retirer/deposer l'argent voulu sur le compte en session et retourne a l'acceuil
    function CtlAgentOutPutTransactionCompteClient(){
        if (isset($_POST['retrait'])) {
            retraitAgentClient($_POST['retrait']);
        }
        else if (isset($_POST['depot'])) {
            depotAgentClient($_POST['depot']);
        }
        accueilAgent();
    }

    