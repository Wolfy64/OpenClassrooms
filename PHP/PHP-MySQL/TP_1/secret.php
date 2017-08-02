<?php
    $motDePasseCorrect = "Kangourou";
    $motdePasseUtilisateur = htmlspecialchars($_POST["motDePasse"]);
    $codeSecret = "" ;
                
    if ($motdePasseUtilisateur == $motDePasseCorrect) {
        $codeSecret = "<fieldset>" 
                . "<legend>Code Secret</legend>"
                . "<p>Gloat4-vicar-7caine-March8-1Byway-yawn</p>"
                . "</fieldset>";              
    } else {
        $URL="http://localhost:8888/TP_1/formulaire.php";
        header ("Location: $URL");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Codes Secrets</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div>
        <?php echo $codeSecret; ?>
    </div>
</body>

</html>