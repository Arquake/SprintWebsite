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
            
            $contenu .= "<option value=".$compte['idCompte'].">".$compte['type']." : ".$compte['solde']." €</option>";

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
    function transactionRetraitClientAgentView() {
        $contenu = connectedHeader();
        $contenu .= '
        <aside></aside>
        
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

        <p class="afficherBeauP">Compte séléctionné pour <strong>retrait</strong> : '.$_SESSION['typeCompteClient'].' : '.$_SESSION['soldeCompteClient'].' €</p>
    
            <fieldset>
                <legend>Retrait</legend>

                <p><label for="retrait">Montant du retrait</label>
                <input type="number" name="retrait"></p> 

                <p><input class="submitFormInput" type="submit" value="Soumettre" name="outPutTransactionRetraitCompteClient"></p>
            </fieldset>

            
        </form>

        

            <p><input class="submitFormInput" type="submit" value="Soumettre" name="outPutTransactionRetraitCompteClient"></p>
            </fieldset>
            </form>

        
        ';
        require_once("View/gabarit.php");
    }

     //Affiche le panel pour deposer de l'argent sur le compte en session
     function transactionDepotClientAgentView() {

        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected() .'
        <aside></aside>        

        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <p class="afficherBeauP">Compte séléctionné pour <strong>dépot</strong> : '.$_SESSION['typeCompteClient'].' : '.$_SESSION['soldeCompteClient'].' €</p>
    

            <fieldset>
                <legend>Dépot</legend>

                <p><label for="depot">Montant du dépot</label>
                <input type="number" name="depot"></p>
                <p><input class="submitFormInput" type="submit" value="Soumettre" name="outPutTransactionDepotCompteClient"></p>
            </fieldset>

            
        </form>
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


    function priseDeRendezVousAgents( $motifs, $arr, $error=false, $cree=false, $supprime=false ) {
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected();

        if ( $error ) {
            $contenu .= '<div class="invalidForm">Le RDV n\'a pas pu être créé<br>veuillez rentrer des informations valides</div>';
        } else if ( $cree ) {
            $contenu .= '<div class="invalidForm">RDV Créé</div>';
        } else if ( $supprime ) {
            $contenu .= '<div class="invalidForm">RDV Supprimé</div>';
        }

        $contenu .= '<div class"priseRdv">
            <form action="index.php" method="post" class="sideFormPriseRendezVous">
                <fieldset>

                    <legend>Programmer un RDV</legend>
                    <p>
                        <label for="motifRDV">Motif Du RDV</label>
                        <select id="motifRDV" name="motifRDV">
                        ';
        foreach ( $motifs as $motif){

            $contenu .= "<option value=".$motif['type'].">".$motif['type']."</option>";

        }
        
        $contenu .= '
                        </select>
                    </p>
                    <p><label for="">Date</label><input type="date" name="date" id="date"></p>
                    <p><label for="">Heure de début</label><input type="time" name="heureDebut" id="heureDebut"></p>
                    <p><label for="">Heure de fin</label><input type="time" name="heureFin" id="heureFin"></p>
                    <input class="submitFormInput" type="submit" name="creerRDVAgent" value="Créer">
                </fieldset>
                

                <fieldset>
                    <legend>Supprimer un RDV</legend>
                    <p><label for="">Identifiant du RDV</label><input type="number" name="rdvDel" id="rdvDel"></p> 
                    <input class="submitFormInput" type="submit"  name="deleteRDVAgent" value="Supprimer">

                </fieldset>
            </form>
        '.afficherEDTAgents($arr).'</div>';



        require_once("View/gabarit.php");
    }



    function afficherEDTAgents($arr, $login=false) {

        $maxlengthArray = 0;

        //
        // get maximum length of sub-array in array
        //

        for ( $i = 0 ; $i < 7 ; $i++) { if ( count($arr[$i]) > $maxlengthArray ) { $maxlengthArray = count($arr[$i]); } }

        $ddate = date("y-m-d",strtotime("this week"));
        $date = new DateTime($ddate);
        
        if ( isset($_POST['weekMinusOne']) ) {
            $_SESSION['$week'] -= 1;
        } else if ( isset($_POST['weekAddOne']) ) {
            $_SESSION['$week'] += 1;
        } else {
            $_SESSION['$week'] = 0;
        }

        $date->modify('+'.(($_SESSION['$week']-1)*7).' days');

        $emploiDuTemps = '
        <table class="edtAgents">
            <tr>
                <td class="tdWeekChange">
                    <form action="index.php" method="post" class="edtWeekChangeForm">
                        <input class="edtSubmitWeekChange" type="submit" name="weekMinusOne" value="'.($date->format("W")).'">
                    </form>
                </td>
                <th colspan="5" class="semainetd">Semaine '.($date->modify('+7 days')->format("W")).' de l\'année '.$date->format("Y").'</th>
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
                        $emploiDuTemps .= EDTAgentBubble($arr[$j][$i]);
                    }
                }
                $emploiDuTemps .= '</tr>';
            }

        $emploiDuTemps .= '</table>';

        return $emploiDuTemps;
    }


    function errorTransactionNoAccountFound(){
        $contenu = connectedHeader() . AgentAsideSideBarWhenClientConnected() . '<div class="invalidForm">Aucun Compte n\'existe<br>Pour ce Client</div>';
        require_once("View/gabarit.php");
    }

    function EDTAgentBubble($arr){
        return '
        <td class="edttdHoraire">
            <div class="insidetd">
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
                    motif : '.$arr['Motif'].'
                </div>
            </div>
        </td>';
    }