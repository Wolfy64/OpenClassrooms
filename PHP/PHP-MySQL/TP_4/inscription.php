<?php 
    session_start();

    if (isset($_SESSION['pseudo'])){
        $_SESSION['pseudo'];
    }else {
        $_SESSION['pseudo'] = 'inconnu(e)';
    }

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Inscription</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" rel="stylesheet">
    </head>

    <body>
        <h3>Bonjour <?php echo $_SESSION['pseudo']; ?></h3>
        <form method="post" action="post_inscription.php" name="inscription">
            <h4>Veuillez remplir le formulaire pour vous inscrire</h4>
            <label for="pseudo">Pseudo: </label>
            <input type="text" name="pseudo" placeholder="Votres pseudo ici" id=pseudo required>
            <br>
            <label for="password">Mot de passe: </label>
            <input type="password" name="password" placeholder="Votre mot de passe" id="password" required>
            <br>
            <label for="check_password">Retapez votre mot de passe: </label>
            <input type="password" name="check_password" placeholder="Votre mot de passe" id="check_password" required>
            <br>
            <label for="email">Adresse E-mail: </label>
            <input type="text" name="email" placeholder="exemple@email.com" id="email" required>
            <br>
            <div class="button">
            <input type="reset" value="Remettre à zero">
            <input type="submit" value="Inscription" style="margin-left:120px">
            </div>

        </form>
        <a href="index.php">Retour page d'acceuil</a>
    </body>
</html>