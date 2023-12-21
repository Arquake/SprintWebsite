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
    // 
    //
    //
    //

    function CtlStats() {
        
    }