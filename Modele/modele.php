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
        $resultat = $connexion -> query('SELECT * FROM Client');
        if ( $resultat == false || empty($resultat) ){
            return false;
        }
        return $resultat;
    }