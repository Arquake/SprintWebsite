<?php

    require_once("View/view.php");
    require_once("Modele/modele.php");
    require_once('agentController.php');
    require_once('directeurController.php');


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


    


    function CtlConseillerHomePage() {
        accueilConseiller();
    }