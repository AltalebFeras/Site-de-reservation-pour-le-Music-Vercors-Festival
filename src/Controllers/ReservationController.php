<?php

namespace src\Controllers;

use src\Models\Database;
use src\Services\Reponse;
use src\Repositories\ReservationRepositories;

class ReservationController
{
    use Reponse;

    private $DB;
    private $ReservationRepositories;

    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();
        $this->ReservationRepositories = new ReservationRepositories;
        require_once __DIR__ . '/../../config.php';
    }

    public function stockerLaReservation()
    {
        $ReservationRepositories = new ReservationRepositories();
        $this->ReservationRepositories->traitementReservation($ReservationRepositories);
        $this->render("dashboard", ["erreur" => ""]);
        
    }
}
