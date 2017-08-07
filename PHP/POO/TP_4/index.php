<?php
/**
*   DESIGN PATTERN: MVC
*/

//============================
//      DATABABE PDO
//============================

$dsn = 'mysql:dbname=tp_cours;host=localhost:8889';
$user = 'root';
$password = 'root';

try {
     $db = new PDO($dsn, $user, $password);
} catch(PDOException $e){
     die('Data base connection error: ' . $e->getMessage());
}

//============================
//      DISPATCHER
//============================

require_once('Model/NewsManager.php');

$manager = new NewsManager($db);

// Check if $_GET be there
if(!isset($_GET['action'])){
    $action = 'newsList';
}else{
    $action = htmlspecialchars($_GET['action']);
}

// To check which controller to use
switch ($action) {
    case 'newsList':
        require_once('Controler/newsList.php');
        break;

    case 'news':
        require_once('Controler/news.php');
        break;

    case 'admin':
        require_once('Controler/admin.php');
        break;
    
    default:
        require_once('View/404.php');
        break;
}