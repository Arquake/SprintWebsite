<?php

    function CtlDirecteurCreateAgentSubmit() {
        gestionEmployeDirecteur('homepage');
    }

    function CtlDirecteurHomePage() {
        accueilDirecteur();
    }

    function CtlAjouterEmploye ( $login, $password, $poste ,$nom, $prenom ){

        $created = createEmploye( $login, $password, $poste ,$nom, $prenom);

        gestionEmployeDirecteur($created);

    }