<?php

use src\Controllers\HomeController;
use src\Controllers\UtilisateurController;
use src\Services\Routing;

$HomeController = new HomeController;
$UtilisateurController = new UtilisateurController;
// $FilmController = new FilmController;

$route = $_SERVER['REDIRECT_URL'];
$methode = $_SERVER['REQUEST_METHOD'];
$routeComposee = Routing::routeComposee($route);


switch ($route) {
  case HOME_URL:
    if (isset($_SESSION['connecté'])) {
      header('location: ' . HOME_URL . 'dashboard');
      die;
    } 
    if ($methode === 'POST') {
      // I HAVE TO ADD THE TREATMENT TO THE HOME CONTROLLER FOR THE USER 
      $UtilisateurController->x();
    } 
    else {
      $HomeController->index();
    }
    break;


  case HOME_URL . 'admin':
    if (isset($_SESSION['connecté'])) {
      header('location: /dashboard');
      die;
    } else {
      if ($methode === 'POST') {
        $HomeController->authAdmin($_POST['password']);
      } else {
        $HomeController->indexAdmin();
      }
    }
    break;
  case HOME_URL . 'connexion':
    if (isset($_SESSION['connecté'])) {
      header('location: /dashboard');
      die;
    } else {
      if ($methode === 'POST') {
        // I HAVE TO ADD THE TREATMENT TO THE HOME CONTROLLER FOR THE USER 
        $HomeController->authAdmin($_POST['password']);
      } else {
        $HomeController->indexConnexion();
      }
    }
    break;


  case HOME_URL . 'deconnexion':
    $HomeController->quit();
    break;

  case $routeComposee[0] == "dashboard":
    if (isset($_SESSION["connecté"])) {
      // On a ici toutes les routes qu'on a à partir du dashboard

      switch ($route) {
        case $routeComposee[1] == "films":
          // On a ici toutes les routes qu'on peut faire pour les films
          switch ($route) {
            case $routeComposee[2] == "new":
              if ($methode === "POST") {
                $data = $_POST;
                $FilmController->save($data);
              } else {
                $FilmController->new();
              }
              break;

            case $routeComposee[2] == 'details':
              $idFilm = end($routeComposee);
              $FilmController->show($idFilm);
              break;

            case $routeComposee[2] == "edit":
              $idFilm = end($routeComposee);
              $FilmController->edit($idFilm);
              break;

            case $routeComposee[2] == "update":
              if ($methode === "POST") {
                $idFilm = end($routeComposee);
                $data = $_POST;
                $FilmController->save($data, $idFilm);
              }
              break;

            case $routeComposee[2] == "delete":
              $idFilm = end($routeComposee);
              $FilmController->delete($idFilm);
              break;

            default:
              // par défaut on voit la liste des films.
              $FilmController->index();
              break;
          }

          break;

        default:
          // par défaut une fois connecté, on voit la liste des films.
          $FilmController->index();
          break;
      }
    } else {
      header("location: " . HOME_URL);
      die;
    }
    break;

  default:
    $HomeController->page404();
    break;
}
