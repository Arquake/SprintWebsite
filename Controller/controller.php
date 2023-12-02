<?php

    require_once("View/view.php");
    require_once("Modele/modele.php");


    function CtlError( $exception ){
        error();
    }

    function CtlAccueil(){
        accueil();
    }

    function CtlConnexion( $login, $password ){

        //
        // If $login && $password aren't empty entre the loop
        //

        if ( ( !empty($login) && !empty($password) ) ) {

            //
            // $resultat gets the login, password, poste from the database
            // if $resultat is false client will be send back to the form with an error message
            //

            $resultat = formConnexion( $login, $password );

            if ( $resultat != false ){

                //
                // poste && login will be stored in the $_SESSION for future uses and database access
                // name && surname are also stored to display on top of the screen
                //

                $_SESSION['poste'] = $resultat['poste'];
                $_SESSION['login'] = $login;

                $resultat = employeInformations( $login );

                $_SESSION['nom'] = $resultat['nom'];
                $_SESSION['prenom'] = $resultat['prenom'];

                //
                // try to match $poste with the correct page to show
                //

                if ( $_SESSION['poste'] == "Agent" ){
                    echo "<script>console.log('Agent')</script>";
                } else if ( $_SESSION['poste'] == "Conseiller" ){
                    echo "<script>console.log('Conseiller')</script>";
                } else {
                    echo "<script>console.log('Directeur')</script>";
                }

            }

            accueil();

        }

        accueil(false);

    }

    function CtlAjouterEmploye ( $login, $password, $poste ,$nom, $prenom ){

        $created = createEmploye( $login, $password, $poste ,$nom, $prenom);

        echo "<script>console.log('".$created."')</script>";

        gestionEmployeDirecteur($created);

    }

    function CtlAjouterClient(){
        
    }

    function CtlSupprimerClient( $idClient ){

    }

    function CtlAjouterRendezVous( $dateRDV, $heureDebut, $heureFin){

    }

    function CtlSupprimerRendezVous( $id ){

    }

    