<!DOCTYPE html>
<html lang="en">

<!-- L'en-tête -->
<?php include("header.php"); ?>

<body>

<p> Bonjour <?php echo htmlspecialchars($_POST["prenom"]); ?></p>
<?php 
    if (isset($_POST["vegetarien"])){
        echo "Vous êtes végétarien";
    }
    else {
        echo "Vous n'êtes pas végétarien, vous mangez de la viande";
    }
?>

</body>

<!-- Le pied de page -->
<?php include("footer.php"); ?>
</html>