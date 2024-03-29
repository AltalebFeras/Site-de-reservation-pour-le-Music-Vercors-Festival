<?php

namespace src\Controllers;

session_start();
use src\Services\Reponse;


class ReservationController
{
    use Reponse;


    public function index(): void
    {
        $this->render("Reservation");
    }

    public function indexAdmin(): void
    {
        $this->render("admin");
    }

    public function indexConnexion(): void
    {
        $this->render("connexion");
    }

    public function authAdmin(string $motDePasseAdmin): void
    {
        if ($motDePasseAdmin === 'admin') {
            $_SESSION['connecté'] = TRUE;
            header('location: ' . HOME_URL . 'dashboard');
            die();
        } else {
            header('location: ' . HOME_URL . '?erreur=connexion');
        }
    }


    public function authUser(string $motDePasseUser): void
    {
        if ($motDePasseUser === 'admin') {
            $_SESSION['connecté'] = TRUE;
            header('location: ' . HOME_URL . 'dashboard');
            die();
        } else {
            header('location: ' . HOME_URL . '?erreur=connexion');
        }
    }


    public function deconnexion(): void
    {
        session_destroy();
        header('location: ' . HOME_URL);
        die();
    }





}