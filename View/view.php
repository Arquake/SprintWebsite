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
        <div class="error"><a class="errorATag" href="index.php">Cliquez ici pour retourner à l\'accueil</a></div>';
        require_once("View/gabarit.php");
    }




    function connectedHeader() {
        return '
        <header>
            <form action="index.php" method="POST" id="topForm">
                <input type="image" src="View/style/assets/logo.png" alt="Submit" id="logo" name="menu">

                <input class="topFormInformation" type="text" name="login" value="'.$_SESSION['prenom'].' '.$_SESSION['nom'].'" disabled="disabled">

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
                    $emploiDuTemps .= '<th>'.$i.' H '.$j.'</th>';
                } else {
                    $emploiDuTemps .= '<th>'.$i.' H 00</th>';
                }
                
                for ( $k = 0 ; $k < 7 ; $k++){
                    $emploiDuTemps .= '<td><input type="button" class="priseRDVButton"></td>';
                }
                $emploiDuTemps .= '</tr>';
            }
        }
        $emploiDuTemps .= '<tr>';
        $emploiDuTemps .= '<th>20 H</th>';
        for ( $k = 0 ; $k < 7 ; $k++){
            $emploiDuTemps .= '<td><input type="button" class="priseRDVButton"></td>';
        }
        $emploiDuTemps .= '</tr></table>';

        return $emploiDuTemps;
    }


    function clientSynthesis($synthèse) {
        $contenu = connectedHeader();

        if ( $_SESSION['poste'] == 'Agent' ) {

                $contenu .= AgentAsideSideBarWhenClientConnected();

                $contenu .= '<div class="clientSynthesis">
                <h1>Synthèse du client</h1>
                <p>ID du client : ' . $synthèse['idClient'] . '</p>
                <p>Nom du client : ' . $synthèse['nomClient'] . '</p>
                <p>Prénom du client : ' . $synthèse['prenomClient'] . '</p>
                </div>';

        } else if ( $_SESSION['poste'] == 'Conseiller' ) {

            $contenu .= '';

        } else { 

            $contenu .= '';

        }

        require_once("View/gabarit.php");

    }