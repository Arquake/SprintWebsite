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

                    <li><input class="asideInput" type="submit" value="Inscrire Client" name="asideConseillerInscrireClient"></li>
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


    function inscrireClient() {

    }