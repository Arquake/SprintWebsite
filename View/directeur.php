<?php

    function accueilDirecteur(){
        $contenu = connectedHeader();
        $contenu .= '
        <aside>
            <form action="index.php" method="post">
                <ul>

                    <li><input class="asideInput" type="submit" value="Créer Employé" name="asideDirecteurCreerEmploye"></li>

                </ul>
            </form>
        </aside>';
        require_once("View/gabarit.php");
    }

    function gestionEmployeDirecteur($employeCreated = false){
        $contenu = connectedHeader();
        $contenu .= '
        <aside>
            <form action="index.php" method="post">
                <ul>

                    <li><input class="asideInput" type="submit" value="Créer Employé" name="asideDirecteurCreerEmploye"></li>

                </ul>
            </form>
        </aside>';
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
                <p><input type="submit" value="Créer" name="createEmploye"></p>
            </fieldset>
        </form>';
        require_once("View/gabarit.php");
    }