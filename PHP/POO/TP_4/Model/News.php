<?php
/**
*   NEWS
*/

Class News 
{
    private $id,
            $author,
            $title,
            $content,
            $dateAdd,
            $dateUpdate;


    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    //============================
    //      METHODS
    //============================

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

    //============================
    //      GETTERS
    //============================

    public function getId()
    {
       return $this->id;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getDateAdd()
    {
        $date = new DateTime($this->dateAdd);
        return $date->format('d-m-Y à H:i');
    }

    public function getDateUpdate()
    {
        $date1 = new DateTime($this->dateUpdate);
        $date2 = new DateTime($this->dateAdd);

        if(isset($_GET['action'])){
            $action = htmlspecialchars($_GET['action']);
            
            switch ($action){
                case 'news':
                    if($date1 > $date2){
                        $dateUpdate = ' <small> 
                                            <em> Modifié le ' . $date1->format('d-m-Y H:i') . '</em> 
                                        </small> ';
                    }else{
                        $dateUpdate = null;
                    }
                    break;

                case 'admin':
                    if($date1 > $date2){
                        $dateUpdate = $date1->format('d-m-Y H:i');
                    }else{
                        $dateUpdate = ' - ';
                    }
                    break;
                default:
                    $dateUpdate = $date1->format('d-m-Y H:i');
                    break;
            }
            return $dateUpdate;
        }else{
            throw new Exception("Error variable GET['action'] not found");
            ;
        }
    }

    //============================
    //      SETTERS
    //============================

    public function setId($id)
    {
        (int)$id;
        if($id > 0){
            $this->id = $id;
        }
    }

    public function setAuthor($author)
    {
        $author = (string)$author;

        if (strlen($author) <= 30){
            $this->author = $author;
        } else{
            try{
                throw new Exception("Author name upper to 30", 1);
            }catch (Exception $e){
                echo 'Exception: ' . $e->getMessage();
            };
        }
    }

    public function setTitle($title)
    {
         $title = (string)$title;

        if (strlen($title) <= 100){
            $this->title = $title;
        } else{
            try{
                throw new Exception("Title text upper to 100", 1);
            }catch (Exception $e){
                echo 'Exception: ' . $e->getMessage();
            };
        } 

    }

    public function setContent($content)
    {
        $content = (string)$content;
        $this->content = $content;
 
    }

    public function setDateAdd($date)
    {
        $date = new DateTime($date);
        $this->dateAdd = $date->format('Y-m-d H:i:s');
    }

    public function setDateUpdate($date)
    {
        $date = new DateTime($date);
        $this->dateUpdate = $date->format('Y-m-d H:i:s');
    }
}