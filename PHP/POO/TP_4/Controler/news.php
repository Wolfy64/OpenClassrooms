<?php
/**
*   SHOW A NEWS BY ID
*/
if (isset($_GET['id'])){

    $id = (int)htmlspecialchars($_GET['id']);
    $news = $manager->newsRead($id);

    require_once('Model/pageTitleManager.php');
    
    require_once('View/_header.php');
    
    require_once('View/newsCount.php');
    
    require_once('View/news.php');

    require_once('View/_footer.php');
    
}else{
    require_once('View/404.php');
}