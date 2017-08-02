<!DOCTYPE html>
<html lang="en">

<!-- L'en-tête -->
<?php include("header.php"); ?>

    <body>
        <h2>MySQL</h2>
        <?php

            $nom = $_POST["nom"];
            $possesseur = $_POST["possesseur"];
            $console = $_POST["console"];
            $prix = $_POST["prix"];
            $nbre_joueurs_max = $_POST["nbre_joueurs_max"];
            $commentaires = $_POST["commentaires"];
 
             if ($nom && $possesseur &&  $console &&  $prix && $nbre_joueurs_max && $commentaires){
                // On arrête l'exécution de la page en affichant un message décrivant l'erreur
                try{
                    // Sous MAMP (Mac) On se connecte à MySQL
                    $bdd = new PDO("mysql:host=localhost; dbname=test; charset=utf8", "root", "root", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                } 
                catch (Exeption $e) {
                    // En cas d'erreur, on affiche un message et on arrête tout
                    die("Erreur : " . $e->getMessage());
                }
                // Si tout va bien, on peut continuer
                
                // On ajoute une entrée dans la table jeux_video
                $req = $bdd->prepare("INSERT INTO jeux_video (nom, possesseur, console, prix, nbre_joueurs_max, commentaires) VALUES( :nom, :possesseur,:console, :prix, :nbre_joueurs_max, :commentaires)");
                $req->execute(array(
                    "nom" => $nom,
                    "possesseur" => $possesseur,
                    "console" => $console,
                    "prix" => $prix,
                    "nbre_joueurs_max" => $nbre_joueurs_max,
                    "commentaires" => $commentaires
                ));
                
                echo "Le jeux a bien été ajouté !";

            // Termine le traitement de la requête
            $req->closeCursor();
            }
         ?>
    </body>
<!-- Le pied de page -->
<?php include("footer.php"); ?>
</html>
