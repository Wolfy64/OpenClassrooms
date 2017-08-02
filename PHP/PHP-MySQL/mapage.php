<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php include("header.php") ?>

<body>
    <p>
        Je me souviens de toi tu t'appelle <?php echo $_SESSION["prenom"] . " " . $_SESSION["nom"]; ?> et tu as <?php echo $_SESSION["age"]; ?> ans.
    </p>
</body>

<?php include("footer.php") ?>
</html>
