<?php

namespace src\Models;

use src\Services\Hydratation;

class Pass {
    private $passID, $prixPass, $nomPass;

    use Hydratation;

    public function getPassID(): int {
        return $this->passID;
    }
    public function setPassID(int $passID) {
        $this->passID = $passID;
    }

    public function getPrixPass(): int {
        return $this->prixPass;
    }
    public function setPrixPass(int $prixPass) {
        $this->prixPass = $prixPass;
    }

    public function getNomPass(): string {
        return $this->nomPass;
    }
    public function setNomPass(string $nomPass) {
        $this->nomPass = $nomPass;
    }
}