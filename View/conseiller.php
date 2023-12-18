<?php


    function accueilConseiller(){
        $contenu = connectedHeader();
        if ( isset($_SESSION['idClient']) ) {

            $contenu .= ConseillerAsideSideBarWhenClientConnected();

        } else {
            $contenu .= '
            <aside>
                <form action="index.php" method="post">
                    <ul>

                        <li><input class="asideInput" type="submit" value="Recherche Client" name="asideConseillerClientResearch"></li>

                        <li><input class="asideInput" type="submit" value="Plannings" name="asideConseillerPlanning"></li>

                    </ul>
                </form>
            </aside>';
        }
        require_once("View/gabarit.php");
    }

    function ConseillerAsideSideBarWhenClientConnected() {
        return '<aside>
        <form action="index.php" method="post">
                <ul>

                    <li><input class="asideInput" type="submit" value="Vendre Contrat" name="asideConseillerVendreContrat"></li>
                    <li><input class="asideInput" type="submit" value="Ouvrir Compte" name="asideConseillerOuvrirCompte"></li>
                    <li><input class="asideInput" type="submit" value="Modifier Découvert" name="asideConseillerModifDecouvert"></li>
                    <li><input class="asideInput" type="submit" value="Résiliation" name="asideConseillerResiliation"></li>
                    <li><input class="asideInput" type="submit" value="Nouvelle Recherche" name="asideClientNouvelleRecherche"></li>

                </ul>
            </form>
        </aside>';
    }

    function rechercheClientConseillerView($valid = true){
        $contenu = connectedHeader();
        $contenu .= '
        <aside>
            <form action="index.php" method="post">
                <ul>

                    <li><input class="asideInput" type="submit" value="Recherche Client" name="asideConseillerClientResearch"></li>

                    <li><input class="asideInput" type="submit" value="Plannings" name="asideConseillerPlanning"></li>

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

                    <p><label for="nomCreation">ID Client</label><input type="number" name="idClientRecherche" onBlur="validFormField( this, 1, 45 )"></p>
                        
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


    function rechercheApprofondiClientConseiller($res) {
        $contenu = connectedHeader();
        $contenu .= '
        <aside>
            <form action="index.php" method="post">
                <ul>

                    <li><input class="asideInput" type="submit" value="Recherche Client" name="asideConseillerClientResearch"></li>

                    <li><input class="asideInput" type="submit" value="Plannings" name="asideConseillerPlanning"></li>

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


    function mainPageClientConseiller() {
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected();
        require_once("View/gabarit.php");
    } 


    function inscrireClient( $clientInformation) {

        $contenu = connectedHeader() . '
            <aside>
                <form action="index.php" method="post">
                    <ul>

                        <li><input class="asideInput" type="submit" value="Nouvelle Recherche" name="asideClientNouvelleRecherche"></li>

                    </ul>
                </form>
            </aside>
            
            
            <form action="index.php" method="post" class="topPageForm" id="topPageForm">

                <fieldset>

                    <legend>Inscrire Client</legend>

                        <p><label for="nomClientInscription">Nom du Client</label><input type="text" name="nomClientInscription" value="'.$clientInformation['nomClient'].'"></p>

                        <p><label for="prenomClientInscription">Prénom du Client</label><input type="text" name="prenomClientInscription" value="'.$clientInformation['prenomClient'].'"></p>

                        <p><label for="dateNaissanceClientInscription">Date de Naissanse du Client</label><input type="date" name="dateNaissanceClientInscription" value="'.$clientInformation['dateNaissance'].'"></p>

                        <p><label for="telephoneClientInscription">Numéro de téléphone</label><input type="number" name="telephoneClientInscription"></p>

                        <p><label for="mailClientInscription">Adresse mail</label><input type="text" name="mailClientInscription"></p>

                        <p><label for="adresseClientInscription">Adresse</label><input type="text" name="adresseClientInscription"></p>

                        <p><label for="codePostalClientInscription">Code Postal</label><input type="number" name="codePostalClientInscription"></p>

                        <p><label for="professionClientInscription">Profession</label><input type="text" name="professionClientInscription"></p>

                        <p><label for="situationClientInscription">Situation</label><input type="text" name="situationClientInscription"></p>

                        <p><label for="revenuClientInscription">Revenu Mensuel</label><input type="number" name="revenuClientInscription"></p>

                        <p><label for="decouvertClientInscription">Montant Decouvert</label><input type="number" name="decouvertClientInscription"></p>

                    <p><input class="submitFormInput" type="submit" value="Inscrire" name="inscrireClientSubmit"></p>
                </fieldset>
            </form>';

        require_once("View/gabarit.php");
    }


    function venteContrat( $typeContrats ) {
        $contenu = connectedHeader() . ConseillerAsideSideBarWhenClientConnected() . '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <fieldset>

                <legend>Vendre Contrat</legend>

                    <label for="contratType">Type de Contrat</label>
                    <select id="contratType" name="contratType">';

                    foreach ( $typeContrats as $contrat){
                        
                        $contenu .= "<option value=".$contrat['type'].">".$contrat['type']."</option>";

                    }


        $contenu .= '
                    </select>

                <p><input class="submitFormInput" type="submit" value="Inscrire" name="venteContratSubmit"></p>
            </fieldset>
        </form>';

        require_once("View/gabarit.php");
    }


    function ouvertureCompte( $typeCompte ) {
        $contenu = connectedHeader() . ConseillerAsideSideBarWhenClientConnected() . '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <fieldset>

                <legend>Ouvrir Compte</legend>

                    <label for="compteType">Type de Compte</label>
                    <select id="compteType" name="compteType">';

                    foreach ( $typeCompte as $compte){
                        
                        $contenu .= "<option value=".$compte['type'].">".$compte['type']."</option>";

                    }


        $contenu .= '
                    </select>

                <p><input class="submitFormInput" type="submit" value="Inscrire" name="creerCompteSubmit"></p>
            </fieldset>
        </form>';

        require_once("View/gabarit.php");
    }


    function modificationDecouvert( $listeCompte ) {
        $contenu = connectedHeader() . ConseillerAsideSideBarWhenClientConnected() . '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <fieldset>

                <legend>Modifier Découvert</legend>

                    <label for="decouvertList">Type de Compte</label>
                    <select id="decouvertList" name="decouvertList">';

                    foreach ( $listeCompte as $compte){
                        
                        $contenu .= "<option value=".$compte['idCompte'].">".$compte['type']." - ".$compte['idCompte']." - [ ".$compte['Decouvert']." ]</option>";

                    }


        $contenu .= '
                    </select>

                <p><input class="submitFormInput" type="submit" value="Inscrire" name="creerCompteSubmit"></p>
            </fieldset>
        </form>';

        require_once("View/gabarit.php");
    }


    function resilier( $comptes, $contrats) {
        $contenu = connectedHeader() . ConseillerAsideSideBarWhenClientConnected() . '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <fieldset>

                <legend>Résilier</legend>

                    <label for="resiliation">Type de Compte</label>
                    <select id="resiliation" name="resiliation">';

                    foreach ( $comptes as $compte){
                        
                        $contenu .= "<option value=".$compte['idCompte'].">".$compte['type']." - ".$compte['idCompte']."</option>";

                    }

                    foreach ( $contrats as $contrat){
                        
                        $contenu .= "<option value=".$contrat['idContrat'].">".$contrat['type']." - ".$contrat['idContrat']."</option>";

                    }


        $contenu .= '
                    </select>

                <p><input class="submitFormInput" type="submit" value="Inscrire" name="creerCompteSubmit"></p>
            </fieldset>
        </form>';

        require_once("View/gabarit.php");
    }