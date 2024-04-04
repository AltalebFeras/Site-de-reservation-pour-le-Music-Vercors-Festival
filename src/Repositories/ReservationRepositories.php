<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Reservation;
use src\Models\Database;

class ReservationRepositories
{
  private $DB;

  public function __construct()
  {
    $database = new Database;
    $this->DB = $database->getDB();

    require_once __DIR__ . '/../../config.php';
  }



  public function   traitementReservation(ReservationRepositories $ReservationRepositories)
  {
    if (empty($_POST) || !isset($_POST['nombreReservations'])) {
      $nombreReservations = htmlspecialchars($_POST['nombreReservations']);
    }
    $totalPrice = $this->calculation();
    $nombreReservations = $_POST['nombreReservations'];
    $utilisateurID = $_SESSION['utilisateur'];
    $data = array(
      'nombreReservations' => $nombreReservations,
      'prixTotal' => $totalPrice,
      'utilisateurID' => $utilisateurID
    );

    $reservation = new Reservation($data);
    $ReservationRepositories->createReservation($reservation);
    $_SESSION['reservé'] = true;
    $_SESSION['message'] = "Votre réservation est validée!";
    

  }




  public function createReservation(Reservation $Reservation): Reservation
  {
    $sql = "INSERT INTO " . PREFIXE . "reservation (nombreReservations, prixTotal, utilisateurID )
     VALUES (:nombreReservations, :prixTotal, :utilisateurID );";
    $statement = $this->DB->prepare($sql);
    $retour = $statement->execute([
      ':nombreReservations' => $Reservation->getNombreReservations(),
      ':prixTotal' => $Reservation->getPrixTotal(),
      ':utilisateurID' => $Reservation->getUtilisateurID()
    ]);



    $reservationID = $this->DB->lastInsertId();
    $Reservation->setReservationID($reservationID);
    $_SESSION['reservationID'] =$this->DB->lastInsertId();

    return $Reservation;
  }
  public function insertID(Reservation $Reservation): Reservation
  {
    $sql = "INSERT INTO " . PREFIXE . "reservation (utilisateurID) VALUES (:utilisateurID)";
    $statement = $this->DB->prepare($sql);
    $statement->execute([
      ':utilisateurID' => $_SESSION['utilisateur']
    ]);
    $Reservation->setUtilisateurID($this->DB->lastInsertId());

    return $Reservation;
  }
  


  public function UpdateReservation(Reservation $Reservation): bool
  {
    $sql = "UPDATE " . PREFIXE . "mvf_reservation 
            SET
              nombreReservations = :nombreReservations,
              prixTotal = :prixTotal
            WHERE reservationID = :reservationID";

    $statement = $this->DB->prepare($sql);

    $retour = $statement->execute([
      ':reservationID' => $Reservation->getReservationId(),
      ':nombreReservations' => $Reservation->getnombreReservations(),
      ':prixTotal' => $Reservation->getPrixTotal()
    ]);

    return $retour;
  }

  public function deleteReservation(int $ID): bool
  {
    try {
      $sql = "DELETE FROM " . PREFIXE . "mvf_reservation WHERE reservationID = :reservationID;";

      $statement = $this->DB->prepare($sql);

      return $statement->execute([':reservationID' => $ID]);
    } catch (PDOException $error) {
      echo "Erreur de suppression : " . $error->getMessage();
      return false;
    }
  }


  public function getAllReservation()
  {
    $sql = "SELECT * FROM " . PREFIXE . "mvf_reservation;";

    $retour = $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Reservation::class);

    return $retour;
  }

  public function displayAllReservations()
  {
      $sql = "SELECT * FROM " . PREFIXE . "reservation;";
      $stmt = $this->DB->prepare($sql);
      $stmt->execute();
      $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
      if ($reservations) {
          echo "<table border='1'>
              <tr>
                  <th>Reservation ID</th>
                  <th>Number of Reservations</th>
                  <th>Total Price</th>
                  <th>User ID</th>
                  <th>User Reservations</th>
                  <th>User Passes</th>
                  <th>User Options</th>
                  <th>User Nights</th>
              </tr>";
  
          foreach ($reservations as $reservation) {
              // Retrieve user-specific data
              $userID = $reservation['utilisateurID'];
              $userReservations = $this->getUserReservations($userID);
              $userPasses = $this->getUserPasses($userID);
              // $userOptions = $this->getUserOptions($userID);
              // $userNights = $this->getUserNights($userID);
  
              echo "<tr>
                  <td>{$reservation['reservationID']}</td>
                  <td>{$reservation['nombreReservations']}</td>
                  <td>{$reservation['prixTotal']}</td>
                  <td>{$reservation['utilisateurID']}</td>
                  <td>$userReservations</td>
                  <td>$userPasses</td>
                  <td>$userOptions</td>
                  <td>$userNights</td>
              </tr>";
          }
  
          echo "</table>";
      } else {
          echo "No reservations found.";
      }
  }
  
  // Function to retrieve user reservations
  // Function to retrieve user reservations
