<?php

    //
    // NV
    //
    // on vérifie si le login n'existe pas déjà
    // Si il n'existe pas on créé l'employé en chiffrant le mot de passe avec un coût de 12
    //

    function createEmploye( $login, $password, $poste, $nomEmploye, $prenomEmploye ){

        $connexion = getConnect();
        $resultat = $connexion -> query("SELECT login FROM Employe WHERE login='" . $login . "'");
        
        if ( $resultat != false && empty($resultat) == 0 ){

            $connexion -> query("INSERT INTO Employe(login,password,poste,nomEmploye,prenomEmploye,dateEmbauche) VALUES('" . $login . "', '" . password_hash($password, PASSWORD_DEFAULT, ['cost' => 12] ) . "', '" . $poste . "', '" . $nomEmploye . "', '" . $prenomEmploye . "', '" . date('Ymd') . "')");

            return true;

        }

        return false;

    }


    //
    // NV
    //
    // récupère les logins, nom, prenoms, postes
    // 

    function informationConnexionDirecteur() {
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT login, nomEmploye, prenomEmploye, poste FROM Employe"))->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }


    //
    // NV
    //
    //
    //

    function informationConnexionEmployeDirecteur() {
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT login, nomEmploye, prenomEmploye, poste FROM Employe WHERE login='".$_POST['modifierLemploye']."'"))->fetch(PDO::FETCH_ASSOC);
        return $resultat;
    }