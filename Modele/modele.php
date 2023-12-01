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
        $resultat = $connexion -> query("SELECT password FROM Employe WHERE login='" . $login . "'");
        if ( $resultat == false || empty($resultat) ){
            return false;
        }
        return $resultat;
    }

    function employeInformations( $login ){
        $connexion = getConnect();
        $resultat = $connexion -> query("SELECT nom, prenom FROM Employe WHERE login='" . $login . "'");
        return $resultat;
    }