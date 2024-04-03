<?php

namespace src\Models;

use DateTime;
use src\Services\Hydratation;

class Utilisateur
{
    private $utilisateurID;
    private  $nom;
    private $prenom;
    private $email;
    private $motDePasse;
    private $telephone;
    private $adresse;
    private $RGPD;
    private $role;


    use Hydratation;

    public function getUtilisateurID(): int
    {
        return $this->utilisateurID;
    }
    public function setUtilisateurID(int $utilisateurID)
    {
        $this->utilisateurID = $utilisateurID;
    }


    public function getNom(): string
    {
        return $this->nom;
    }
    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;
    }


    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }
    public function setMotDePasse(string $motDePasse)
    {
        $this->motDePasse = $motDePasse;
    }
    public function getTelephone(): string
    {
        return $this->telephone;
    }
    public function setTelephone(string $telephone)
    {
        $this->telephone = $telephone;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }
    public function setAdresse(string $adresse)
    {
        $this->adresse = $adresse;
    }




    public function getRGPD(): DateTime
    {
        return $this->RGPD;
    }
    public function setRGPD(DateTime $RGPD)
    {
        $this->RGPD = $RGPD;

        return $this->RGPD = new DateTime();
    }

    public function getRole(): string
    {
        return $this->role;
    }
    public function setRole(string $role)
    {
        $this->role = $role;
    }
}
