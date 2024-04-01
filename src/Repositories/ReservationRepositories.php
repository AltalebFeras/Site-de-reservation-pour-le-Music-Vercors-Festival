<?php

namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Reservation;
use src\Models\Database;

class ReservationRepository {
  private $DB;

  public function __construct() {
    $database = new Database;
    $this->DB = $database->getDB();

    require_once __DIR__ . '/../../config.php';
  }
 
  // public function traitementReservation()
  // {
  //     if (
  //         empty($_POST) ||
  //         !isset($_POST['reservation']) ||
  //         !isset($_POST['nombreReservation']) ||
  //         !isset($_POST['prixTotal']) ||
  //         !isset($_POST['utilisateur'])
  //     ) {
  //         echo "Formulaire soumis incomplet";
  //         return;
  //     }

  //     $reservationData = htmlspecialchars($_POST['reservation']);
  //     $nombreReservation = htmlspecialchars($_POST['nombreReservation']);
  //     $prixTotal = htmlspecialchars($_POST['prixTotal']);
  //     $utilisateur = htmlspecialchars($_POST['utilisateur']);

  //     $reservation = new Reservation();
  //     $reservation->setReservationId($reservationData);
  //     $reservation->setNombreReservations($nombreReservation);
  //     $reservation->setPrixTotal($prixTotal);
  //     $reservation->setUtilisateurId($utilisateur);

  //     $data = [
  //         'success' => true,
  //         'message' => 'Reservation created successfully',
  //         'reservation' => $reservation
  //     ];

  //     // Supposons que cette méthode envoie une réponse appropriée
  //     // $this->sendResponse($data);
  // }

  public function getAllReservation() {
    $sql = "SELECT * FROM " . PREFIXE . "mvf_reservation;";

    $retour = $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Reservation::class);

    return $retour;
  }

  public function getReservationById(int $id): Reservation|bool {
    $sql = "SELECT * FROM " . PREFIXE . "mvf_reservation WHERE reservationID = :id";

    $statement = $this->DB->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $retour = $statement->fetch(PDO::FETCH_CLASS, Reservation::class);

    return $retour;
  }

  public function CreateReservation(Reservation $Reservation): bool {

    $sql = "INSERT INTO " . PREFIXE . "reservation (nombre_reservations, prix_total, utilisateurID)
     VALUES (:nombreReservations, :prixTotal, :utilisateurID)";

    $sql = "INSERT INTO " . PREFIXE . "mvf_reservation (nombre_reservations, prix_total, utilisateurID) VALUES (:nombre_reservations, :prix_total, :utilisateurID)";


    $statement = $this->DB->prepare($sql);

    $retour = $statement->execute([
      ':nombre_reservations' => $Reservation->getNombreReservations(),
      ':prix_total' => $Reservation->getPrixTotal(),
      ':utilisateur_id' => $Reservation->getUtilisateurId()
    ]);

    return $retour;
  }

  public function UpdateReservation(Reservation $Reservation): bool {
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

  public function deleteReservation(int $ID): bool {
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
