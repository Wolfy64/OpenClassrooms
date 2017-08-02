<!DOCTYPE html>
<html lang="en">

<!-- L'en-tête -->
<?php include("header.php"); ?>

    <body>
        <h2>MySQL</h2>
        <?php

            // On arrête l'exécution de la page en affichant un message décrivant l'erreur
            try{
                // Sous MAMP (Mac) On se connecte à MySQL
                $bdd = new PDO("mysql:host=localhost; dbname=test; charset=utf8", "root", "root", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (Exeption $e) {
                // En cas d'erreur, on affiche un message et on arrête tout
                die("Erreur : " . $e->getMessage());
            }
            
            // Si tout va bien, on peut continuer

            // Consulter la liste des jeux
            if (isset($_GET["possesseur"]) && isset($_GET["prix_max"])){

                // On récupère tout le contenu de la table jeux_video
                $req = $bdd->prepare("SELECT ID, nom, possesseur, console, prix, commentaires, nbre_joueurs_max FROM jeux_video WHERE possesseur = ? AND prix <= ? ORDER BY prix DESC LIMIT 0,10");
                $req->execute(array($_GET["possesseur"], $_GET["prix_max"]));

                echo "<ul>";
                // On affiche chaque entrée une à une
                while ($donnees = $req->fetch()){
                    echo "<li>" . "[ ID : ". $donnees["ID"] ." ] ". $donnees["nom"] . " ( " . $donnees["prix"] . " Eur ) </li>";
                }
                echo "</ul>" ;
            
            //Modification d'un jeux dans la bdd
            } elseif (isset($_POST["update_Nom"]) && isset($_POST["update_Possesseur"]) && isset($_POST["update_Prix"])) {
                
                $update_Nom = $_POST["update_Nom"];
                $update_Possesseur = $_POST["update_Possesseur"];
                $update_Prix = $_POST["update_Prix"];


                $req = $bdd->prepare("UPDATE jeux_video SET nom = :update_Nom, possesseur = :update_Possesseur, prix = :update_Prix WHERE nom = :update_Nom");
                $req ->execute(array(
                    "update_Nom" => $update_Nom,
                    "update_Possesseur" => $update_Possesseur,
                    "update_Prix" => $update_Prix
                ));
                    echo "<p>Le jeux à été modifié</p>";
            
            //Suppression d'un jeux dans la bdd
            } elseif (isset($_POST["id"])) {
                $id = $_POST["id"];

                // $rep = $bdd->query("SELECT nom FROM jeux_video WHERE id= ':id'");
                // $rep -> execute(array(
                //     "id" => $id
                // ));

                $req = $bdd->prepare(" DELETE FROM jeux_video WHERE id = :id");
                $req -> execute(array(
                    "id" => $id
                ));
                //while ($donnees = $rep->fetch()){
                echo "<p>Le jeux dont l'ID est le " . $id . " a bien été supprimé !</p>";
                //echo "<p>Le jeux: " . "\"" . $donnees["nom"] . "\"" ." dont l'ID est le " . $id . " a bien été supprimé !</p>";
            }
                //}

            // Termine le traitement de la requête
            $req->closeCursor();
         ?>
    </body>
<!-- Le pied de page -->
<?php include("footer.php"); ?>
</html>