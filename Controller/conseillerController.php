<?php

    function CtlConseillerHomePage() {
        accueilConseiller();
    }

    function CtlConseillerResearchClientSubmitted() {

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

                $_SESSION['client'] = $res['nomClient'];
                $_SESSION['clientPrenom'] = $res['prenomClient'];
                $_SESSION['clientNaissance'] = $res['dateNaissance'];
                $_SESSION['idClient'] = $res['idClient'];

                agentInscrit();

            } else if ( isset($res[0]['nomClient']) ) {
                $_SESSION['clientNom'] = $res[0]['nomClient'];
                $_SESSION['clientPrenom'] = $res[0]['prenomClient'];
                $_SESSION['clientNaissance'] = $res[0]['dateNaissance'];
                $_SESSION['idClient'] = $res[0]['idClient'];

                agentInscrit();

            } else if ( isset($res[1]) ) {
                rechercheApprofondiClientConseiller($res);
            } else {
                rechercheClientConseillerView(false);
            }

        } else {
            rechercheClientConseillerView(false);
        }

    }


    function CtlConseillerResearchClientChoices() {

        $res = getClientByID($_POST['clientRechercheChoice']);

        $_SESSION['clientNom'] = $res['nomClient'];
        $_SESSION['clientPrenom'] = $res['prenomClient'];
        $_SESSION['clientNaissance'] = $res['dateNaissance'];
        $_SESSION['idClient'] = $_POST['clientRechercheChoice'];



        mainPageClientConseiller();
    }

    function CtlClientDisconnectConseiller() {
        unset($_SESSION['clientNom']);
        unset($_SESSION['clientPrenom']);
        unset($_SESSION['clientNaissance']);
        unset($_SESSION['idClient']);
        unset($_SESSION['idCompte']);
        accueilConseiller();
    }


    function CtlInscrireClient() {

        // \w = [:alnum:]_
        if (preg_match("/^[[:alpha:]-]/",$_POST['nomClientInscription']) &&
            preg_match("/^[[:alpha:]-]/",$_POST['prenomClientInscription']) &&
            preg_match("/^[[:digit:]]+-+[[:digit:]]+-+[[:digit:]]/",$_POST['dateNaissanceClientInscription']) &&
            preg_match("/^[[:digit:]]{10,10}/",$_POST['telephoneClientInscription']) &&
            preg_match("/^[\w-]+@+[\w-]+\.+[\w-]/",$_POST['mailClientInscription']) && 
            $_POST['adresseClientInscription'] != "" &&
            preg_match("/^[[:digit:]]/",$_POST['codePostalClientInscription']) &&
            preg_match("/^[[:alpha:]]/",$_POST['professionClientInscription']) &&
            preg_match("/^[[:alpha:]]/",$_POST['situationClientInscription']) &&
            preg_match("/^[[:digit:]]/",$_POST['revenuClientInscription']) &&
            preg_match("/^[[:digit:]]/",$_POST['decouvertClientInscription'])
            ) {
                inscriptionClientConseiller();
                accueilConseiller();
        }
        else {
            inscrireClient( DataClient() );
        }
    }

    
    function agentInscrit(){
        //
        // si le client n'est pas inscrit le faire inscrire
        //

        $res = clientInscritCheck();

        if ( $res == true ) {
            accueilConseiller();
        } else {
            inscrireClient( DataClient() );
        }
    }