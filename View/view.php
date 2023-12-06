<?php

    require_once("agent.php");
    require_once("conseiller.php");
    require_once("directeur.php");

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
                <p><input class="submitFormInput" type="submit" value="Connexion" name="connexion"></p>
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


    function afficherEDT($login=false,$semaineRequete=false) {

        $emploiDuTemps = '
        <table>
            <tr>
            <th>Semaine Du '.$semaineRequete.'</th>
            <th>Lundi</th>
            <th>Mardi</th>
            <th>Mercredi</th>
            <th>Jeudi</th>
            <th>Vendredi</th>
            <th>Samedi</th>
            <th>Dimanche</th>
            </tr>';

        for ( $i = 8 ; $i < 20 ; $i++ ) {
            $emploiDuTemps .= '<tr>';
            for ( $j = 0 ; $j < 60 ; $j += 15) {
                if ( $j != 0 ) {
                    $emploiDuTemps .= '<td>'.$i.' H '.$j.'</td>';
                } else {
                    $emploiDuTemps .= '<td>'.$i.' H</td>';
                }
                
                for ( $k = 0 ; $k < 7 ; $k++){
                    $emploiDuTemps .= '<td></td>';
                }
                $emploiDuTemps .= '</tr>';
            }
        }
        $emploiDuTemps .= '<tr>';
        $emploiDuTemps .= '<td>20 H</td>';
        for ( $k = 0 ; $k < 7 ; $k++){
            $emploiDuTemps .= '<td></td>';
        }
        $emploiDuTemps .= '</tr></table>';

        return $emploiDuTemps;
    }


    