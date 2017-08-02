<p> <a href="index.php">Retour à la liste des News</a> </p>

<p> Par <em> <?php echo $news->getAuthor(); ?> </em> , le <?php echo $news->getDateAdd(); ?> </p>

<h2>  <?php echo $news->getTitle(); ?>  </h2>

<p>  <?php echo $news->getContent(); ?> </p>

<p> <?php echo $news->getDateUpdate() ?> </p>