<?php
    //
    // $_SESSION received | started
    //
    session_start();

    require_once("Controller/controller.php");


    echo "<script>console.log('".var_dump($_SESSION)."')</script>";
    echo "<script>console.log('".var_dump($_POST)."')</script>";


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

        }
        
        
        
        
        
        
        
        
        //
        // DEFAULT CASES
        // Main pages of : AGENTS | CONSEILLERS | DIRECTEUR | CONNEXION PAGE
        //
        if ( isset($_SESSION['poste'])) {
            if ( $_SESSION['poste'] == "Agent" ) {

                //
                // If an agent try to research a client this page will be loaded
                //

                if ( isset($_POST['asideAgentClientResearch']) ) {
                    CtlAgentResearchClient();
                } 

                //
                // If an agent try to create a client this page will be loaded
                //
                
                else if ( isset($_POST['asideClientCreation']) ){
                    CtlAgentCreateationClient();
                }

                //
                //
                //

                else if ( isset($_POST['creationClientAgentSubmit']) ) {
                    CtlAgentCreateClient();
                }

                //
                //
                //

                else if ( isset($_POST['rattacherClientSubmit']) ) {
                    CtlRattacherClient();
                }
                

                else if ( isset($_POST['asideClientDisconnect']) ) {
                    CtlClientDisconnect();
                }

                else if ( isset($_POST['rechercheClientSubmit']) ) {
                    CtlAgentResearchClientSubmitted();
                }

                else if ( isset($_POST['clientRechercheChoice'])) {
                    CtlAgentResearchClientChoices();
                }

                else if ( isset($_POST['asideClientTransaction']) ) {
                    CtlAgentTransactionClientChoice();
                } 

                else if ( isset($_POST['selectionnerCompteClientSubmit']) ) {
                    CtlAgentTransactionClient();
                }

                else if ( isset($_POST['outPutTransactionRetraitCompteClient'])){
                    CtlAgentOutPutTransactionRetraitCompteClient ();
                }

                else if ( isset($_POST['outPutTransactionDepotCompteClient'])){
                    CtlAgentOutPutTransactionDepotCompteClient ();
                } //////////////////////////////////////// MP

                else if ( isset($_POST['asideClientSynthese']) ) {
                    CtlAgentSyntheseClientPage();
                }

                else if ( isset($_POST['asideClientNouvelleRecherche']) ) {
                    CtlAgentResearchClient();
                }

                else if ( isset($_POST['asideClientModification']) ) {
                    CtlModificationClient();
                }

                else {
                    CtlAgentHomePage();
                }


                
            }

            else if ( $_SESSION['poste'] == "Conseiller" ) {
                CtlConseillerHomePage();
            }

            else if ( $_SESSION['poste'] == "Directeur" ) {

                if ( isset($_POST['asideDirecteurCreerEmploye'] )) {
                    CtlDirecteurCreateAgentSubmit();
                } 
                
                
                else if ( isset($_POST['createEmploye']) ) {

                    //
                    // if createEmploye submit is clicked and if there's an ongoing session which has the $poste Directeur
                    //
        
                    CtlAjouterEmploye( $_POST['loginCreation'], $_POST['passwordCreation'], $_POST['posteCreation'], $_POST['nomCreation'], $_POST['prenomCreation'] );
        
                } 
                
                
                
                else {
                    CtlDirecteurHomePage();
                }
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

    