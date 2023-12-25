<?php


    //
    // NV
    //
    // 
    //

    function directeurAside() {
        return '
        <aside>
            <form action="index.php" method="post">
                <ul class="asideUl">

                    <li class="asideLi"><input class="asideInput" type="submit" value="Gestion Employé" name="asideDirecteurGestionEmploye"></li>

                    <li class="asideLi"><input class="asideInput" type="submit" value="Gestion RDV" name="asideDirecteurGestionRendezVous"></li>

                    <li class="asideLi"><input class="asideInput" type="submit" value="Gestion Compte" name="asideDirecteurGestionCompte"></li>
                    
                    <li class="asideLi"><input class="asideInput" type="submit" value="Gestion Contrat" name="asideDirecteurGestionContrat"></li>

                    <li class="asideLi"><input class="asideInput" type="submit" value="Statistiques" name="asideDirecteurStats"></li>

                </ul>
            </form>
        </aside>';
    }


    //
    // NV
    //
    // 
    //

    function accueilDirecteur(){
        $contenu = connectedHeader() . directeurAside();
        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // 
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
                        
                        $contenu .= "<option value=".$employe['login'].">".$employe['nomEmploye']." - ".$employe['prenomEmploye']." - ".$employe['poste']."</option>";

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
                <p><label for="nomCreation">Nom de l\'employé</label><input type="text" name="nomCreation" required="required" value="'.$employe['nomEmploye'].'"></p>
                <p><label for="prenomCreation">Prénom de l\'employé</label><input type="text" name="prenomCreation" required="required" value="'.$employe['prenomEmploye'].'"></p>
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
                <input class="submitFormInput" type="submit" value="Créer employé" name="DirecteurCreerEmploye">

                <input class="submitFormInput" type="submit" value="Modifier employé" name="DirecteurModifierEmploye">
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
    function gestionCompte($typeList, $sortie = 0){
        $contenu = connectedHeader() . directeurAside();

        if ( $sortie == 1 ){
            $contenu .= '<div class="invalidForm">Ajout effectif</div>';
        } else if ( $sortie == 4 ){
            $contenu .= '<div class="invalidForm">Ajout impossible : type déjà existant </div>';
        } else if ( $sortie == 2 ){
            $contenu .= '<div class="invalidForm">Suppression effective</div>';
        } else if ( $sortie == 3 ){
            $contenu .= '<div class="invalidForm">Suppression impossible : type encore utilisé </div>';
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
                <legend>Retirer un type de compte</legend>
                </p>

                <p>
                    <label for="typeSelection">Type de Compte :</label>
                    <select id="typeSelection" name="DirecteurSupprimerCompteType">';

                foreach ( $typeList as $type){

                    $contenu .= "<option value=".$type['typeCompte'].">".$type['typeCompte']."</option>";
                
                }

                $contenu .= '
                    </select>
                </p>

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
    function gestionContrat($typeList, $sortie = 0){
        $contenu = connectedHeader() . directeurAside();

        if ( $sortie == 1 ){
            $contenu .= '<div class="invalidForm">Ajout effectif</div>';
        } else if ( $sortie == 4 ){
            $contenu .= '<div class="invalidForm">Ajout impossible : type déjà existant </div>';
        } else if ( $sortie == 2 ){
            $contenu .= '<div class="invalidForm">Suppression effective</div>';
        } else if ( $sortie == 3 ){
            $contenu .= '<div class="invalidForm">Suppression impossible : type encore utilisé </div>';
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

                    $contenu .= "<option value=".$type['typeContrat'].">".$type['typeContrat']."</option>";
                
                }

                $contenu .= '
                    </select>
                </p>

            <input class="submitFormInput" type="submit" value="Retirer" name="DirecteurRetirerContratSubmit">
            </fieldset>
        </form>';
        require_once("View/gabarit.php");
    }

    function modifierPiece(){
        $contenu = connectedHeader() . directeurAside();
        require_once("View/gabarit.php");
    }

    
    function directeursStats(){
        $contenu = connectedHeader() . directeurAside();
        require_once("View/gabarit.php");
    }
