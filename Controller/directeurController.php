<?php


    //
    // NV
    //
    //
    //

    function CtlDirecteurCreateAgentSubmit() {
        gestionEmployeDirecteur('homepage');
    }


    //
    // NV
    //
    //
    //

    function CtlDirecteurHomePage() {
        accueilDirecteur();
    }


    //
    // NV
    //
    //
    //

    function CtlAjouterEmploye ( $login, $password, $poste ,$nom, $prenom ){

        $created = createEmploye( $login, $password, $poste ,$nom, $prenom);

        gestionEmployeDirecteur($created);

    }

    //
    // NV
    //
    //
    //

    function CtlModifierEmploye() {
        $arr = informationConnexionDirecteur();
        modifierEmployeForms($arr);
    }


    //
    // NV
    //
    //
    //

    function CtlModifierEmployeSelected() {
        $arr = informationConnexionEmployeDirecteur();
        $_SESSION['employeChoisiInformationLogin'] = $_POST['modifierLemploye'];
        modificationSelectedEmploye($arr);
    }


    //
    // NV
    //
    //
    //

    function CtlAppliquerModificationEmploye() {

        

        $errorArray = [];

        array_push($errorArray, ($_POST['loginCreation'] == '' || loginCheckIfExistDirecteur()) && $_POST['loginCreation'] != $_SESSION['employeChoisiInformationLogin'] );
        array_push($errorArray, isset($_POST['passwordCheckbox']) && $_POST['passwordCreation'] == '' );
        array_push($errorArray, $_POST['nomCreation'] == '');
        array_push($errorArray, $_POST['prenomCreation'] == '');
        

        if ( in_array(true, $errorArray) ) {
            if ( isset($_SESSION['employeChoisiInformationLogin'])) {
                $arr = informationConnexionEmployeDirecteur($_SESSION['employeChoisiInformationLogin']);
            } else {
                $arr = informationConnexionEmployeDirecteur();
            }
            modificationSelectedEmploye($arr, $errorArray[0], $errorArray[1], $errorArray[2], $errorArray[3]);
        } else {
            modificationInformationEmployeDirecteur();
            $arr = informationConnexionDirecteur();
            unset($_SESSION['employeChoisiInformationLogin']);
            modifierEmployeForms($arr, true);
        }
    }

    //
    // NV
    //
    // Affiche les différentes type de stats au directeur
    //

    function CtlStatsDirecteur() {
        directeurChoixTypeStats();
    }


    //
    // NV
    //
    // récupère les statistiques demandés
    //

    function CtlStatsDirecteurRechercher() {

        $res = [];

        if( isset($_POST['dateDebutStatscontrats']) && isset($_POST['dateFinStatscontrats']) ) {
            $res['contrats'] = nombreContrat();
        }

        if( isset($_POST['dateDebutStatscomptes']) && isset($_POST['dateFinStatscomptes']) ) {
            $res['comptes'] = nombreCompte();
        }

        if( isset($_POST['dateDebutStatsrdv']) && isset($_POST['dateFinStatsrdv']) ) {
            $res['rdv'] = nombreRdv();
        }

        if( isset($_POST['dateStatsnbClient']) ) {
            $res['clients'] = nombreClient();
        }

        if( isset($_POST['dateStatssoldeTotal']) ) {
            $res['solde'] = soldeTotal();
        }

        afficherStatsDirecteurs( $res );
    }


    //
    // MP
    //
    // Repond au bouton "Gestion compte" du aside 
    //
    function CtlDirecteurCompte($sortie = 0){
        $typeList = getTypeCompteList();
        gestionTypeCompte($typeList, $sortie);
    }

    //
    // MP
    //
    // Repond au bouton "Ajouter" de la page de gestion de compte
    //
    function CtlDirecteurAjouterCompte(){
        if (VerificationExistanceTypeCompte($_POST['DirecteurAjouterCompteType'])){        
            ajouterLeTypeCompte($_POST['DirecteurAjouterCompteType']);
            CtlGestionMotifs(1,1);
        }else {
            CtlDirecteurCompte(5);
        }
    }

    //
    // MP
    //
    // Repond au bouton "Retirer" de la page de gestion de compte
    //
    function CtlDirecteurSupprimerCompte(){
        if (VerificationPossessionTypeCompte($_POST['DirecteurSupprimerCompteType'])){
            supprimerLeTypeCompte($_POST['DirecteurSupprimerCompteType']);
            CtlDirecteurCompte(1);
        } else {
            CtlDirecteurCompte(2);
        }
    }


    //
    // MP
    //
    // Repond au bouton "Gestion contrat" du aside 
    //
    function CtlDirecteurContrat($sortie = 0){
        $typeList = getTypeContratList();
        gestionTypeContrat($typeList,$sortie);
    }

    //
    // MP
    //
    // Repond au bouton "Ajouter" de la page de gestion de contrat
    //
    function CtlDirecteurAjouterContrat(){
        if (VerificationExistanceTypeContrat($_POST['DirecteurAjouterContratType'])){        
            ajouterLeTypeContrat($_POST['DirecteurAjouterContratType']);
            CtlGestionMotifs(2,1);
        }else {
            CtlDirecteurCompte(5);
        }
    }

    //
    // MP
    //
    // Repond au bouton "Retirer" de la page de gestion de contrat
    //
    function CtlDirecteurSupprimerContrat(){
        if (VerificationPossessionTypeContrat($_POST['DirecteurSupprimerContratType'])){
            supprimerLeTypeContrat($_POST['DirecteurSupprimerContratType']);
            CtlDirecteurContrat(1);
        } else {
            CtlDirecteurContrat(2);
        }
    }

    //
    // MP
    //
    // Link le bouton gestion employé a l'affichage des choix de l'action liée
    // 
    function CtlGestionEmploye(){
        gestionEmploye();
    }

    //
    // MP
    //
    // Link le bouton gestion produits de l'aside
    // 
    function CtlGestionProduits(){
        gestionProduits();
        if(isset($_SESSION['typeCompte'])) { unset($_SESSION['typeCompte']); }
    }

    //
    // MP
    //
    // Link le bouton gestion motifs de l'aside
    // - viaType par defaut sur 0, permet l'affichage correcte de la page des motifs
    // - message par defaut sur 0, affiche le message par son id das la page de motifs
    //
    function CtlGestionMotifs($viaType = 0, $message = 0){
        $_SESSION['viaType'] = $viaType;
        $motifList = getMotifPieceList();
        unset($_SESSION['idMotif']);
        gestionMotifs($motifList,$viaType,$message);
    }

    //
    // MP
    //
    // 
    //
    function CtlAjoutMotif(){        
        $motif = $_POST['DirecteurAjouterMotif'];
        
        if (VerificationExistanceMotif($motif)){
            ajoutMotif($motif,$_POST['DirecteurAjouterPiece']);
            CtlGestionMotifs($_SESSION['viaType'],1);
        } else {
            CtlGestionMotifs($_SESSION['viaType'],4);
        }
    }
    
    //
    // MP
    //
    //
    //
    function CtlModifierMotif(){
        $_SESSION['idMotif'] = $_POST['DirecteurModifierMotif'];
        $motif = getMotifViaId($_POST['DirecteurModifierMotif']);
        motifModificationPage($motif['libelleMotif'], $motif['listePiece']);
        
    }
    
    //
    // MP
    //
    //
    //
    function CtlModifierMotifValidation(){
        $motif = $_POST['motifModification'];
        
        if (VerificationExistanceMotif($motif)){
            modifierMotifViaIdSession($motif,$_POST['pieceMotifModification']);
            CtlGestionMotifs($_SESSION['viaType'],3);
        } else {
            CtlGestionMotifs($_SESSION['viaType'],2);
        }
    }

    //
    // MP
    //
    //
    //
    function CtlDirecteurModifierCompte(){
        $_SESSION['typeCompte'] = $_POST['DirecteurSupprimerCompteType'];
        typeCompteModificationPage();
    }

    //
    // MP
    //
    // 
    //
    function CtlModifierTypeCompteValidation(){
        $type = $_POST['typeCompteModification'];

        if (VerificationMofificationTypeCompte($type)){
            modifierTypeCompte($type);
            CtlDirecteurCompte(3);
        } else {
            CtlDirecteurCompte(4);
        }
    }

    //
    // MP
    //
    //
    //
    function CtlDirecteurModifierContrat(){
        $_SESSION['typeContrat'] = $_POST['DirecteurSupprimerContratType'];
        typeContratModificationPage();
    }

    //
    // MP
    //
    // 
    //
    function CtlModifierTypeContratValidation(){
        $type = $_POST['typeContratModification'];

        if (VerificationMofificationTypeContrat($type)){
            modifierTypeContrat($type);
            CtlDirecteurContrat(3);
        } else {
            CtlDirecteurContrat(4);
        }
    }













