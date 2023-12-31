<?php
    //
    // $_SESSION received | started
    //
    session_start();

    require_once("Controller/controller.php");


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
                // Bouton "Selectionner" de la selection de l'action à effectué (dépot/retrait) et du compte sur lequel l'effectué 
                //

                else if ( isset($_POST['selectionnerCompteClientSubmit']) ) {
                    CtlAgentTransactionClient();
                }

                //
                // MP
                //
                // Bouton "soumettre" du retrait sur le compte
                // -Prend le montant indiqué et le retire du compte
                //

                else if ( isset($_POST['outPutTransactionRetraitCompteClient'])){
                    CtlAgentOutPutTransactionRetraitCompteClient();
                }

                //
                // MP
                //
                // Bouton "soumettre" du dépot sur le compte
                // -Prend le montant indiqué et le depose sur le compte
                //

                else if ( isset($_POST['outPutTransactionDepotCompteClient'])){
                    CtlAgentOutPutTransactionDepotCompteClient();
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
                // MP
                //
                // Bouton "Modifier" de la modification des infos clients
                //
                else if ( isset($_POST['ModificationClientSubmit'])){
                    CtlAgentModificationClient();
                }

                //
                // MP
                //
                // Bouton "Editer" de la modification des infos clients
                //
                else if ( isset($_POST['ReModificationClientSubmit'])){
                    CtlAgentReModificationClient();
                }
                
                //
                // MP
                //
                // Bouton "Valider" de la modification des infos clients
                //
                else if ( isset($_POST['ValiderModificationClientSubmit'])){
                    CtlAgentValiderModificationClient();
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
                // Quand le bouton de recherche client est cliqué dans le aside
                //

                if ( isset($_POST['asideConseillerClientResearch']) ) {
                    CtlConseillerResearchClient();
                } 


                //
                // NV
                // 
                // Quand le bouton planning est cliqué dans le aside
                // Ou quand les boutons pour se déplacer dans l'emploi du temps sont cliqués
                //

                else if ( isset($_POST['asideConseillerPlanning']) || isset($_POST['weekMinusOne']) || isset($_POST['weekAddOne']) ||isset($_POST['conseillerEDTSubmit']) ) {
                    if ( isset($_POST['conseillerEDTSubmit']) ) {
                        $_SESSION['conseillerRattacherClient'] = $_POST['conseillerEDTChoice'];
                    } else if ( isset($_POST['asideConseillerPlanning']) ) {
                        $_SESSION['conseillerRattacherClient'] = $_SESSION['login'];
                    }

                    CtlPriseDeRendezVousConseiller();
                    
                }


                //
                // NV
                //
                // quand le bouton créé formation est cliqué
                //
                
                else if ( isset($_POST['creerRDVConseiller']) ) {
                    CtlCreationRendezVousConseiller();
                } 

                //
                // NV
                //
                // quand le bouton de suppression rendez-vous est cliqué
                //
                
                else if ( isset($_POST['deleteRDVConseiller']) ) {
                    CtlSupprimerRendezVousConseiller();
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
                // quand le bouton de recherche approfondi est cliqué
                //

                else if ( isset($_POST['clientRechercheChoice'])) {
                    CtlAgentResearchClientChoices();
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
                // Quand le bouton Incrire est cliqué
                //

                else if ( isset($_POST['inscrireClientSubmit']) ) {
                    CtlInscrireClient();
                } 

                //
                // NV
                //
                // Quand le bouton Vendre Contrat dans le aside est cliqué
                //

                else if ( isset($_POST['asideConseillerVendreContrat']) ) {
                    CtlvendreContrat();
                } 

                //
                // NV
                //
                // Quand le bouton Ouvrir Compte dans le aside est cliqué
                //

                else if ( isset($_POST['asideConseillerOuvrirCompte']) ) {
                    CtlouvrirCompte();
                } 

                //
                // NV
                //
                // Quand le bouton Modifier Decouvert dans le aside est cliqué
                //

                else if ( isset($_POST['asideConseillerModifDecouvert']) ) {
                    CtlmodifierDecouvert();
                } 

                //
                // NV
                //
                // Quand le bouton Résiliation dans le aside est cliqué
                //

                else if ( isset($_POST['asideConseillerResiliation']) ) {
                    Ctlresilier();
                } 


                //
                // NV
                //
                // quand le bouton synthèse dans le aside est cliqué
                //

                else if ( isset($_POST['asideClientSynthese']) ) {
                    CtlClientSynthese();
                }


                //
                // NV
                //
                // Quand le bouton Rendez-Vous dans le li de la synthèse client est cliqué
                //

                else if ( isset($_POST['syntheseRdv']) ) {
                    CtlClientSynthese();
                }


                //
                // NV
                //
                // Quand le bouton Comptes dans le li de la synthèse client est cliqué
                //

                else if ( isset($_POST['syntheseComptes']) ) {
                    CtlComptesClientSynthese();
                }


                //
                // NV
                //
                // Quand le bouton Contrat dans le li de la synthèse client est cliqué
                //

                else if ( isset($_POST['syntheseContrats']) ) {
                    CtlContratsClientSynthese();
                }


                //
                // NV
                //
                // Quand le bouton créer le compte dans le form est cliqué
                //

                else if ( isset($_POST['creerCompteSubmit']) ) {
                    CtlouvertureCompteClientSuite();
                } 


                //
                // NV
                //
                // Quand le bouton créer le contrat dans le form est cliqué
                //

                else if ( isset($_POST['creerContratSubmit']) ) {
                    CtlouvertureContratClientSuite();
                } 


                //
                // NV
                //
                // Quand le bouton modifier dans le forme de modification découvert est cliqué
                //

                else if ( isset($_POST['modifierDecouvertSubmit']) ) {
                    CtlmodifierDecouvertSuite();
                } 


                //
                // NV
                //
                // si le bouton submit pour résilier son compte est cliqué
                //

                else if ( isset($_POST['resilierCompteSubmit']) ) {
                    CtlRésilierCompte();
                } 


                //
                // NV
                //
                // si le bouton submit pour résilier son contrat est cliqué
                //

                else if ( isset($_POST['resilierContratSubmit']) ) {
                    CtlRésilierContrat();
                } 


                //
                // NV
                //
                // si le bouton dans le planning est cliqué
                //

                else if ( isset($_POST['clientButtonResearch']) ) {
                    CtlRechercheClientPlanning();
                }


                //
                // NV
                //
                // si le bouton dans le planning est cliqué
                //

                else if ( isset($_POST['asideConseillerInscrireClient']) ) {
                    CtlInscriptionClientAside();
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

                //// ---- ASIDE ---- 

                //
                // MP
                //
                // Quand le bouton "Gestion employé" dans le Aside est cliqué
                //
                if ( isset($_POST['asideDirecteurGestionEmploye']) ) {
                    CtlGestionEmploye();
                }

                //
                // MP
                //
                // Quand le bouton Gestion compte est cliqué
                //
                else if ( isset($_POST['asideDirecteurGestionProduit']) ) {
                    CtlGestionProduits();
                } 

                //
                // MP
                //
                // Quand le bouton Gestion contrat est cliqué
                //
                else if ( isset($_POST['asideDirecteurGestionMotifs']) ) {
                    CtlGestionMotifs();
                } 

                //
                // NV
                //
                // Quand le bouton Statistiques dans le aside est cliqué
                //
                else if ( isset($_POST['asideDirecteurStats']) ) {
                    CtlStatsDirecteur();
                } 


                //// --- Plus ASIDE ---

                //
                // MP
                //
                // Link le bouton "Creer employé" au code correspondant
                //
                else if ( isset($_POST['DirecteurCreerEmploye'] )) {
                    CtlDirecteurCreateAgentSubmit();
                } 
                
                //
                // MP
                //
                // Link le bouton "Modifier employé" au code correspondant
                //
                else if ( isset($_POST['DirecteurModifierEmploye'] )) {
                    CtlModifierEmploye();
                }

                /// --COMPTE--
        
                //
                // MP
                //
                // Link le bouton "Ajouter type compte" au code correspondant
                //
                else if ( isset($_POST['DirecteurAjouterCompteSubmit'] )) {
                    CtlDirecteurAjouterCompte();
                } 

                //
                // MP
                //
                // Link le bouton "Supprimer type compte" au code correspondant
                //
                else if ( isset($_POST['DirecteurRetirerCompteSubmit'] )) {
                    CtlDirecteurSupprimerCompte();
                } 
            
                //
                // MP
                //
                // Link le bouton "Supprimer type compte" au code correspondant
                //
                else if ( isset($_POST['DirecteurModifierCompteSubmit'] )) {
                    //CtlDirecteurModifierCompte();
                } 

                //
                // MP
                //
                // Link le bouton de modif des type de compte au code correspondant
                //
                else if ( isset($_POST['DirecteurGestionTypeCompte'] )) {
                    CtlDirecteurCompte();
                } 

                //
                // MP
                //
                // Link le bouton "terminer" de l'ajout de motif 
                // renverra sur la page des compte
                //
                else if ( isset($_POST['DirecteurMotifSortieCompte'] )) {
                    CtlDirecteurCompte();
                } 

                /// --CONTRAT--
        
                //
                // MP
                //
                // Link le bouton "Ajouter type contrat" au code correspondant
                //
                else if ( isset($_POST['DirecteurAjouterContratSubmit'] )) {
                    CtlDirecteurAjouterContrat();
                } 

                //
                // MP
                //
                // Link le bouton "Supprimer type contrat" au code correspondant
                //
                else if ( isset($_POST['DirecteurRetirerContratSubmit'] )) {
                    CtlDirecteurSupprimerContrat();
                } 

                //
                // MP
                //
                // Link le bouton de modif des type de contrat au code correspondant
                //
                else if ( isset($_POST['DirecteurGestionTypeContrat'] )) {
                    CtlDirecteurContrat();
                } 

                //
                // MP
                //
                // Link le bouton "terminer" de l'ajout de motif 
                // renverra sur la page des contrat
                //
                else if ( isset($_POST['DirecteurMotifSortieContrat'] )) {
                    CtlDirecteurContrat();
                } 
                

                /// --MOTIFS--

                //
                // MP
                //
                // Quand le bouton "ajouter" de la page de gestion des
                //
                else if ( isset($_POST['DirecteurAjouterMotifSubmit'] )) {
                    CtlAjoutMotif();
                }









                
                //
                // NV
                //
                // if createEmploye submit is clicked and if there's an ongoing session which has the $poste Directeur
                //
                
                else if ( isset($_POST['createEmploye']) ) {
        
                    CtlAjouterEmploye( $_POST['loginCreation'], $_POST['passwordCreation'], $_POST['posteCreation'], $_POST['nomCreation'], $_POST['prenomCreation'] );
        
                } 

                //
                // NV 
                //
                // Quand le bouton modifier dans le form de modification employe est cliqué
                //

                else if ( isset($_POST['modifierEmployeSubmit']) ) {
                    CtlModifierEmployeSelected();
                }

                //
                // NV 
                //
                // Quand le bouton modifier dans le form de modification de l'employe choisi est cliqué
                //

                else if ( isset($_POST['modifierEmployeChoisiSubmit']) ) {
                    CtlAppliquerModificationEmploye();
                } 

                //
                // NV
                //
                // Quand le bouton recherche statistique est cliqué
                //
                else if ( isset($_POST['asideDirecteurStats']) ) {
                    directeurChoixTypeStats();
                } 


                //
                // NV
                //
                // Quand le bouton recherche statistique est cliqué
                //
                else if ( isset($_POST['statsRechercheSubmit']) ) {
                    CtlStatsDirecteurRechercher();
                } 


                //
                // NV
                //
                // DEFAULT CASE
                //
                
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

    