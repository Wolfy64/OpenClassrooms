<?php 
    session_start();

    // Affiche le nom de l'utilisateur si il est connecté
    if (isset($_SESSION['pseudo'])){
        $_SESSION['pseudo'];
    }else {
        $_SESSION['pseudo'] = 'inconnu(e)';
    }

    // Si les cookies "pseudo" et "password" sont présent les champs de connexion sont pré-remplis
    if (isset($_COOKIE['pseudo'], $_COOKIE['password'])){
        $_COOKIE['pseudo'];
        $_COOKIE['password'];
    }else{
        $_COOKIE['pseudo'] = "";
        $_COOKIE['password']= "";
    }

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Connexion</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <h3>Bonjour <?php echo $_SESSION['pseudo']; ?></h3>
        <?php

        ?>
        <form method="POST" action="post_connexion.php">
            <label for="pseudo">Pseudo: </label>
            <input type="text" name="pseudo" placeholder="Votre pseudo" id="pseudo" value="<?php echo $_COOKIE['pseudo']; ?>" required>
            <br>
            <label for="password">Mot de passe: </label>
            <input type="password" name="password" placeholder="Votre mot de pace" value="<?php echo $_COOKIE['password']; ?>" required>
            <br>
            <label for="remember_me">Connexion automatique</label>
            <input type="checkbox" name="remember_me" value="remember_me" id="remember_me">
            <br>
            <input type="submit" value="Connexion" style="margin-left:200px">
        </form>
        
        <a href="index.php">Retour page d'acceuil</a>
    </body>
</html>