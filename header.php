<?php
session_start();
include_once('sql.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./assets/gbaf.png" />
    <title>GBAF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
            <img src="./assets/gbaf.png" alt="" width="45">
            </a>
            <div class="d-flex">
                <?php if (!isset($_SESSION['logged_user'])) : ?>
                    <a href='./user/login.php' class="btn btn-primary me-2" type="button">Connexion
                    </a>
                    <a href='./user/register.php' class="btn btn-primary bg-light text-primary me-2" type="button">Inscription
                    </a>
                <?php else : ?>
                    <div class="dropdown">
                        <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $_SESSION['logged_user_name']?>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item bg-danger" href='./user/logout.php'  type="button">Déconnexion</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="container">