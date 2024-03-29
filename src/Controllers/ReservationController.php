<?php

namespace src\Controllers;

session_start();
use src\Services\Reponse;
use src\Models\Reservation;


class ReservationController
{
    use Reponse;

    public function traitementReservation()
    {
        if (
            empty($_POST) ||
            !isset($_POST['reservation']) ||
            !isset($_POST['nombreReservation']) ||
            !isset($_POST['prixTotal']) ||
            !isset($_POST['utilisateur'])
        ) {
            echo "form submitted";
        }
        $reservation = htmlspecialchars($_POST['reservation']);
        $nombreReservation = htmlspecialchars($_POST['nombreReservation']);
        $prixTotal = htmlspecialchars($_POST['prixTotal']);
        $utilisateur = htmlspecialchars($_POST['utilisateur']);

        $reservation = new Reservation();
        $reservation->setReservationId($reservation);
        $reservation->setNombreReservations($nombreReservation);
        $reservation->setPrixTotal($prixTotal);
        $reservation->setUtilisateurId($utilisateur);

        $reservation->save();

        $data = [
            'success' => true,
            'message' => 'Reservation created successfully',
            'reservation' => $reservation
        ];
    }



}