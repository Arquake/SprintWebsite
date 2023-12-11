<?php

    function AgentAsideSideBarWhenClientConnected() {
        $contenu = '
        <aside>
            <form action="index.php" method="post">
                <ul>

                    <li><input class="asideInput" type="submit" value="Synthèse Client" name="asideClientSynthese"></li>

                    <li><input class="asideInput" type="submit" value="Modification Client" name="asideClientModification"></li>

                    <li><input class="asideInput" type="submit" value="Transaction" name="asideClientTransaction"></li>

                    <li><input class="asideInput" type="submit" value="Prise Rendez-Vous" name="asideClientPriseRendezVous"></li>

                    <li><input class="asideInput" type="submit" value="Nouvelle Recherche" name="asideClientNouvelleRecherche"></li>

                </ul>
            </form>
        </aside>';

        return $contenu;
    }

    function accueilAgent(){
        $contenu = connectedHeader();
        if ( isset($_SESSION['idClient']) ) {

            $contenu .= AgentAsideSideBarWhenClientConnected();

        } else {
            $contenu .= '
            <aside>
                <form action="index.php" method="post">
                    <ul>

                        <li><input class="asideInput" type="submit" value="Recherche Client" name="asideAgentClientResearch"></li>

                        <li><input class="asideInput" type="submit" value="Créer Client" name="asideClientCreation"></li>

                    </ul>
                </form>
            </aside>';
        }
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
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected();
        require_once("View/gabarit.php");
    } 

    // SELECTIONNER LE COMPTE SUR LEQUEL EFFECTUER LA TRANSACTION
    function transactionChoixClientAgentView($compteList){
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
        </aside>
        <form action="index.php" method="post" class="transactionForm" id="transactionForm">
            <fieldset>
                <legend>Effectuer Transaction</legend>
                <p>
                    <label for="compteSelection">Compte disponible :</label>
                    <select id="compteSelection" name="compteSelection">';

        foreach ( $compteList as $compte){
            
            $contenu .= "<option value=".$compte['idCompte'].">".$compte['type']." - ".$compte['solde']." €</option>";

        }


        $contenu .= '
                    </select>
                </p>
                <p>
                    <label for"retrait">Retrait</label><input id="retrait" type="radio" name="radioTransaction" value="retrait" checked>
                </p>
                <p>
                    <label for"depot">Dépot</label><input id="depot" type="radio" name="radioTransaction" value="depot">
                </p>
                <p><input class="submitFormInput" type="submit" value="Selectionner" name="selectionnerCompteClientSubmit"></p>
            </fieldset>
            
        </form>
        ';
        
        require_once("View/gabarit.php");
    }

    //Affiche le panel pour retirer de l'argent sur le compte en session
    function transactionRetraitClientAgentView($compte) {
        $contenu = connectedHeader();
        $contenu .= '
        <aside></aside>
        
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <p class="afficherBeauP">Compte séléctionné pour <strong>retrait</strong> : ';
            
            foreach ( $compte as $item){
            
                $contenu .= $item['type']." - ".$item['solde']." €</p>";
    
            }
            
            $contenu .= '

            <fieldset>
                <legend>Retrait</legend>

                <p><label for="retrait">Montant du retrait</label>
                <input type="number" name="retrait"></p> 
                <p><input class="submitFormInput" type="submit" value="Soumettre" name="outPutTransactionRetraitCompteClient"></p>
            </fieldset>

            
        </form>
        
        ';
        require_once("View/gabarit.php");
    }

     //Affiche le panel pour deposer de l'argent sur le compte en session
     function transactionDepotClientAgentView($compte) {

        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected() .'
        <aside></aside>        

        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <p class="afficherBeauP">Compte séléctionné pour <strong>dépot</strong> : ';
            
            foreach ( $compte as $item){
            
                $contenu .= $item['type']." - ".$item['solde']." €</p>";
    
            }
            
            $contenu .= '

            <fieldset>
                <legend>Dépot</legend>

                <p><label for="depot">Montant du dépot</label>
                <input type="number" name="depot"></p>
                <p><input class="submitFormInput" type="submit" value="Soumettre" name="outPutTransactionDepotCompteClient"></p>
            </fieldset>

            
        </form>
        
        ';
        require_once("View/gabarit.php");
    }


    function AgentclientModificationPage() {
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected() . '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <fieldset>

                <legend>Modifier Client</legend>

                <p><label for="nomClientModification">Nom du Client</label><input type="text" name="nomClientModification" value="'.$_SESSION['clientNom'].'"></p>

                <p><label for="prenomClientModification">Prénom du Client</label><input type="text" name="prenomClientModification" value="'.$_SESSION['clientPrenom'].'"></p>

                <p><label for="dateNaissanceClientModification">Date de Naissanse du Client</label><input type="date" name="dateNaissanceClientModification" value="'.$_SESSION['clientNaissance'].'"></p>


                <p><input class="submitFormInput" type="submit" value="Modifier" name="ModificationClientSubmit"></p>
            </fieldset>
        </form>
        ';
        require_once("View/gabarit.php");
    }


    function priseDeRendezVousAgents() {
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected() .'
        <div class"priseRdv">
            <form action="rdv.php" method="post" class="sideFormPriseRendezVous">
                <fieldset>

                    <legend>Programmer un RDV</legend>
                    <p><label for="">Nom Du RDV</label><input type="text" name="nomRDV" id="nomRDV"></p>
                    <p><label for="">Date</label><input type="date" name="date" id="date"></p>
                    <p><label for="">Heure de début</label><input type="time" name="heureDebut" id="heureDebut"></p>
                    <p><label for="">Heure de fin</label><input type="time" name="heureFin" id="heureFin"></p>
                    <input class="submitFormInput" type="submit" name="create" value="Créer">
                </fieldset>
                

                <fieldset>
                    <legend>Supprimer un RDV</legend>
                    <p><label for="">Date</label><input type="date" name="dateDel" id="dateDel"></p>
                    <!--
                        <p><label for="">Heure de début</label><input type="time" name="heureDebutDel" id="heureDebutDel"></p>
                        <p><label for="">Heure de fin</label><input type="time" name="heureFinDel" id="heureFinDel"></p> 
                    -->
                    <p><label for="">Identifiant du RDV</label><input type="number" name="rdvDel" id="rdvDel"></p> 
                    <input class="submitFormInput" type="submit"  name="delete" value="Supprimer">

                </fieldset>
            </form>
        '.afficherEDTAgents().'</div>';



    require_once("View/gabarit.php");
    }


    function afficherEDTAgents($login=false,$semaineRequete=false) {

        $emploiDuTemps = '
        <table class="edtAgents">
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


    function errorTransactionNoAccountFound(){
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected() . '<div class="invalidForm">Aucun Compte n\'existe<br>Pour ce Client</div>';
        require_once("View/gabarit.php");
    }