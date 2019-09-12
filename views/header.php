<?php

session_start();

$page = $_REQUEST["page"] ?? "home";
  $fichier = "";

  switch($page){
    case 'home' :
      $fichier = "accueil.php";
      break;
    case 'detail' :
      $fichier = "detail.php";
      break;
    case 'contact' :
      $fichier = "contact.php";
      break;
    case 'admin' :
      $fichier = "../admin/index.php";
      break;
    case 'insert' :
      $fichier = "../admin/insert.php";
      break;
    case 'delete' :
      $fichier = "../admin/delete.php";
      break;
    case 'view' :
      $fichier = "../admin/view.php";
      break;
    case 'update' :
      $fichier = "../admin/update.php";
      break;
    case 'login' :
      $fichier = "../admin/login.php";
      break;
    case 'register' :
      $fichier = "../admin/register.php";
      break;
    case 'logout' :
      $fichier = "../admin/logout.php";
      break;
    case 'welcome' :
      $fichier = "../admin/welcome.php";
      break;
    default:
      $fichier = "404.php";
      break;
  }
?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    

    <title>Agence immobilière</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>

  <body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark" style="min-height: 10vh;margin: 0 !important;">
    <a class="navbar-brand" href="index.php?page=home">Agence immobilière</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php?page=home">Accueil <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=contact">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=login">Admin</a>
            </li>
            <?php if (isset($_SESSION["user_login"])): ?>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=logout">Se déconnecter</a>
            </li>
            <?php endif ?>
        </ul>
    </div>
</nav>

<main role="main" class="container" style="min-height:85vh;">

