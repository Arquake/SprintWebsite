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

                CtlClientSynthèse( 3 );

            } else if ( isset($res[1]) ) {
                rechercheApprofondiClientConseiller($res);
            } else if ( isset($res[0]['nomClient']) ) {
                $_SESSION['clientNom'] = $res[0]['nomClient'];
                $_SESSION['clientPrenom'] = $res[0]['prenomClient'];
                $_SESSION['clientNaissance'] = $res[0]['dateNaissance'];
                $_SESSION['idClient'] = $res[0]['idClient'];

                CtlClientSynthèse( 3 );
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

        CtlClientSynthèse( 3 );
    }


    //
    // NV
    //
    // Deconnecte le client de la session
    //

    function CtlClientDisconnectConseiller() {
        unset($_SESSION['clientNom']);
        unset($_SESSION['clientPrenom']);
        unset($_SESSION['clientNaissance']);
        unset($_SESSION['idClient']);
        unset($_SESSION['idCompte']);
        accueilConseiller();
    }


    //
    // NV
    //
    // vérifie la validité des informations dans le form d'inscription client
    //

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
            preg_match("/^[[:alpha:]]/",$_POST['situationClientInscription']) 
            ) {
                inscriptionClientConseiller();
                accueilConseiller();
        }
        else {
            inscrireClient( DataClient(), true );
        }
    }


    //
    // NV
    //
    // renvoie sur la page pour inscrire le client
    //

    function CtlInscriptionClientAside() {
        inscrireClient( DataClient() );
    }


    //
    // NV
    //
    // si la connexion client établi vérifie si le client est inscrit si il ne l'est pas oblige à l'inscrire sinon se connecte normaement
    //
    // $researchtype : 1 = synthèse comptes | 2 = synthèse contrats | 3 = rdv | 4 = rdv venant du planning
    //
    
    function CtlClientSynthèse( $rdvChoice = -1 ){

        $arr = getAllRdvOfClient();
        
        $currentDate = date('Y-m-d');
        $index = 0;

        while ( $index < count($arr) && $arr[$index]['jourReunion'] < $currentDate ) {
            if ( $rdvChoice != -1 && $arr[$index]['idRdv'] == $rdvChoice) {
                $rdvChoisi = $arr[$index];
            } else {
                $rdvChoisi = "";
            }
            $index++;
        }

        if ( $index == 0) {
            $arrPasse = [];
        } else {
            $arrPasse = array_slice($arr, 0, $index);
        }

        if ( $index == count($arr)) {
            $arrVenir = [];
        } else {
            $arrVenir = array_slice($arr, $index);
        }
            

        $motifsArr = getMotifsType();

        $motifs = [];

        for ( $i = 0 ; $i < count($motifsArr) ; $i++ ) {
            $motifs[$motifsArr[$i]['idMotif']] = [ 'libelleMotif' => $motifsArr[$i]['libelleMotif'], 'listePiece' => $motifsArr[$i]['listePiece']];
        }

        $res = clientInscritCheck();

        if( !empty($res) ) {

            if ( $res['estInscrit'] == true ) {

                if ( $rdvChoice != -1 ) {
                    clientRdvSynthèseConseiller( DataClient(), true, $arrVenir, $arrPasse, $motifs, $rdvChoisi );
                } else {
                    clientRdvSynthèseConseiller( DataClient(), true, $arrVenir, $arrPasse, $motifs );
                }

            } else {
                if ( $rdvChoice != -1 ) {
                    clientRdvSynthèseConseiller( DataClient(), false, $arrVenir, $arrPasse, $motifs, $rdvChoisi );
                } else {
                    clientRdvSynthèseConseiller( DataClient(), false, $arrVenir, $arrPasse, $motifs );
                }
            }

        } else {

            echo "erreur synthèse";

        }


        
    }


    //
    // NV
    //
    // fonction pour résilier le contrat
    //


    function Ctlresilier(){

        $comptes = getAllCompteClient();
        $contrats = getAllContratClient();

        resilier( $comptes, $contrats );
        
    }


    //
    // NV
    //
    // récupère les types de compte possible et affiche la vue de selection
    //

    function CtlouvrirCompte(){

        $typeComptes = getAllTypeCompte();

        ouvertureCompte( $typeComptes );
        
    }


    //
    // NV
    //
    // vérifie les informations fourni si elles sont bonne créer le compte sinon retouner une erreur
    //

    function CtlouvertureCompteClientSuite(){

        $typeComptes = getAllTypeCompte();

        if ( !isset($_POST['decouvertCheckbox']) ) {
            $_POST['decouvertCreation'] = 0;
        }
        if ( !isset($_POST['plafondCheckbox']) ) {
            $_POST['plafondCreation'] = 0;
        }
        if ( !isset($_POST['interetCheckbox']) ) {
            $_POST['interetCreation'] = 0;
        }

        if ( intval($_POST['decouvertCreation']) > 0 || intval($_POST['plafondCreation']) < 0 || intval($_POST['interetCreation']) < 0 || intval($_POST['soldeInitial']) < 0 ) {

            ouvertureCompte( $typeComptes, false, true );

        } else {
            
            creerCompteConseiller();
            
            ouvertureCompte( $typeComptes, true );
        }

    }


    //
    // NV
    //
    // récupère les types de contrat possible et affiche la vue de selection
    //

    function CtlvendreContrat(){

        $typeContrats = getAllTypeContrat();

        venteContrat( $typeContrats );
        
    }


    //
    // NV
    //
    // vérifie les informations fourni si elles sont bonne créer le contrat sinon retouner une erreur
    //

    function CtlouvertureContratClientSuite(){

        $typeContrats = getAllTypeContrat();

        if ( !isset($_POST['tarifCreation']) || $_POST['tarifCreation'] == '' || intval($_POST['tarifCreation']) < 0 ) {

            venteContrat( $typeContrats, false, true );

        } else {
            
            creerContratConseiller();
            
            venteContrat( $typeContrats, true );
        }

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


    //
    // NV
    //
    // résilie le contrat
    //

    function CtlRésilierContrat() {

        resilierContrat();

        $comptes = getAllCompteClient();
        $contrats = getAllContratClient();

        resilier( $comptes, $contrats, false, false, true );
    }


    //
    // NV
    //
    // résilie le compte si le solde dessus est 0 
    //

    function CtlRésilierCompte() {

        $solde = getSoldeClient();

        if ( intval($solde) == 0 ) {
            resilierCompte();
            $comptes = getAllCompteClient();
            $contrats = getAllContratClient();

            resilier( $comptes, $contrats, false, true );
        } else {
            $comptes = getAllCompteClient();
            $contrats = getAllContratClient();

            resilier( $comptes, $contrats, true);
        }
    }


    //
    // NV
    //
    // prend le client correspondant à l'id
    //

    function CtlRechercheClientPlanning() {

        $res = getclientByRDV($_POST['clientButtonResearch']);

        $res = getClientByID($res);

        $_SESSION['clientNom'] = $res['nomClient'];
        $_SESSION['clientPrenom'] = $res['prenomClient'];
        $_SESSION['clientNaissance'] = $res['dateNaissance'];
        $_SESSION['idClient'] = $res['idClient'];

        CtlClientSynthèse( 4, $_POST['clientButtonResearch'] );

    }


    //
    // NV
    //
    // récupère les comptes du client et les envois à la vue
    //

    function CtlComptesClientSynthese() {
        $arr = getAllCompteClient();

        clientComptesSynthèseConseiller( DataClient(), $arr );
    }


    //
    // NV
    //
    // récupère les contrats du client et les envois à la vue
    //

    function CtlContratsClientSynthese() {
        $arr = getAllContratClient();

        clientContratsSynthèseConseiller( DataClient(), $arr );
    }