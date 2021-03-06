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
    case 'tab' :
      $fichier = "tab.php";
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
    case 'deletePhotos' :
      $fichier = "../admin/deletePhotos.php";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
  </head>

  <body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark" style="min-height: 10vh;margin: 0 !important;">
    <a class="navbar-brand" href="index.php?page=home">Agence immobilière</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['QUERY_STRING'] == 'page=home'){echo 'active';}?>" href="index.php?page=home">Accueil <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['QUERY_STRING'] == 'page=contact'){echo 'active';}?>" href="index.php?page=contact">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['QUERY_STRING'] == 'page=login'){echo 'active';}?>" href="index.php?page=login">Admin</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['QUERY_STRING'] == 'page=tab'){echo 'active';}?>" href="index.php?page=tab">Tab</a>
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