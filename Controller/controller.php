<?php

    require_once("View/view.php");
    require_once("Modele/modele.php");


    function CtlError( $exception ){
        accueil(false);
    }

    function CtlAccueil(){
        accueil();
    }

    function CtlConnexion( $login, $password ){
        if ( !empty($login) && !empty($password) ) {
            $resultat = formConnexion( $login, $password );
            if ( $resultat != false ){
                accueil(false);
            }
        }
        accueil(false);
    }

    function CtlAjouterClient(){
        
    }

    function CtlSupprimerClient( $idClient ){

    }

    function CtlAjouterRendezVous( $dateRDV, $heureDebut, $heureFin){

    }

    function CtlSupprimerRendezVous( $id ){

    }

    