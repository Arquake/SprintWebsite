<?php


    //
    // NV
    //
    // inscription d'un client
    //

    function inscriptionClientConseiller() {
        $connexion = getConnect();

        $query = "UPDATE client SET 
        
        nomClient=:nom,
        prenomClient=:prenom,
        dateNaissance=:naissance,
        estInscrit='1',
        numeroTelephone=:tel,
        mail=:mail,
        adresse=:adresse,
        codePostale=:code,
        profession=:prof,
        situation=:situation,
        dateInscription = CURRENT_DATE
        
        WHERE idClient=:idClient";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':nom', $_POST['nomClientInscription'], PDO::PARAM_STR);
        $prepare->bindValue(':prenom', $_POST['prenomClientInscription'], PDO::PARAM_STR);
        $prepare->bindValue(':naissance', $_POST['dateNaissanceClientInscription'], PDO::PARAM_STR);
        $prepare->bindValue(':tel', $_POST['telephoneClientInscription'], PDO::PARAM_INT);
        $prepare->bindValue(':mail', $_POST['mailClientInscription'], PDO::PARAM_STR);
        $prepare->bindValue(':adresse', $_POST['adresseClientInscription'], PDO::PARAM_STR);
        $prepare->bindValue(':code', $_POST['codePostalClientInscription'], PDO::PARAM_INT);
        $prepare->bindValue(':prof', $_POST['professionClientInscription'], PDO::PARAM_STR);
        $prepare->bindValue(':situation', $_POST['situationClientInscription'], PDO::PARAM_STR);
        $prepare->bindValue(':idClient', $_SESSION['idClient'], PDO::PARAM_INT);

        $prepare -> execute();

    }


    //
    // NV
    //
    // récupère tout les types de compte
    //

    function getAllTypeCompte() {
        $connexion = getConnect();

        $resultat = ($connexion->query("SELECT * FROM compte"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // NV
    //
    // créé le compte en accordance avec les paramètres fourni et vérifié
    //

    function creerCompteConseiller() {
        $connexion = getConnect();

        $query = "INSERT INTO compteclient(idClient, dateOuverture, solde, interet, montantDecouvert, plafond, typeCompte) VALUES(
            :id,
            CURRENT_DATE,
            :solde,
            :interet,
            :decouvert,
            :plafond,
            :type)";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':id', $_SESSION['idClient'], PDO::PARAM_INT);
        $prepare->bindValue(':solde', $_POST['soldeInitial'], PDO::PARAM_STR);
        $prepare->bindValue(':interet', $_POST['interetCreation'], PDO::PARAM_STR);
        $prepare->bindValue(':decouvert', $_POST['decouvertCreation'], PDO::PARAM_STR);
        $prepare->bindValue(':plafond', $_POST['plafondCreation'], PDO::PARAM_STR);
        $prepare->bindValue(':type', $_POST['compteType'], PDO::PARAM_STR);

        $prepare -> execute();

        $res = ($connexion -> query("SELECT MAX(idCompte)'max' FROM compteclient")) -> fetch(PDO::FETCH_ASSOC)['max'];

        if ( intval($_POST['soldeInitial']) != 0 ) {

            $query = "INSERT INTO operation(idCompte, typeOperation, montant, dateOperation) VALUES (:id,'dépot',:solde, CURRENT_DATE)";

            $prepare = $connexion->prepare($query);

            $prepare->bindValue(':id', $res, PDO::PARAM_STR);
            $prepare->bindValue(':solde', $_POST['soldeInitial'], PDO::PARAM_STR);

            $prepare -> execute();
        }
    }


    //
    // NV
    //
    // récupère tout les types de contrats
    //

    function getAllTypeContrat() {
        $connexion = getConnect();

        $resultat = ($connexion->query("SELECT * FROM contrat"))->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }


    //
    // NV
    //
    // créé le compte en accordance avec les paramètres fourni et vérifié
    //

    function creerContratConseiller() {
        $connexion = getConnect();

        $query = "INSERT INTO contratclient(idClient, dateVente, tarifMensuel, typeContrat) VALUES (:id ,CURRENT_DATE,:tarif ,:type )";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':id', $_SESSION['idClient'], PDO::PARAM_INT);
        $prepare->bindValue(':tarif', $_POST['tarifCreation'], PDO::PARAM_STR);
        $prepare->bindValue(':type', $_POST['contratType'], PDO::PARAM_STR);

        $prepare -> execute();
    }


    //
    // NV
    //
    // récupère tout les comptes du client
    //

    function getAllCompteClient() {
        $connexion = getConnect();

        $query = "SELECT * FROM compteclient WHERE idClient=:id";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':id', $_SESSION['idClient'], PDO::PARAM_INT);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);

        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }


    //
    // NV
    //
    // récupère tout les contrats du client
    //

    function getAllContratClient() {
        $connexion = getConnect();

        $query = "SELECT * FROM contratclient WHERE idClient=:id";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':id', $_SESSION['idClient'], PDO::PARAM_INT);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);

        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }


    //
    // NV
    //
    // modifie le découvert du compte choisi
    //

    function modifierDecouvert() {
        $connexion = getConnect();

        $query = "UPDATE compteclient SET montantDecouvert=:montant WHERE idCompte=:idCompte";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':montant', $_POST['decouvertModification'], PDO::PARAM_STR);
        $prepare->bindValue(':idCompte', $_POST['listeComptes'], PDO::PARAM_STR);

        $prepare -> execute();
    }


    //
    // NV
    //
    // récupère le solde du compte
    //

    function getSoldeClient() {
        $connexion = getConnect();

        $query = "SELECT solde FROM compteclient WHERE idCompte=:idCompte";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':idCompte', $_POST['resiliationCompte'], PDO::PARAM_INT);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);

        return $prepare->fetch(PDO::FETCH_ASSOC)['solde'];
    }


    //
    // NV
    //
    // résilie le contrat selectionner
    //

    function resilierContrat() {
        $connexion = getConnect();

        $query = "DELETE FROM contratclient WHERE idContrat=:idContrat";

        $prepare = $connexion->prepare($query);
        
        $prepare->bindValue(':idContrat', $_POST['resiliationContrat'], PDO::PARAM_INT);

        $prepare -> execute();
    }


    //
    // NV
    //
    // résilie le compte selectionner
    //

    function resilierCompte() {
        $connexion = getConnect();

        $query = "DELETE FROM compteclient WHERE idCompte=:idCompte";

        $prepare = $connexion->prepare($query);
        
        $prepare->bindValue(':idCompte', $_POST['resiliationCompte'], PDO::PARAM_INT);

        $prepare -> execute();
    }


    //
    // NV
    //
    // récupère le client lié au rdv
    //

    function getclientByRDV() {
        $connexion = getConnect();

        $query = "SELECT idClient FROM rendezvous WHERE idRDV=:idRDV";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':idRDV', $_POST['clientButtonResearch'], PDO::PARAM_INT);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);

        return $prepare->fetch(PDO::FETCH_ASSOC)['idClient'];
    }


    //
    // NV
    //
    // récupère tout les RDV liés au client
    //

    function getAllRdvOfClient() {
        $connexion = getConnect();

        $query = "SELECT * FROM rendezvous WHERE idClient=:id ORDER BY jourReunion ASC, heureDebut ASC";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':id', $_SESSION['idClient'], PDO::PARAM_INT);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);

        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }


    //
    // NV
    //
    // récupère toutes les transactions d'un client
    //

    function getAllOperationsClient() {
        $connexion = getConnect();

        $query = "SELECT * FROM operation WHERE idCompte IN (SELECT idCompte FROM compteclient WHERE idClient=:id) ORDER BY idOperation DESC";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':id', $_SESSION['idClient'], PDO::PARAM_INT);

        $prepare -> execute();

        $prepare -> setFetchMode(PDO::FETCH_ASSOC);

        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }


    //
    // NV
    //
    // vérifie si le client est Inscrit
    //

    function clientInscritCheck() {
        $connexion = getConnect();

        $query = "SELECT estInscrit FROM client WHERE idClient=:idClient";

        $prepare = $connexion->prepare($query);

        $prepare->bindValue(':idClient', $_SESSION['idClient'], PDO::PARAM_INT);

        $prepare -> execute();

        $prepare->setFetchMode(PDO::FETCH_ASSOC);

        return $prepare->fetch(PDO::FETCH_ASSOC);
    }