<?php

namespace src\Repositories;

use src\Models\Options;
use PDO;
use src\Models\Database;

class OptionsRepositories
{
    private $DB;

    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();

        require_once __DIR__ . '/../../config.php';
    }

    public function traitementOptions(OptionsRepositories $OptionsRepositories)
    {
        $options = [];
    
        // Check if 'enfants' is set to "Oui" and handle children's helmets
        if (isset($_POST['enfants']) && $_POST['enfants'] === "Oui" && isset($_POST['nombreCasquesEnfants'])) {
            $nomOption = "Casque Enfant";
            $stockOption = (int)$_POST['nombreCasquesEnfants'];
            $prixOption = $this->getPrixOption('nombreCasquesEnfants');
            $options[] = new Options(['nomOption' => $nomOption, 'stockOption' => $stockOption, 'prixOption' => $prixOption]);
        }
    
        // Check if 'NombreLugesEte' is set and handle summer sledges
        if (isset($_POST['NombreLugesEte'])) {
            $nomOption = "Luge";
            $stockOption = (int)$_POST['NombreLugesEte'];
            $prixOption = $this->getPrixOption('NombreLugesEte');
            $options[] = new Options(['nomOption' => $nomOption, 'stockOption' => $stockOption, 'prixOption' => $prixOption]);
        }
    
        // Loop through options and store them in the database
        foreach ($options as $option) {
            $OptionsRepositories->createOptions($option);
        }
    }
    
    public function createOptions(Options $options)
    {
        $sql = "INSERT INTO " . PREFIXE . "options (nomOption, stockOption, prixOption)
         VALUES (:nomOption, :stockOption, :prixOption)";
         
        $statement = $this->DB->prepare($sql);
        $statement->execute([
            ':nomOption' => $options->getNomOption(),
            ':stockOption' => $options->getStockOption(),
            ':prixOption' => $options->getPrixOption(),
        ]);
        
    }

    private function getPrixOption($option)
    {
        switch ($option) {
            case 'nombreCasquesEnfants':
                return 2;
            case 'NombreLugesEte':
                return 5;
            default:
                return 0;
        }
    }

    public function UpdateThisOptions(Options $Options): Options
    {
        $sql = "UPDATE " . PREFIXE . "options SET nomOption = :nomOption, prixOption = :prixOption WHERE optionsID = :optionsID";
        $statement = $this->DB->prepare($sql);
        $statement->bindParam(':optionsID', $Options->optionsID);
        $statement->bindParam(':nomOption', $Options->nomOption);
        $statement->bindParam(':prixOption', $Options->prixOption);
        $statement->execute();
        return $Options;
    }

    public function DeleteThisOptions(Options $Options): Options
    {
        $sql = "DELETE FROM " . PREFIXE . "options WHERE optionsID = :optionsID";
        $statement = $this->DB->prepare($sql);
        $statement->bindParam(':optionsID', $Options->optionsID);
        $statement->execute();
        return $Options;
    }
}
