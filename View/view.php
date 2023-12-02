<?php

    function accueil($validForm = true){
        $contenu = '
        <header><img src="View/style/assets/logo.png" alt="" id="logo"></header>
        <aside></aside>';
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
        <header><img src="View/style/assets/logo.png" alt="" id="logo"></header>
        <aside></aside>
        <div class="invalidForm">Une erreur s\'est produite</div>
        <div class="error"><a class="errorATag" href="index.php">Cliquez ici pour recharger la page</a></div>';
        require_once("View/gabarit.php");
    }




    function accueilAgent(){
        $contenu = connectedHeader();
        require_once("View/gabarit.php");
    }


    function accueilConseiller(){
        $contenu = connectedHeader();
        require_once("View/gabarit.php");
    }


    function accueilDirecteur(){
        $contenu = connectedHeader();
        require_once("View/gabarit.php");
    }


    function connectedHeader() {
        return '
        <header>
            <img src="View/style/assets/logo.png" alt="" id="logo">
            <form action="index.php" method="POST" id="signOutForm">
                <input type="image" src="View/style/assets/logout.png" alt="Submit" id="signOut" name="deconnexion">
            </form>
        </header>
        ';
    }




    function gestionEmployeDirecteur($employeCreated = false){
        $contenu = '<aside></aside>';
        if ( $employeCreated ){
            $contenu .= '<div class="invalidForm">Employé créé</div>';
        } else {
            $contenu .= '<div class="invalidForm">Erreur</div>';
        }
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" onSubmit="createEmployeCheck(this)" id="topPageForm">
            <fieldset>
                <legend>Création d\'employé</legend>
                <p><label for="nomCreation">Nom de l\'employé</label><input type="text" name="nomCreation" onBlur="validFormField( this, 2, 45 )" required="required"></p>
                <p><label for="prenomCreation">Prénom de l\'employé</label><input type="text" name="prenomCreation" onBlur="validFormField( this, 2, 45 )" required="required"></p>
                <p><label for="loginCreation">Login de l\'employé</label><input type="text" name="loginCreation" onBlur="validFormField( this, 2, 32 )" required="required"></p>
                <p><label for="password">Mot De Passe de l\'employé</label><input type="password" name="passwordCreation" onBlur="validFormField( this, 8, 32 )" required="required"></p>
                <p>
                    <label for="posteCreation">Poste de l\'empolyé</label>
                    <select id="posteCreation" name="posteCreation">
                        <option value="Agent">Agent</option>
                        <option value="Conseiller">Conseiller</option>
                        <option value="Directeur">Directeur</option>
                    </select>
                </p>
                <p><input type="submit" value="Créer" name="createEmploye"></p>
            </fieldset>
        </form>';
        require_once("View/gabarit.php");
    }