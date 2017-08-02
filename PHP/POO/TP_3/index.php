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

if (isset($_POST['name']) && isset($_POST['create']) && isset($_POST['type'])){
	
	$name = htmlspecialchars($_POST['name']);
	$type = strtolower(htmlspecialchars($_POST['type']));
	$create = htmlspecialchars($_POST['create']);

	switch($type){

		case 'warrior':
			$person = new Warrior(['name' => $name, 'type' => $type]);
			break;

		case 'wizard':
			$person = new Wizard(['name' => $name, 'type' => $type]);
			break;

		default:
			throw new Exception('Cette classe n\'existe pas !', 1);
			break;		
	}

	if (!$person->nameAvaible()){
		echo '<p class="label label-error col-6 centered">Le nom n\'est pas valable</p>';
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

elseif (isset($_POST['name']) && isset($_POST['use']) ){

	$name = htmlspecialchars($_POST['name']);
	$use = htmlspecialchars($_POST['use']);

	if ($manager->exists($name)){
		$person = $manager->read($name);

	} else {
		echo '<p class="label label-error col-6 centered">Le personnage n\'existe pas</p>';
	}
} 

// Si on a cliqué sur un personnage pour le frapper ou lui lancer un sort.
elseif ( isset($_GET['hit']) || isset($_GET['bewitched']) ) {
	if (!isset($person)){
		$message = 'Merci de créer un personnage ou de vous identifier.';
			
	} else {
		if ( isset($_GET['hit']) ){
			if ( !$manager->exists((int)$_GET['hit']) ){
				$message = 'Le personnage n\'existe pas !';
			}

			$id = $_GET['hit'];
			$personToHit = $manager->read( (int)$id);
			$return = $person->hit($personToHit);

		} elseif ( isset($_GET['bewitched']) ){
			if ( !$manager->exists((int)$_GET['bewitched']) ){
				$message = 'Le personnage n\'existe pas !';
			}

			$id = $_GET['bewitched'];
			$personToWitched = $manager->read( (int)$id );
			$return = $person->bewitched($personToWitched);

		} else {
			throw new Exception("La variable GET est manquante", 1);
		}
	}
	// On stocke dans $retour les éventuelles erreurs ou messages.
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

		case Wizard::NO_SPELL :
			$message = 'Vous n\'avez pas de magie !';
			break;

		case Wizard::CHARACTER_WITCHED :
			$message = 'Le personnage a bien été ensorcelé !';
			$manager->update($personToWitched);
			break;

		case Wizard::ITS_ME_SPELL :
			$message = 'Mais... pourquoi voulez-vous vous ensorceler ???';
			break;
		default:
			throw new Exception("Erreur de variable", 1);
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Warcraft beta 0.1</title>
	<link href="spectre.css" rel="stylesheet">
	<link href="spectre-icon.css" rel="stylesheet">
</head>
<body>

<div class="container centered col-10">
	<h4 class="centered col-6">Nombre de personnages créés: <?php echo $manager->count() ?> </h4>

	<?php 
	// On a un message à afficher ?
	if (isset($message)){
		echo '<p><mark>' . $message . '</mark></p>';
	}

	// Si on utilise un personnage (nouveau ou pas).
	if (isset($person)){
		?>

		<p><a href="?logOut=1" class="btn-red">Déconnexion</a></p>

		<div class="columns">
			<div class="column col-4 card">
	
				<div class="card-title" >
					<legend>Mes informations</legend>
				</div>
	
				<div class="card-body">
					<p >
						Type: <?php echo $person->getTypeFr(); ?><br>
						Nom : <?php echo htmlspecialchars($person->getName()); ?><br>
						Dégâts : <?php echo $person->getDamages(); ?><br>
						<?php echo $person->getAssetClasse(); ?> : <?php echo $person->getAsset(); ?><br>
					</p>
				</div>
	
	
			</div>

			<div class="col-6 ">
				<img src="images.jpeg" class="img-responsive" />
			</div>
		</div>


		<fieldset >
			<legend>Qui frapper ?</legend>
		<p>

		<?php

		// On vérifie si le personnage n'est pas endormi
		$person->getSleepCountdown();

		// Affiche la liste des personnages
		$persons = $manager->readAll($person->getName());

		if (empty($persons)){

			echo 'Personne à frapper !';
		} else {

			foreach ($persons as $onePerson){
				echo '<a href="?hit=' . $onePerson->getId() . '">' . htmlspecialchars($onePerson->getName()) . '</a> (Dégâts: ' . $onePerson->getDamages() . ' | Type: ' . $onePerson->getType() . ')';

				if ($person->getType() == 'wizard'){
					echo '<a href="?bewitched=' . $onePerson->getId() . '">Lancer un sort </a>';
					}
				echo '<br>';
			}
		}
		?>	
		</p>
		</fieldset>
		<?php
	} else{
		?>


			<form action="" method="post" class="col-6 centered">
				<div class="form-group">
					<label for="name" class="form-label">Nom du personnage: </label>
					<input id="name" type="text" name="name" class="form-input">
					<br>
					<input type="submit" name="use" value="Utiliser ce personnage" class="btn btn-sm btn-primary">
				</div>

				<div class="form-group">
					<label for="type" class="form-label">Classe du personnage: </label>
					<select name="type" class="form-select">
						<option value="Warrior">Guerrier</option>
						<option value="Wizard">Mage</option>
					</select>
				</div>

				<input type="submit" name="create" value="Créer ce personnage" class="btn btn-sm">
			</form>

		<?php
	}
	?>
	
</div>
</body>
</html>

<?php
if (isset($person)){
	$_SESSION['person'] = $person;
}
?>
