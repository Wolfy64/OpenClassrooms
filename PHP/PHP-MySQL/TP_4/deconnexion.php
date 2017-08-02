<?php
    session_start();
    session_destroy();
    setcookie('pseudo', '');
    setcookie('password', '');

    // Vérifi si il existe une session
    if (isset($_SESSION['pseudo'])){
        $_SESSION['pseudo'];
    }else {
        $_SESSION['pseudo'] = 'inconnu(e)';
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Déconnexion</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <h3>Au revoir <?php echo $_SESSION['pseudo']; ?></h3>
        <a href="index.php">Retour page d'acceuil</a>
    </body>
</html>