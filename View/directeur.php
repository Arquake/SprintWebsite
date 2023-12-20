<?php


function directeurAside() {
    return '
    <aside>
        <form action="index.php" method="post">
            <ul>

                <li><input class="asideInput" type="submit" value="Créer Employé" name="asideDirecteurCreerEmploye"></li>
                
                <li><input class="asideInput" type="submit" value="Modifier Employé" name="asideDirecteurModifierEmploye"></li>

                <li><input class="asideInput" type="submit" value="Modifier pièces" name="asideDirecteurModifierPiece"></li>

                <li><input class="asideInput" type="submit" value="Statistiques" name="asideDirecteurStats"></li>

            </ul>
        </form>
    </aside>';
}


    function accueilDirecteur(){
        $contenu = connectedHeader() . directeurAside();
        require_once("View/gabarit.php");
    }

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
                <p><label for="loginCreation">Login de l\'employé</label><input type="text" name="loginCreation" onBlur="validFormField( this, 2, 32 )" required="required"></p>
                <p><label for="password">Mot De Passe de l\'employé</label><input type="password" name="passwordCreation" onBlur="validFormField( this, 8, 32 )" required="required"></p>
                <p>
                    <label for="posteCreation">Poste de l\'empolyé</label>
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


    function modifierEmployeForms($employes){
        $contenu = connectedHeader() . directeurAside() . '
        <form action="index.php" method="post" class="topPageForm" onSubmit="createEmployeCheck(this)" id="topPageForm">
            <fieldset>
                <legend>Choisir l\'employé à modifier</legend>
                <p><label for="modifierLemploye">Employe</label>
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


    function modificationSelectedEmploye( $employe ) {
        $contenu = connectedHeader() . directeurAside() . '
        <form action="index.php" method="post" class="topPageForm" onSubmit="createEmployeCheck(this)" id="topPageForm">
            <fieldset>
                <legend>Création d\'employé</legend>
                <p><label for="nomCreation">Nom de l\'employé</label><input type="text" name="nomCreation" onBlur="validFormField( this, 2, 45 )" required="required" value="'.$employe['nomEmploye'].'"></p>
                <p><label for="prenomCreation">Prénom de l\'employé</label><input type="text" name="prenomCreation" onBlur="validFormField( this, 2, 45 )" required="required" value="'.$employe['prenomEmploye'].'"></p>
                <p><label for="loginCreation">Login de l\'employé</label><input type="text" name="loginCreation" onBlur="validFormField( this, 2, 32 )" required="required" value="'.$employe['login'].'"></p>
                <p><label for="password">Mot De Passe de l\'employé</label><input type="password" name="passwordCreation" onBlur="validFormField( this, 8, 32 )" required="required"></p>
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
                <p><input class="submitFormInput" type="submit" value="Créer" name="modifierEmployeChoisiSubmit"></p>
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