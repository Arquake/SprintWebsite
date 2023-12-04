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

        if ( $resultat != false ){

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
        
        $resultat = ($connexion -> query("SELECT nomEmploye, prenomEmploye FROM Employe WHERE login='" . $login . "'"))->fetch(PDO::FETCH_ASSOC);

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


    function createClient($nomClient,$prenomClient,$dateNaissance) {

        $connexion = getConnect();

        $connexion -> query("INSERT INTO Client(nomClient, prenomClient, dateNaissance, estInscrit) VALUES('".$nomClient."', '".$prenomClient."' ,'".$dateNaissance."', 0)");

        $resultat = ($connexion -> query("SELECT idClient FROM Client WHERE idClient=(SELECT MAX(idClient) FROM Client)"))->fetch(PDO::FETCH_ASSOC);

        return $resultat;
    }


    function getAllConseillers() {

        $connexion = getConnect();

        $resultat = ($connexion -> query("SELECT login, nomEmploye, prenomEmploye FROM Employe"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }


    function rattacherClientAgent() {

        $connexion = getConnect();

        $connexion -> query("INSERT INTO RattacherA(idClient, login, dateRattachement) VALUES('".$_SESSION['idClient']."', '".$_SESSION['login']."' ,CURRENT_DATE) ");

        return true;
    }