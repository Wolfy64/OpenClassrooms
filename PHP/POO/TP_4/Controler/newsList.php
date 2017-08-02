<?php
/**
*   SHOW LIST OF ALL NEWS
*/
require_once('Model/pageTitleManager.php');

require_once('View/_header.php');

require_once('View/newsCount.php');

$manager->newsList();

require_once('View/_footer.php');

