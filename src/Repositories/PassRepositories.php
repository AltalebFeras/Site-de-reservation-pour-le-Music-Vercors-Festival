<?php

namespace src\Repositories;

use src\Models\Nuitee;
use PDO;
use src\Models\Database;
use src\Models\Utilisateur;
use src\Models\Reservation;

class PassRepositories
{
    private $DB;

    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();

        require_once __DIR__ . '/../../config.php';
    }