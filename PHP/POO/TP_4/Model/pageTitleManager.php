<?php
/**
* PAGE TITLE MANAGER
*/

if(!isset($_GET['action'])){
    $action = 'index';
} else{
    $action = htmlspecialchars($_GET['action']);
}

switch ($action) {
    case 'index':
        $title = 'Acceuil du site';
        break;
    
    case 'news':
        $title = $news->getTitle();
        break;
    
    case 'admin':
        $title =  'Administration';
        break;
    
    default:
        $title = 'page 404';
        break;
}