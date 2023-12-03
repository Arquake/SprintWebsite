<?php
    //
    // $_SESSION received | started
    //
    session_start();

    session_unset();

    include_once("Controller/controller.php");


    //echo "<script>console.log('".var_dump($_SESSION)."')</script>";
    //echo "<script>console.log('".var_dump($_POST)."')</script>";


    //
    // Check if user try to sign out
    // if the user try to sign out unset all variables in $_SESSION
    //


    //
    // deconnexion input is set as an image
    // because of it is returned by it x and y coordinates
    // if x is set y is set and then just take one to match if button is clicked
    //

    try {
        if ( isset($_POST['deconnexion_x'])) {
            session_unset();
        }

        // echo "<script>console.log('".var_dump($_SESSION)."')</script>";
        // echo "<script>console.log('".var_dump($_POST)."')</script>";

        //
        // if the user is connected a $poste is assigned to him
        // controller is gonna be accessed to match the $poste of the user
        // { 'Agent', 'Conseiller', 'Directeur'}
        // 

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
    } catch ( Exception $e ) {
    CtlError( $e );
    }

    