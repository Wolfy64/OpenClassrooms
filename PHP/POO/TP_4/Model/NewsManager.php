<?php
/**
* NEWS MANAGER
*/

require_once('News.php');

class NewsManager
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    //============================
    //      CRUD
    //============================

    public function newsCreate(News $info)
    {
        $dbh = $this->db->prepare('INSERT INTO news(author, title, content, dateAdd) VALUES(:author, :title, :content, NOW())');
        $dbh->bindValue(':author', $info->getAuthor(), PDO::PARAM_STR );
        $dbh->bindValue(':title', $info->getTitle(), PDO::PARAM_STR );
        $dbh->bindValue(':content', $info->getContent(), PDO::PARAM_STR );

        $dbh->execute();

    }

    public function newsRead(int $id)
    {

        $dbh = $this->db->prepare('SELECT id, author, title, content, dateAdd, dateUpdate FROM news WHERE id = :id');
        $dbh->bindValue(':id', $id, PDO::PARAM_INT);
        $dbh->execute();

        $data = $dbh->fetch(PDO::FETCH_ASSOC);

        return new News($data);
    }

    public function newsUpdate(News $info)
    {
        $dbh = $this->db->prepare('UPDATE news SET author = :author, title = :title, content = :content, dateUpdate = NOW() WHERE id = :id');
        $dbh->bindValue(':id', $info->getId(), PDO::PARAM_INT);
        $dbh->bindValue(':author', $info->getAuthor(), PDO::PARAM_STR );
        $dbh->bindValue(':title', $info->getTitle(), PDO::PARAM_STR );
        $dbh->bindValue(':content', $info->getContent(), PDO::PARAM_STR );
        
        $dbh->execute();
    }

    public function newsDelete(int $id)
    {
        $dbh = $this->db->prepare('DELETE FROM news WHERE id = :id');
        $dbh->bindValue(':id', $id, PDO::PARAM_INT);

        $dbh->execute();
    }

    //============================
    //      METHODS
    //============================

    public function newsCount()
    {
        return $this->db->query('SELECT COUNT(*) FROM news')->fetchColumn();
    }

    public function newsList(){

        foreach (self::newsReadAll() as $news) {

            $content = $news->getContent();

            if (strlen($news->getContent()) > 200){
                echo '<h4> <a href="?action=news&id=' . $news->getId() . '">' . $news->getTitle() . '</a> </h4> <p>'. substr($content, 0, 200) . '... </p>';
            }else{
                echo '<h4> <a href="?action=news&id=' . $news->getId() . '">' . $news->getTitle() . '</a> </h4> <p>'. $content . '</p>';
            }
            
        }
    }
 
    public function newsReadAll()
    {
         $news = [];

        $dbh = $this->db->query('SELECT id, author, title, content, dateAdd, dateUpdate FROM news');
        $dbh->execute();

        while ($data = $dbh->fetch(PDO::FETCH_ASSOC)){
            $news[] = new News($data);
        };
        return $news;
    }

    public function adminNewsList()
    {   
        foreach (self::newsReadAll() as $news) {
            echo '<tr>
                    <td>' . $news->getAuthor() .     '</td>
                    <td>' . $news->getTitle() .      '</td>
                    <td>' . $news->getDateAdd() .    '</td>
                    <td>' . $news->getDateUpdate() . '</td>
                    <td>  
                        <a href="?action=admin&update=' . $news->getId() . '"> Modifier </a>
                         | 
                        <a href="?action=admin&delete=' . $news->getId() . '"> Supprimer </a>
                    </td>
                  </tr>';
        }
    }


}
