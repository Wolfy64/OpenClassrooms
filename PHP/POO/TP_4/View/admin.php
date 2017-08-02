<body>
    <p>
        <a href="index.php">Retour à la liste des News</a>
    </p>

    <form action="<?php echo $form ?>" method="POST">
        <p> <?php echo $message ?> </p>
        <p>
            <label for="author">Auteur:</label>
            <input type="text" name="author" value="<?php echo $author ?>" placeholder="Veuillez saisir votre nom" id="author" required>
            <br>
            <label for="title">Titre:</label>
            <input type="text" name="title" value="<?php echo $title ?>" placeholder="Veuillez saisir votre titre" id="title" required>
            <br>
            <label for="content">Contenu:</label>
            <br>
            <textarea name="content" rows="8" cols="60" placeholder="Veuillez saisir le contenu de votre article" id="content" required><?php echo $content ?></textarea>
            <br>
            <button name="button" type="submit">Valider</button>
        </p>
    </form>

    <p class="center"> Il y a actuellement <?php echo $manager->newsCount() ?> news. En voici la liste: </p>

    <table>
        <tbody>
            <tr>
                <th>Autheur</th>
                <th>Titre</th>
                <th>Date d'ajout</th>
                <th>Dernière modification</th>
                <th>Action</th>
            </tr>
            <?php echo $manager->adminNewsList() ?>
        </tbody>
    </table>
