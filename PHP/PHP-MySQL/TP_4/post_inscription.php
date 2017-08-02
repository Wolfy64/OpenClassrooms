<?php
    session_start();
    
    // Vérification des varaibles
    if (!isset($_POST['pseudo'], $_POST['password'], $_POST['check_password'], $_POST['email'])) {
        echo 'Il manque une donnée';
        exit;
    }

    //Variable pour la gestion des erreurs
    $error= array();

    // Variable pour protéger contre les failles xss
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $password = htmlspecialchars($_POST['password']);
    $check_password = htmlspecialchars($_POST['check_password']);
    $email = htmlspecialchars($_POST['email']);

    // Gestion des erreurs du formulaire
    if (empty($pseudo) || empty($password) || empty($check_password) ||empty($email)){
        echo 'Il manque une variable';
        exit;
    }

    if (!preg_match('#^([0-9a-z]+[ \.-]*){3,50}#', $pseudo)){
        $error['pseudo'] ='le pseudo: <strong>" ' . $pseudo .' "</strong> n\'est pas un pseudo correct';
    }

    if (!preg_match('#[a-z0-9_\/@.!-]{4,}#', $password)) {
        $error['password'] = 'le mot de passes doit contenir 4 caractères minimum';
    }

    if ($password != $check_password) {
        $error['chek_password'] = 'les mots de passes ne sont pas identiques';
    }

    if (!preg_match('#^[0-9a-z._-]+@[0-9a-z._-]{2,}\.[a-z]{2,4}$#', $email)){
        $error['email'] = 'l\'email: <strong>" ' . $email . ' "</strong> n\'est pas un email correct';
    }

    if (!empty($error)){
        foreach ($error as $value) {
            echo '<p>' . $value . '</p>
            <br>
            <a href="inscription.php"> Retour à la page d\'inscription </a>';
            exit;
        } 
    }

    // Connexion à la base bdd
    try{
        $db = new PDO('mysql:host=localhost; dbname=tp4_espaceMembre', 'root', 'root' );
    }catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

    // Hachage du mot de passe
    $pass_hache = sha1( 'gz64' . $password);

    // Vérification du pseudo
    $req = $db->prepare('SELECT pseudo FROM membres WHERE pseudo = :pseudo');
    $req->execute(array('pseudo' => $pseudo));

    $data = $req->fetch();

    if ($pseudo == $data['pseudo']){
        echo 'Ce pseudo existe déjà
        <br>
        <a href="inscription.php">Retour à la page d\'inscription</a>';
        $req->closeCursor();

    } else {
        //On enregistre les données dans la bdd
        $req = $db->prepare('INSERT INTO membres(pseudo, pass, email, date_inscription) 
                            VALUES(:pseudo, :pass, :email, NOW())');
        $req->execute(array(
            'pseudo' => $pseudo,
            'pass' => $pass_hache,
            'email' => $email ));

        echo 'L\'inscription c\'est bien déroulée '
        . $pseudo
        . '<br>
        <a href="index.php">Retour page d\'acceuil</a>';

        // Fin de la requete
        $req->closeCursor();

        // Crée une nouvelle session
        $_SESSION['pseudo'] = $pseudo;
}
