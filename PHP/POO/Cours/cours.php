<?php

function loadClass($class){
    require $class . '.php';
}

spl_autoload_register('loadClass');

$perso = new Personnage([
  "id" => 26,
  'nom' => 'Victor',
  'forcePerso' => 5,
  'degats' => 0,
  'niveau' => 1,
  'experience' => 99
]);

try {
  $db = new PDO('mysql:host=localhost:8889; dbname=test', 'root', 'root');
} catch(Exception $e){
  die('Erreur : '.$e->getMessage());
}

$manager = new PersonnagesManager($db);

// $manager->add($perso); // OK
// $manager->delete($perso); // A moitier
// $manager->get(26); // OK
$manager->getList(); // OK
// $manager->update($perso); // OK
