<?php


    //
    // NV
    //
    // page d'accueil du conseiller
    //

    function accueilConseiller(){
        $contenu = connectedHeader();
        if ( isset($_SESSION['idClient']) ) {

            $contenu .= ConseillerAsideSideBarWhenClientConnected();

        } else {
            $contenu .= '
            <aside>
                <form action="index.php" method="post">
                    <ul class="asideUl">

                        <li class="asideLi"><input class="asideInput" type="submit" value="Recherche Client" name="asideConseillerClientResearch"></li>

                        <li class="asideLi"><input class="asideInput" type="submit" value="Plannings" name="asideConseillerPlanning"></li>

                    </ul>
                </form>
            </aside>';
        }
        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // aside conseiller connecté à un client
    //
    // DOIT UNIQUEMENT ETRE APPELE POUR RETOURNER SON CONTENU
    //

    function ConseillerAsideSideBarWhenClientConnected() {
        return '<aside>
            <form action="index.php" method="post">
                <ul class="asideUl">

                    <li class="asideLi"><input class="asideInput" type="submit" value="Synthèse Client" name="asideClientSynthese"></li>
                    <li class="asideLi"><input class="asideInput" type="submit" value="Vendre Contrat" name="asideConseillerVendreContrat"></li>
                    <li class="asideLi"><input class="asideInput" type="submit" value="Ouvrir Compte" name="asideConseillerOuvrirCompte"></li>
                    <li class="asideLi"><input class="asideInput" type="submit" value="Modifier Découvert" name="asideConseillerModifDecouvert"></li>
                    <li class="asideLi"><input class="asideInput" type="submit" value="Résiliation" name="asideConseillerResiliation"></li>
                    <li class="asideLi"><input class="asideInput" type="submit" value="Accueil" name="asideClientNouvelleRecherche"></li>

                </ul>
            </form>
        </aside>';
    }


    //
    // NV
    //
    // aside conseiller non connecté à un client
    //
    // DOIT UNIQUEMENT ETRE APPELE POUR RETOURNER SON CONTENU
    //

    function ConseillerAsideSideBarWhenClientNotConnected() {
        return '
        <aside>
            <form action="index.php" method="post">
                <ul class="asideUl">

                    <li class="asideLi"><input class="asideInput" type="submit" value="Recherche Client" name="asideConseillerClientResearch"></li>

                    <li class="asideLi"><input class="asideInput" type="submit" value="Plannings" name="asideConseillerPlanning"></li>

                </ul>
            </form>
        </aside>';
    }


    //
    // NV
    //
    // vue de la recherche client
    //

    function rechercheClientConseillerView($valid = true){
        $contenu = connectedHeader() .ConseillerAsideSideBarWhenClientNotConnected();
        if ( !$valid ){
            $contenu .= '<div class="invalidForm">Aucun client ne<br>correspond à la recherche</div>';
        };
        $contenu .= '
        
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <fieldset>

                <legend>Recherche Client</legend>

                <fieldset>
                    <legend>Rechercher par ID</legend>

                    <p><label for="nomCreation">ID Client</label><input type="number" name="idClientRecherche"></p>
                        
                </fieldset>

                <fieldset>
                    <legend>Rechercher par Informations Client</legend>

                    <p><label for="nomClientrRecherche">Nom du Client</label><input type="text" name="nomClientRecherche""></p>

                    <p><label for="prenomClientRecherche">Prénom du Client</label><input type="text" name="prenomClientRecherche"></p>

                    <p><label for="dateNaissanceClientRecherche">Date de Naissanse du Client</label><input type="date" name="dateNaissanceClientRecherche"></p>


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
    // vue de la recherche approffondi de client
    //

    function rechercheApprofondiClientConseiller($res) {
        $contenu = connectedHeader() . ConseillerAsideSideBarWhenClientNotConnected() . '
        
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <fieldset>

                <legend>Liste Des Clients</legend>';

                foreach ( $res as $client){
            
                    $contenu .= '
                        <p><label for="'.$client['idClient'].'">'.htmlentities($client['nomClient'], ENT_QUOTES,"UTF-8")."    ".htmlentities($client['prenomClient'], ENT_QUOTES,"UTF-8")."     ".$client['dateNaissance'].'</label>
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
    // vue de l'inscription d'un client à la banque
    //

    function inscrireClient( $clientInformation, $error=false) {

        $contenu = connectedHeader() . ConseillerAsideSideBarWhenClientConnectedNonInscrit(); 
        
        if ( $error ){
            $contenu .= '<div class="invalidForm">Le formulaire n\'est pas conforme</div>';
        };
        
        $contenu .= '
            <form action="index.php" method="post" class="topPageForm" id="topPageForm">

                <fieldset>

                    <legend>Inscrire Client</legend>

                        <p><label for="nomClientInscription">Nom du Client</label><input type="text" name="nomClientInscription" value="'.htmlentities($clientInformation['nomClient'], ENT_QUOTES,"UTF-8").'"></p>

                        <p><label for="prenomClientInscription">Prénom du Client</label><input type="text" name="prenomClientInscription" value="'.htmlentities($clientInformation['prenomClient'], ENT_QUOTES,"UTF-8").'"></p>

                        <p><label for="dateNaissanceClientInscription">Date de Naissanse du Client</label><input type="date" name="dateNaissanceClientInscription" value="'.$clientInformation['dateNaissance'].'"></p>

                        <p><label for="telephoneClientInscription">Numéro de téléphone</label><input type="number" name="telephoneClientInscription"></p>

                        <p><label for="mailClientInscription">Adresse mail</label><input type="text" name="mailClientInscription"></p>

                        <p><label for="adresseClientInscription">Adresse</label><input type="text" name="adresseClientInscription"></p>

                        <p><label for="codePostalClientInscription">Code Postal</label><input type="number" name="codePostalClientInscription"></p>

                        <p><label for="professionClientInscription">Profession</label><input type="text" name="professionClientInscription"></p>

                        <p><label for="situationClientInscription">Situation</label><input type="text" name="situationClientInscription"></p>

                    <p><input class="submitFormInput" type="submit" value="Inscrire" name="inscrireClientSubmit"></p>
                </fieldset>
            </form>';

        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // vue pour choisir le type de compte à ouvrir
    //

    function venteContrat( $typeContrat, $creer = false, $erreur = false ) {
        $contenu = connectedHeader() . ConseillerAsideSideBarWhenClientConnected(); 
        
        if ( $creer ){
            $contenu .= '<div class="invalidForm">Contrat Créé</div>';
        } else if ( $erreur ) {
            $contenu .= '<div class="invalidForm">Une erreur a été rencontré durant<br>la création du contrat</div>';
        }
        
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm" onSubmit="creationContratOuverture( this )">

            <fieldset>

                <legend>Vendre Contrat</legend>

                    <label for="contratType">Type de Contrat</label>
                    <select id="contratType" name="contratType">';

                    foreach ( $typeContrat as $contrat){
                        
                        $contenu .= "<option value='".$contrat['typeContrat']."'>".$contrat['typeContrat']."</option>";

                    }


        $contenu .= '
                    </select>

                    <p>
                        <label for="tarifCreation">Tarif Mensuel</label>
                        <input type="number" name="tarifCreation" id="tarif" onBlur="soldeCheckNegative(this)">
                    </p>

                <p><input class="submitFormInput" type="submit" value="Créer" name="creerContratSubmit"></p>
            </fieldset>
        </form>';

        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // vue pour choisir le type de compte à ouvrir
    //

    function ouvertureCompte( $typeCompte, $creer = false, $erreur = false ) {
        $contenu = connectedHeader() . ConseillerAsideSideBarWhenClientConnected(); 
        
        if ( $creer ){
            $contenu .= '<div class="invalidForm">Compte Créé</div>';
        } else if ( $erreur ) {
            $contenu .= '<div class="invalidForm">Une erreur a été rencontré durant<br>la création du compte</div>';
        }
        
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm" onSubmit="creationCompteInformationCheck( this )">

            <fieldset>

                <legend>Ouvrir Compte</legend>

                    <label for="compteType">Type de Compte</label>
                    <select id="compteType" name="compteType">';

                    foreach ( $typeCompte as $compte){

                        $contenu .= "<option value='".strval($compte['typeCompte'])."'>".$compte['typeCompte']."</option>";

                    }


        $contenu .= '
                    </select>

                    <p>
                        <label for="decouvertCreation">Montant Découvert</label>
                        <input type="checkbox" id="decouvertCheckbox" name="decouvertCheckbox" class="checkboxModification">
                        <input type="number" name="decouvertCreation"" id="decouvert" class="inputNextToCheckbox" disabled onBlur="decouvertCheckPositive(this)">
                    </p>

                    <p>
                        <label for="plafondCreation">Plafond</label>
                        <input type="checkbox" id="plafondCheckbox" name="plafondCheckbox" class="checkboxModification">
                        <input type="number" name="plafondCreation"" id="plafond" class="inputNextToCheckbox" disabled onBlur="plafondInterestCheckNegative(this)">
                    </p>

                    <p>
                        <label for="interetCreation">Interet %</label>
                        <input type="checkbox" id="interetCheckbox" name="interetCheckbox" class="checkboxModification">
                        <input type="number" name="interetCreation"" id="interet" class="inputNextToCheckbox" disabled onBlur="plafondInterestCheckNegative(this)">
                    </p>

                    <p><label for="soldeInitial">Solde initial</label><input type="number" name="soldeInitial" id="soldeInitial" value="0" onBlur="soldeCheckNegative(this)"></p>

                <p><input class="submitFormInput" type="submit" value="Créer" name="creerCompteSubmit"></p>
            </fieldset>
        </form>
        
        <script>
            var decouvert = document.getElementById(\'decouvertCheckbox\')
            var plafond = document.getElementById(\'plafondCheckbox\')
            var interet = document.getElementById(\'interetCheckbox\')
            
            plafond.addEventListener(\'change\', () => {
                document.getElementById(\'plafond\').disabled = !document.getElementById(\'plafond\').disabled
                document.getElementById(\'plafond\').value = ""
            })

            interet.addEventListener(\'change\', () => {
                document.getElementById(\'interet\').disabled = !document.getElementById(\'interet\').disabled
                document.getElementById(\'interet\').value = ""
            })

            decouvert.addEventListener(\'change\', () => {
                document.getElementById(\'decouvert\').disabled = !document.getElementById(\'decouvert\').disabled
                document.getElementById(\'decouvert\').value = ""
            })
        </script>';

        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // vue pour résilier comptes et contrats
    //

    function resilier( $comptes, $contrats, $errorCompte = false, $resilierCompteSucess = false, $resilierContratSucess = false) {
        $contenu = connectedHeader() . ConseillerAsideSideBarWhenClientConnected(); 
        
        if ( $errorCompte ){
            $contenu .= '<div class="invalidForm">Le compte doit avoir régularisé sa situation et être complètement vide</div>';
        } else if ( $resilierCompteSucess ) {
            $contenu .= '<div class="invalidForm">Le compte a été résilié</div>';
        } else if ( $resilierContratSucess ) {
            $contenu .= '<div class="invalidForm">Le contrat a été résilié</div>';
        } else if ( empty($comptes) && empty($contrats) ) {
            $contenu .= '<div class="invalidForm">Aucun Compte ou Contrat n\'existe pour le client</div>';
        }
        
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">';

        if( !empty($comptes) ) {
            $contenu .= '

            <fieldset>

                <legend>Résilier Compte</legend>

                    <label for="resiliationCompte">Compte</label>
                    <select id="resiliationCompte" name="resiliationCompte">';

                    foreach ( $comptes as $compte){
                        
                        $contenu .= "<option value='".$compte['idCompte']."'>".$compte['typeCompte']." - [".$compte['solde']."]</option>";

                    }


            $contenu .= '
                    </select>

                <p><input class="submitFormInput" type="submit" value="Résilier" name="resilierCompteSubmit"></p>
            </fieldset>';
        }

        if( !empty($contrats) ) {
            $contenu .= '<fieldset>

            <legend>Résilier Contrat</legend>

                <label for="resiliationContrat">Contrat</label>
                <select id="resiliationContrat" name="resiliationContrat">';

                foreach ( $contrats as $contrat){
                    
                    $contenu .= "<option value='".$contrat['idContrat']."'>".$contrat['typeContrat']." - [".$contrat['tarifMensuel']."]</option>";

                }


        $contenu .= '
                        </select>

                    <p><input class="submitFormInput" type="submit" value="Résilier" name="resilierContratSubmit"></p>
                </fieldset>';
        }

        
        $contenu .= '</form>';

        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // Page avec l'EDT du conseiller du client et les forms de prise et suppression de rendez vous
    //

    function priseDeRendezVousConseillers( $conseillers, $arr, $error=false, $cree=false, $supprime=false, $suppression = false ) {
        $contenu = connectedHeader() . ConseillerAsideSideBarWhenClientNotConnected();

        if ( $error ) {
            $contenu .= '<div class="invalidForm">Le RDV n\'a pas pu être supprimé<br>veuillez rentrer des informations valides</div>';
        } else if ( $cree ) {
            $contenu .= '<div class="invalidForm">Formation créé</div>';
        } else if ( $supprime ) {
            $contenu .= '<div class="invalidForm">RDV Supprimé</div>';
        } else if ( $suppression ) {
            $contenu .= '<div class="invalidForm">Vous ne pouvez pas supprimer <br> le RDV d\'un autre conseiller</div>';
        }

        $contenu .= '<div class"priseRdv">
            <form action="index.php" method="post" class="sideFormPriseRendezVous">

                <fieldset>
                    <legend>Selectionner Conseiller</legend>
                    <p><label for="">Conseiller</label><select id="conseillerEDTChoice" name="conseillerEDTChoice"> ';
                    foreach ( $conseillers as $conseiller){
            
                        $contenu .= "<option value='".$conseiller['login']."'>". htmlentities($conseiller['nomEmploye'], ENT_QUOTES,"UTF-8") .' '. htmlentities($conseiller['prenomEmploye'], ENT_QUOTES,"UTF-8") ."</option>";
            
                    }
                    
        $contenu .= '
                    </select>
                    </p>
                    <input class="submitFormInput" type="submit"  name="conseillerEDTSubmit" value="Selectionner">

                </fieldset>

                <fieldset>

                    <legend>Programmer une Formation</legend>

                    <p><label for="" class="priseRDVformLabel">Date</label><input type="date" name="date" id="date" min="'.(new DateTime(date("y-m-d")))->format("Y-m-d").'"></p>
                    <p><label for="" class="priseRDVformLabel">Heure de début</label><input type="time" name="heureDebut" id="heureDebut"></p>
                    <p><label for="" class="priseRDVformLabel">Heure de fin</label><input type="time" name="heureFin" id="heureFin"></p>
                    <input class="submitFormInput" type="submit" name="creerRDVConseiller" value="Créer">
                </fieldset>
                

                <fieldset>
                    <legend>Supprimer un RDV</legend>
                    <p><label for="" class="priseRDVformLabelIDRDV">Identifiant du RDV</label><input type="number" name="rdvDel" id="rdvDel"></p> 
                    <input class="submitFormInput" type="submit"  name="deleteRDVConseiller" value="Supprimer">

                </fieldset>
            </form>
        '.afficherEDTConseiller($arr).'</div>';



        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // renvoi l'edt de l'agent dans une table
    //

    function afficherEDTConseiller($arr) {

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

                <th colspan="5" class="semainetd">Semaine '.($date->modify('+7 days')->format("W")).' de l\'année '.$date->format("Y").'<br> De '.htmlentities($_SESSION['conseillerNom'], ENT_QUOTES,"UTF-8").' '.htmlentities($_SESSION['conseillerPrenom'], ENT_QUOTES,"UTF-8").'</th>
                
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
    // NV
    //
    // vue si la suppression de rdv n'est pas possible
    //

    function suppressionRDVSuiteAFormation() {
        $contenu = connectedHeader() . ConseillerAsideSideBarWhenClientNotConnected() . '
        
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <fieldset>

                <p>Veuillez supprimer le rendez-vous prévu à cette heure</p>

            </fieldset>
        </form>';

        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // page de la synthèse client si il n'est pas inscrit
    // DOIT UNIQUEMENT ETRE APPELE POUR RETOURNER SON CONTENU
    //

    function ConseillerAsideSideBarWhenClientConnectedNonInscrit(){
        return '<aside>
        <form action="index.php" method="post">
                <ul class="asideUl">

                    <li class="asideLi"><input class="asideInput" type="submit" value="Synthèse Client" name="asideClientSynthese"></li>
                    <li class="asideLi"><input class="asideInput" type="submit" value="Inscrire Client" name="asideConseillerInscrireClient"></li>
                    <li class="asideLi"><input class="asideInput" type="submit" value="Nouvelle Recherche" name="asideClientNouvelleRecherche"></li>

                </ul>
            </form>
        </aside>';
    }


