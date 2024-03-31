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
      $UtilisateurController->traitmentUtilisateur();
    } else {
      $HomeController->index();
    }
    break;


  case HOME_URL . 'admin':
    if (isset($_SESSION['connecté'])) {
      header('location: /dashboard');
      die;
    } else {
      if ($methode === 'POST') {
        $HomeController->authAdmin($_POST['motDePasseAdmin']);
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
        $UtilisateurController->connexionUtilisateur();
      } else {
        $HomeController->indexConnexion();
      }
    }
    break;

  case HOME_URL . 'dashboard':
    $UtilisateurController->showDashboard();
    break;

  case HOME_URL . 'deconnexion':
    $HomeController->quit();
    break;

  case HOME_URL . 'dashboard' . 'supprimer':
    if ($methode === "POST") {
      $utilisateurID = $_SESSION['utilisateur'];
      $UtilisateurController->supprimerUtilisateur();
    }
    break;



  case $routeComposee[0] == "dashboard":
    if (isset($_SESSION["connecté"])) {
      // On a ici toutes les routes qu'on a à partir du dashboard

      switch ($route) {
        case $routeComposee[1] == "compte":
          $UtilisateurController->afficherCompte();
          case $routeComposee[1] == "reservation":
            $UtilisateurController->afficherReservation();


          switch ($route) {

            case $routeComposee[2] == "delete":

              break;

            default:

              $UtilisateurController->showDashboard();
              break;
          }

          break;

        default:
          // par défaut une fois connecté, on voit la liste des films.
          $UtilisateurController->showDashboard();
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
