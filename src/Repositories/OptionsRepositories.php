<?php 

namespace src\Repositories;

use src\Models\Options;
use PDO;
use src\Models\Database;
use src\Models\Reservation;

class OptionsRepositories
{
    private $DB;

    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();

        require_once __DIR__ . '/../../config.php';
    }

    public function getThisOptionsById($id): Options
    {
        $sql = $this->concatenationRequete("WHERE " . PREFIXE . "options.ID = :id");

        $statement = $this->DB->prepare($sql);

        // verifier si besoin d'ajouter options.ID = :id
        $statement->bindParam(':id', $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Options::class);
        return $statement->fetch();
    }

    public function getThisOptionsByReservationId($id): Options
    {
        $sql = $this->concatenationRequete("WHERE " . PREFIXE . "options.reservationId = :id");

        $statement = $this->DB->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Options::class);
        return $statement->fetch();
    }

    public function getThisOptionsByUser($id): Options
    {
        $sql = $this->concatenationRequete("WHERE " . PREFIXE . "options.user = :id");

        $statement = $this->DB->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Options::class);
        return $statement->fetch();
    }


    public function CreateThisOptions(Options $Options): Options
    {
        $sql = "INSERT INTO " . PREFIXE . "Options (optionsID, nomOptions, prixOptions) VALUES (:optionsID, :nomOptions, :prixOptions)";
        $statement = $this->DB->prepare($sql);
        $statement->bindParam(':optionsID', $Options->optionsID);
        $statement->bindParam(':nomOptions', $Options->nomOptions);
        $statement->bindParam(':prixOptions', $Options->prixOptions);
        $statement->execute();
        return $Options;
    }

    public function UpdateThisOptions(Options $Options): Options
    {
        $sql = "UPDATE " . PREFIXE . "Options SET nomOptions = :nomOptions, prixOptions = :prixOptions WHERE optionsID = :optionsID";
        $statement = $this->DB->prepare($sql);
        $statement->bindParam(':optionsID', $Options->optionsID);
        $statement->bindParam(':nomOptions', $Options->nomOptions);
        $statement->bindParam(':prixOptions', $Options->prixOptions);
        $statement->execute();
        return $Options;
    }

    public function DeleteThisOptions(Options $Options): Options
    {
        $sql = "DELETE FROM " . PREFIXE . "Options WHERE optionsID = :optionsID";
        $statement = $this->DB->prepare($sql);
        $statement->bindParam(':optionsID', $Options->optionsID);
        $statement->execute();
        return $Options;
    }


    private function concatenationRequete($sql)
    {
        $sql = "SELECT * FROM " . PREFIXE . "Options " . $sql;
        return $sql;
    }

}