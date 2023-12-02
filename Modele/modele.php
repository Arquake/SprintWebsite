<?php
    include_once("connect.php");

    function getConnect() {
        $connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connexion->query('SET NAMES UTF8');

        return $connexion;
    }

    function formConnexion( $login, $password ){

        $connexion = getConnect();
        $resultat = $connexion -> query("SELECT * FROM Employe WHERE login='" . $login . "'");

        if ( $resultat != false || !empty($resultat) ){

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

            $connexion -> query("INSERT INTO EMPLOYE(login,password,poste) VALUES(login='" . $login . "', password='" . $password . "', poste='" . $poste . "')");

            return true;

        }

        return false;

    }