<?php

namespace src\Repositories;

use PDO;
use src\Models\Database;
use src\Models\Pass;
use src\Models\Reservation;

class Reservation_passRepositories
{
    private $DB;
    private $ReservationRepositories;
    private $PassRepositories;


    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();
        $this->ReservationRepositories = new ReservationRepositories;
        $this->PassRepositories = new PassRepositories;

        require_once __DIR__ . '/../../config.php';
    }

    public function reservationID($Reservation){
        $this->ReservationRepositories = new ReservationRepositories;
        
    $reservationID = $this->DB->lastInsertId();
    $Reservation->setReservationID($reservationID);
    return $reservationID;

    }
    public function passID($Pass){
        $this->PassRepositories = new PassRepositories;

        
    $passID = $this->DB->lastInsertId();
    $Pass->setReservationID($passID);
    return $passID;

    }

    public function x()
{
    
    // Check if $jour is not empty
    if (!empty($jour)) {
        
        $jour = $this->traitementJour(); // Get the selected day
        $passID = $_SESSION['passID'];
        $reservationID = $_SESSION['reservationID'];
        
        // Prepare SQL statement
        $sql = "INSERT INTO " . PREFIXE . "reservation_pass (jour, passID, reservationID) VALUES (:jour, :passID, :reservationID)";

        // Prepare and execute the statement
        $statement = $this->DB->prepare($sql);
        $retour = $statement->execute([
            ':jour' => $jour,
            ':passID' => $passID,
            ':reservationID' => $reservationID,
        ]);
    }
}

    public function traitementJour()
    {
        if (isset($_POST['choixJour'])) {
            $choixJour = $_POST['choixJour'];
             if ($choixJour === "choixJour1" || $choixJour === "choixJour2" || $choixJour === "choixJour3") {
                $jour = $this->getJour($choixJour);
                return $jour; 
            }
        }
        if (isset($_POST['choixJour2'])) {
            $choixJour = $_POST['choixJour2'];
             if ($choixJour === "choixJour12" || $choixJour === "choixJour23" ) {
                $jour = $this->getJour($choixJour);
                return $jour; 
            }
        }

        if (isset($_POST['choixPass'])) {
            $choixJour = $_POST['choixPass'];
             if ($choixJour === "pass3jours" ) {
                $jour = $this->getJour($choixJour);
                return $jour; 
            }
        }

        if (isset($_POST['choixJourReduit'])) {
            $choixJour = $_POST['choixJourReduit'];
             if ($choixJour === "choixJour1reduit" || $choixJour === "choixJour2reduit" || $choixJour === "choixJour3reduit") {
                $jour = $this->getJour($choixJour);
                return $jour; 
            }
        }
        if (isset($_POST['choixJour2Reduit'])) {
            $choixJour = $_POST['choixJour2Reduit'];
             if ($choixJour === "choixJour12reduit" || $choixJour === "choixJour23reduit" ) {
                $jour = $this->getJour($choixJour);
                return $jour; 
            }
        }

        if (isset($_POST['choixPassReduit'])) {
            $choixJour = $_POST['choixPassReduit'];
             if ($choixJour === "pass3joursreduit" ) {
                $jour = $this->getJour($choixJour);
                return $jour; 
            }
        }
    }
    


    public function createJour($Pass, $Reservation, $choixJour)
    {
        $sql = "INSERT INTO " . PREFIXE . "reservation_pass (jour, passID, reservationID) VALUES (:jour, :passID, :reservationID)";
            $jour= $this->getJour($choixJour);
            $passID= $this->reservationID($Reservation);
            $reservationID= $this->passID($Pass);
        $statement = $this->DB->prepare($sql);
        $retour = $statement->execute([
            ':jour' => $jour,
            ':passID' => $passID,
            ':reservationID' => $reservationID,
        ]);
    }
    public function getJour($choixJour)
    {
        
        switch ($choixJour) {
            case 'choixJour1':
                return '01/07/2024';

            case 'choixJour2':
                return '02/07/2024';

            case 'choixJour3':
                return '03/07/2024';

            case 'choixJour1reduit':
                return '01/07/2024';

            case 'choixJour2reduit':
                return '02/07/2024';

            case 'choixJour3reduit':
                return '03/07/2024';

            case 'choixJour12':
                return '01/07/2024' . '/' . '02/07/2024';

            case 'choixJour23':
                return '02/07/2024' . '/' . '03/07/2024';

            case 'choixJour12reduit':
                return '01/07/2024' . '/' . '02/07/2024';

            case 'choixJour23reduit':
                return '02/07/2024' . '/' . '03/07/2024';

            case 'pass3jours':
                return '01/07/2024' . '/' . '02/07/2024' . '/' . '03/07/2024';

            case 'pass3joursreduit':
                return '01/07/2024' . '/' . '02/07/2024' . '/' . '03/07/2024';

            default:
                return ''; // Default price if pass type not recognized
        }
    }



//     public function traitementJour()
// {
//     // Define an array to map the POST values to their corresponding date options
//     $choixJourOptions = [
//         'choixJour1' => 'choixJour1',
//         'choixJour2' => 'choixJour2',
//         'choixJour3' => 'choixJour3',
//         'choixJour12' => 'choixJour12',
//         'choixJour23' => 'choixJour23',
//         'pass3jours' => 'pass3jours',
//         'choixJour1reduit' => 'choixJour1reduit',
//         'choixJour2reduit' => 'choixJour2reduit',
//         'choixJour3reduit' => 'choixJour3reduit',
//         'choixJour12reduit' => 'choixJour12reduit',
//         'choixJour23reduit' => 'choixJour23reduit',
//         'pass3joursreduit' => 'pass3joursreduit'
//     ];

//     // Loop through the array and check if the corresponding $_POST value is set
//     foreach ($choixJourOptions as $postValue => $choixJour) {
//         if (isset($_POST[$postValue])) {
//             // If set, call getJour with the selected option and return the result
//             return $this->getJour($choixJour);
//         }
//     }

//     // If none of the options are set, return an empty string or handle the default behavior as needed
//     return '';
// }

}
