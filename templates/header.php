<?php
require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);

$flassMessage = $message->getMessage();

if(!empty($flassMessage["msg"])){
    //Limpar a mensagem
    $message->clearMessage();

}

$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(false);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieStar</title>
    <link rel="short icon" href="<?= $BASE_URL ?>img/logoicon.png"/>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/css/bootstrap.css" integrity="sha512-r0fo0kMK8myZfuKWk9b6yY8azUnHCPhgNz/uWDl2rtMdWJlk7gmd9socvGZdZzICwAkMgfTkVrplDahQ07Gi0A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">

</head>
<body>
    <header>
        <nav id="main-navbar" class="navbar navbar-expand-lg">
            <a href="<?= $BASE_URL ?>" class="navbar-brand">
            <img src="<?= $BASE_URL ?>img/logo.png" alt="MovieStar" id="logo">
            <span id="moviestar-title">MovieStar</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"
            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <form action="" method="GET" id="search-form" class="form-inline my-2 my-lg-0">
                <input type="text" name="q" id="search" class="form-control mr-sm-2" type="search" placeholder="Buscar filmes" aria-label="Search">
                <button class="btn my-2 my-sm-0" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav">
                    <?php if($userData):?>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>./newmovie.php" class="nav-link">
                        <i class=" far fa-plus-square"></i> Incluir Filme
                    </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>./dashboard.php" class="nav-link">Meus Filmes</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>./editprofile.php" class="nav-link bold"><?=$userData->name?></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>./logout.php" class="nav-link">Sair</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>./auth.php" class="nav-link">Entrar/Cadastrar</a>
                    </li>
                    <?php endif; ?> 
                </ul>
            </div>
        
        </nav>
    </header>
    <?php if(!empty($flassMessage["msg"])):?>
        <div class="msg-container">
            <p class="msg <?=$flassMessage["type"] ?>"><?=$flassMessage["msg"] ?></p>
        </div>
    <?php endif ;?>
