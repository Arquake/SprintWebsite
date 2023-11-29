<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="View/style/style.css">
    <link rel="preload" href="View/style/fonts/SFProDisplay-Bold.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="View/style/fonts/SFProDisplay-Bold.woff" as="font" type="font/woff" crossorigin>
</head>
<body>
    <header><img src="View/style/assets/logo.png" alt="" id="logo"></header>

    <form action="index.php" method="post" class="connexionForm">
        <fieldset>
            <legend>Connexion</legend>
            <p><label for="">Login</label><input type="text"></p>
            <p><label for="">Mot De Passe</label><input type="password"></p>
            <p><input type="submit" value="Connexion"></p>
        </fieldset>
    </form>

    <?php
        echo $contenu;
    ?>

</body>
</html>