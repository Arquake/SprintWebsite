<?php

function CtlAgentResearchClientSubmitted() {

    $clientInfo = array ();

    if ( $_POST['idClientRecherche'] != '' ) {
        $clientInfo['ID'] = $_POST['idClientRecherche'];
    }
    
    if ( $_POST['nomClientRecherche'] != '' ) {
        $clientInfo['nomClient'] = $_POST['nomClientRecherche'];
    }

    if ( $_POST['prenomClientRecherche'] != '') {
        $clientInfo['prenomClient'] = $_POST['prenomClientRecherche'];
    }

    if ( $_POST['dateNaissanceClientRecherche'] != '') {
        $clientInfo['naissanceClient'] = $_POST['dateNaissanceClientRecherche'];
    }

    $res = rechercherClient($clientInfo);

    if ($res != false ) {
        if ( isset($res['idClient']) && isset($res['nomClient']) ) {

            $_SESSION['client'] = $res['nomClient'];
            $_SESSION['clientPrenom'] = $res['prenomClient'];
            $_SESSION['clientNaissance'] = $res['dateNaissance'];
            $_SESSION['idClient'] = $res['idClient'];

            mainPageClientAgent();
        } else if ( isset($res[0]['nomClient']) ) {
            $_SESSION['clientNom'] = $res[0]['nomClient'];
            $_SESSION['clientPrenom'] = $res[0]['prenomClient'];
            $_SESSION['clientNaissance'] = $res[0]['dateNaissance'];
            $_SESSION['idClient'] = $res[0]['idClient'];

            mainPageClientAgent();
        } else if ( isset($res[1]) ) {
            rechercheApprofondiClient($res);
        } else {
            rechercheClientAgentView(false);
        }

    } else {
        rechercheClientAgentView(false);
    }

}