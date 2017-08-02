<?php
/**
*   ADMIN MANAGER
*/

// ADD OR DELETE NEWS
if( empty($_GET['update'])){
    $message = null;
    $form = 'index.php?action=admin';
    $author = null;
    $title = null;
    $content = null;

    // ADD NEWS IN DATABASE 
    if( !empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['content'])){

        $news = new News([
            'author' => htmlspecialchars($_POST['author']),
            'title' => htmlspecialchars($_POST['title']),
            'content' => htmlspecialchars($_POST['content'])
            ]);

        $manager->newsCreate($news);
        $message = 'La news a bien été ajouté';
    }elseif(isset($_POST['button'])){
        $message = 'Veuillez remplir tous les champs !';
    }else{
        $message = null;
    }

    // DELETE NEWS
    if (isset($_GET['delete']) && !empty($_GET['delete']) ){
    
        $id = (int)$_GET['delete'];

        $manager->newsDelete($id);
        $message = 'La news a bien été supprimé';
    }
}

// UPDATE NEWS
if (isset($_GET['update']) && !empty($_GET['update']) ){
    $id = htmlspecialchars($_GET['update']);
    $news = $manager->newsRead($id);
    $author = $news->getAuthor();
    $title = $news->getTitle();
    $content = $news->getContent();
    $form = 'index.php?action=admin&update=' . $id;

    if( !empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['content'])){
        
        $newsUpdate = new News([
            'id' => $id,
            'author' => htmlspecialchars($_POST['author']),
            'title' => htmlspecialchars($_POST['title']),
            'content' => htmlspecialchars($_POST['content'])
            ]);     

        $manager->newsUpdate($newsUpdate);
        $message = 'La news a bien été Modifié';
    }else{
        $message = null;
    }
}


