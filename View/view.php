<?php

    function accueil(){
        $contenu = '
        <aside></aside>
        <form action="index.php" method="post" class="connexionForm" onSubmit="connexionSubmitCheck(this)">
            <fieldset>
                <legend>Connexion</legend>
                <p><label for="">Login</label><input type="text" name="login" onBlur="validFormField( this, 8, 32 )"></p>
                <p><label for="">Mot De Passe</label><input type="password" name="password" onBlur="validFormField( this, 8, 32 )"></p>
                <p><input type="submit" value="Connexion" name="connexion"></p>
            </fieldset>
        </form>';
        require_once("View/gabarit.php");
    }