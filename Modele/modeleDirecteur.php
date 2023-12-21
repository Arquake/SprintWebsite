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
    // récupère les logins, noms, prenoms, postes de tout les employes
    // 

    function informationConnexionDirecteur() {
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT login, nomEmploye, prenomEmploye, poste FROM Employe"))->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }


    //
    // NV
    //
    // récupère le login, nom, prenom, poste de l'employe selectionné
    //

    function informationConnexionEmployeDirecteur( $employe = false ) {
        $connexion = getConnect();
        
        if ( $employe == false ) {
            $resultat = ($connexion -> query("SELECT login, nomEmploye, prenomEmploye, poste FROM Employe WHERE login='".$_POST['modifierLemploye']."'"))->fetch(PDO::FETCH_ASSOC);
        } else {
            $resultat = ($connexion -> query("SELECT login, nomEmploye, prenomEmploye, poste FROM Employe WHERE login='".$employe."'"))->fetch(PDO::FETCH_ASSOC);
        }

        return $resultat;
    }


    //
    // NV
    //
    // modifie les informations de l'employe selectionné
    //

    function modificationInformationEmployeDirecteur() {
        $connexion = getConnect();
        if ( isset($_POST['passwordCheckbox'])) {
            $connexion -> query("UPDATE employe SET login='".$_POST['loginCreation']."',password='".$_POST['passwordCreation']."',poste='".$_POST['posteCreation']."',nomEmploye='".$_POST['nomCreation']."',prenomEmploye='".$_POST['prenomCreation']."' WHERE login='".$_SESSION['employeChoisiInformationLogin']."'");
        } else {
            $connexion -> query("UPDATE employe SET login='".$_POST['loginCreation']."',poste='".$_POST['posteCreation']."',nomEmploye='".$_POST['nomCreation']."',prenomEmploye='".$_POST['prenomCreation']."' WHERE login='".$_SESSION['employeChoisiInformationLogin']."'");
        }
    }


    //
    // NV
    //
    // vérifie si le login n'existe pas encore
    // false n'esxiste pas | true existe déjà
    //

    function loginCheckIfExistDirecteur() {
        $connexion = getConnect();
        $resultat = ($connexion -> query("SELECT login FROM Employe WHERE login='".$_POST['loginCreation']."'"))->fetch(PDO::FETCH_ASSOC);
        if ( !empty($resultat) ) { return true; }
        return false;
    }