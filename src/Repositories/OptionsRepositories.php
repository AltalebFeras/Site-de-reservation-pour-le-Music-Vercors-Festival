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
    
        if (isset($_POST['enfants']) && $_POST['enfants'] === "Oui" && isset($_POST['nombreCasquesEnfants']) && $_POST['nombreCasquesEnfants']>0) {
            $nomOption = "Casque Enfant";
            $stockOption = (int)$_POST['nombreCasquesEnfants'];
            $prixOption = $this->getPrixOption('nombreCasquesEnfants');
            $options[] = new Options(['nomOption' => $nomOption, 'stockOption' => $stockOption, 'prixOption' => $prixOption]);
        }
    
        if (isset($_POST['NombreLugesEte']) && $_POST['NombreLugesEte'] > 0 ) {
            $nomOption = "Luge";
            $stockOption = (int)$_POST['NombreLugesEte'];
            $prixOption = $this->getPrixOption('NombreLugesEte');
            $options[] = new Options(['nomOption' => $nomOption, 'stockOption' => $stockOption, 'prixOption' => $prixOption]);
        }
    
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
}
