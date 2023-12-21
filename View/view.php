<?php

    require_once("agent.php");
    require_once("conseiller.php");
    require_once("directeur.php");


    //
    // NV
    //
    // affiche la page de connexion
    //

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


    //
    // NV
    //
    // Affiche cette page en cas d'erreur dans l'index
    //

    function error(){
        $contenu = '
        <header><img src="View/style/assets/logo.png" alt="" id="logo"></header>
        <aside></aside>
        <div class="invalidForm">Une erreur s\'est produite</div>
        <div class="error"><a class="errorATag" href="index.php">Cliquez ici pour retourner à l\'accueil</a></div>';
        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // Header avec le logo le bouton de déconnexion et le Prénom et Nom de l'agent connecté
    //

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


    //
    // G
    //
    // page de la synthèse client
    //

    function clientSynthesis($synthèse) {
        $contenu = connectedHeader();

        if ( $_SESSION['poste'] == 'Conseiller' ) {

                $contenu .= ConseillerAsideSideBarWhenClientConnected() . '
                <div class="clientSynthesis">
                    <h1>Synthèse du client</h1>
                    <p>ID du client : ' . $synthèse['idClient'] . '</p>
                    <p>Nom du client : ' . $synthèse['nomClient'] . '</p>
                    <p>Prénom du client : ' . $synthèse['prenomClient'] . '</p>
                </div>';

        }  else { 

            $contenu .= '';

        }

        require_once("View/gabarit.php");

    }

    
    //
    // NV
    //
    // création de bulle dans l'EDT
    //

    function EDTBubble($arr){
        if ( $arr['idClient'] != -1 ) {
            return '
            <td class="edttdHoraire">
            <form method="post">
                <button name="clientButtonResearch" class="insidetd" value="'.$arr['idClient'].'">
                    <div class="horaires">
                        '.$arr['heureDebut'].'
                        <br>
                        '.$arr['heureFin'].'
                    </div>
                    <div class="indordvtd">
                        idRDV : '.$arr['idRdv'].'
                    </div>
                    <div class="indordvtd">
                        client : '.$arr['idClient'].'
                    </div>
                    <div class="indordvtd">
                        motif : '.$arr['idMotif'].'
                    </div>
                </button>
            </form>
            </td>';
        }

        return '
            <td class="edttdHoraire">
                <div class="formation">
                    <div class="horaires">
                        '.$arr['heureDebut'].'
                        <br>
                        '.$arr['heureFin'].'
                    </div>
                    <div class="indordvtd">
                        idRDV : '.$arr['idRdv'].'
                    </div>
                    <div class="indordvtd">
                        motif : '.$arr['idMotif'].'
                    </div>
                </div>
            </td>';
    }

