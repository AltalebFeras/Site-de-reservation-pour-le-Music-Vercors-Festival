<?php

namespace src\Controllers;

use src\Models\Database;
use src\Services\Reponse;
use src\Repositories\UtilisateurRepositories;

class UtilisateurController
{
    use Reponse;
    private $DB;
    private $UtilisateurRepositories;


    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();
        $this->UtilisateurRepositories = new UtilisateurRepositories; 
        require_once __DIR__ . '/../../config.php';
    }

    public function traitmentUtilisateur(){
        $this->UtilisateurRepositories->sInscrire(); 
      $this->render("connexion", ["erreur" => ""]);

    }
    public function connexionUtilisateur(){
        $this->UtilisateurRepositories->seConnecter(); 
      $this->render("dashboard", ["erreur" => ""]);

        
    }

    public function showDashboard(){
        if (isset($_SESSION["connecté"])) {
            
            $this->render("dashboard", ["erreur" => ""]);


        }


    }
    
}