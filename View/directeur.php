<?php


    //
    // NV
    //
    // aside du directeur
    //

    function directeurAside() {
        return '
        <aside>
            <form action="index.php" method="post">
                <ul class="asideUl">

                    <li class="asideLi"><input class="asideInput" type="submit" value="Gestion employés" name="asideDirecteurGestionEmploye"></li>

                    <li class="asideLi"><input class="asideInput" type="submit" value="Gestion produits" name="asideDirecteurGestionProduit"></li>
                    
                    <li class="asideLi"><input class="asideInput" type="submit" value="Gestion motifs" name="asideDirecteurGestionMotifs"></li>

                    <li class="asideLi"><input class="asideInput" type="submit" value="Statistiques" name="asideDirecteurStats"></li>

                </ul>
            </form>
        </aside>';
    }


    //
    // NV
    //
    // affiche l'accueil du directeur
    //

    function accueilDirecteur(){
        $contenu = connectedHeader() . directeurAside();
        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // affiche la page de modification employe
    //

    function gestionEmployeDirecteur($employeCreated = false){
        $contenu = connectedHeader() . directeurAside() ;
        if ( $employeCreated != 'homepage' ) {
            if ( $employeCreated ){
            $contenu .= '<div class="invalidForm">Employé créé</div>';
            } else {
                $contenu .= '<div class="invalidForm">Erreur</div>';
            }
        }
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" onSubmit="createEmployeCheck(this)" id="topPageForm">
            <fieldset>
                <legend>Création d\'employé</legend>
                <p><label for="nomCreation">Nom de l\'employé</label><input type="text" name="nomCreation" onBlur="validFormField( this, 2, 45 )" required="required"></p>
                <p><label for="prenomCreation">Prénom de l\'employé</label><input type="text" name="prenomCreation" onBlur="validFormField( this, 2, 45 )" required="required"></p>
                <p><label for="loginCreation">Identifiant de l\'employé</label><input type="text" name="loginCreation" onBlur="validFormField( this, 2, 32 )" required="required"></p>
                <p><label for="password">Mot de passe de l\'employé</label><input type="password" name="passwordCreation" onBlur="validFormField( this, 8, 32 )" required="required"></p>
                <p>
                    <label for="posteCreation">Poste de l\'employé</label>
                    <select id="posteCreation" name="posteCreation">
                        <option value="Agent">Agent</option>
                        <option value="Conseiller">Conseiller</option>
                        <option value="Directeur">Directeur</option>
                    </select>
                </p>
                <p><input class="submitFormInput" type="submit" value="Créer" name="createEmploye"></p>
            </fieldset>
        </form>';
        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // page de selection de l'employe à modifier
    //

    function modifierEmployeForms($employes, $created=false){
        $contenu = connectedHeader() . directeurAside(); 
        
        if ( $created ) {
            $contenu .= '<div class="invalidForm">Les informations ont été enregistrés</div>';
        }
        
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" onSubmit="createEmployeCheck(this)" id="topPageForm">
            <fieldset>
                <legend>Choisir l\'employé à modifier</legend>
                <p><label for="modifierLemploye">Employé</label>
                    <select id="modifierLemploye" name="modifierLemploye">';

                    foreach ( $employes as $employe){
                        
                        $contenu .= "<option value='".$employe['login']."'>".htmlentities($employe['nomEmploye'], ENT_QUOTES,"UTF-8")." - ".htmlentities($employe['prenomEmploye'], ENT_QUOTES,"UTF-8")." - ".$employe['poste']."</option>";

                    }

        $contenu .= '
                    </select>
                </p>
                <p><input class="submitFormInput" type="submit" value="Modifier" name="modifierEmployeSubmit"></p>
            </fieldset>
        </form>';
        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // quand on à selectionner l'employe à modifier ou que les informations rentrés sont incorrect on arrive sur cette page
    //

    function modificationSelectedEmploye( $employe, $errorLogin = false, $errorPassword = false, $errorName = false, $errorSurname = false ) {

        $contenu = connectedHeader() . directeurAside();

        
        if ( $errorLogin ) {
            $contenu .= '<div class="invalidForm">Le login existe déjà</div>';
        }
        if ( $errorPassword ) {
            $contenu .= '<div class="invalidForm">Le mot de passe n\'est pas valide</div>';
        }
        if ( $errorName ) {
            $contenu .= '<div class="invalidForm">Le nom de l\'employe n\'est pas valide</div>';
        }
        if ( $errorSurname ) {
            $contenu .= '<div class="invalidForm">Le prenom de l\'employe n\'est pas valide</div>';
        }

        
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="modificationEmploye" onSubmit="modifierEmploye(this)">
            <fieldset>
                <legend>Création d\'employé</legend>
                <p><label for="nomCreation">Nom de l\'employé</label><input type="text" name="nomCreation" required="required" value="'.htmlentities($employe['nomEmploye'], ENT_QUOTES,"UTF-8").'"></p>
                <p><label for="prenomCreation">Prénom de l\'employé</label><input type="text" name="prenomCreation" required="required" value="'.htmlentities($employe['prenomEmploye'], ENT_QUOTES,"UTF-8").'"></p>
                <p><label for="loginCreation">Identifiant de l\'employé</label><input type="text" name="loginCreation" required="required" value="'.$employe['login'].'"></p>
                <p>
                    <label for="password">Mot De Passe de l\'employé</label>
                    <input type="checkbox" id="passwordCheckbox" name="passwordCheckbox" class="checkboxModification">
                    <input type="password" id="passwordChp" name="passwordCreation" disabled class="inputNextToCheckbox"></p>
                <p>
                    <label for="posteCreation">Poste de l\'empolyé</label>
                    <select id="posteCreation" name="posteCreation">
                        <option value="Agent" ';
                        if ( $employe['poste'] == "Agent") { $contenu .= 'selected="selected"'; }
                        $contenu .='>Agent</option>
                        <option value="Conseiller" ';
                        if ( $employe['poste'] == "Conseiller") { $contenu .= 'selected="selected"'; }
                                        $contenu .='>Conseiller</option>
                        <option value="Directeur" ';
                        if ( $employe['poste'] == "Directeur") { $contenu .= 'selected="selected"'; }
                                        $contenu .='>Directeur</option>
                    </select>
                </p>
                <p><input class="submitFormInput" type="submit" value="Modifier" name="modifierEmployeChoisiSubmit"></p>
            </fieldset>
        </form>
        
        <script>
            var checkbox = document.getElementById(\'passwordCheckbox\')
            
            checkbox.addEventListener(\'change\', () => {
                document.getElementById(\'passwordChp\').disabled = !document.getElementById(\'passwordChp\').disabled
                document.getElementById(\'passwordChp\').value = ""
            })
        </script>';
        require_once("View/gabarit.php");
    }


    //
    // MP
    //
    // Affichage du choix entre creer employé et modifier employe
    //

    function gestionEmploye(){
        $contenu = connectedHeader() . directeurAside().'
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">
            <fieldset>
                <legend>Action souhaitée</legend>
                <p>
                <input class="submitFormLarge" type="submit" value="Créer employé" name="DirecteurCreerEmploye">

                <input class="submitFormLarge" type="submit" value="Modifier employé" name="DirecteurModifierEmploye">
                </p>
            </fildset>    
        </form>';
        require_once("View/gabarit.php");
    }


    //
    // MP
    //
    // Affichage du choix pour la gestion compte
    //

    function gestionTypeCompte($typeList,$sortie = 0){
        $contenu = connectedHeader() . directeurAside();

        if ( $sortie == 1 ){
            $contenu .= '<div class="invalidForm">Suppression effective</div>';
        } else if ( $sortie == 2 ){
            $contenu .= '<div class="invalidForm">Suppression impossible : type encore utilisé </div>';
        } else if ( $sortie == 3 ){
            $contenu .= '<div class="invalidForm">Modification effective</div>';
        } else if ( $sortie == 4 ){
            $contenu .= '<div class="invalidForm">Modification impossible : nom déjà utilisé ou vide</div>';
        } else if ( $sortie == 5 ){
            $contenu .= '<div class="invalidForm">Ajout impossible : nom déjà utilisé ou vide</div>';
        }

        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">
            <fieldset>
                <legend>Ajouter un type de compte</legend>
                
                <p><label for="typeSelection">Type de Compte :</label>
                <input type="text" name="DirecteurAjouterCompteType" required></p>

            <input class="submitFormInput" type="submit" value="Ajouter" name="DirecteurAjouterCompteSubmit">
            </fieldset>
        </form>

        <form action="index.php" method="post" class="topPageForm" id="topPageForm">
            <fieldset>
                <legend>Modifier Type de compte</legend>
                </p>

                <p>
                    <label for="typeSelection">Type de Compte :</label>
                    <select id="typeSelection" name="DirecteurSupprimerCompteType">';

                foreach ( $typeList as $type){

                    $contenu .= "<option value='".$type['typeCompte']."'>".$type['typeCompte']."</option>";
                
                }

                $contenu .= '
                    </select>
                </p>

            <input class="submitFormInput" type="submit" value="Modifier" name="DirecteurModifierCompteSubmit">
            <input class="submitFormInput" type="submit" value="Retirer" name="DirecteurRetirerCompteSubmit">
            </fieldset>
        </form>';
        require_once("View/gabarit.php");
    }


    //
    // MP
    //
    // Affichage du choix pour la gestion contrat
    //

    function gestionTypeContrat($typeList, $sortie){
        $contenu = connectedHeader() . directeurAside();

        if ( $sortie == 1 ){
            $contenu .= '<div class="invalidForm">Suppression effective</div>';
        } else if ( $sortie == 2 ){
            $contenu .= '<div class="invalidForm">Suppression impossible : type encore utilisé </div>';
        } else if ( $sortie == 3 ){
            $contenu .= '<div class="invalidForm">Modification effective</div>';
        } else if ( $sortie == 4 ){
            $contenu .= '<div class="invalidForm">Modification impossible : nom déjà utilisé ou vide</div>';
        } else if ( $sortie == 5 ){
            $contenu .= '<div class="invalidForm">Ajout impossible : nom déjà utilisé ou vide</div>';
        }

        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">
            <fieldset>
                <legend>Ajouter un type de contrat</legend>
                
                <p><label for="typeSelection">Type de Contrat :</label>
                <input type="text" name="DirecteurAjouterContratType" required></p>

            <input class="submitFormInput" type="submit" value="Ajouter" name="DirecteurAjouterContratSubmit">
            </fieldset>
        </form>

        <form action="index.php" method="post" class="topPageForm" id="topPageForm">
            <fieldset>
                <legend>Retirer un type de contrat</legend>
                </p>

                <p>
                    <label for="typeSelection">Type de Contrat :</label>
                    <select id="typeSelection" name="DirecteurSupprimerContratType">';

                foreach ( $typeList as $type){

                    $contenu .= "<option value='".$type['typeContrat']."'>".$type['typeContrat']."</option>";
                
                }

                $contenu .= '
                    </select>
                </p>

            <input class="submitFormInput" type="submit" value="Modifier" name="DirecteurModifierContratSubmit">
            <input class="submitFormInput" type="submit" value="Retirer" name="DirecteurRetirerContratSubmit">
            </fieldset>
        </form>';
        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // Choix entre les différentes options de statistiques
    //

    function directeurChoixTypeStats() {

        $date = new DateTime(date("y-m-d"));

        $contenu = connectedHeader() . directeurAside().'

        <script>
            date = "'.$date->format("Y-m-d").'";
        </script>

        <form action="index.php" method="post" class="topPageForm" id="topPageForm">
            <fieldset>
                <legend>Action souhaitée</legend>

                    <p id="contrats"><label for="checkboxStatsContrats">Nombres De Contrats</label><input class="checkboxStats" type="checkbox" value="" name="checkboxStatsContrats" onClick="plageDate( \'contrats\', \'contratsDiv\', \'contrats\' )"></p>

                    <p id="comptes"><label for="checkboxStatsComptes">Nombres De Comptes</label><input class="checkboxStats" type="checkbox" value="" name="checkboxStatsComptes" onClick="plageDate( \'comptes\', \'comptesDiv\', \'comptes\' )"></p>

                    <p id="rdv"><label for="checkboxStatsRDV">Nombres De RDV</label><input class="checkboxStats" type="checkbox" value="" name="checkboxStatsRDV" onClick="plageDate( \'rdv\', \'rdvDiv\', \'rdv\' )"></p>

                    <p id="nbClient"><label for="checkboxStatsClients">Nombres De Clients</label><input class="checkboxStats" type="checkbox" value="" name="checkboxStatsClients" onClick="dateSelection( \'nbClient\', \'nbClientDiv\', \'nbClient\' )"></p>

                    <p id="soldeTotal"><label for="checkboxStatsSolde">Solde Total</label><input class="checkboxStats" type="checkbox" value="" name="checkboxStatsSolde" onClick="dateSelection( \'soldeTotal\', \'soldeTotalDiv\', \'soldeTotal\' )"></p>

                    <input class="submitFormInput" type="submit" value="Rechercher" name="statsRechercheSubmit">

            </fildset>    
        </form>';
        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // affiche les stats directeur
    //

    function afficherStatsDirecteurs( $stats ) {

        $contenu = connectedHeader() . directeurAside().'

        <form action="index.php" method="post" class="topPageForm" id="topPageForm">
            <fieldset>

                <legend>Statistique</legend>';

                

        if( isset($_POST['dateDebutStatscontrats']) && isset($_POST['dateFinStatscontrats']) ) {
            $contenu .= '<p><label class="listePiece" for="">Nombres de Contrats du '.$_POST['dateDebutStatscontrats'].' au '.$_POST['dateFinStatscontrats'].'</label>
            <textarea name="listePiece" id="listePiece" disabled="disabled" class="resultatRecherche">'.$stats['contrats'].'</textarea></p>';
        }

        if( isset($_POST['dateDebutStatscomptes']) && isset($_POST['dateFinStatscomptes']) ) {
            $contenu .= '<p><label class="listePiece" for="">Nombres de Comptes du '.$_POST['dateDebutStatscomptes'].' au '.$_POST['dateFinStatscomptes'].'</label>
            <textarea name="listePiece" id="listePiece" disabled="disabled" class="resultatRecherche">'.$stats['comptes'].'</textarea></p>';
        }

        if( isset($_POST['dateDebutStatsrdv']) && isset($_POST['dateFinStatsrdv']) ) {
            $contenu .= '<p><label class="listePiece" for="">Nombres de Rendes-Vous prit du '.$_POST['dateDebutStatsrdv'].' au '.$_POST['dateDebutStatsrdv'].'</label>
            <textarea name="listePiece" id="listePiece" disabled="disabled" class="resultatRecherche">'.$stats['rdv'].'</textarea></p>';
        }

        if( isset($_POST['dateStatsnbClient']) ) {
            $contenu .= '<p><label class="listePiece" for="">Nombres de Clients à la date du '.$_POST['dateStatsnbClient'].'</label>
            <textarea name="listePiece" id="listePiece" disabled="disabled" class="resultatRecherche">'.$stats['clients'].'</textarea></p>';
        }

        if( isset($_POST['dateStatssoldeTotal']) ) {
            $contenu .= '<p><label class="listePiece" for="">Solde total à la date du '.$_POST['dateStatssoldeTotal'] . '</label>
            <textarea name="listePiece" id="listePiece" disabled="disabled" class="resultatRecherche">'.$stats['solde'].'</textarea></p>';
        }

        $contenu .='<input class="submitFormInput" type="submit" value="Nouvelle Recherche" name="asideDirecteurStats">
            </fieldset>
        </form>';



        require_once("View/gabarit.php");
    }


    //
    // MP
    //
    // Affichage du choix de la gestion de contrat
    //

    function gestionProduits(){
        $contenu = connectedHeader() . directeurAside().'
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">
            <fieldset>
                <legend>Action souhaitée</legend>
                <p>
                <input class="submitFormLarge" type="submit" value="Gérer les type de compte" name="DirecteurGestionTypeCompte">

                <input class="submitFormLarge" type="submit" value="Gérer les type de contrat" name="DirecteurGestionTypeContrat">
                </p>
            </fildset>    
        </form>';
        require_once("View/gabarit.php");
    }


    //
    // MP
    //
    // Permet d'ajouter/modifier des motifs de rendez vous 
    // 
    // $motifList est la liste de tout les elements de la table motif de la bdd 
    // $viaType, int : 
    // - 0, affiche la page de d'ajout/modification des motifs de rdv
    // - 1, quand on arrive sur cette page apres création d'un type de compte
    // - 2, quand on arrive sur cette page apres création d'un type de contrat  
    //

    function gestionMotifs($motifList,$viaType,$message=0){
        $contenu = connectedHeader() . directeurAside();

        if ( $message == 1 ){
            $contenu .= '<div class="invalidForm">Ajout effectif</div>';
        } else if ( $message == 2 ){
            $contenu .= '<div class="invalidForm">Modification impossible : motif non-nommé</div>';
        } else if ( $message == 3 ){
            $contenu .= '<div class="invalidForm">Modification effective</div>';
        } else if ( $message == 4 ){
            $contenu .= '<div class="invalidForm">Création impossible</div>';
        } 


        $contenu .='
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">
            <fieldset>
                <legend>Ajouter motif RDV</legend>
                
                <p><label for="motif">Motif de RDV :</label>
                <input type="text" id="motif" name="DirecteurAjouterMotif"></p>

                <p><label for="piece">Pièce(s) à prévoir :</label>
                <textarea class="textAreaPieces" id="piece" name="DirecteurAjouterPiece"></textarea></p>

                <input class="submitFormInput" type="submit" value="Ajouter" name="DirecteurAjouterMotifSubmit">';
                
            if ($viaType != 0){
                if($viaType == 1){
                    $contenu.='<input class="submitFormInput" type="submit" value="Terminer" name="DirecteurMotifSortieCompte">'; 
                }
                else{
                    $contenu.='<input class="submitFormInput" type="submit" value="Terminer" name="DirecteurMotifSortieContrat">'; 
                }

                $contenu.='
                    </fieldset> 
                        </form>';  
            } else  {

                $contenu.='
                    </fieldset> 
                </form>
                
                <form action="index.php" method="post" class="topPageForm" id="topPageForm">
                    <fieldset>
                        <legend>Modifier un motif</legend>
                        <p>
                            <label for="typeSelection">Motif de RDV :</label>
                            <select id="typeSelection" name="DirecteurModifierMotif">';

                foreach ( $motifList as $motif){

                    $contenu .= "<option value='".$motif['idMotif']."'>".htmlentities($motif['libelleMotif'], ENT_QUOTES,"UTF-8")."</option>";
                
                }

                        $contenu .= '
                            </select>
                        </p>

                        <input class="submitFormInput" type="submit" value="Modifier" name="DirecteurModifierMotifSubmit">
                    </fieldset>
                </form>';
        }
        require_once("View/gabarit.php");
    }

    //
    // MP 
    //
    // Affiche la page de modification des motif avec leur affichage de base à l'interieur.
    //
    // $motif : libelle motif pre-existant
    // $piece : pièces necessaires pre-existante
    //
    function motifModificationPage($motif, $piece) {
        $contenu = connectedHeader() . directeurAside();
        
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm" onSubmit="modificationMotifSubmit()">

            <fieldset>

                <legend>Modifier motif</legend>

                <p><label for="motifModification">Motif :</label>
                <input type="text" id="motifModification" name="motifModification" value="'.htmlentities($motif, ENT_QUOTES,"UTF-8").'" required></p>

                <p><label for="pieceMotifModification">Pièce(s) à prévoir :</label>
                <textarea class="textAreaPieces" id="pieceMotifModification" name="pieceMotifModification" required >'.htmlentities($piece, ENT_QUOTES,"UTF-8").' </textarea></p>
                
                <div id="modification">
                    <p id="modifier">
                    <input class="submitFormInput" type="submit" value="Modifier" name="ModificationMotifSubmit" onClick="modificationMotifEditSubmit(true)"></p>
                </div>

            </fieldset>
        </form>
        ';
        require_once("View/gabarit.php");
    }

    //
    // MP 
    //
    // Affiche la page de modification des type de compte avec leur affichage de base à l'interieur.
    //

    function typeCompteModificationPage() {
        $contenu = connectedHeader() . directeurAside();
        
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm" onSubmit="modificationTypeCompteSubmit()">

            <fieldset>

                <legend>Modifier type compte</legend>

                <p><label for="typeCompteModification">Nouveau nom :</label>
                <input type="text" id="typeCompteModification" name="typeCompteModification" value="'.$_SESSION['typeCompte'].'" required></p>
                
                <div id="modification">
                    <p id="modifier">
                    <input class="submitFormInput" type="submit" value="Modifier" name="ModificationTypeCompteSubmit" onClick="modificationTypeCompteEditSubmit(true)"></p>
                </div>

            </fieldset>
        </form>
        ';
        require_once("View/gabarit.php");
    }

    //
    // MP 
    //
    // Affiche la page de modification des type de contrat avec leur affichage de base à l'interieur.
    //

    function typeContratModificationPage() {
        $contenu = connectedHeader() . directeurAside();
        
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm" onSubmit="modificationTypeContratSubmit()">

            <fieldset>

                <legend>Modifier type contrat</legend>

                <p><label for="typeContratModification">Nouveau nom :</label>
                <input type="text" id="typeContratModification" name="typeContratModification" value="'.$_SESSION['typeContrat'].'" required></p>
                
                <div id="modification">
                    <p id="modifier">
                    <input class="submitFormInput" type="submit" value="Modifier" name="ModificationTypeContratSubmit" onClick="modificationTypeContratEditSubmit(true)"></p>
                </div>

            </fieldset>
        </form>
        ';
        require_once("View/gabarit.php");
    }