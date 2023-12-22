<?php

    require_once("View/view.php");
    require_once("Modele/modele.php");
    require_once('agentController.php');
    require_once('directeurController.php');
    require_once('conseillerController.php');


    function CtlError( $exception ){
        error();
    }

    function CtlAccueil(){
        accueil();
    }

    function CtlConnexion( $login, $password ){

        //
        // If $login && $password aren't empty entre the loop
        //

        if ( ( !empty($login) && !empty($password) ) ) {

            //
            // $resultat gets the login, password, poste from the database
            // if $resultat is false client will be send back to the form with an error message
            //

            $resultat = formConnexion( $login, $password );

            if ( $resultat != false && !empty($resultat)){

                //
                // poste && login will be stored in the $_SESSION for future uses and database access
                // name && surname are also stored to display on top of the screen
                //

                $_SESSION['poste'] = $resultat['poste'];
                $_SESSION['login'] = $login;

                $resultat = employeInformations( $login );

                $_SESSION['nom'] = $resultat['nomEmploye'];
                $_SESSION['prenom'] = $resultat['prenomEmploye'];

                //
                // try to match $poste with the correct page to show
                //

                if ( $_SESSION['poste'] == "Agent" ){
                    accueilAgent();
                } else if ( $_SESSION['poste'] == "Conseiller" ){
                    accueilConseiller();
                } else {
                    accueilDirecteur();
                }

            }

        }

        accueil(false);

    }


    //
    // NV
    //
    // récupère les comptes du client
    //

    function CtlmodifierDecouvert(){

        $comptes = getAllCompteClient();

        modificationDecouvert( $comptes );
        
    }


    //
    // NV
    //
    // vérifie les informations fourni si elles sont bonne modifie le découvert sinon retouner une erreur
    //

    function CtlmodifierDecouvertSuite(){

        if ( !isset($_POST['decouvertModification']) || $_POST['decouvertModification'] == '' || intval($_POST['decouvertModification']) > 0 ) {

            $comptes = getAllCompteClient();

            modificationDecouvert( $comptes, false, true );

        } else {
            
            modifierDecouvert();

            $comptes = getAllCompteClient();
            
            modificationDecouvert( $comptes, true );
        }
        
    }


    