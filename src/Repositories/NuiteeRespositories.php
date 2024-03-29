<?php

namespace src\Repositories;

use src\Models\Nuitee;
use PDO;
use src\Models\Database;
use src\Models\Reservation;

class NuiteeRespositories
{
    private $DB;

    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();

        require_once __DIR__ . '/../../config.php';
    }

    public function getThisNuiteeById($id): Nuitee
    {
        $sql = $this->concatenationRequete("WHERE " . PREFIXE . "nuitee.ID = :id");

        $statement = $this->DB->prepare($sql);

        // verifier si besoin d'ajouter nuittee.ID = :id
        $statement->bindParam(':id', $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Nuitee::class);
        return $statement->fetch();
    }

    public function getThisNuiteeByReservationId($id): Nuitee
    {
        $sql = $this->concatenationRequete("WHERE " . PREFIXE . "nuitee.reservationId = :id");

        $statement = $this->DB->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Nuitee::class);
        return $statement->fetch();
    }

    public function getThisNuiteeByUser($id): Nuitee
    {
        $sql = $this->concatenationRequete("WHERE " . PREFIXE . "nuitee.user = :id");

        $statement = $this->DB->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Nuitee::class);
        return $statement->fetch();
    }

    public function CreateThisNuitee(Nuitee $Nuitee): Nuitee
    {
        $sql = "INSERT INTO " . PREFIXE . "Nuitee (nuiteeID, nomNuitee, prixNuitee) VALUES (:nuiteeID, :nomNuitee, :prixNuitee); INSERT INTO " . PREFIXE . "Reservation (dateDebut, dateFin, reservationID, user) VALUES (:datedebut, :datefin, :reservationid, :user);";
        $statement = $this->DB->prepare($sql);
        $statement->execute([
            ':nuiteeID'=> $Nuitee->getNuiteeID(),
            ':nomNuitee'=> $Nuitee->getNomNuitee(),
            ':prixNuitee'=> $Nuitee->getPrixNuitee(),
            // ':user'=> $Nuitee->getUser()
        ]);
        $id = $this->DB->lastInsertId();
        $Nuitee->setNuiteeID($id);
        return $Nuitee;
    }

    public function deleteThisNuitee($Id): bool
    {
        $sql = "DELETE FROM " . PREFIXE . "Nuitee WHERE ID = :id; 
                DELETE FROM " . PREFIXE . "Reservation WHERE reservationID = :id;";
        $statement = $this->DB->prepare($sql);
        $statement->bindParam(':id', $Id);
        return $statement->execute();
    }

    private function concatenationRequete($condition)
    {
        return "SELECT * FROM " . PREFIXE . "nuitee " . $condition;
    }
}