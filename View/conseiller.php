<?php
    function accueilConseiller(){
        $contenu = connectedHeader();
        if ( isset($_SESSION['idClient']) ) {

            $contenu .= AgentAsideSideBarWhenClientConnected();

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
                    <li><input class="asideInput" type="submit" value="Modification Découvert" name="asideConseillerModifDecouvert"></li>
                    <li><input class="asideInput" type="submit" value="Résiliation" name="asideConseillerResiliation"></li>

                </ul>
            </form>
        </aside>';
    }