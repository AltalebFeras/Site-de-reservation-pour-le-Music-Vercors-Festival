<?php

namespace src\Models;

use src\Services\Hydratation;

class Reservation
{
    private $reservationID;
    private $nombre_Reservations;
    private $prix_Total;
    private $utilisateurID;

    use Hydratation;



    /**
     * Get the value of reservationID
     *
     * @return  mixed
     */
    public function getReservationID()
    {
        return $this->reservationID;
    }

    /**
     * Set the value of reservationID
     *
     * @param   mixed  $reservationID  
     *
     */
    public function setReservationID($reservationID)
    {
        $this->reservationID = $reservationID;

    }

    /**
     * Get the value of nombre_Reservations
     *
     * @return  mixed
     */
    public function getNombreReservations()
    {
        return $this->nombre_Reservations;
    }

    /**
     * Set the value of nombre_Reservations
     *
     * @param   mixed  $nombre_Reservations  
     *
     */
    public function setNombreReservations($nombre_Reservations)
    {
        $this->nombre_Reservations = $nombre_Reservations;

    }

    /**
     * Get the value of prix_Total
     *
     * @return  mixed
     */
    public function getPrixTotal()
    {
        return $this->prix_Total;
    }

    /**
     * Set the value of prix_Total
     *
     * @param   mixed  $prix_Total  
     *
     */
    public function setPrixTotal($prix_Total)
    {
        $this->prix_Total = $prix_Total;


    }

    /**
     * Get the value of utilisateurID
     *
     * @return  mixed
     */
    public function getUtilisateurID()
    {
        return $this->utilisateurID;
    }

    /**
     * Set the value of utilisateurID
     *
     * @param   mixed  $utilisateurID  
     *
     */
    public function setUtilisateurID($utilisateurID)
    {
        $this->utilisateurID = $utilisateurID;

    }
   }
