<?php

    function CtlConseillerHomePage() {
        accueilConseiller();
    }


    //
    // NV
    //
    // Charge la page de recher client du conseiller
    //

    function CtlConseillerResearchClient() {

        CtlClientDisconnect();

        rechercheClientConseillerView();

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

            } else if ( isset($res[1]) ) {
                rechercheApprofondiClientConseiller($res);
            } else if ( isset($res[0]['nomClient']) ) {
                $_SESSION['clientNom'] = $res[0]['nomClient'];
                $_SESSION['clientPrenom'] = $res[0]['prenomClient'];
                $_SESSION['clientNaissance'] = $res[0]['dateNaissance'];
                $_SESSION['idClient'] = $res[0]['idClient'];

                agentInscrit();
            }  else {
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

        agentInscrit();
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


    function Ctlresilier(){

        // Modifier pour recupérer comptes et contrats dans le modèle

        $comptes = [ 0 => [
            'idCompte' => 0, 'type' => 'CCP'
        ],
        1 => [
            'idCompte' => 1, 'type' => 'CEL'
        ]];
        

        $contrats = [ 0 => [
            'idContrat' => 0, 'type' => 'Assurance Vie'
        ],
        1 => [
            'idContrat' => 1, 'type' => 'Assurance Décès'
        ]];

        //

        resilier( $comptes, $contrats);
        
    }


    function CtlouvrirCompte(){

        // Modifier pour recupérer Type comptes dans le modèle

        $typeCompte = [ 0 => [
            'type' => 'CCP'
        ],
        1 => [
            'type' => 'CEL'
        ]];

        //

        ouvertureCompte( $typeCompte );
        
    }


    function CtlvendreContrat(){

        // Modifier pour recupérer comptes et contrats dans le modèle       

        $typeContrats = [ 0 => [
            'type' => 'Assurance Vie'
        ],
        1 => [
            'type' => 'Assurance Décès'
        ]];

        //

        venteContrat( $typeContrats );
        
    }


    function CtlmodifierDecouvert(){

        // Modifier pour recupérer Type comptes dans le modèle

        $listeCompte = [ 0 => [
            'idCompte' => 0, 'type' => 'CCP', 'Decouvert' => -300
        ],
        1 => [
            'idCompte' => 1, 'type' => 'CEL', 'Decouvert' => 0
        ]];

        //

        modificationDecouvert( $listeCompte );
        
    }


    //
    // NV
    //
    // On retourne l'edt du conseiller relié au client
    // on l'affiche les forms de créations et suppression de rdv
    //

    function CtlPriseDeRendezVousConseiller() {

        $infoConseiller = employeInformations( $_SESSION['conseillerRattacherClient'] );

        $_SESSION['conseillerNom'] = $infoConseiller['nomEmploye'];

        $_SESSION['conseillerPrenom'] = $infoConseiller['prenomEmploye'];

        $arr=getEDTConseillerByDate();

        priseDeRendezVousConseillers( getAllConseillers(), $arr );
    }


    //
    // NV
    //
    // on créé la formation ou non puis on affiche à nouveau la page avec l'emploi du temps du conseiller
    //

    function CtlCreationRendezVousConseiller() {
        //
        // on verifie si les information sont remplient puis on vérifie si la date se trouve bien après la date du jour
        // on vérifie au ssi si les heures sont bien dans l'ordre
        //

        echo "<script>console.log('".var_dump(checkRDVCreation())."')</script>";

        if ( $_POST['date'] == '' || $_POST['heureDebut'] == '' || $_POST['heureFin'] == '' || $_POST['date'] <= date("Y-m-d") || $_POST['heureDebut'] > $_POST['heureFin'] ) {


            $arr=getEDTConseillerByDate();
            priseDeRendezVousConseillers( getAllConseillers(), $arr, true );

            
        }
        
        else if ( empty(checkRDVCreation() ) ){
            $_SESSION['idClient'] = -1;
            $_POST['motifRDV'] = "formation";
            createRDV();
            unset($_SESSION['idClient']);
            unset($_POST['motifRDV']);
            
            $arr=getEDTConseillerByDate();

            priseDeRendezVousConseillers( getAllConseillers(), $arr, false, true );
        } else {
            suppressionRDVSuiteAFormation();
        }
        
    }


    //
    // NV
    //
    // supprime le rdv puis on affiche à nouveau la page avec l'emploi du temps du conseiller
    //

    function CtlSupprimerRendezVousConseiller() {

        $arr=getEDTConseillerByDate();

        if ($_POST['rdvDel'] != '' ) {
            if( $_SESSION['login'] == $_SESSION['conseillerRattacherClient'] ) {
                deleteRDV();
                priseDeRendezVousConseillers( getAllConseillers(), $arr);
            } else {
                priseDeRendezVousConseillers( getAllConseillers(), $arr, false, false, false, true );
            }
            
        } else {
            priseDeRendezVousConseillers( getAllConseillers(), $arr, true, false, true );
        }
    }