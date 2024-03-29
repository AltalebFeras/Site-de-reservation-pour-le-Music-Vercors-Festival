<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Reservation;
use src\Models\Database;

class ReservationRipository {
  private $DB;

  public function __construct() {
    $database = new Database;
    $this->DB = $database->getDB();

    require_once __DIR__ . '/../../config.php';
  }

  public function getAllReservation() {
    $sql = "SELECT * FROM " . PREFIXE . "reservation;";

    $retour = $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Reservation::class);

    return $retour;
  }

  public function getReservationById(int $id): Reservation|bool {
    $sql = "SELECT * FROM " . PREFIXE . "reservation WHERE reservationID = :id";

    $statement = $this->DB->prepare($sql);
    $statement->bindParam(':reservationID', $id);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS, Reservation::class);
    $retour = $statement->fetch();

    return $retour;
}


  public function CreateReservation(Reservation $Reservation): bool {
    $sql = "INSERT INTO " . PREFIXE . "reservation (nombre_reservations, prix_total, utilisateurID) VALUES (:nombreReservations, :prixTotal, :utilisateurID)";

    $statement = $this->DB->prepare($sql);

    $retour = $statement->execute([
      ':nombreReservations' => $Reservation->getNombreReservations(),
      ':prixTotal' => $Reservation->getPrixTotal(),
      ':utilisateurID' => $Reservation->getUtilisateurID()
    ]);

    return $retour;
}


  public function UpdateReservation(Reservation $Reservation): bool {
    $sql = "UPDATE " . PREFIXE . "reservation 
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

  public function deleteReservation(int $ID): bool {
    try {
      $sql = "DELETE FROM " . PREFIXE . "reservation WHERE reservationID = :reservationID;";

      $statement = $this->DB->prepare($sql);

      return $statement->execute([':reservationID' => $ID]);
    } catch (PDOException $error) {
      echo "Erreur de suppression : " . $error->getMessage();
      return false;
    }
  }
}
