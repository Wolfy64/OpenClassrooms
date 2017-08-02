<?php

/**
* ==== RULES TO ORGANIZE YOUR CODE ====
*
* 2 parts in a page: the top with php, the bottom with html
* all queries have to be in the php part, ath the begginning
*in html part, if you start with php, you have to close with php
*don't repeat yourself, so use variables and "include" to *factorise your code
**/

// do the queries
$bdd = new PDO('mysql:host=localhost;dbname=tp_cours;charset=utf8', 'root', 'root'); $query = "SELECT * FROM book";
$req = $bdd->prepare($query);
$req-> execute();
while($row = $req->fetch(PDO::FETCH_ASSOC)){
    // create one book(an array) with each line from the bdd
    // notice that there in no "s" on book
    $book = array(
        'title' => $row['title'],
        'author' => $row['author'],
        'description' => $row['description'],
        'note' => $row['note']
        );

    // add this book in global array: it's an array of array
    // don't forget the "s" on $bookSSSS
    $books[] = $book;
}

// include the doctype and the top of the page which is the same on all page
include_once('_head.php');
include_once('_nav.php');

?>

<section id="list_book">
    <table class="table">
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Description</th>
            <th>Note</th>
        </tr>
        <?php foreach ($books as $book): ?>
        <tr>
            <th> <?php echo $book['title']; ?></th>
            <th> <?php echo $book['author']; ?></th>
            <th> <?php echo $book['description']; ?></th>
            <th> <?php echo $book['note']; ?></th>
        </tr>
        <?php endforeach ?>
    </table>
</section>

<section id="add_book">
    <?php include_once('_form.php'); ?>
</section>

<?php require_once('_footer.php'); ?>