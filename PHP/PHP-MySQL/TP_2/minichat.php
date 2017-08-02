<!DOCTYPE html>
<html lang="en">
    <head>
        <title>MiniChat</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
        <style>
            body{
                background-color: #333E55;
                color: #EFEFEF;
                margin-left: 10%;
                margin-right: 10%;
                min-width: 300px;
            }
            
            #saisieText {
                margin-top: 5%;
                display: flex;
                justify-content: center;
                border: 1px solid white;
            }
            #saisieText input{
                width: 100%;
                display: flex;
            }
            #chat {
                margin-top: 10px;
                border: 1px solid white;
            }
            .pseudo {
                font-family:Didot, Arial;
                //font-weight: bold;
                font-size: 1.25em;
                color: #3E8AE3;
                padding-left: 5%;
            }
            h1 {
                margin-left: 10%;
            }

        </style>
    </head>
    <body>
        <section id="saisieText">
            <form action="minichat_post.php" method="POST">
                <label for="pseudo">Pseudo:</label>
                <input type="text" name="pseudo"> <br>
                <label for="message">Message: </label>
                <input type="text" name="message" value=""> <br>
                <input type="submit" name="" value="Envoyer">
            </form>
        </section>
        <section id="chat">

            <h1>Minichat:</h1>
            <?php
                $bdd = new PDO("mysql:host=localhost; dbname=tp2_minichat; charset=utf8","root","root");
                $reponse = $bdd->query("SELECT * FROM minichat ORDER BY id DESC LIMIT 0, 10");

                while ($donnees = $reponse->fetch()) {
                    echo "<span class=\"pseudo\">" . $donnees["pseudo"] . ": </span> <span class=\"message\">" .$donnees["message"] . "<br>";
                }
            ?>
        </section>
    </body>
</html>