<?php

namespace src\Repositories;

use PDO;
use src\Models\Database;
use src\Models\Pass;
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

    // public function traitementPass(PassRepositories $PassRepositories)
    // {
    //     $prixPass = 0;
    //     $nomPass = "";

    //     if (isset($_POST['choixPass'])) {
    //         $prixPass = $this->getPrixPass($_POST['choixPass']);
    //         $nomPass = htmlspecialchars($_POST['choixPass']);
    //     } elseif (isset($_POST['choixPassReduit'])) {
    //         $prixPass = $this->getPrixPass($_POST['choixPassReduit']);
    //         $nomPass = htmlspecialchars($_POST['choixPassReduit']);
    //     } else {
    //         echo "error choisi un pass";
    //     }


    //     $pass = new Pass(['prixPass' => $prixPass, 'nomPass' => $nomPass]);

    //     $PassRepositories->createPass($pass);
    // }

    public function createPass(Pass $Pass): Pass
    {
        $sql = "INSERT INTO " . PREFIXE . "pass (prixPass, nomPass )
              VALUES (:prixPass, :nomPass )";
        $statement = $this->DB->prepare($sql);
        $retour = $statement->execute([
            ':prixPass' => $Pass->getPrixPass(),
            ':nomPass' => $Pass->getNomPass(),
        ]);

        return $Pass;
    }

    // public function traitementJour()
    // {
    //     if (isset($_POST['choixJour']) && $_POST['choixJour'] === "choixJour1") {
    //         $jour = $this->getJour($_POST['choixPass']);
    //         return $jour;
    //     }
    // }
    // public function createJour()
    // {
    
    //     $sql = "INSERT INTO " . PREFIXE . "reservation_pass (jour, passID, reservationID )
    //     VALUES (:jour, :passID, :reservationID )";
       
    //     $statement = $this->DB->prepare($sql);
    //     $retour = $statement->execute([
    //         ':jour' =>getJour(),
    //         ':passID' =>getPassID(),
    //         ':reservationID' => getReservationID(),
    //     ]);
    // }
    private function getJour($choixJour)
    {
        switch ($choixJour) {
            case 'choixJour1':
                return '01/07/2024';
            case 'choixJour2':
                return '02/07/2024';
            case 'choixJour3':
                return '03/07/2024';
          
            default:
                return ''; // Default price if pass type not recognized
        }
    }
    private function getPrixPass($choixPass)
    {
        switch ($choixPass) {
            case 'pass1jour':
                return 40;
            case 'pass2jours':
                return 70;
            case 'pass3jours':
                return 100;
            case 'pass1jourreduit':
                return 25;
            case 'pass2joursreduit':
                return 50;
            case 'pass3joursreduit':
                return 65;
            default:
                return 0; // Default price if pass type not recognized
        }
    }
    public function traitementPass(PassRepositories $PassRepositories)
{
    $prixPass = 0;
    $nomPass = "";

    if (isset($_POST['choixPass'])) {
        $prixPass = $this->getPrixPass($_POST['choixPass']);
        $nomPass = htmlspecialchars($_POST['choixPass']);
    } elseif (isset($_POST['choixPassReduit'])) {
        $prixPass = $this->getPrixPass($_POST['choixPassReduit']);
        $nomPass = htmlspecialchars($_POST['choixPassReduit']);
    } else {
        echo "error choisi un pass";
    }

    $pass = new Pass(['prixPass' => $prixPass, 'nomPass' => $nomPass]);

    // Create pass and get its ID
    $pass = $PassRepositories->createPass($pass);
    $passID = $pass->getPassID(); 

    // For reservation ID, you need to fetch it from somewhere, maybe session or database
    $reservationID = $Reservation->getReservationID(); // Implement this method to fetch reservation ID

    // After creating pass, handle day (jour)
    if (isset($_POST['choixJour']) && $_POST['choixJour'] === "choixJour1") {
        $jour = $this->getJour($_POST['choixJour']);

        // Create jour entry in database
        $this->createJour($jour, $passID, $reservationID);
    }
}

public function createJour($jour, $passID, $reservationID)
{
    $sql = "INSERT INTO " . PREFIXE . "reservation_pass (jour, passID, reservationID)
            VALUES (:jour, :passID, :reservationID)";
   
    $statement = $this->DB->prepare($sql);
    $retour = $statement->execute([
        ':jour' => $jour,
        ':passID' => $passID,
        ':reservationID' => $reservationID,
    ]);
}

}
