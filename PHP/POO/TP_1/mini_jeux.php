<?php
	// On enregistre notre autoload.
	function loadClass($class){
		require $class . '.php';
	}

	spl_autoload_register('loadClass');

	// On appelle session_start() APRÈS avoir enregistré l'autoload.
	session_start();

	if ( isset($_GET['logOut'])){
		session_destroy();
		header('Location: .');
		exit();
	}

	try {
		$dbh = new PDO('mysql:host=localhost; dbname=tp_cours', 'root', 'root');
	} catch(Exception $e){
		die('Erreur : '.$e->getMessage());
	}
	// On émet une alerte à chaque fois qu'une requête a échoué.
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	$manager = new PersonnagesManager($dbh);
	
	// Si la session perso existe, on restaure l'objet.
	if (isset($_SESSION['perso'])){
		$perso = $_SESSION['perso'];
	}

	// Si on a voulu créer un personnage.
	if ( isset($_POST['create']) && isset($_POST['name']) ){
		// On crée un nouveau personnage.
		$perso = new Personnage(['name' => $_POST['name']]);

		if ( !$perso->nameOk() ){
			$message = 'Le nom choisi est invalide';
			unset($perso);

		} elseif ( $manager->exists($perso->getName()) ){
			$message =  'Le nom du personnage est déjà pris';
			unset($perso);
		} else {
			$manager->add($perso);
		}
	
	// Si on a voulu utiliser un personnage.
	} elseif ( isset($_POST['use']) && isset($_POST['name']) ){

		// Si celui-ci existe.
		if ( $manager->exists($_POST['name']) ){
			$perso = $manager->get($_POST['name']);

		// S'il n'existe pas, on affichera ce message.
		} else {
			$message = 'Le pesrso n\'existe pas !';
		}
	// Si on a cliqué sur un personnage pour le frapper.
	} elseif ( isset($_GET['frapper'])){
		if (!isset($perso)){
			$message = 'Merci de créer un personnage et de vous identifier.';
		}else {
			if (!$manager->exists((int) $_GET['frapper'])){
				$message = 'Le personnage que vous voulez frapper n\'existe pas !';
			} else {
				$persoAFrapper = $manager->get((int) $_GET['frapper']);

				// On stocke dans $retour les éventuelles erreurs ou messages que renvoie la méthode frapper.
				$retour = $perso->frapper($persoAFrapper);

				switch ($retour){
					case Personnage::CEST_MOI:
						$message = 'Mais... pourquoi voulez-vous vous frapper ???';
						break;

					case Personnage::PERSONNAGE_FRAPPE:
						$message = 'Le personnage a bien été frappé !';

						$manager->update($perso);
						$manager->update($persoAFrapper);

						break;

					case Personnage::PERSONNAGE_TUE:
						$message = 'Vous avez tué ce personnage !';
						
						$manager->update($perso);
						$manager->delete($persoAFrapper);

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
	<title>TP: Mini jeu de combat</title>
</head>
<body>

	<p>Nombre de personnage crées: <?php echo $manager->count() ?></p>

	<?php
		// On a un message à afficher ?
		if ( isset($message) ){
			// Si oui, on l'affiche.
			echo '<p>' . $message . '</p>';
		}

		// Si on utilise un personnage (nouveau ou pas).
		if (isset($perso)){
	?>
			<p><a href="?logOut=1">Déconnexion</a></p>

			<fieldset>
				<legend>Mes informations</legend>
				<p>
					Nom: <?php echo htmlspecialchars($perso->getName()) ?> <br>
					Dégats: <?php echo $perso->getDegats()  ?>
				</p>
			</fieldset>

			<fieldset>
				<legend>Qui frapper ?</legend>
				<p>
	<?php
	$persos = $manager->getList($perso->getName());
	if ( empty($persos)){
		echo  'Personne à frapper !';
	}else {
		foreach ($persos as $unPerso){
			echo '<a href="?frapper=' . $unPerso->getId() . '">' . htmlspecialchars($unPerso->getName()) . '</a> (dégâts: ' . $unPerso->getDegats() . ') <br>';
		}
	}
	?>
				</p>
			</fieldset>
	<?php
		} else {
	?>	

	<form action="" method="post">
		<p>
			Nom: <input type="text" name="name" maxlength="50">
			<input type="submit" value="Créer ce personnage" name="create">
			<input type="submit" value="Utiliser ce personnage" name="use">
		</p>
	</form>
	<?php
		}
	?>
</body>
</html>
<?php
// Si on a créé un personnage, on le stocke dans une variable session afin d'économiser une requête SQL.
if ( isset($perso) ){
	$_SESSION['perso'] = $perso;
}