<?php
    function accueilConseiller(){
        $contenu = connectedHeader();
        $contenu .= '
        <aside></aside>';
        require_once("View/gabarit.php");
    }