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
            if ( isset($_POST['connexion']) ){

                //
                // if connexion button is pressed
                // 

                CtlConnexion($_POST['login'],$_POST['password']);

            } else {

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

    