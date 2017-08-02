<?php
    // Connexion à la bdd et vérification d'erreur
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=activite', 'root', 'root');
    } 
    catch (Exeption $e){
        die ('Erreur: ' . $e->getMessage());
    }

    // Si le champ "pseudo" ou "message" est vide cela n'est pas enregistré dans la bdd
    if (!empty($_POST['pseudo']) && !empty($_POST['message'])){
        setcookie('pseudo', htmlspecialchars($_POST['pseudo']), time() + 365*24*3600, null, null , false , true);

        $req =  $bdd->prepare('INSERT INTO minichat_arrange(pseudo, date_message, message)
                                VALUES(:pseudo, NOW(), :message)');
        $req->execute(array(
            ':pseudo' => $_POST['pseudo'],
            ':message' => $_POST['message']
        ));
    }else {
        setcookie('pseudo', NULL, time() + 365*24*3600, null, null , false , true);
    }

    header('Location: minichat_arrange.php');
?>