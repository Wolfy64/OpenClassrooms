<?php 
    session_start();

    // Vérifie si une session existe
    if (isset($_SESSION['pseudo'])){
        $_SESSION['pseudo'];
    }else {
        $_SESSION['pseudo'] = 'inconnu(e)';

    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Page d'acceuil</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <h1>Page d'acceuil</h1>
        <h3>Bonjour <?php echo $_SESSION['pseudo']; ?></h3>
        <ul type="square">
            <li>
                <a href="connexion.php">Se connecter</a>
            </li>
            <li>
                <a href="inscription.php">Créer un compte</a>
            </li>
            <li>
                <a href="deconnexion.php">Se déconnecter</a>
            </li>
        </ul>
    
    </body>
</html>