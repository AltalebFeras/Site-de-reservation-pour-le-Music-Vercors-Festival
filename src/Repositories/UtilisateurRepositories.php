<?php

namespace src\Repositories;

use src\Models\Utilisateur;
use PDO;
use src\Models\Database;

class UtilisateurRepositories
{
  private $DB;

  public function __construct()
  {
    $database = new Database;
    $this->DB = $database->getDB();

    require_once __DIR__ . '/../../config.php';
  }

  public function getThisUtilisateurById($id): Utilisateur
  {
    $sql = $this->concatenationRequete("WHERE " . PREFIXE . "utilisateur.ID = :id");

    $statement = $this->DB->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_CLASS, Utilisateur::class);
    return $statement->fetch();
  }

  public function CreateThisUtilisateur(Utilisateur $Utilisateur): Utilisateur
  {
    $sql = "INSERT INTO " . PREFIXE . "Utilisateur (nom, prenom, email, motDePasse, telephone, adresse, RGPD, role ) VALUES (:nom, :prenom,:email,:motdepasse, :telephone, :adresse, :rgpd, :role,  );";
    $statement = $this->DB->prepare($sql);

    $statement->execute([
      ':nom'=> $Utilisateur->getNom(),
      ':PRENOM'=> $Utilisateur->getPrenom(),
      ':TELEPHONE'=> $Utilisateur->getTelephone(),
      ':ADRESSE'=> $Utilisateur->getAdresse(),
      ':MOTDEPASSE'=> $Utilisateur->getMotDePasse(),
      ':ROLE'=> $Utilisateur->getRole(),
      ':RGPD'=> $Utilisateur->getRgpd()
    ]);

    $id = $this->DB->lastInsertId();
    $Utilisateur->setId($id);

    return $Utilisateur;
  }

  public function deleteThisUtilisateur($Id): bool
  {
    

  //   a creer delete user;
  }
}
