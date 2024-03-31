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
  public function traitementReservation()
  {
      if (
          empty($_POST) ||
          !isset($_POST['reservation']) ||
          !isset($_POST['nombreReservation']) ||
          !isset($_POST['prixTotal']) ||
          !isset($_POST['utilisateur'])
      ) {
          echo "Formulaire soumis incomplet";
          return; // Ajout d'un retour pour éviter l'exécution du reste du code
      }

      // Utilisation de noms de variables distincts pour les données du formulaire et l'instance de la classe Reservation
      $reservationData = htmlspecialchars($_POST['reservation']);
      $nombreReservation = htmlspecialchars($_POST['nombreReservation']);
      $prixTotal = htmlspecialchars($_POST['prixTotal']);
      $utilisateur = htmlspecialchars($_POST['utilisateur']);

      // Création d'une instance de la classe Reservation
      $reservation = new Reservation();
      $reservation->setReservationId($reservationData); // Utilisation d'une méthode adéquate pour définir les données
      $reservation->setNombreReservations($nombreReservation);
      $reservation->setPrixTotal($prixTotal);
      $reservation->setUtilisateurId($utilisateur);

      // Supposons que la logique pour sauvegarder la réservation soit implémentée ailleurs, sinon cela va générer une erreur
      // $reservation->save();

      // Cette partie peut être inutile si la sauvegarde de la réservation est gérée ailleurs
      $data = [
          'success' => true,
          'message' => 'Reservation created successfully',
          'reservation' => $reservation
      ];

      // Supposons que cette méthode envoie une réponse appropriée, ce qui nécessite la définition du trait Reponse
      // $this->sendResponse($data);
  }

  public function getAllReservation() {
    $sql = "SELECT * FROM " . PREFIXE . "reservation;";

    $retour = $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Reservation::class);

    return $retour;
  }

  public function getReservationById(int $id): Reservation|bool {
    $sql = "SELECT * FROM " . PREFIXE . "Reservation WHERE reservationID = :id";

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
    $sql = "UPDATE " . PREFIXE . "Reservation 
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
