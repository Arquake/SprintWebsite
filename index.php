<?php
    //
    // $_SESSION received | started
    //
    session_start();

    include_once("Controller/controller.php");

    //
    // Check if user try to sign out
    // if the user try to sign out unset all variables in $_SESSION
    //


    try {
        if ( isset($_POST['deconnexion'])) {
            session_unset();
        }

        //
        // if the user is connected a $poste is assigned to him
        // controller is gonna be accessed to match the $poste of the user
        // { 'Agent', 'Conseiller', 'Directeur'}
        // 

        if ( isset($_SESSION['poste']) ) {
            CtlAccueil();
        } else {

            if ( isset($_POST['connexion']) && !isset($_SESSION['poste']) ){

                //
                // if connexion submit is clicked and if there's no ongoing session
                //

                CtlConnexion($_POST['login'],$_POST['password']);

            } else if ( isset($_POST['createEmploye']) && $_SESSION['poste'] == 'Directeur') {

                //
                // if createEmploye submit is clicked and if there's an ongoing session which has the $poste Directeur
                //

                CtlAjouterEmploye( $_POST['loginCreation'], $_POST['passwordCreation'], $_POST['posteCreation'], $_POST['nomCreation'], $_POST['prenomCreation'] );

            } 
            
            
            
            
            
            
            //
            // DEFAULT CASES
            // Main pages of : AGENTS | CONSEILLERS | DIRECTEUR | CONNEXION PAGE
            //
            if ( isset($_SESSION['poste'])) {
                if ( $_SESSION['poste'] == "Agents" ) {
                    CtlAgentHomePage();
                }
    
                else if ( $_SESSION['poste'] == "Conseiller" ) {
                    CtlConseillerHomePage();
                }
    
                else if ( $_SESSION['poste'] == "Directeur" ) {
                    CtlDirecteurHomePage();
                }
            }
            
            else {

                //
                // if nothing is pressed or just loaded the page
                // for the first time in the current navigation tab
                //

                CtlAccueil();
            }
        }

    } catch ( Exception $e ) {
        CtlError( $e );
    }

    