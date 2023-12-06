<?php

    function accueilAgent(){
            $contenu = connectedHeader();
            $contenu .= '
            <aside>
                <form action="index.php" method="post">
                    <ul>

                        <li><input class="asideInput" type="submit" value="Recherche Client" name="asideAgentClientResearch"></li>

                        <li><input class="asideInput" type="submit" value="Créer Client" name="asideClientCreation"></li>

                    </ul>
                </form>
            </aside>';
            require_once("View/gabarit.php");
        }

    function creationClientAgent($error = true) {
        $contenu = connectedHeader();
        $contenu .= '
        <aside>
            <form action="index.php" method="post">
                <ul>

                    <li><input class="asideInput" type="submit" value="Recherche Client" name="asideAgentClientResearch"></li>

                    <li><input class="asideInput" type="submit" value="Créer Client" name="asideClientCreation"></li>

                </ul>
            </form>
        </aside>';
        if ( !$error ){
            $contenu .= '<div class="invalidForm">Formulaire non valide !</div>';
        };
        $contenu .= '
        
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">
            <fieldset>
                <legend>Création du Client</legend>

                    <p><label for="nomClientCreation">Nom du Client</label><input type="text" name="nomClientCreation" onBlur="validFormField( this, 1, 45 )"></p>

                    <p><label for="prenomClientCreation">Prénom du Client</label><input type="text" name="prenomClientCreation" onBlur="validFormField( this, 2, 45 )"></p>

                    <p><label for="dateNaissanceClientCreation">Date de Naissanse du Client</label><input type="date" name="dateNaissanceClientCreation" onBlur="validFormField( this, 2, 32 )"></p>

                    <p><input class="submitFormInput" type="submit" value="Créer le Client" name="creationClientAgentSubmit"></p>
            </fieldset>
        </form>

        ';
        require_once("View/gabarit.php");
        
    }

    function rechercheClientAgentView($valid = true){
        $contenu = connectedHeader();
        $contenu .= '
        <aside>
            <form action="index.php" method="post">
                <ul>

                    <li><input class="asideInput" type="submit" value="Recherche Client" name="asideAgentClientResearch"></li>

                    <li><input class="asideInput" type="submit" value="Créer Client" name="asideClientCreation"></li>

                </ul>
            </form>
        </aside>';
        if ( !$valid ){
            $contenu .= '<div class="invalidForm">Aucun client ne<br>correspond à la recherche</div>';
        };
        $contenu .= '
        
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <fieldset>

                <legend>Recherche Client</legend>

                <fieldset>
                    <legend>Rechercher par ID</legend>

                    <p><label for="nomCreation">ID Client</label><input type="number" name="idClientRecherche" onBlur="validFormField( this, 2, 45 )"></p>
                        
                </fieldset>

                <fieldset>
                    <legend>Rechercher par Informations Client</legend>

                    <p><label for="nomClientrRecherche">Nom du Client</label><input type="text" name="nomClientRecherche" onBlur="validFormField( this, 1, 45 )"></p>

                    <p><label for="prenomClientRecherche">Prénom du Client</label><input type="text" name="prenomClientRecherche" onBlur="validFormField( this, 2, 45 )"></p>

                    <p><label for="dateNaissanceClientRecherche">Date de Naissanse du Client</label><input type="date" name="dateNaissanceClientRecherche" onBlur="validFormField( this, 2, 32 )"></p>


                </fieldset>

                <p><input class="submitFormInput" type="submit" value="Rechercher" name="rechercheClientSubmit"></p>
            </fieldset>
        </form>
        
        ';
        require_once("View/gabarit.php");
    }


    function rechercheApprofondiClient($res) {
        $contenu = connectedHeader();
        $contenu .= '
        <aside>
            <form action="index.php" method="post">
                <ul>

                    <li><input class="asideInput" type="submit" value="Recherche Client" name="asideAgentClientResearch"></li>

                    <li><input class="asideInput" type="submit" value="Créer Client" name="asideClientCreation"></li>

                </ul>
            </form>
        </aside>
        
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <fieldset>

                <legend>Liste Des Clients</legend>';

                foreach ( $res as $client){
            
                    $contenu .= '
                        <p><label for="'.$client['idClient'].'">'.$client['nomClient']."    ".$client['prenomClient']."     ".$client['dateNaissance'].'</label>
                        <input type="radio" id="'.$client['idClient'].'" name="clientRechercheChoice" value="'.$client['idClient'].'"></p>';
        
                }


        $contenu .= '

                <p><input class="submitFormInput" type="submit" value="Selectionner" name="rechercheSelectionClientSubmit"></p>
            </fieldset>
        </form>
        
        ';
        require_once("View/gabarit.php");
    }


    function rattacherClient($conseillerList) {
        $contenu = connectedHeader();
        $contenu .= '
        <aside>
        </aside>
        <form action="index.php" method="post" class="topPageForm" onSubmit="clientRattachementCreation(this)" id="topPageForm">
            <fieldset>
                <p>
                    <label for="posteRattachement">Conseiller à Rattacher</label>
                    <select id="posteRattachement" name="posteRattachement">';

        foreach ( $conseillerList as $conseiller){
            
            $contenu .= "<option value=".$conseiller['login'].">".$conseiller['nomEmploye']."  ".$conseiller['prenomEmploye']."</option>";

        }


        $contenu .= '
                    </select>
                </p>
            </fieldset>
            <p><input class="submitFormInput" type="submit" value="Rattacher" name="rattacherClientSubmit"></p>
        </form>
        ';
        require_once("View/gabarit.php");
    }


    function mainPageClientAgent() {
        $contenu = connectedHeader();
        $contenu .= '
        <aside>
            <form action="index.php" method="post">
                <ul>

                    <li><input class="asideInput" type="submit" value="Synthèse Client" name="asideClientSynthèse"></li>

                    <li><input class="asideInput" type="submit" value="Modification Client" name="asideClientModification"></li>

                    <li><input class="asideInput" type="submit" value="Transaction" name="asideClientTransaction"></li>

                    <li><input class="asideInput" type="submit" value="Prise Rendez-Vous" name="asideClientPriseRendezVous"></li>

                    <li><input class="asideInput" type="submit" value="Nouvelle Recherche" name="asideClientNouvelleRecherche"></li>

                </ul>
            </form>
        </aside>';
        require_once("View/gabarit.php");
}