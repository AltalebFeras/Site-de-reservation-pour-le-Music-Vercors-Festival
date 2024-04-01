<?php

namespace src\Controllers;

use src\Models\Database;
use src\Models\Reservation;
use src\Repositories\ReservationRepository;
use src\Services\Reponse;

// Déplacez session_start() au début du script ou dans une méthode appropriée

class ReservationController
{
    // Utilisation du trait "Reponse" supposé défini dans src/Services/Reponse.php
    use Reponse;

    private $DB;
    private $ReservationRepository;

    public function __construct()
    {
        session_start(); // Déplacez ceci au début du script ou dans une méthode appropriée

        $database = new Database;
        $this->DB = $database->getDB();
        $this->ReservationRepository = new ReservationRepository;
    }

    public function traitementReservation()
    {
        if (
            empty($_POST) ||
            !isset($_POST['reservationID']) ||
            !isset($_POST['nombre_reservations']) ||
            !isset($_POST['prix_total']) ||
            !isset($_POST['utilisateurID'])
        ) {
            echo "Formulaire soumis incomplet";
            return;
        }
  
        $reservationData = htmlspecialchars($_POST['reservationID']);
        $nombreReservation = htmlspecialchars($_POST['nombreR_rservations']);
        $prixTotal = htmlspecialchars($_POST['prix_total']);
        $utilisateur = htmlspecialchars($_POST['utilisateurID']);
  
        $reservation = new Reservation();
        $reservation->setReservationId($reservationData);
        $reservation->setNombreReservations($nombreReservation);
        $reservation->setPrixTotal($prixTotal);
        $reservation->setUtilisateurId($utilisateur);
  
        $data = [
            'success' => true,
            'message' => 'Reservation created successfully',
            'reservation' => $reservation
        ];
    }
  
}
