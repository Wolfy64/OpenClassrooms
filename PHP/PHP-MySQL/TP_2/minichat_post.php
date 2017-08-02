<?php
    // Effectuer ici la requête qui insère le message
        $pseudo = strip_tags($_POST["pseudo"]);
        $message = htmlspecialchars($_POST["message"]);
        $bdd = new PDO("mysql:host=localhost; dbname=tp2_minichat; charset=utf8","root","root");

    if (isset($_POST["pseudo"]) && isset($_POST["message"])){
        $req = $bdd->prepare("INSERT INTO minichat(pseudo, message) VALUES (:pseudo, :message)");
        $req->execute(array(
            "pseudo" => $pseudo,
            "message" => $message
        ));
    } else {
        echo "<h1>NOPE</h1>";
    }


    // Puis rediriger vers minichat.php comme ceci :
    header('Location: minichat.php');

?>
