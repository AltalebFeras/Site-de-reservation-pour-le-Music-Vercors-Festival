<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Reservation;
use src\Models\Database;

class ReservationRepository
{
  private $DB;

  public function __construct()
  {
    $database = new Database;
    $this->DB = $database->getDB();

    require_once __DIR__ . '/../../config.php';
  }


 

  public function traitementReservation()
  {
    if (
      empty($_POST) ||
      !isset($_POST['nombreReservation'])
    ) {
      $nombreReservation = htmlspecialchars($_POST['nombreReservation']);
      require_once __DIR__ . '/../Views/utilisateurView/reservationCalculation.php';
    }

    $prix_total = $totalPrice;
    $utilisateurID = $_SESSION['utilisateur'];
    $data = array(
      'nombreReservation' => $nombreReservation,
      'prix_total' => $prix_total,
      'utilisateurID' => $utilisateurID
    );

    $reservation = new Reservation($data);
    $ReservationRepositories->createReservation($reservation);
  }

  public function getAllReservation()
  {
    $sql = "SELECT * FROM " . PREFIXE . "mvf_reservation;";

    $retour = $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Reservation::class);

    return $retour;
  }

  public function getReservationById(int $id): Reservation|bool
  {
    $sql = "SELECT * FROM " . PREFIXE . "mvf_reservation WHERE reservationID = :id";

    $statement = $this->DB->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $retour = $statement->fetch(PDO::FETCH_CLASS, Reservation::class);

    return $retour;
  }

  public function createReservation(Reservation $Reservation): Reservation
  {
    $sql = "INSERT INTO " . PREFIXE . "reservation (nombre_reservations, prix_total, utilisateurID, )
     VALUES (:nombreReservation, :prix_total, :utilisateurID );";
    $statement = $this->DB->prepare($sql);
    $retour = $statement->execute([
      ':nombre_reservations' => $Reservation->getNombreReservations(),
      ':prix_total' => $Reservation->getPrixTotal(),
      ':utilisateur_id' => $Reservation->getUtilisateurId()
    ]);



    $reservationID = $this->DB->lastInsertId();
    $Reservation->setUtilisateurID($reservationID);

    return $Reservation;
  }

  public function UpdateReservation(Reservation $Reservation): bool
  {
    $sql = "UPDATE " . PREFIXE . "mvf_reservation 
            SET
              nombre_reservations = :nombre_reservations,
              prix_total = :prix_total
            WHERE reservationID = :reservationID";

    $statement = $this->DB->prepare($sql);

    $retour = $statement->execute([
      ':reservationID' => $Reservation->getReservationId(),
      ':nombre_reservations' => $Reservation->getNombreReservations(),
      ':prix_total' => $Reservation->getPrixTotal()
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
}
