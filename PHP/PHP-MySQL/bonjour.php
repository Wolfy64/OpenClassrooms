<?php 

    if (isset($_GET['nom']) && isset($_GET['prenom']) && isset($_GET['repeter'])) {

        $nbRepetition = (int)$_GET['repeter'];
        if ( $nbRepetition <= 100 && $nbRepetition >= 1){
            for ($i = 1 ; $i <= $nbRepetition; $i++ ) {
                echo '<p> Bonjour ' . $_GET['prenom'] . ' ' . $_GET['nom'] . ' ! </P>'; 
            }
        } else {
            echo 'La repetition ne se situe pas entre 1 et 100 !' ;
        }
    }

    else{
        echo 'Il manque un parametre !';
    }
    ?>