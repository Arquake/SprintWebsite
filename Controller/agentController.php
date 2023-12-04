<?php

    function CtlAgentHomePage() {
        accueilAgent();
    }

    function CtlAgentResearchClient() {
        rechercheClientAgent();
    }

    function CtlAgentCreateationClient(){
        creationClientAgent();
    }

    function CtlAgentCreateClient() {

        $idClient = createClient($_POST['nomClientCreation'], $_POST['prenomClientCreation'], $_POST['dateNaissanceClientCreation']);

        $_SESSION['clientNom'] = $_POST['nomClientCreation'];
        $_SESSION['clientPrenom'] = $_POST['prenomClientCreation'];
        $_SESSION['clientNaissance'] = $_POST['dateNaissanceClientCreation'];
        $_SESSION['idClient'] = $idClient;

        $conseillersList = getAllConseillers();

        rattacherClient($conseillersList);
    }

    function CtlRattacherClient() {
        rattacherClientAgent();
        mainPageClientAgent();
    }