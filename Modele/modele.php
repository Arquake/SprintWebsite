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

        $connexion = getConnect();

        /*WHERE login='" . $login . "'*/
        $resultat = $connexion -> query("SELECT * FROM Employe WHERE login='" . $login . "'");
        $resultat = $resultat->fetch(PDO::FETCH_ASSOC);

        echo "<script>console.log('".var_dump($resultat)."')</script>";

        if ( $resultat != false ){

            //
            // password will be checked according to the hash given from the database
            //

            echo "<script>console.log('".var_dump($resultat)."')</script>";

            if ( password_verify($password, $resultat['password']) ) {

                return $resultat;

            }

        }

        return false;

    }

    function employeInformations( $login ){

        $connexion = getConnect();
        
        $resultat = $connexion -> query("SELECT nomEmploye, prenomEmploye FROM Employe WHERE login='" . $login . "'");

        return $resultat;

    }

    function createEmploye( $login, $password, $poste, $nomEmploye, $prenomEmploye ){

        $connexion = getConnect();
        $resultat = $connexion -> query("SELECT login FROM Employe WHERE login='" . $login . "'");
        
        if ( $resultat != false && empty($resultat) == 0 ){

            $connexion -> query("INSERT INTO Employe(login,password,poste,nomEmploye,prenomEmploye,dateEmbauche) VALUES('" . $login . "', '" . password_hash($password, PASSWORD_DEFAULT, ['cost' => 12] ) . "', '" . $poste . "', '" . $nomEmploye . "', '" . $prenomEmploye . "', '" . date('Ymd') . "')");

            return true;

        }

        return false;

    }