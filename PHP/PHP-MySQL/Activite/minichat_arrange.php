<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Mini Chat</title>
        <meta charset="UTF-8">
    </head>
    <style>
        body {
            background-color: #393D5C;
        ;
        }
        h1 {
            text-align: center;
            background-color: #D5D8EB;
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            border: 2px solid #7A8FEC;

        }
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
            margin-top: 15px;
            color: white;
        }

        .chat {
            max-width: 600px;
            margin: auto;
            padding: 0px 10px 0px 10px;
            display: flex;
            flex-direction: column;
            background-color: #D5D8EB;
            border: 2px solid #7A8FEC;
            border-radius: 10px;
        }

        .line{
            border: 2px solid #7A8FEC;
            border-radius: 10px;
            margin: 10px;
        }
        .date {
            font-style: italic;
            font-size: 0.8em;
            color: #5E5E5E;
            float: right;
            padding-right: 10px;
        }
        .pseudo{
            font-weight: bold;
            color: #17202A;
        }

        p{
            padding: 0px 0px 0px 10px;
        }
    </style>
    <body>
        <h1>Activité : Le mini-chat amélioré</h1>

        <!--Envoi des données via la methode POST-->
        <form method="POST" action="minichat_arrange_post.php" >
            <label for="pseudo">Pseudo: </label>
            <input type="text" name="pseudo" value="<?php echo htmlspecialchars($_COOKIE['pseudo']) ?>">
            <br>
            <label for="message">Votre message: </label>
            <input type="text" name="message" value="">
            <br>
            <input type="submit" value="Envoyer">
        </form>
        <div class="chat">
            <?php
                // Connexion à la base de donnée
                try{
                    $bdd = new PDO('mysql:host=localhost;dbname=activite', 'root', 'root');
                } catch (Exeption $e){
                    die ('Erreur: ' . $e->getMessage());
                }

                // Affichage les 10 derniés messages
                $req = $bdd->query('SELECT *, DATE_FORMAT(date_message, \'le %d / %m / %Y à %imin et %ss\') AS date_message_fr FROM minichat_arrange ORDER BY id DESC LIMIT 0,10');
                while ($donnees = $req->fetch()) {
                ?>
                        <div class="line">
                    <p>
                        <span class="date"><?php echo htmlspecialchars($donnees['date_message_fr']); ?></span>
                        <br>
                        <span class="pseudo"><?php echo htmlspecialchars($donnees['pseudo']); ?>: </span>
                        <?php echo htmlspecialchars($donnees['message']); ?>
                    </p>
                        </div>
             <?php
                }
                $req->closeCursor();
            ?>           
        </div>

    </body>
</html>
