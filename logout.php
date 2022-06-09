<?php
    session_start();
    session_destroy();
    include_once('config.php');
    include_once('header.php');
?>
<p class="alert alert-warning my-5">Vous avez été déconnecté</p>
<a class="btn btn-primary" href="./index.php">Retourner a l'accueil</a>

<?php include_once('footer.php'); ?>