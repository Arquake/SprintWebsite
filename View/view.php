<?php

    function accueil($validForm = true){
        $contenu = '<aside></aside>';
        if ( !$validForm ){
            $contenu .= '<div class="invalidForm">Formulaire non valide<br>mot de passe ou login incorrect</div>';
        };
        $contenu .= '
        <form action="index.php" method="post" class="connexionForm" onSubmit="connexionSubmitCheck(this)">
            <fieldset>
                <legend>Connexion</legend>
                <p><label for="">Login</label><input type="text" name="login" onBlur="validFormField( this, 8, 32 )" required="required"></p>
                <p><label for="">Mot De Passe</label><input type="password" name="password" onBlur="validFormField( this, 8, 32 )" required="required"></p>
                <p><input type="submit" value="Connexion" name="connexion"></p>
            </fieldset>
        </form>';
        require_once("View/gabarit.php");
    }