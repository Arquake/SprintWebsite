<?php

    function accueil($validForm = true){
        $contenu = '<aside></aside>';
        if ( !$validForm ){
            $contenu .= '<div class="invalidForm">Formulaire non valide<br>mot de passe ou login incorrect</div>';
        };
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm" onSubmit="connexionAttempt(this)">
            <fieldset>
                <legend>Connexion</legend>
                <p><label for="login">Login</label><input type="text" name="login" onBlur="validFormField( this, 2, 32 )" required="required"></p>
                <p><label for="password">Mot De Passe</label><input type="password" name="password" onBlur="validFormField( this, 8, 32 )" required="required"></p>
                <p><input type="submit" value="Connexion" name="connexion"></p>
            </fieldset>
        </form>';
        require_once("View/gabarit.php");
    }


    function error(){
        $contenu = '
        <aside></aside>
        <div class="invalidForm">Une erreur s\'est produite</div>
        <div class="error"><a class="errorATag" href="index.php">Cliquez ici pour recharger la page</a></div>';
        require_once("View/gabarit.php");
    }

    function accueilAgent(){
        require_once("View/gabarit.php");
    }

    function accueilConseiller(){
        require_once("View/gabarit.php");
    }

    function accueilDirecteur(){
        require_once("View/gabarit.php");
    }

    function gestionEmployeDirecteur($employeCreated = false){
        $contenu = '<aside></aside>';
        if ( $employeCreated ){
            $contenu .= '<div class="invalidForm">Employé créé</div>';
        } else {
            $contenu .= '<div class="invalidForm">Erreur</div>';
        }
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm" onSubmit="connexionAttempt(this)">
            <fieldset>
                <legend>Connexion</legend>
                <p><label for="login">Login</label><input type="text" name="login" onBlur="validFormField( this, 2, 32 )" required="required"></p>
                <p><label for="password">Mot De Passe</label><input type="password" name="password" onBlur="validFormField( this, 8, 32 )" required="required"></p>
                <p><input type="submit" value="Connexion" name="connexion"></p>
            </fieldset>
        </form>';
        require_once("View/gabarit.php");
    }