<?php

namespace src\Models;

use src\Services\Hydratation;

class Option {
    private $optionID, $nomOption, $stockOption, $prixOption;

    use Hydratation;

    public function getOptionID(): int {
        return $this->optionID;
    }
    public function setOptionID(int $optionID) {
        $this->optionID = $optionID;
    }

    public function getNomOption(): string {
        return $this->nomOption;
    }
    public function setNomOption(string $nomOption) {
        $this->nomOption = $nomOption;
    }

    public function getStockOption(): int {
        return $this->stockOption;
    }
    public function setStockOption(int $stockOption) {
        $this->stockOption = $stockOption;
    }

    public function getPrixOption(): int {
        return $this->prixOption;
    }
    public function setPrixOption(int $prixOption) {
        $this->prixOption = $prixOption;
    }
}