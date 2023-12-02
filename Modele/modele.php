<?php
    require_once("connect.php");

    function getConnect() {
        try {
            $connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connexion->query('SET NAMES UTF8');

            return $connexion;
        } catch ( Exception $e ){
            echo "<script>console.log('".$e."')</script>";
        }
        

        
    }

    function formConnexion( $login, $password ){

        echo "<script>console.log('there')</script>";

        $connexion = getConnect();

        echo "<script>console.log('oui')</script>";

        $resultat = $connexion -> query("SELECT * FROM Employe WHERE login='" . $login . "'");
        echo "<script>console.log('".!empty($resultat)."')</script>";

        if ( $resultat != false && !empty($resultat) != 1 ){

            //
            // password will be checked according to the hash given from the database
            //

            if ( password_verify($password, $resultat['password']) ) {

                return $resultat;

            }

        }

        return false;

    }

    function employeInformations( $login ){

        $connexion = getConnect();
        $resultat = $connexion -> query("SELECT nom, prenom FROM Employe WHERE login='" . $login . "'");

        return $resultat;

    }

    function createEmploye( $login, $password, $poste ){

        $connexion = getConnect();
        $resultat = $connexion -> query("SELECT login FROM Employe WHERE login='" . $login . "'");
        
        if ( $resultat != false || !empty($resultat) ){

            $connexion -> query("INSERT INTO EMPLOYE(login,password,poste) VALUES(login='" . $login . "', password='" . password_hash($password, PASSWORD_DEFAULT, ['cost' => 12] ) . "', poste='" . $poste . "')");

            return true;

        }

        return false;

    }