<?php

namespace src\Models;

use src\Services\Hydratation;

class Nuitee {
    private $nuiteeID, $nomNuitee, $prixNuitee;

    use Hydratation;

    public function getNuiteeID(): int {
        return $this->nuiteeID;
    }
    public function setNuiteeID(int $nuiteeID) {
        $this->nuiteeID = $nuiteeID;
    }

    public function getNomNuitee(): string {
        return $this->nomNuitee;
    }
    public function setNomNuitee(string $nomNuitee) {
        $this->nomNuitee = $nomNuitee;
    }

    public function getPrixNuitee(): int {
        return $this->prixNuitee;
    }
    public function setPrixNuitee(int $prixNuitee) {
        $this->prixNuitee = $prixNuitee;
    }
}