private function getUserReservations($userID)
{
    // Execute SQL query to retrieve user reservations
    $sql = "SELECT * FROM mvf_reservation WHERE utilisateurID = :userID";
    $stmt = $this->DB->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $userReservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data or generate HTML representation
    $html = "<ul>";
    foreach ($userReservations as $reservation) {
        $html .= "<li>Reservation ID: {$reservation['reservationID']}</li>";
        $html .= "<li>Number of Reservations: {$reservation['nombreReservations']}</li>";
        $html .= "<li>Total Price: {$reservation['prixTotal']}</li>";
    }
    $html .= "</ul>";

    // Return the HTML representation of user reservations
    return $html;
}

  
  // Functions to retrieve user passes, options, and nights follow a similar structure as getUserReservations.
  
  public function getReservationById(int $id): Reservation|bool
  {
    $sql = "SELECT * FROM " . PREFIXE . "mvf_reservation WHERE reservationID = :id";

    $statement = $this->DB->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $retour = $statement->fetch(PDO::FETCH_CLASS, Reservation::class);

    return $retour;
  }
  public function calculation()
  {
    $numberOfReservations = intval($_POST["nombreReservations"]);

    //   Chosen Passes
    $pass1jourPrice = 40;
    $pass2joursPrice = 70;
    $pass3joursPrice = 100;
    $totalPassPrice = 0;

    $tarifReduitChecked = isset($_POST["tarifReduit"]);
    $tarifReduitPass1jourPrice = 25;
    $tarifReduitPass2joursPrice = 50;
    $tarifReduitPass3joursPrice = 65;

    if ($tarifReduitChecked) {
      if ($_POST["choixPassReduit"] == "pass1jourreduit")
        $totalPassPrice += $tarifReduitPass1jourPrice;
      if ($_POST["choixPassReduit"] == "pass2joursreduit")
        $totalPassPrice += $tarifReduitPass2joursPrice;
      if ($_POST["choixPassReduit"] == "pass3joursreduit")
        $totalPassPrice += $tarifReduitPass3joursPrice;
    } else {

      if ($_POST["choixPass"] == "pass1jour")
        $totalPassPrice += $pass1jourPrice;
      if ($_POST["choixPass"] == "pass2jours")
        $totalPassPrice += $pass2joursPrice;
      if ($_POST["choixPass"] == "pass3jours")
        $totalPassPrice += $pass3joursPrice;
    }
    //   Optional Extras

    $tentPrice = 5;
    $vanPrice = 5;
    $tent3NuitsPrice = 12;
    $van3NuitsPrice = 12;
    $enfantsCasquePrice = 2;
    $lugePrice = 5;
    $totalExtrasPrice = 0;

     if (isset($_POST["tenteNuit1"]) || isset($_POST["tenteNuit2"]) || isset($_POST["tenteNuit3"])) {
      $numberOfTenteNuits = 0;
      if (isset($_POST["tenteNuit1"])) $numberOfTenteNuits++;
      if (isset($_POST["tenteNuit2"])) $numberOfTenteNuits++;
      if (isset($_POST["tenteNuit3"])) $numberOfTenteNuits++;
      $totalExtrasPrice += $tentPrice * $numberOfTenteNuits;
    }

    if (isset($_POST["vanNuit1"]) || isset($_POST["vanNuit2"]) || isset($_POST["vanNuit3"])) {
      $numberOfVanNuits = 0;
      if (isset($_POST["vanNuit1"])) $numberOfVanNuits++;
      if (isset($_POST["vanNuit2"])) $numberOfVanNuits++;
      if (isset($_POST["vanNuit3"])) $numberOfVanNuits++;
      $totalExtrasPrice += $vanPrice * $numberOfVanNuits;
    }
    if (isset($_POST["tente3Nuits"]))
      $totalExtrasPrice += $tent3NuitsPrice;
    if (isset($_POST["van3Nuits"]))
      $totalExtrasPrice += $van3NuitsPrice;
    if (isset($_POST["nombreCasquesEnfants"]))
      $totalExtrasPrice += intval($_POST["nombreCasquesEnfants"]) * $enfantsCasquePrice;
    if (isset($_POST["NombreLugesEte"]))
      $totalExtrasPrice += intval($_POST["NombreLugesEte"]) * $lugePrice;


    // Total Calculation
    $totalPrice = ($totalPassPrice + $totalExtrasPrice) * $numberOfReservations;

    return $totalPrice;
  }
}
