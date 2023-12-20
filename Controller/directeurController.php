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
        $arr = informationConnexionEmployeDirecteur();
        modificationSelectedEmploye($arr);
    }


    //
    // NV
    //
    //
    //

    function CtlModifierPiece() {
        
    }


    //
    // NV
    //
    //
    //

    function CtlStats() {
        
    }