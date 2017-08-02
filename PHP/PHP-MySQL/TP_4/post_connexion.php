<?php
session_start();

// Vérification des varaibles
if (!isset($_POST['pseudo'], $_POST['password'])){
    echo 'Il manque une donnée';
    exit;
}

// Variable pour protéger contre les failles xss
$pseudo = htmlspecialchars($_POST['pseudo']);
$password = htmlspecialchars($_POST['password']);

// Ne hache pas le mot de passe si cela viens du cookie "password"
if(!isset($_COOKIE['password'])){
    $pass_hache = sha1('gz64' . $password);
} else{
    $pass_hache = $_COOKIE['password'];
}

// Gestion des erreurs du formulaire
if (empty($pseudo) || empty($password)){
    echo 'Il manque une variable';
    exit;
}

// Connexion à la base bdd
try{
    $db = new PDO('mysql:host=localhost; dbname=tp4_espaceMembre', 'root', 'root' );
}catch (Exception $e){
    die('Erreur : ' . $e->getMessage());
}

// Vérification du pseudo et crátion d'une session'
$req = $db->prepare('SELECT * FROM membres WHERE pseudo = :pseudo AND pass = :pass');
$req -> execute(array(
        'pseudo' => $pseudo,
        'pass' => $pass_hache));

$data = $req -> fetch();

if (!$data){
    echo 'Le pseudo ou le mot de passe est incorrect
    <br>
    <a href="connexion.php">Retour à la page de connexion</a>';
    $req->closeCursor();
}else{
    $_SESSION['id'] = $data['id'];
    $_SESSION['pseudo'] = $data['pseudo'];
    
    // Création d'un cookie
    if (isset($_POST['remember_me'])){
        setcookie('pseudo', $_SESSION['pseudo'], time()+3600, null, null, false, true);
        setcookie('password', $pass_hache, time()+3600, null, null, false, true);
    }
    
    echo 'Bonjour ' . $_SESSION['pseudo'] . ' vous etes connecté
    <br>
    <a href="index.php">Retour page d\'acceuil</a>';
    
    // Fin de la requete
    $req->closeCursor();

}


