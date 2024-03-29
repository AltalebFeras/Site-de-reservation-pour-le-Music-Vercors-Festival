<?php

namespace src\Models;

use src\Services\Hydratation;

class Reservation {
    private $ReservationId, $NombreReservations, $PrixTotal, $UtilisateurId;

    use Hydratation;


    public function getReservationId(): int {
        return $this->ReservationId;
    }
    public function setReservationId(int $ReservationId): void{
        $this->ReservationId = $ReservationId;
    }

    public function getNombreReservations(): int {
        return $this->NombreReservations;
    }
    public function setNombreReservations(int $NombreReservations): void {
        $this->NombreReservations = $NombreReservations;
    }

    public function getPrixTotal(): int {
        return $this->PrixTotal;
    }
    public function setPrixTotal(int $PrixTotal): void {
        $this->PrixTotal = $PrixTotal;
    }

    public function getUtilisateurId(): int {
        return $this->UtilisateurId;
    }


    public function setUtilisateurId(int $UtilisateurId): void {
        $this->UtilisateurId = $UtilisateurId;
    }
}
