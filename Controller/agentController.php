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

        if ($_POST['radioTransaction'] == "retrait") {
            transactionRetraitClientAgentView($compte);
        }
        else if ($_POST['radioTransaction'] == "depot") {
            transactionDepotClientAgentView($compte);
        }
    }

    //Lance de quoi retirer l'argent voulu sur le compte en session et retourne a l'acceuil
    function CtlAgentOutPutTransactionRetraitCompteClient(){
        if (isset($_POST['retrait'])) {
            retraitAgentClient($_POST['retrait']);
        } else {
            echo '<script>alert("Indiquer le montant voulu");</script>';
        }
        CtlAgentTransactionClientChoice();
    }

    //Lance de quoi deposer l'argent voulu sur le compte en session et retourne a l'acceuil
    function CtlAgentOutPutTransactionDepotCompteClient(){
        if (isset($_POST['depot'])) {
            depotAgentClient($_POST['depot']);
        } else {
            echo '<script>alert("Indiquer le montant voulu");</script>';
        }
        CtlAgentTransactionClientChoice();
    }



    function CtlAgentSyntheseClientPage() {
        // Récupérer les informations du client
        $clientData = DataClient();
    
        // Vérifier si les données du client existent
        if ($clientData) {
            // Afficher les informations du client dans la page de synthèse
            echo "<h1>Synthèse du client</h1>";
            echo "<p>ID du client : " . $clientData['idClient'] . "</p>";
            echo "<p>Nom du client : " . $clientData['nomClient'] . "</p>";
            echo "<p>Prénom du client : " . $clientData['prenomClient'] . "</p>";
    
        } else {
            // Gérer le cas où les données du client ne peuvent pas être récupérées
            echo "Impossible de récupérer les informations du client.";
        }
    }
    