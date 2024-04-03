<?php

namespace src\Repositories;

use src\Models\Nuitee;
use PDO;
use src\Models\Database;
use src\Models\Reservation;

class NuiteeRepositories
{
    private $DB;

    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();

        require_once __DIR__ . '/../../config.php';
    }

    public function traitementNuitee(NuiteeRepositories $NuiteeRepositories)
    {
         $nights = [];
        $prices = [];

         for ($i = 1; $i <= 3; $i++) {
            if (isset($_POST['tenteNuit' . $i])) {
                $nights[] = htmlspecialchars($_POST['tenteNuit' . $i]);
                $prices[] = $this->getPrixNuitee($_POST['tenteNuit' . $i]);
            }
        }

         for ($i = 1; $i <= 3; $i++) {
            if (isset($_POST['vanNuit' . $i])) {
                $nights[] = htmlspecialchars($_POST['vanNuit' . $i]);
                $prices[] = $this->getPrixNuitee($_POST['vanNuit' . $i]);
            }
        }

         if (isset($_POST['tente3Nuits']) && isset($_POST['van3Nuits'])) {
            $nights[] = htmlspecialchars($_POST['tente3Nuits']);
            $prices[] = $this->getPrixNuitee($_POST['tente3Nuits']);

            $nights[] = htmlspecialchars($_POST['van3Nuits']);
            $prices[] = $this->getPrixNuitee($_POST['van3Nuits']);
        }

        // Insert each selected night into the database
        foreach ($nights as $index => $night) {
            $nuitee = new Nuitee(['prixNuitee' => $prices[$index], 'nomNuitee' => $night]);
            $NuiteeRepositories->createNuitee($nuitee);
        }
    }

    public function createNuitee(Nuitee $Nuitee): Nuitee
    {
        $sql = "INSERT INTO " . PREFIXE . "nuitee (nomNuitee, prixNuitee)
                VALUES (:nomNuitee, :prixNuitee)";
        $statement = $this->DB->prepare($sql);
        $retour = $statement->execute([
            ':nomNuitee' => $Nuitee->getNomNuitee(),
            ':prixNuitee' => $Nuitee->getPrixNuitee(),
        ]);

        return $Nuitee;
    }

    private function getPrixNuitee($nightType)
    {
        switch ($nightType) {
            case 'tenteNuit1':
            case 'tenteNuit2':
            case 'tenteNuit3':
                return 5;
            case 'tente3Nuits':
            case 'van3Nuits':
                return 12;
            case 'vanNuit1':
            case 'vanNuit2':
            case 'vanNuit3':
                return 5;
            default:
                return 0;
        }
    }

    // Other methods...





    // public function CreateThisNuitee(Nuitee $Nuitee): Nuitee
    // {
    //     $sql = "INSERT INTO " . PREFIXE . "Nuitee (nuiteeID, nomNuitee, prixNuitee) VALUES 
    //     (:nuiteeID, :nomNuitee, :prixNuitee);
    //      INSERT INTO " . PREFIXE . "Reservation (dateDebut, dateFin, reservationID, user) VALUES
    //       (:datedebut, :datefin, :reservationid, :user);";
    //     $statement = $this->DB->prepare($sql);
    //     $statement->execute([
    //         ':nuiteeID' => $Nuitee->getNuiteeID(),
    //         ':nomNuitee' => $Nuitee->getNomNuitee(),
    //         ':prixNuitee' => $Nuitee->getPrixNuitee(),
    //         // ':user'=> $Nuitee->getUser()
    //     ]);
    //     $id = $this->DB->lastInsertId();
    //     $Nuitee->setNuiteeID($id);
    //     return $Nuitee;
    // }

    // public function deleteThisNuitee($Id): bool
    // {
    //     $sql = "DELETE FROM " . PREFIXE . "Nuitee WHERE ID = :id; 
    //             DELETE FROM " . PREFIXE . "Reservation WHERE reservationID = :id;";
    //     $statement = $this->DB->prepare($sql);
    //     $statement->bindParam(':id', $Id);
    //     return $statement->execute();
    // }
}
