<!DOCTYPE html>
<html lang="en">

<head>
    <title>TP : un blog avec des commentaires</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <h1>Mon super blog !</h1>

    <?php 
        try {
            $bdd = new PDO('mysql:host=localhost; dbname=tp3_blog; charset=utf8', 'root', 'root'); 
        }
        catch(Exception $e) {
            die('Erreur : '.$e->getMessage());
            }
        // Requetes sur la table billets
        $reponse_billets = $bdd->query('SELECT *,DATE_FORMAT(date_creation, \'le %d.%m %Y à %Hh%m\') AS date_creation FROM billets ORDER BY date_creation DESC LIMIT 0, 5');

        // Génere un billet pour chaque article present dans la bdd
        while ($donnees_billets = $reponse_billets->fetch()) {
        ?>
            <h3> <?php echo htmlspecialchars($donnees_billets['titre']); ?>
                <span class="date"> - <?php echo $donnees_billets['date_creation'] ?></span>
            </h3>
            <section class="news">
                <p> <?php echo htmlspecialchars($donnees_billets['contenu']);?> <br>
                    <a href="commentaires.php?id=<?php echo htmlspecialchars($donnees_billets['id']); ?>">Commentaires</a>
                </p>
            </section>
        <?php
        }
        
    ?>
        <?php htmlspecialchars($reponse_billets->closeCursor()); ?>

</body>

</html>