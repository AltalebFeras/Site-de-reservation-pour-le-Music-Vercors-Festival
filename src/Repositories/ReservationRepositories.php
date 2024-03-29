<?php
namespace src\Repositories;

use PDO;
use PDOException;
use src\Models\Reservation;
use src\Models\Database;

class ReservationRipository {
  private $DB;

  public function __construct()
  {
    $database = new Database;
    $this->DB = $database->getDB();

    require_once __DIR__ . '/../../config.php';
  }

  public function getAllReservation(){
    $sql = "SELECT * FROM ".PREFIXE."reservation;";

    $retour = $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Reservation::class);

    return $retour;
  }

  public function getThisReservationById(int $id): Reservation|bool {
    $sql = "SELECT * FROM ".PREFIXE."reservation WHERE id = :id";

    $statement = $this->DB->prepare($sql);
    // a verifier pour les ID si il faut ajouter utilisaterID
    $statement->bindParam(':id', $id);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS, Reservation::class);
    $retour = $statement->fetch();

    return $retour;
  }


  public function CreateThisReservation(reservation $Reservation): bool{
    $sql = "INSERT INTO ". PREFIXE . "reservation (reservationID, nombreReservations, prixTotal, utilisateurID) VALUES (:reservationID, :nombreReservations, :prixTotal, :utilisateurID)";

    $statement = $this->DB->prepare($sql);

    $retour = $statement->execute([
      ':reservationID' => $Reservation->getReservationID(),
      ':nombreReservations' => $Reservation->getNombreReservations(),
      ':prixTotal' => $Reservation->getPrixTotal(),
      ':utilisateurID' => $Reservation->getUtilisateurID()
    ]);

    return $retour;
  }

  public function UpdateThisReservation(Reservation $Reservation): bool{
    $sql = "UPDATE ". PREFIXE . "reservation 
            SET
              nombreReservations =:nombreReservations,
              prixTotal = :prixTotal
            WHERE reservationID = :reservationID";

    $statement = $this->DB->prepare($sql);

    $retour = $statement->execute([
      ':reservationID' => $Reservation->getReservationId(),
      ':nombreReservations' => $Reservation->getNombreReservations(),
      ':prixTotal' => $Reservation->getPrixTotal(),
      ':utilisateurID' => $Reservation->getUtilisateurID()
    ]);

    return $retour;
  }

    public function deleteThisReservation(int $ID): bool {
      try{

      $sql = "DELETE FROM " . PREFIXE . "reservation WHERE ID = :ID;";

      // $sql = "DELETE FROM " . PREFIXE . "relations_Reservation WHERE ID_CATEGORIES = :ID;
      //         DELETE FROM " . PREFIXE . "categories WHERE ID = :ID;";
  
      $statement = $this->DB->prepare($sql);
  //  a verifier pour les ID si il faut ajouter utilisaterID
      return $statement->execute([':ID' => $ID]);
  
      } catch(PDOException $error) {
        echo "Erreur de suppression : " . $error->getMessage();
        return FALSE;
      }
    }
}