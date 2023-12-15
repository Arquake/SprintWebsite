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
                // NV
                //
                // If an agent try to research a client this page will be loaded
                //

                if ( isset($_POST['asideAgentClientResearch']) ) {
                    CtlAgentResearchClient();
                } 

                //
                // NV
                //
                // If an agent try to create a client this page will be loaded
                //
                
                else if ( isset($_POST['asideClientCreation']) ){
                    CtlAgentCreateationClient();
                }

                //
                // NV
                //
                // quand le bouton de création est appuyé par un agent
                //

                else if ( isset($_POST['creationClientAgentSubmit']) ) {
                    CtlAgentCreateClient();
                }

                //
                // NV
                //
                // quand le bouton de rattachement client est cliqué
                //

                else if ( isset($_POST['rattacherClientSubmit']) ) {
                    CtlRattacherClient();
                }

                //
                // NV
                //
                // quand l'agent clique sur le bouton de recherche 
                // dans les forms de recherche client
                //

                else if ( isset($_POST['rechercheClientSubmit']) ) {
                    CtlAgentResearchClientSubmitted();
                }

                //
                // NV
                //
                // quand le bouton de recherche approfondi est cliqué
                //

                else if ( isset($_POST['clientRechercheChoice'])) {
                    CtlAgentResearchClientChoices();
                }

                //
                // MP
                //
                // Quand le bouton de transaction sur la gauche est cliqué
                //

                else if ( isset($_POST['asideClientTransaction']) ) {
                    CtlAgentTransactionClientChoice();
                } 

                //
                // MP
                //
                // 
                //

                else if ( isset($_POST['selectionnerCompteClientSubmit']) ) {
                    CtlAgentTransactionClient();
                }

                //
                // MP
                //
                //
                //

                else if ( isset($_POST['outPutTransactionRetraitCompteClient'])){
                    CtlAgentOutPutTransactionRetraitCompteClient ();
                }

                //
                // MP
                //
                //
                //

                else if ( isset($_POST['outPutTransactionDepotCompteClient'])){
                    CtlAgentOutPutTransactionDepotCompteClient ();
                } //////////////////////////////////////// MP

                //
                // G
                //
                // quand le bouton synthèse dans le aside est cliqué
                //

                else if ( isset($_POST['asideClientSynthese']) ) {
                    CtlAgentSyntheseClientPage();
                }

                //
                // NV
                //
                // quand le bouton nouvelle recherche dans le aside est cliqué
                //

                else if ( isset($_POST['asideClientNouvelleRecherche']) ) {
                    CtlAgentResearchClient();
                }

                //
                // MP
                //
                // quand le bouton modification client dans le aside est cliqué
                //

                else if ( isset($_POST['asideClientModification']) ) {
                    CtlModificationClient();
                }

                //
                // NV
                //
                // quand le bouton de prise de rendez vous dans le aside est cliqué
                //

                else if ( isset($_POST['asideClientPriseRendezVous']) || isset($_POST['weekMinusOne']) || isset($_POST['weekAddOne']) ) {
                    CtlPriseDeRendezVousAgents();
                } 

                //
                // NV
                //
                // quand le bouton créé rendez vous est cliqué
                //
                
                else if ( isset($_POST['creerRDVAgent']) ) {
                    CtlCreationRendezVousAgent();
                } 

                //
                // NV
                //
                // quand le bouton de suppression rendez-vous est cliqué
                //
                
                else if ( isset($_POST['deleteRDVAgent']) ) {
                    CtlSupprimerRendezVousAgent();
                }

                //
                // NV
                //
                // default case
                //

                else {
                    CtlAgentHomePage();
                }


                
            }

            else if ( $_SESSION['poste'] == "Conseiller" ) {

                //
                // NV
                // 
                // Quand le bouton de recherche client par un agent est cliqué sans le aside
                //

                if ( isset($_POST['asideConseillerClientResearch']) ) {
                    CtlAgentResearchClient();
                } 

                //
                // NV
                //
                // quand le conseiller clique sur le bouton de recherche 
                // dans les forms de recherche client
                //

                else if ( isset($_POST['rechercheClientSubmit']) ) {
                    CtlConseillerResearchClientSubmitted();
                }

                //
                // NV
                //
                // quand le bouton nouvelle recherche est cliqué
                //

                else if ( isset($_POST['asideClientNouvelleRecherche']) ) {
                    CtlClientDisconnectConseiller();
                } 
                
                //
                // NV
                //
                // base case
                //

                else {
                    CtlConseillerHomePage();
                }
            }

            else if ( $_SESSION['poste'] == "Directeur" ) {

                if ( isset($_POST['asideDirecteurCreerEmploye'] )) {
                    CtlDirecteurCreateAgentSubmit();
                } 
                
                
                else if ( isset($_POST['createEmploye']) ) {

                    //
                    // NV
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

    