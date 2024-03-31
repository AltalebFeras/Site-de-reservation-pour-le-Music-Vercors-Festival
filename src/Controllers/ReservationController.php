<?php

namespace src\Controllers;

session_start(); // Déplacer ceci au début du script ou dans une méthode appropriée

use src\Models\Database;
use src\Models\Reservation;
use src\Models\Utilisateur;
use src\Services\Reponse;
use src\Repositories\ReservationRepositories;
use src\Repositories\UtilisateurRepositories;



class ReservationController
{
    // Utilisation du trait "Reponse" supposé défini dans src/Services/Reponse.php
    use Reponse;

    private $DB;
    private $ReservationRepositories;
    private $UtilisateurRepositories;

    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();
        $this->ReservationRepositories = new ReservationRepositories;
        $this->UtilisateurRepositories = new UtilisateurRepositories;
        require_once __DIR__ . '/../../config.php';
    }

    public function traitmentReservation()
    {
        $this->ReservationRepositories->sInscrire();
        $this->render("reservation", ["erreur" => ""]);
    }
    

    // public function traitementReservation()
    // {
    //     if (
    //         empty($_POST) ||
    //         !isset($_POST['reservation']) ||
    //         !isset($_POST['nombreReservation']) ||
    //         !isset($_POST['prixTotal']) ||
    //         !isset($_POST['utilisateur'])
    //     ) {
    //         echo "Formulaire soumis incomplet";
    //         return; // Ajout d'un retour pour éviter l'exécution du reste du code
    //     }

    //     // Utilisation de noms de variables distincts pour les données du formulaire et l'instance de la classe Reservation
    //     $reservationData = htmlspecialchars($_POST['reservation']);
    //     $nombreReservation = htmlspecialchars($_POST['nombreReservation']);
    //     $prixTotal = htmlspecialchars($_POST['prixTotal']);
    //     $utilisateur = htmlspecialchars($_POST['utilisateur']);

    //     // Création d'une instance de la classe Reservation
    //     $reservation = new Reservation();
    //     $reservation->setReservationId($reservationData); // Utilisation d'une méthode adéquate pour définir les données
    //     $reservation->setNombreReservations($nombreReservation);
    //     $reservation->setPrixTotal($prixTotal);
    //     $reservation->setUtilisateurId($utilisateur);

    //     // Supposons que la logique pour sauvegarder la réservation soit implémentée ailleurs, sinon cela va générer une erreur
    //     // $reservation->save();

    //     // Cette partie peut être inutile si la sauvegarde de la réservation est gérée ailleurs
    //     $data = [
    //         'success' => true,
    //         'message' => 'Reservation created successfully',
    //         'reservation' => $reservation
    //     ];

    //     // Supposons que cette méthode envoie une réponse appropriée, ce qui nécessite la définition du trait Reponse
    //     // $this->sendResponse($data);
    // }
}