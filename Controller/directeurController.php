<?php


    //
    // NV
    //
    //
    //

    function CtlDirecteurCreateAgentSubmit() {
        gestionEmployeDirecteur('homepage');
    }


    //
    // NV
    //
    //
    //

    function CtlDirecteurHomePage() {
        accueilDirecteur();
    }


    //
    // NV
    //
    //
    //

    function CtlAjouterEmploye ( $login, $password, $poste ,$nom, $prenom ){

        $created = createEmploye( $login, $password, $poste ,$nom, $prenom);

        gestionEmployeDirecteur($created);

    }

    //
    // NV
    //
    //
    //

    function CtlModifierEmploye() {
        $arr = informationConnexionDirecteur();
        modifierEmployeForms($arr);
    }


    //
    // NV
    //
    //
    //

    function CtlModifierEmployeSelected() {
        if ( isset($_POST['employeChoisiInformationLogin']) ) {
            $_POST['modifierLemploye'] = $_SESSION['employeChoisiInformationLogin'];
        }
        $arr = informationConnexionEmployeDirecteur();
        $_SESSION['employeChoisiInformationLogin'] = $_POST['modifierLemploye'];
        modificationSelectedEmploye($arr);
    }


    //
    // NV
    //
    //
    //

    function CtlAppliquerModificationEmploye() {

        

        $errorArray = [];

        array_push($errorArray, ($_POST['loginCreation'] == '' || loginCheckIfExistDirecteur()) && $_POST['loginCreation'] != $_SESSION['employeChoisiInformationLogin'] );
        array_push($errorArray, isset($_POST['passwordCheckbox']) && $_POST['passwordCreation'] == '' );
        array_push($errorArray, $_POST['nomCreation'] == '');
        array_push($errorArray, $_POST['prenomCreation'] == '');
        

        if ( in_array(true, $errorArray) ) {
            if ( isset($_SESSION['employeChoisiInformationLogin'])) {
                $arr = informationConnexionEmployeDirecteur($_SESSION['employeChoisiInformationLogin']);
            } else {
                $arr = informationConnexionEmployeDirecteur();
            }
            modificationSelectedEmploye($arr, $errorArray[0], $errorArray[1], $errorArray[2], $errorArray[3]);
        } else {
            modificationInformationEmployeDirecteur();
            $arr = informationConnexionDirecteur();
            unset($_SESSION['employeChoisiInformationLogin']);
            modifierEmployeForms($arr, true);
        }
    }


    //
    // 
    //
    //
    //

    function CtlModifierPiece() {
        
    }


    //
    // NV
    //
    // Affiche les différentes type de stats au directeur
    //

    function CtlStatsDirecteur() {
        directeurChoixTypeStats();
    }


    //
    // NV
    //
    // récupère les statistiques demandés
    //

    function CtlStatsDirecteurRechercher() {

    }


    //
    // MP
    //
    // Repond au bouton "Gestion compte" du aside 
    //
    function CtlDirecteurCompte( $sortie = 0){
        $typeList = getTypeCompteList();
        gestionCompte($typeList,$sortie);
    }

    //
    // MP
    //
    // Repond au bouton "Ajouter" de la page de gestion de compte
    //
    function CtlDirecteurAjouterCompte(){
        if (VerificationExistanceTypeCompte($_POST['DirecteurAjouterCompteType'])){        
            ajouterLeTypeCompte($_POST['DirecteurAjouterCompteType']);
            CtlDirecteurCompte(1);
        }else {
            CtlDirecteurCompte(4);
        }
    }

    //
    // MP
    //
    // Repond au bouton "Retirer" de la page de gestion de compte
    //
    function CtlDirecteurSupprimerCompte(){
        if (VerificationPossessionTypeCompte($_POST['DirecteurSupprimerCompteType'])){
            supprimerLeTypeCompte($_POST['DirecteurSupprimerCompteType']);
            CtlDirecteurCompte(2);
        } else {
            CtlDirecteurCompte(3);
        }
    }


    //
    // MP
    //
    // Repond au bouton "Gestion contrat" du aside 
    //
    function CtlDirecteurContrat( $sortie = 0){
        $typeList = getTypeContratList();
        gestionContrat($typeList,$sortie);
    }

    //
    // MP
    //
    // Repond au bouton "Ajouter" de la page de gestion de contrat
    //
    function CtlDirecteurAjouterContrat(){
        if (VerificationExistanceTypeContrat($_POST['DirecteurAjouterContratType'])){        
            ajouterLeTypeContrat($_POST['DirecteurAjouterContratType']);
            CtlDirecteurContrat(1);
        }else {
            CtlDirecteurContrat(4);
        }
    }

    //
    // MP
    //
    // Repond au bouton "Retirer" de la page de gestion de contrat
    //
    function CtlDirecteurSupprimerContrat(){
        if (VerificationPossessionTypeContrat($_POST['DirecteurSupprimerContratType'])){
            supprimerLeTypeContrat($_POST['DirecteurSupprimerContratType']);
            CtlDirecteurContrat(2);
        } else {
            CtlDirecteurContrat(3);
        }
    }

















