<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" type="text/css" href="View/style/style.css">
    <link rel="preload" href="View/style/fonts/SFProDisplay-Bold.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="View/style/fonts/SFProDisplay-Bold.woff" as="font" type="font/woff" crossorigin>

    <script src="app.js"></script> 

    <title>MGN</title>
</head>
<body>
    <header><img src="View/style/assets/logo.png" alt="" id="logo"></header>




    <?php
        echo $contenu;
    ?>


    <form action="index.php" method="post" class="topPageForm" onSubmit="createEmployeCheck(this)" id="topPageForm">
        <fieldset>
            <legend>Création d'employé</legend>
            <p><label for="login">Login de l'employé</label><input type="text" name="loginCreation" onBlur="validFormField( this, 2, 32 )" required="required"></p>
            <p><label for="password">Mot De Passe de l'employé</label><input type="password" name="passwordCreation" onBlur="validFormField( this, 8, 32 )" required="required"></p>
            <p>
                <label for="posteCreation">Poste de l'empolyé</label>
                <select id="posteCreation" name="posteCreation">
                    <option value="Agent">Agent</option>
                    <option value="Conseiller">Conseiller</option>
                </select>
            </p>
            <p><input type="submit" value="Créer" name="createEmploye"></p>
        </fieldset>
    </form>

</body>
</html>