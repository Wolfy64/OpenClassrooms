<?php 
// 1 : on ouvre le fichier
$monfichier = fopen("compteur.txt", "r+");

// On lit la première ligne (nombre de pages vues)
$pagesVues = fgets($monfichier);

// On augmente de 1 ce nombre de pages vues
$pagesVues =+ 1;

// On remet le curseur au début du fichier
fseek($monfichier, 0);

// On écrit le nouveau nombre de pages vues
fputs($monfichier, $pagesVues);

// 3 : quand on a fini de l'utiliser, on ferme le fichier
fclose($monfichier);

echo "<p>Cette page à été vue " . $pagesVues . " fois.</p>"
?>
