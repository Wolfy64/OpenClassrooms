<?php

//------------------------------
//	Charchement des Classes
//------------------------------

function loadClass($class){
	 require $class . '.php';
}

spl_autoload_register('loadClass');

//------------------------------
//	Session Gestion
//------------------------------

session_start();

if (isset($_GET['logOut'])){
	session_destroy();
	header('Location: .');
	exit();
}

//------------------------------
//	Instance CharacterManager
//------------------------------

$db = new PDO('mysql:host=localhost:8889; dbname=tp_cours', 'root', 'root');
// On émet une alerte à chaque fois qu'une requête a échoué.
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$manager = new CharacterManager($db);

//------------------------------
//	Session existante
//------------------------------

if (isset($_SESSION['person'])){
  $person = $_SESSION['person'];
}

//------------------------------
//	Créer $person
//------------------------------

if (isset($_POST['name']) && isset($_POST['create'])){
	
	$name = htmlspecialchars($_POST['name']);
	$create = htmlspecialchars($_POST['create']);
	$person = new Character(['name' => $name]);

	if (!$person->nameAvaible()){
		echo 'Le nom n\'est pas valable';
		unset($person);

	} elseif ($manager->exists($person->getName())) {
		echo 'Le pseudo existe déjà';
		unset($person);
	} else {
		$manager->create($person);
	}
}

//------------------------------
//	Utiliser $person
//------------------------------

elseif (isset($_POST['name']) && isset($_POST['use'])){

	$name = htmlspecialchars($_POST['name']);
	$create = htmlspecialchars($_POST['use']);

	if ($manager->exists($name)){
		$person = $manager->read($name);

	} else {
		echo 'Le personnage n\'existe pas';
	}

} 
// Si on a cliqué sur un personnage pour le frapper.
elseif (isset($_GET['hit'])) {
	if (!isset($person)){
		$message = 'Merci de créer un personnage ou de vous identifier.';

	} else {
		if (!$manager->exists((int) $_GET['hit'])){
		$message = 'Le personnage que vous voulez frapper n\'existe pas !';
	
		} else {
			$personToHit = $manager->read((int) $_GET['hit']);

			// On stocke dans $retour les éventuelles erreurs ou messages que renvoie la méthode frapper.
			$return = $person->hit($personToHit); 

			switch ($return){

			case Character::ITS_ME :
			$message = 'Mais... pourquoi voulez-vous vous frapper ???';
			break;

			case Character::CHARACTER_HIT :
			$message = 'Le personnage a bien été frappé !';

			$manager->update($person);
			$manager->update($personToHit);

			break;

			case Character::CHARACTER_KILL :
			$message = 'Vous avez tué ce personnage !';

			$manager->update($person);
			$manager->delete($personToHit);

			break;
			}
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Warcraft beta 0.1</title>
</head>
<body>
	<p>Nombre de personnages créés: <?php echo $manager->count() ?> </p>

	<?php 
		// On a un message à afficher ?
		if (isset($message)){
			echo '<p>' . $message . '</p>';
		}

		// Si on utilise un personnage (nouveau ou pas).
		if (isset($person)){
			?>

			<p><a href="?logOut=1">Déconnexion</a></p>
			<fieldset>
				<legend>Mes informations</legend>
				<p>
					Nom : <?php echo htmlspecialchars($person->getName()) ?><br />
					Dégâts : <?php echo $person->getDamages() ?>
				</p>
			</fieldset>

			<fieldset>
				<legend>Qui frapper ?</legend>
			<p>

			<?php 
			// Affiche la liste des personnages
			$persons = $manager->readAll($person->getName());

			if (empty($persons)){

				echo 'Personne à frapper !';
			} else {

				foreach ($persons as $onePerson){
					echo '<a href="?hit=' . $onePerson->getId() . '">' . htmlspecialchars($onePerson->getName()) . '</a> (dégâts : ' . $onePerson->getDamages() . '<br />';
				}
			}
			?>
			</p>
			</fieldset>
			<?php
		} else{
			?>
			<form action="" method="post">
				<label for="name">Nom du personnage: </label>
				<input id="name" type="text" name="name">

				<input type="submit" name="use" value="Utiliser ce personnage">
				<br>

				<label for="type">Classe du personnage: </label>
				<select name="type">
					<option value="Warrior">Guerrier</option>
					<option value="Wizard">Mage</option>
				</select>

				<input type="submit" name="create" value="Créer ce personnage">
			</form>
			<?php
		}
	?>
	
</body>
</html>

<?php
if (isset($person)){
	$_SESSION['person'] = $person;
}
?>