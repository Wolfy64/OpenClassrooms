<?php 
// On Demarre la session AVANT d'écrire du code HTML
session_start();

// On s'amuse à créer quelques variables de session dans $_SESSION
$_SESSION["prenom"] = "jean";
$_SESSION["nom"] = "Dupont";
$_SESSION["age"] = 24;
?>

<!DOCTYPE html>
<html lang="en">

<!-- L'en-tête -->
<?php include("header.php"); ?>

<body>

    <h2>Les expressions régulieres</h2>

    <?php
        if (isset($_POST['texte'])){

            $texte = stripslashes($_POST['texte']); // On enlève les slashs qui se seraient ajoutés automatiquement
            $texte = htmlspecialchars($texte); // On rend inoffensives les balises HTML que le visiteur a pu rentrer
            $texte = nl2br($texte); // On crée des <br /> pour conserver les retours à la ligne
            
            // On fait passer notre texte à la moulinette des regex
            $texte = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $texte);
            $texte = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $texte);
            $texte = preg_replace('#\[color=(red|green|blue|yellow|purple|olive)\](.+)\[/color\]#isU', '<span style="color:$1">$2</span>', $texte);
            $texte = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $texte);

            // Et on affiche le résultat. Admirez !
            echo $texte . '<br /><hr />';
        }
    ?>

    <p>
        Bienvenue dans le parser du Site du Zéro !<br />
        Nous avons écrit ce parser ensemble, j'espère que vous saurez apprécier de voir que tout ce que vous avez appris va vous être très utile !
    </p>

    <p>Amusez-vous à utiliser du bbCode. Tapez par exemple :</p>

    <blockquote style="font-size:0.8em">
        <p>
            Je suis un gros [b]Zéro[/b], et pourtant j'ai [i]tout appris[/i] sur http://www.siteduzero.com<br />
            Je vous [b][color=green]recommande[/color][/b] d'aller sur ce site, vous pourrez apprendre à faire ça [i][color=purple]vous aussi[/color][/i] !
        </p>
    </blockquote>

    <form method="post">
    <p>
        <label for="texte">Votre message ?</label><br />
        <textarea id="texte" name="texte" cols="50" rows="8"></textarea><br />
        <input type="submit" value="Montre-moi toute la puissance des regex" />
    </p>

    </form>

    <p>
        <?php
            if (isset($_POST['mail'])){

                $_POST['mail'] = htmlspecialchars($_POST['mail']); // On rend inoffensives les balises HTML que le visiteur a pu rentrer

                if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['mail'])){
                    echo 'L\'adresse ' . $_POST['mail'] . ' est <strong>valide</strong> !';
                } else {
                    echo 'L\'adresse ' . $_POST['mail'] . ' n\'est pas valide, recommencez !';
                }
            }
        ?>
    </p>

    <form method="post">
        <p>
            <label for="mail">Votre mail ?</label> <input id="mail" name="mail" /><br /> 
            <input type="submit" value="Vérifier le mail" />
        </p>
    </form>

    <p>
        <?php
            if (isset($_POST['telephone'])){

                $_POST['telephone'] = htmlspecialchars($_POST['telephone']); // On rend inoffensives les balises HTML que le visiteur a pu entrer

                if (preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $_POST['telephone']))
                {
                    echo 'Le ' . $_POST['telephone'] . ' est un numéro <strong>valide</strong> !';
                }
                else
                {
                    echo 'Le ' . $_POST['telephone'] . ' n\'est pas valide, recommencez !';
                }
            }
        ?>
    </p>

    <form method="post">
        <p>
            <label for="telephone">Votre téléphone ?</label> <input id="telephone" name="telephone" /><br />
            <input type="submit" value="Vérifier le numéro" />
        </p>
    </form>

    <p> #(((https?|ftp)://(w{3}\.)?)(?&lt;!www)(\w+-?)*\.([a-z]{2,4}))# </p>
    <br>
    <?php 
        if (preg_match('#(((https?|ftp)://(w{3}\.)?)(?<!www)(\w+-?)*\.([a-z]{2,4}))#', 'https://www.tata')) {
            echo 'Vrai';
            } else {
                echo 'Faux';
        }
    ?>

    <h2>Redimensionner une image</h2>
    <?php include('resize.php'); ?>
    <a href="images/nature.jpg">
    <img src="images/mini_nature.jpg" alt="image">
    </a>

    <h2>Créer des images en PHP</h2>
    <img src="image.php" alt="image">
    <img src="copyrighter.php?image=images/grenouille.jpeg" alt="image">
    <img src="copyrighter.php?image=images/tropiques.jpg" />

    <h2>MySQL</h2>

    <fieldset>
        <legend>Suppression d'un jeux dans la bdd:</legend>
        <form action="jeux_video.php" method="POST">
            <p><label> ID du jeux: <input type="text" name="id"></label></p>
            <p><input type="submit" value="Envoyer"></p>
        </form>
    </fieldset>

    <fieldset>
        <legend>Modification d'un jeux dans la bdd:</legend>
        <form action="jeux_video.php" method="POST">
            <p><label> Nom du jeux: <input type="text" name="update_Nom"> </label></p>
            <p><label> Possesseur:<input type="text" name="update_Possesseur"> </label></p>
            <p><label> Prix:<input type="text" name="update_Prix"> </label></p>
            <p><input type="submit" value="Envoyer"></p>
        </form>
    </fieldset>
        
    <fieldset>
        <legend>Ajout d'un jeux dans la bdd:</legend>
        <form action="ajout_jeux_video.php" method="POST">
            <p><label> Nom du jeux: <input type="text" name="nom"> </label></p>
            <p><label> Possesseur:<input type="text" name="possesseur"> </label></p>
            <p><label> Console:<input type="text" name="console"> </label></p>
            <p><label> Prix:<input type="text" name="prix"> </label></p>
            <p><label> Nombre de joueur:<input type="text" name="nbre_joueurs_max"> </label></p>
            <p><label> Commentaires:<br>
            <textarea name="commentaires"> </textarea> </p>
            <p><input type="submit" value="Envoyer"></p>
        </form>
    </fieldset>

    <fieldset>
        <legend>Consulter la liste des jeux:</legend>
        <form action="jeux_video.php" method="GET">
            <p><label> Prénom: <input type="text" name="possesseur"> </label><em>(Florent, Patrick ou Michel)</em></p>
            <p><label> Prix Maximun:<input type="text" name="prix_max"> </label></p>
            <p><input type="submit" value="Envoyer"></p>
        </form>
    </fieldset>

    <h2>Utilisation des sessions</h2>
    <p>
        Salut<?php echo $_SESSION["prenom"] ?> ! <br> Tu es à l'acccueil de mon site (index.php). Veux tu aller sur une autre page ?
    </p>
    <p>
        <a href="mapage.php">Lien vers mapage.php</a>
    </p>
    <h2>Transmettre des données avec les formulaires</h2>
    <form action="cible.php" method="POST">
        <p><label> Prénom: <input type="text" name="prenom"> </label></p>
        <p><label> Est vous végetarien ?<input type="checkbox" name="vegetarien"> </label></p>
        <p><input type="submit" value="Envoyer"></p>
    </form>

    <h2>Transmettre des données avec l'URL</h2>
    <a href="bonjour.php?nom=Dupont&amp;prenom=Jean&amp;repeter=8">Dis-moi bonjour !</a>

    <h2>Inclure des portions de page</h2>
    <?php include("menus.php"); ?>

    <h2>Les tableaux</h2>
    <?php 
        $prenom = array (
            'prénom'=> 'françois',
            'nom'=> 'Dupont',
            'ville'=> 'Marseille');
        foreach($prenom as $cle => $element){
            echo 'La cle ' . $cle . ' vaut ' . $element . ' <br>';
        }
        echo '<pre>';
        print_r($prenom);
        echo '<pre>';
    ?>

</body>

<!-- Le pied de page -->
<?php include("footer.php"); ?>

</html>