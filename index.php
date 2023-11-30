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

        } else {
            if ( isset($_POST['connexion']) ){

            } else {
                CtlAccueil();
            }
        }

    } catch ( Exception $e ) {
        CtlError( $e );
    }

    