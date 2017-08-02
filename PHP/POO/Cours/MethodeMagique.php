<?php

Class Maclasse{
	private $attributs =[];
	private $unAttributPrive;

	public function __get($nom){
		if (isset($this->attributs[$nom])){
			return $this->attributs[$nom];
		}
	}

	public function __set($nom, $valeur){
		$this->attributs[$nom] = $valeur;
	}

	public function afficherUnAttributs(){
		echo '<pre>' . print_r($this->attributs, true) . '</pre>' . PHP_EOL;
	}
}

$obj = new Maclasse;

$obj->attribut = 'simple test'. PHP_EOL;
$obj->blabla = 'test 2'. PHP_EOL;
$obj->autreAttribut = 'un autre test'. PHP_EOL;

echo $obj->attribut;
echo $obj->blabla;
echo $obj->autreAttribut;

class FileReader
{
    protected $f;

    public function __construct($path)
    {
        $this->f = fopen($path, 'c+');
    }

    public function __debugInfo()
    {
        return ['f' => fstat($this->f)];
    }
}

$f = new FileReader('fichier.txt');
var_dump($f); // Affiche les informations retournées par fstat.
