<?php

    //
    // NV
    //
    // fonction pour récupérer le aside si l'agent est connecté à un client
    //

    function AgentAsideSideBarWhenClientConnected() {
        $contenu = '
        <aside>
            <form action="index.php" method="post">
                <ul class="asideUl">

                    <li class="asideLi"><input class="asideInput" type="submit" value="Modification client" name="asideClientModification"></li>

                    <li class="asideLi"><input class="asideInput" type="submit" value="Transaction" name="asideClientTransaction"></li>

                    <li class="asideLi"><input class="asideInput" type="submit" value="Prise rendez-vous" name="asideClientPriseRendezVous"></li>

                    <li class="asideLi"><input class="asideInput" type="submit" value="Nouvelle recherche" name="asideClientNouvelleRecherche"></li>

                </ul>
            </form>
        </aside>';

        return $contenu;
    }


    //
    // NV
    //
    // fonction pour récupérer le aside si l'agent n'est pas connecté à un client
    //

    function AgentAsideSideBarWhenClientNotConnected() {
        $contenu = '
        <aside>
            <form action="index.php" method="post">
                <ul class="asideUl">

                    <li class="asideLi"><input class="asideInput" type="submit" value="Recherche client" name="asideAgentClientResearch"></li>

                    <li class="asideLi"><input class="asideInput" type="submit" value="Créer client" name="asideClientCreation"></li>

                </ul>
            </form>
        </aside>';

        return $contenu;
    }


    //
    // NV
    //
    // page d'accueil de l'agent
    //

    function accueilAgent(){
        $contenu = connectedHeader();
        if ( isset($_SESSION['idClient']) ) {

            $contenu .= AgentAsideSideBarWhenClientConnected();

        } else {
            $contenu .= AgentAsideSideBarWhenClientNotConnected();
        }

        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // page de la création client
    //

    function creationClientAgent($error = true) {
        $contenu = connectedHeader();
        $contenu .= AgentAsideSideBarWhenClientNotConnected();
        if ( !$error ){
            $contenu .= '<div class="invalidForm">Formulaire non valide !</div>';
        };
        $contenu .= '
        
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">
            <fieldset>
                <legend>Création du client</legend>

                    <p><label for="nomClientCreation">Nom du client</label><input type="text" name="nomClientCreation" onBlur="validFormField( this, 1, 45 )"></p>

                    <p><label for="prenomClientCreation">Prénom du client</label><input type="text" name="prenomClientCreation" onBlur="validFormField( this, 2, 45 )"></p>

                    <p><label for="dateNaissanceClientCreation">Date de naissanse du client</label><input type="date" name="dateNaissanceClientCreation" onBlur="validFormField( this, 2, 32 )"></p>

                    <p><input class="submitFormInput" type="submit" value="Créer le client" name="creationClientAgentSubmit"></p>
            </fieldset>
        </form>

        ';
        require_once("View/gabarit.php");
        
    }


    //
    // NV
    //
    // page de la recherche client
    //

    function rechercheClientAgentView($valid = true){
        $contenu = connectedHeader();
        $contenu .= AgentAsideSideBarWhenClientNotConnected();
        if ( !$valid ){
            $contenu .= '<div class="invalidForm">Aucun client ne<br>correspond à la recherche</div>';
        };
        $contenu .= '
        
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <fieldset>

                <legend>Recherche client</legend>

                <fieldset>
                    <legend>Rechercher par ID</legend>

                    <p><label for="nomCreation">ID client</label><input type="number" name="idClientRecherche" onBlur="validFormField( this, 1, 45 )"></p>
                        
                </fieldset>

                <fieldset>
                    <legend>Rechercher par informations client</legend>

                    <p><label for="nomClientrRecherche">Nom du client</label><input type="text" name="nomClientRecherche" onBlur="validFormField( this, 1, 45 )"></p>

                    <p><label for="prenomClientRecherche">Prénom du client</label><input type="text" name="prenomClientRecherche" onBlur="validFormField( this, 2, 45 )"></p>

                    <p><label for="dateNaissanceClientRecherche">Date de naissanse du client</label><input type="date" name="dateNaissanceClientRecherche" onBlur="validFormField( this, 2, 32 )"></p>


                </fieldset>

                <p><input class="submitFormInput" type="submit" value="Rechercher" name="rechercheClientSubmit"></p>
            </fieldset>
        </form>
        
        ';
        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // page de la recherche approfondi client
    //

    function rechercheApprofondiClientAgent($res) {
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientNotConnected() . '
        
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


    //
    // NV
    //
    // page du rattachement client
    //

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
            
            $contenu .= "<option value='".$conseiller['login']."'>".$conseiller['nomEmploye']."  ".$conseiller['prenomEmploye']."</option>";

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


    //
    // MP
    //
    // SELECTIONNER LE COMPTE SUR LEQUEL EFFECTUER LA TRANSACTION
    //

    function transactionChoixClientAgentView($compteList){
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected() . '
        <form action="index.php" method="post" class="transactionForm" id="transactionForm">
            <fieldset>
                <legend>Effectuer Transaction</legend>
                <p>
                    <label for="compteSelection">Compte disponible :</label>
                    <select id="compteSelection" name="compteSelection">';

        foreach ( $compteList as $compte){
            
            $contenu .= "<option value='".$compte['idCompte']."'>".$compte['typeCompte']." : ".$compte['solde']." €</option>";

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


    //
    // MP
    //
    //Affiche le panel pour retirer de l'argent sur le compte en session
    //

    function transactionRetraitClientAgentView() {
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected() . '
        
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <p class="afficherBeauP">Retrait sur le '.$_SESSION['typeCompteClient'].' : '.$_SESSION['soldeCompteClient'].' €</p>
            <p class="afficherBeauP">Decouvert : '.$_SESSION['decouvertCompteClient'].' €</p>
    
            <fieldset>
                <legend>Retrait</legend>

                <p><label for="retrait">Montant du retrait</label>
                <input type="number" name="retrait"></p> 

                <p><input class="submitFormInput" type="submit" value="Soumettre" name="outPutTransactionRetraitCompteClient"></p>
            </fieldset>
        </form>';
        require_once("View/gabarit.php");
    }


    //
    // MP
    //
    // Affiche le panel pour deposer de l'argent sur le compte en session
    //

     function transactionDepotClientAgentView() {

        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected() . '     

        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <p class="afficherBeauP">Dépot sur le '.$_SESSION['typeCompteClient'].' : '.$_SESSION['soldeCompteClient'].' €</p>';

        if( intval($_SESSION['plafondCompteClient']) != 0) {
            $contenu .= '<p class="afficherBeauP">Plafond : '.$_SESSION['plafondCompteClient'].' €</p>';
        }


        $contenu .= '<fieldset>
                <legend>Dépot</legend>

                <p><label for="depot">Montant du dépot</label>
                <input type="number" name="depot"></p>
                <p><input class="submitFormInput" type="submit" value="Soumettre" name="outPutTransactionDepotCompteClient"></p>
            </fieldset>

        </form>';
        require_once("View/gabarit.php");
    }


    //
    // MP - NV
    //
    // Affiche la page de modification Agent(client simplifié) des infos client avec leur affichage de base à l'interieur.
    //
    //
    //<p id="valider"><input class="submitFormInput" type="submit" value="Valider" name="ValiderModificationClientSubmit"></p>
    //<p id="editer"><input class="submitFormInput" type="submit" value="Editer" name="ReModificationClientSubmit" onClick="modificationClientEditSubmit(false)"></p>
    //<p id="modifier"><input class="submitFormInput" type="submit" value="Modifier" name="ModificationClientSubmit" onClick="modificationClientEditSubmit(true)"></p>
    //

    function AgentclientModificationPage( $modificationApplique = false, $error = false ) {
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected();
        
        if ( $modificationApplique ) {
            $contenu .= '<div class="invalidForm">Les informations du client ont été modifiés</div>';
        } else if ( $error ) {
            $contenu .= '<div class="invalidForm">Une erreur est survenu lors de la modification</div>';
        }
        
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm" onSubmit="modificationSubmit()">

            <fieldset>

                <legend>Modifier Client</legend>

                <p><label for="nomClientModification">Nom du Client</label><input type="text" id="nomClientModification" name="nomClientModification" value="'.$_SESSION['clientNom'].'" required></p>

                <p><label for="prenomClientModification">Prénom du Client</label><input type="text" id="prenomClientModification" name="prenomClientModification" value="'.$_SESSION['clientPrenom'].'"required ></p>

                <p><label for="dateNaissanceClientModification">Date de Naissanse du Client</label><input type="date" id="dateNaissanceClientModification" name="dateNaissanceClientModification" value="'.$_SESSION['clientNaissance'].'" required max="'.(new DateTime(date("y-m-d")))->format("Y-m-d").'"></p>


                <div id="modification">
                    <p id="modifier"><input class="submitFormInput" type="submit" value="Modifier" name="ModificationClientSubmit" onClick="modificationClientEditSubmit(true)"></p>
                </div>

            </fieldset>
        </form>
        ';
        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // Page avec l'EDT du conseiller du client et les forms de prise et suppression de rendez vous
    //

    function priseDeRendezVousAgents( $motifs, $arr, $conseiller, $error=false, $cree=false, $supprime=false, $errorSupression = false ) {
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected();

        if ( $error ) {
            $contenu .= '<div class="invalidForm">Le RDV n\'a pas pu être créé<br>veuillez rentrer des informations valides</div>';
        } else if ( $cree ) {
            $contenu .= '<div class="invalidForm">RDV Créé</div>';
        } else if ( $supprime ) {
            $contenu .= '<div class="invalidForm">RDV Supprimé</div>';
        } else if ( $errorSupression ) {
            $contenu .= '<div class="invalidForm">Le RDV sélectionné n\'existe pas</div>';
        }

        $contenu .= '<div class"priseRdv">
            <form action="index.php" method="post" class="sideFormPriseRendezVous">
                <fieldset>

                    <legend>Programmer un RDV</legend>
                    <p>
                        <label for="motifRDV" class="priseRDVformLabel">Motif Du RDV</label>
                        <select id="motifRDV" name="motifRDV" required>
                        ';

        foreach ( $motifs as $motif){

            $contenu .= "<option value='".$motif['idMotif']."'>".$motif['libelleMotif']."</option>";

        }
        
        $contenu .= '
                        </select>
                    </p>
                    <p><label for="" class="priseRDVformLabel">Date</label><input type="date" name="date" id="date" min="'.(new DateTime(date("y-m-d")))->modify('+1 days')->format("Y-m-d").'"></p>
                    <p><label for="" class="priseRDVformLabel">Heure de début</label><input type="time" name="heureDebut" id="heureDebut"></p>
                    <p><label for="" class="priseRDVformLabel">Heure de fin</label><input type="time" name="heureFin" id="heureFin"></p>
                    <input class="submitFormInput" type="submit" name="creerRDVAgent" value="Créer">
                </fieldset>
                

                <fieldset>
                    <legend>Supprimer un RDV</legend>
                    <p><label for="" class="priseRDVformLabelIDRDV">Identifiant du RDV</label><input type="number" name="rdvDel" id="rdvDel"></p> 
                    <input class="submitFormInput" type="submit"  name="deleteRDVAgent" value="Supprimer">

                </fieldset>
            </form>
        '.afficherEDTAgents($arr, $conseiller).'</div>';



        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // renvoi l'edt de l'agent dans une table
    //

    function afficherEDTAgents($arr, $conseiller) {

        $maxlengthArray = 0;

        //
        // get maximum length of sub-array in array
        //

        for ( $i = 0 ; $i < 7 ; $i++) { if ( count($arr[$i]) > $maxlengthArray ) { $maxlengthArray = count($arr[$i]); } }

        $ddate = date("y-m-d",strtotime("this week"));
        $date = new DateTime($ddate);
        
        
        $date->modify('+'.(($_SESSION['$week']-1)*7).' days');

        $emploiDuTemps = '
        <table class="edtAgents">
            <tr>
                <td class="tdWeekChange">
                    <form action="index.php" method="post" class="edtWeekChangeForm">
                        <input class="edtSubmitWeekChange" type="submit" name="weekMinusOne" value="'.($date->format("W")).'">
                    </form>
                </td>

                <th colspan="5" class="semainetd">Emploi du temps de<br>'.$conseiller['nomEmploye'].' '.$conseiller['prenomEmploye'].'<br>Semaine '.($date->modify('+7 days')->format("W")).' de l\'année '.$date->format("Y").'</th>
                
                <td class="tdWeekChange">
                    <form action="index.php" method="post" class="edtWeekChangeForm">
                        <input class="edtSubmitWeekChange" type="submit" name="weekAddOne" value="'.($date->modify('+7 days')->format("W")).'">
                    </form>
                </td>
            </tr>
            <tr>
                <th class="jourth">Lundi '.$date->modify('-7 days')->format('d M').'</th>
                <th class="jourth">Mardi '.$date->modify('+1 days')->format('d M').'</th>
                <th class="jourth">Mercredi '.$date->modify('+1 days')->format('d M').'</th>
                <th class="jourth">Jeudi '.$date->modify('+1 days')->format('d M').'</th>
                <th class="jourth">Vendredi '.$date->modify('+1 days')->format('d M').'</th>
                <th class="jourth">Samedi '.$date->modify('+1 days')->format('d M').'</th>
                <th class="jourth">Dimanche '.$date->modify('+1 days')->format('d M').'</th>
            </tr>';


            for ( $i = 0 ; $i < $maxlengthArray ; $i++ ) {
                $emploiDuTemps .= '<tr>';
                for ( $j = 0 ; $j < 7 ; $j++) {
                    if ( count($arr[$j]) <= $i ) {
                        $emploiDuTemps .= '<td class="edttdHoraire">&nbsp</td>';
                    } else {
                        $emploiDuTemps .= EDTBubble($arr[$j][$i]);
                    }
                }
                $emploiDuTemps .= '</tr>';
            }

        $emploiDuTemps .= '</table>';

        return $emploiDuTemps;
    }


    //
    // MP
    //
    // Si le client n'a aucun compte 
    //

    function errorTransactionNoAccountFound(){
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected() . '<div class="invalidForm">Aucun Compte n\'existe<br>Pour ce Client</div>';
        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // Prise de RDV valide affiche page avec les pièces nécessaires
    //

    function affichageRDVPieceNecessaires( $arr ) {
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected();

        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">
            <fieldset>

                <legend>Information RDV</legend>

                <p><label class="listePiece" for="">Libelle</label><textarea name="listePiece" id="listePiece" disabled="disabled" class="libelle">'.$arr['libelleMotif'].'</textarea></p> 

                <p><label class="listePiece" for="">Liste de pièces à prévoir</label><textarea name="listePiece" id="listePiece" disabled="disabled" class="liste">'.$arr['listePiece'].'</textarea></p> 

                <input class="submitFormInput" type="submit" value="Suivant" name="asideClientPriseRendezVous">
            </fieldset>
        </form>';



        require_once("View/gabarit.php");
    }


    