
# TP : page protégée par mot de passe

**Bienvenue dans votre premier TP !**  
Ce qui suit n'est pas un chapitre comme les autres, vous n'allez rien apprendre de nouveau. Mais pour la première fois, vous allez pratiquer pour de bon et réaliser votre premier script PHP !

Le but de chacun des TP est de vous montrer à quoi peut servir tout ce que vous venez d'apprendre. Quand vous lisez un chapitre, vous êtes parfois dans le flou, vous vous dites : « Ok, j'ai compris ce que tu veux me dire, mais je ne vois vraiment pas où tu veux en venir : comment je peux faire un site web avec tout ça ? ». Maintenant, place au concret !

Et − bonne surprise − vous avez déjà le niveau pour protéger le contenu d'une page par mot de passe ! C'est ce que je vais vous apprendre à faire dans ce chapitre.

Comme c'est votre premier TP, il est probable que vous vous plantiez lamentablement (vous voyez, je ne vous cache rien). Vous aurez envie de vous pendre ou de vous jeter par la fenêtre, c'est tout à fait normal.
Je connais peu de monde qui peut se vanter d'avoir réussi du premier coup son premier script PHP. Ne vous découragez donc pas, essayez de suivre et de comprendre le fonctionnement de ce TP, et ça ira déjà mieux au prochain. :-)

## Instructions pour réaliser le TP

**Les prérequis**

En règle générale, il faut avoir lu tous les chapitres qui précèdent le TP pour bien le comprendre. Voici la liste des connaissances dont vous aurez besoin pour réaliser ce TP :

afficher du texte avececho ;
utiliser les variables (affectation, affichage…) ;
transmettre des variables via une zone de texte d'un formulaire ;
utiliser des conditions simples (if,else).
Si l'un de ces points est un peu flou pour vous (vous avez peut-être oublié), n'hésitez pas à relire le chapitre correspondant, vous en aurez besoin pour traiter convenablement le TP. Vous verrez, il ne vous sera pas demandé de faire des choses compliquées. Le but est simplement d'assembler toutes vos connaissances pour répondre à un problème précis.

**Votre objectif**

Voici le scénario : vous voulez mettre en ligne une page web pour donner des informations confidentielles à certaines personnes. Cependant, pour limiter l'accès à cette page, il faudra connaître un mot de passe.

Dans notre cas, les données confidentielles seront les codes d'accès au serveur central de la NASA (soyons fous !). Le mot de passe pour pouvoir visualiser les codes d'accès sera kangourou.

Sauriez-vous réaliser une page qui n'affiche ces codes secrets que si l'on a rentré le bon mot de passe ?

**Comment procéder ?**

Pour coder correctement, je recommande toujours de travailler d'abord au brouillon (vous savez, avec un stylo et une feuille de papier !). Ça peut bien souvent paraître une perte de temps, mais c'est tout à fait le contraire. Si vous vous mettez à écrire des lignes de code au fur et à mesure, ça va être à coup sûr le bazar. À l'inverse, si vous prenez cinq minutes pour y réfléchir devant une feuille de papier, votre code sera mieux structuré et vous éviterez de nombreuses erreurs (qui font, elles, perdre du temps).

À quoi doit-on réfléchir sur notre brouillon ?
Au problème que vous vous posez (qu'est-ce que je veux arriver à faire ?).
Au schéma du code, c'est-à-dire que vous allez commencer à le découper en plusieurs morceaux, eux-mêmes découpés en petits morceaux (c'est plus facile à avaler).
Aux fonctions et aux connaissances en PHP dont vous allez avoir besoin (pour être sûrs que vous les utilisez convenablement).
Et pour montrer l'exemple, nous allons suivre cette liste pour notre TP.

**Problème posé**

On doit protéger l'accès à une page par un mot de passe. La page ne doit pas s'afficher si l'on n'a pas le mot de passe.

**Schéma du code**

Pour que l'utilisateur puisse entrer le mot de passe, le plus simple est de créer un formulaire. Celui-ci appellera la page protégée et lui enverra le mot de passe. Un exemple de ce type de page est représenté à la figure suivante.
L'accès au contenu de la page ne sera autorisé que si le mot de passe fourni par l'utilisateur est kangourou.


Page protégée par mot de passe
Vous devez donc créer deux pages web :

formulaire.php : contient un simple formulaire comme vous savez les faire ;
secret.php : contient les « codes secrets » mais ne les affiche que si on lui donne le mot de passe.
Connaissances requises

Nous avons détaillé les connaissances requises au début de ce chapitre. Vous allez voir que ce TP n'est qu'une simple application pratique de ce que vous connaissez déjà, mais cela sera une bonne occasion de vous entraîner. ;-)

**À vous de jouer !**

On a préparé le terrain ensemble ; maintenant, vous savez tout ce qu'il faut pour réaliser le script !

Vous êtes normalement capables de trouver le code à taper par vous-mêmes, et c'est ce que je vous invite à faire. Ça ne marchera probablement pas du premier coup, mais ne vous en faites pas : ça ne marche jamais du premier coup !

Bon code !