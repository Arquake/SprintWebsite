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

    function creationClientAgent(){
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
        
        <form action="index.php" method="post" class="topPageForm" id="topPageForm" onSubmit="connexionAttempt(this)">
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

    function rechercheClientAgent(){
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
        
        <form action="index.php" method="post" class="topPageForm" onSubmit="clientResearch(this)" id="topPageForm">

            <fieldset>

                <legend>Recherche Client</legend>

                <fieldset>
                    <legend>Rechercher par ID</legend>

                    <p><label for="nomCreation">ID Client</label><input type="number" name="idClientRecherche" onBlur="validFormField( this, 2, 45 )"></p>
                        
                </fieldset>

                <fieldset>
                    <legend>Rechercher par Informations Client</legend>

                    <p><label for="nomClientrRecherche">Nom du Client</label><input type="text" name="nomClientrRecherche" onBlur="validFormField( this, 1, 45 )"></p>

                    <p><label for="prenomClientRecherche">Prénom du Client</label><input type="text" name="prenomClientRecherche" onBlur="validFormField( this, 2, 45 )"></p>

                    <p><label for="dateNaissanceClientRecherche">Date de Naissanse du Client</label><input type="date" name="dateNaissanceClientRecherche" onBlur="validFormField( this, 2, 32 )"></p>


                </fieldset>

                <p><input class="submitFormInput" type="submit" value="Rechercher" name="rechercheClientSubmit"></p>
            </fieldset>
        </form>
        
        ';
        require_once("View/gabarit.php");
    }


    function mainPageClientAgent(){
        $contenu = connectedHeader();
            $contenu .= '
            <aside>
                <form action="index.php" method="post">
                    <ul>

                        <li><input class="asideInput" type="submit" value="Synthèse Client" name="asideClientSynthèse"></li>

                        <li><input class="asideInput" type="submit" value="Modification Client" name="asideClientModification"></li>

                        <li><input class="asideInput" type="submit" value="Transaction" name="asideClientModification"></li>

                        <li><input class="asideInput" type="submit" value="Prise Rendez-Vous" name="asideClientModification"></li>

                        <li><input class="asideInput" type="submit" value="Nouvelle Recherhce" name="asideClientDisconnect"></li>

                    </ul>
                </form>
            </aside>';
            require_once("View/gabarit.php");
    }