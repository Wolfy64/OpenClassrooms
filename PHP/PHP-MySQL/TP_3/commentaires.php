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

    <div class="lien_retour" >  <p> <a href="index.php">Retour à la liste des billets</a> </p> </div>

    <?php 
        // Connexion à la base de données
        try {

            $bdd = new PDO('mysql:host=localhost; dbname=tp3_blog; charset=utf8', 'root', 'root');

            }catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
        // Récupération du billet
        $req = $bdd->prepare('SELECT *, DATE_FORMAT(date_creation, \'le %d.%m %Y à %Hh%m\') AS date_creation FROM billets WHERE id= :id_billet');
        $req->execute(array('id_billet' => $_GET['id']));
        $donnees = $req->fetch();

    ?>

    <h3>
        <?php echo htmlspecialchars($donnees['titre']); ?>
        <span class="date"> - <?php echo htmlspecialchars($donnees['date_creation']); ?></span>
    </h3>
    <section class="news">
        <p> 
            <?php echo htmlspecialchars($donnees['contenu']); ?> <br>
        </p>
    </section>

    <div class="titre_commentaire">
    <h2>Commentaires:</h2>
    </div>

    <?php
        // Important : on libère le curseur pour la prochaine requête 
        $req->closeCursor();

        // Récupération des commentaires
        $req = $bdd->prepare('SELECT *, DATE_FORMAT(date_commentaire, \'le %d.%m %Y à %Hh%m et %ss\') AS date_commentaire FROM `commentaires` WHERE id_billet= :id_billet');
        $req -> execute(array('id_billet' => $_GET['id']));
        while ($donnees = $req->fetch()) {
        ?>
        <section class="commentaires">
            <p>
                <span class="pseudo">
                    <?php echo htmlspecialchars($donnees['auteur']); ?>
                </span>
                <span class="date"> - <?php echo htmlspecialchars($donnees['date_commentaire']); ?></span><br>
                <?php echo htmlspecialchars($donnees['commentaire']); ?>
            </p>
        </section>
        <?php
        } // Fin de la boucle des commentaires 
        // Important : on libère le curseur pour la prochaine requête
        $req->closeCursor();
    ?>

</body>

</html>