<?php

    require_once("agent.php");
    require_once("conseiller.php");
    require_once("directeur.php");


    //
    // NV
    //
    // affiche la page de connexion
    //

    function accueil($validForm = true){
        $contenu = '
        <header><img src="View/style/assets/logo.png" alt="" id="logo"></header>
        <aside></aside>';
        if ( !$validForm ){
            $contenu .= '<div class="invalidForm">Formulaire non valide<br>mot de passe ou login incorrect</div>';
        };
        $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm" onSubmit="connexionAttempt(this)">
            <fieldset>
                <legend>Connexion</legend>
                <p><label for="login">Identifiant</label><input type="text" name="login" onBlur="validFormField( this, 2, 32 )" required="required"></p>
                <p><label for="password">Mot de passe</label><input type="password" name="password" onBlur="validFormField( this, 8, 32 )" required="required"></p>
                <p><input class="submitFormInput" type="submit" value="Connexion" name="connexion"></p>
            </fieldset>
        </form>';
        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // Affiche cette page en cas d'erreur dans l'index
    //

    function error( $exception ){
        $contenu = '
        <header><img src="View/style/assets/logo.png" alt="" id="logo"></header>
        <aside></aside>
        <div class="invalidForm">Une erreur s\'est produite</div>
        <div class="invalidForm">'.$exception->getMessage().'</div>
        <div class="error"><a class="errorATag" href="index.php">Cliquez ici pour retourner à l\'accueil</a></div>';
        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // Header avec le logo le bouton de déconnexion et le Prénom et Nom de l'agent connecté
    //
    //
    //
    //
    //

    function connectedHeader() {
        return '
        <header>
            <form action="index.php" method="POST" id="topForm">
                <input type="image" src="View/style/assets/logo.png" alt="Submit" id="logo" name="menu">

                <input class="topFormInformation" type="text" name="login" value="[ '.$_SESSION['poste'].' ] '.$_SESSION['prenom'].' '.$_SESSION['nom'].'" disabled="disabled">

                <input type="image" src="View/style/assets/logout.png" alt="Submit" id="signOut" name="deconnexion">
            </form>
        </header>
        ';
    }

    
    //
    // NV
    //
    // création de bulle dans l'EDT
    //

    function EDTBubble($arr){
        if ( $arr['idClient'] != -1 ) {
            if( $_SESSION['poste'] == 'Conseiller' ) {
                return '
            <td class="edttdHoraire">
            <form method="post">
                <button name="clientButtonResearch" class="insidetd" value="'.$arr['idRdv'].'">
                    <div class="horaires">
                        '.$arr['heureDebut'].'
                        <br>
                        '.$arr['heureFin'].'
                    </div>
                    <div class="indordvtd">
                        idRDV : '.$arr['idRdv'].'
                    </div>
                    <div class="indordvtd">
                        client : '.$arr['idClient'].'
                    </div>
                    <div class="indordvtd">
                        motif : '.$arr['idMotif'].'
                    </div>
                </button>
            </form>
            </td>';
            } else {
                return '
            <td class="edttdHoraire">
                <div class="insidetd" value="'.$arr['idClient'].'">
                    <div class="horaires">
                        '.$arr['heureDebut'].'
                        <br>
                        '.$arr['heureFin'].'
                    </div>
                    <div class="indordvtd">
                        id RDV : '.$arr['idRdv'].'
                    </div>
                    <div class="indordvtd">
                        id Client : '.$arr['idClient'].'
                    </div>
                    <div class="indordvtd">
                        id Motif : '.$arr['idMotif'].'
                    </div>
                </div>
            </td>';
            }
        }

        return '
            <td class="edttdHoraire">
                <div class="formation">
                    <div class="horaires">
                        '.$arr['heureDebut'].'
                        <br>
                        '.$arr['heureFin'].'
                    </div>
                    <div class="indordvtd">
                        idRDV : '.$arr['idRdv'].'
                    </div>
                    <div class="indordvtd">
                        motif : '.$arr['idMotif'].'
                    </div>
                </div>
            </td>';
    }


    //
    // NV
    //
    // retourne le form de la synthèse pour changer de page
    //

    function synthesePageForm() {
        return '
        <form action="index.php" method="post">
            <ul class="syntheseUl">

                <li class="syntheseLi"><input class="syntheseInput" type="submit" value="Comptes" name="syntheseComptes"></li>
                <li class="syntheseLi"><input class="syntheseInput" type="submit" value="Contrats" name="syntheseContrats"></li>
                <li class="syntheseLi"><input class="syntheseInput" type="submit" value="Rendez-Vous" name="syntheseRdv"></li>

            </ul>
        </form>';
    }


    //
    // NV
    //
    // créé la vue de la synthèse client des RDV du client
    //

    function synthèseClientInformations($estInscrit, $synthese) {

        $contenu = '<h1 class="syntheseHeadingTitle">Synthèse rendez-vous client</h1>
        <div class="clientSynthesisInformation" style="';

        if( !$estInscrit ) {
            $contenu .= 'border-radius:10px;';
        }

        $contenu .= '">

            <div class="topinfoClientSynthesis">
                ID client : ' . $synthese['idClient'] . '
            </div>

            <div class="topinfoClientSynthesis">
                Client : ' . $synthese['nomClient'] . ' '.$synthese['prenomClient'] . '
            </div>

        </div>';

        if ( $estInscrit ) {
            $contenu .= '<div class="clientInscritSupplementInfoRight">

                <div class="rightinfoClientSynthesis">
                    profession : ' . $synthese['profession'] . '
                </div>

                <div class="rightinfoClientSynthesis">
                    situation : ' . $synthese['situation'] . '
                </div>

            </div>

            <div class="clientInscritSupplementInfoBottom">

                <div class="bottominfoClientSynthesis">
                    adresse : ' . $synthese['adresse'] . ' '. $synthese['codePostale'] . '
                </div>

                <div class="bottominfoClientSynthesis">
                    mail : ' . $synthese['mail'] . '
                </div>

                <div class="bottominfoClientSynthesis">
                    numéro de téléphone : ' . $synthese['numeroTelephone'] . '
                </div>
                
            </div>';
        }

        return $contenu;
    }


    //
    // NV
    //
    // page de la synthèse client si il est inscrit
    //
    // $rdv si la fonction est utilisé par planning met en valeur le RDV choisi
    //

    function clientRdvSynthèse( $synthese, $estInscrit, $relevantArrayVenir, $relevantArrayPasse, $motifList, $rdv = false ) {
        $contenu = '
        <script>

            var arrPasse = [';
            $i = 0;
            while ( $i < count($relevantArrayPasse)-1 ) {
                $arr=$relevantArrayPasse[$i];
                $contenu .= '["'.$arr['idRdv'].'","'.$arr['jourReunion'].'","'.$arr['heureDebut'].'","'.$arr['heureFin'].'","'.$arr['dateCreationRdv'].'","'.$motifList[$arr['idMotif']]['libelleMotif'].'", '.str_replace('\r','',json_encode($motifList[$arr['idMotif']]['listePiece'])).'],';
                $i++;
            }

            if ( count($relevantArrayPasse) != 0 ) {
                $arr=$relevantArrayPasse[$i];
                $contenu .= '["'.$arr['idRdv'].'","'.$arr['jourReunion'].'","'.$arr['heureDebut'].'","'.$arr['heureFin'].'","'.$arr['dateCreationRdv'].'","'.$motifList[$arr['idMotif']]['libelleMotif'].'", '.str_replace('\r','',json_encode($motifList[$arr['idMotif']]['listePiece'])).']';
            }
            
            $contenu .= '];

            var arrVenir = [';
            $i = 0;
            while ( $i < count($relevantArrayVenir)-1 ) {
                $arr=$relevantArrayVenir[$i];
                $contenu .= '["'.$arr['idRdv'].'","'.$arr['jourReunion'].'","'.$arr['heureDebut'].'","'.$arr['heureFin'].'","'.$arr['dateCreationRdv'].'","'.$motifList[$arr['idMotif']]['libelleMotif'].'", '.str_replace('\r','',json_encode($motifList[$arr['idMotif']]['listePiece'])).'],';
                $i++;
            }

            if ( count($relevantArrayVenir) != 0 ) {
                $arr=$relevantArrayVenir[$i];
                $contenu .= '["'.$arr['idRdv'].'","'.$arr['jourReunion'].'","'.$arr['heureDebut'].'","'.$arr['heureFin'].'","'.$arr['dateCreationRdv'].'","'.$motifList[$arr['idMotif']]['libelleMotif'].'", '.str_replace('\r','',json_encode($motifList[$arr['idMotif']]['listePiece'])).']';
            }
            
            $contenu .= '];

        </script>
        ';

        $contenu .= connectedHeader();

            

            if ( $_SESSION['poste'] == 'Conseiller' ) {
                if( $estInscrit ) {
                    $contenu .= ConseillerAsideSideBarWhenClientConnected() . synthesePageForm();
                } else {
                    $contenu .= ConseillerAsideSideBarWhenClientConnectedNonInscrit();
                }
            } else if ( $_SESSION['poste'] == 'Agent' ){
                if( $estInscrit ) {
                    $contenu .= AgentAsideSideBarWhenClientConnected() . synthesePageForm();
                } else {
                    $contenu .= AgentAsideSideBarWhenClientConnected();
                }
            }

            

            $contenu .= '<div class="clientSynthesis">
            ' .

            synthèseClientInformations( $estInscrit, $synthese) 

            . '<h1 class="syntheseBubbuleTitle">Rdv à venir</h1>
            <div class="listeRDV" id="RdvVenir">

                <input type="image" src="View/style/assets/Left-Arrow.png" class="smallarrowNextPage" id="rdvVenirMinusVenir">

                

                <input type="image" src="View/style/assets/Right-Arrow.png" class="smallarrowNextPage" id="rdvVenirAddVenir"></input>

                
            </div>
            
            <h1 class="syntheseBubbuleTitle">précédent rdv</h1>
            <div class="listeRDV" id="RdvPasse">

                <input type="image" src="View/style/assets/Left-Arrow.png" class="smallarrowNextPage" id="rdvVenirMinusPasse">

                

                <input type="image" src="View/style/assets/Right-Arrow.png" class="smallarrowNextPage" id="rdvVenirAddPasse"></input>

            </div>
            
            
            <h1 class="syntheseBubbuleTitle">Information rdv</h1>
            <div class="informationRDVSynthese" id="infoSyntheseBlock">';
                if( $rdv != false ) {
                    $contenu .='<div class="leftSyntheseInfo">
                        Jour : ' . $rdv['jourReunion'] .
                        '<br>
                        heure de début : ' . $rdv['heureDebut'] .
                        '<br>
                        heure de fin : ' . $rdv['heureFin'] .
                    '</div>
                    <div class="rightSyntheseInfo">
                        Motif : ' . $motifList[$rdv['idMotif']]['libelleMotif'] .
                        '<br>
                        Liste Pièces Necessaire : <textarea class="rightSyntheseInfoTextarea" disabled>' . $motifList[$rdv['idMotif']]['listePiece'] . '</textarea>
                    </div>';
                }
                
                
            $contenu .= '</div>';

            
            
        $contenu .='</div>
        <script>

        var indexOfPageRdvVenir = 0;
        var indexOfPageRdvPasse = 0;

        getFiveElementsVenir();
        getFiveElementsPasse();

        </script>
        ';

        require_once("View/gabarit.php");

    }


    //
    // NV
    //
    // affiches les informations des comptes du client
    //

    function clientComptesSynthèse( $synthese, $comptes, $operations ) {
        $contenu = connectedHeader();

        if ( $_SESSION['poste'] == 'Conseiller' ) {
            $contenu .= ConseillerAsideSideBarWhenClientConnected();
        } else if ( $_SESSION['poste'] == 'Agent' ){
            $contenu .= AgentAsideSideBarWhenClientConnected();
        }

        $contenu .= synthesePageForm() ;

        $contenu .= '<div class="clientSynthesis">' . synthèseClientInformations( true, $synthese) . '

        <h1 class="syntheseBubbuleTitle">Liste Comptes</h1>
        <div class="syntheseComptes">';

        foreach( $comptes as $compte) {
            $contenu .= compteBubble( $compte ) ;
        }

        

        $contenu .= '
            </div>';

        $contenu .= '
            <h1 class="produitClosTexte">Produit Clos</h1>
            <div class="produitClos" id="produitClos">
            
            </div>
        </div>
        
        <script>
            '.$operations.'
        </script>
        ';

        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // affiches les informations des contrats du client
    //

    function clientContratsSynthèse( $synthese, $contrats ) {

        $contenu = connectedHeader();

        if ( $_SESSION['poste'] == 'Conseiller' ) {
            $contenu .= ConseillerAsideSideBarWhenClientConnected();
        } else if ( $_SESSION['poste'] == 'Agent' ){
            $contenu .= AgentAsideSideBarWhenClientConnected();
        }

        $contenu .= synthesePageForm() ;

        $contenu .= '<div class="clientSynthesis">' . synthèseClientInformations( true, $synthese) .'

        <h1 class="syntheseBubbuleTitle">Liste Contrats</h1>
        <div class="syntheseComptes">';
            
        foreach( $contrats as $contrat) {
            $contenu .= contratBubble( $contrat ) ;
        }

        $contenu .= '
            </div>
        </div>';

        require_once("View/gabarit.php");
    }


    //
    // NV
    //
    // renvoi une bulle avec le compte concerné
    //

    function compteBubble( $compte ) {
        $contenu = '
        <div class="insideBubbleCompte">
            <div class="preDivCompte" onClick="setProduitClos( '.$compte['idCompte'].' )">
                id Compte : '.$compte['idCompte'].'
            </div>
            <div class="divCompte" onClick="setProduitClos( '.$compte['idCompte'].' )">
                <div class="divInsideDivCompte">
                    <div style=" float:left;">
                        typeCompte : '.$compte['typeCompte'].'
                    </div>
                    <div class="infoTopCompte">
                        date ouverture : '.$compte['dateOuverture'].'
                    </div>
                    <div class="infoTopCompte">
                        solde : '.$compte['solde'].' €
                    </div>

                </div>
                <br>
                <div class="divInsideDivCompte">
                    <div style="float:left;">
                        decouvert : '.$compte['montantDecouvert'].' €
                    </div>';
                    if ( $compte['interet'] != 0 ) {
                        $contenu .= '<div class="infoBottomCompte">
                        interet : '.$compte['interet'].' %
                        </div>';
                    }

                    if ( $compte['plafond'] != 0 ) {
                        $contenu .= '<div class="infoBottomCompte">
                        plafond : '.$compte['plafond'].' €
                    </div>';
                    }
                    
                    

                $contenu .= '</div>
            </div>
        </div>';

        return $contenu;
    }


    //
    // NV
    //
    // renvoi une bulle avec le contrat concerné
    //

    function contratBubble( $contrat ) {
        return '
        <div class="insideBubbleCompte">
            <div class="preDivCompte" style="cursor: context-menu;">
                id Compte : '.$contrat['idContrat'].'
            </div>
            <div class="divContrat">
                <div class="divInsideDivCompte">
                    <div class="contratInfoInBubble">
                        typeCompte : <br>'.$contrat['typeContrat'].'
                    </div>
                    <div class="contratInfoInBubble">
                        date ouverture : <br> '.$contrat['dateVente'].'
                    </div>
                    <div class="contratInfoInBubble">
                        Tarif Mensuel : <br> '.$contrat['tarifMensuel'].' €
                    </div>

                </div>
            </div>
        </div>';
    }


    //
    // NV
    //
    // vue de modification de découvert
    //

    function modificationDecouvert( $listeCompte, $modifier = false, $erreur = false ) {

        $contenu = connectedHeader();

        if ( $_SESSION['poste'] == 'Conseiller' ) {
            $contenu .= ConseillerAsideSideBarWhenClientConnected();
        } else if ( $_SESSION['poste'] == 'Agent' ){
            $contenu .= AgentAsideSideBarWhenClientConnected();
        }
        
        if ( $modifier ){
            $contenu .= '<div class="invalidForm">Modification Appliqué</div>';
        } else if ( $erreur ) {
            $contenu .= '<div class="invalidForm">Une erreur a été rencontré durant<br>la modification du découvert</div>';
        }

        if ( empty($listeCompte) ) {
            $contenu .= '<div class="invalidForm">Pas de compte lié au client</div>';
        } else {
            $contenu .= '
        <form action="index.php" method="post" class="topPageForm" id="topPageForm">

            <fieldset>

                <legend>Modifier Découvert</legend>

                    <label for="listeComptes">Compte</label>
                    <select id="listeComptes" name="listeComptes">';

                    foreach ( $listeCompte as $compte){
                        
                        $contenu .= "<option value='".$compte['idCompte']."'>".$compte['idCompte']." - ".$compte['typeCompte']." - [ ".$compte['montantDecouvert']." ]</option>";

                    }


        $contenu .= '
                    </select>

                    <p><label for="decouvertModification">Nouveau Découvert</label><input type="number" name="decouvertModification"" id="decouvert" onBlur="soldeCheckPositive(this)"></p>

                <p><input class="submitFormInput" type="submit" value="Modifier" name="modifierDecouvertSubmit"></p>
            </fieldset>
        </form>';
        }
        
        require_once("View/gabarit.php");
    }