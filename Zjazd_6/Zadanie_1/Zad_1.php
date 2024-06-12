<?php

class NoweAuto {
    protected $model;
    protected $cenaEuro;
    protected $kursEuroPln;

    public function __construct($model, $cenaEuro, $kursEuroPln) {
        if (!is_string($model) || empty($model)) {
            throw new InvalidArgumentException("Model musi być niepustym stringiem.");
        }
        if (!is_int($cenaEuro) && !is_float($cenaEuro) || $cenaEuro <= 0) {
            throw new InvalidArgumentException("Cena w Euro musi być liczbą (int lub float) większą od 0.");
        }
        if (!is_float($kursEuroPln) || $kursEuroPln <= 0) {
            throw new InvalidArgumentException("Kurs Euro/PLN musi być liczbą zmiennoprzecinkową większą od 0.");
        }
        
        $this->model = $model;
        $this->cenaEuro = $cenaEuro;
        $this->kursEuroPln = $kursEuroPln;
    }

    public function ObliczCene() {
        return $this->cenaEuro * $this->kursEuroPln;
    }

    public function getModel() {
        return $this->model;
    }

    public function getCenaEuro() {
        return $this->cenaEuro;
    }

    public function getKursEuroPln() {
        return $this->kursEuroPln;
    }
}

class AutoZDodatkami extends NoweAuto {
    private $alarm;
    private $radio;
    private $klimatyzacja;

    public function __construct($model, $cenaEuro, $kursEuroPln, $alarm, $radio, $klimatyzacja) {
        parent::__construct($model, $cenaEuro, $kursEuroPln);
        
        if (!is_int($alarm) && !is_float($alarm) || $alarm < 0) {
            throw new InvalidArgumentException("Cena alarmu musi być liczbą (int lub float) większą lub równą 0.");
        }
        if (!is_int($radio) && !is_float($radio) || $radio < 0) {
            throw new InvalidArgumentException("Cena radia musi być liczbą (int lub float) większą lub równą 0.");
        }
        if (!is_int($klimatyzacja) && !is_float($klimatyzacja) || $klimatyzacja < 0) {
            throw new InvalidArgumentException("Cena klimatyzacji musi być liczbą (int lub float) większą lub równą 0.");
        }

        $this->alarm = $alarm;
        $this->radio = $radio;
        $this->klimatyzacja = $klimatyzacja;
    }

    public function ObliczCene() {
        $cenaPodstawowa = parent::ObliczCene();
        $cenaDodatkow = ($this->alarm + $this->radio + $this->klimatyzacja) * $this->kursEuroPln;
        return $cenaPodstawowa + $cenaDodatkow;
    }

    public function getAlarm() {
        return $this->alarm;
    }

    public function getRadio() {
        return $this->radio;
    }

    public function getKlimatyzacja() {
        return $this->klimatyzacja;
    }
}

class Ubezpieczenie extends AutoZDodatkami {
    private $procentUbezpieczenia;
    private $liczbaLat;

    public function __construct($model, $cenaEuro, $kursEuroPln, $alarm, $radio, $klimatyzacja, $procentUbezpieczenia, $liczbaLat) {
        parent::__construct($model, $cenaEuro, $kursEuroPln, $alarm, $radio, $klimatyzacja);
        
        if (!is_float($procentUbezpieczenia) || $procentUbezpieczenia <= 0) {
            throw new InvalidArgumentException("Procentowa wartość ubezpieczenia musi być liczbą zmiennoprzecinkową większą od 0.");
        }
        if (!is_int($liczbaLat) || $liczbaLat < 0) {
            throw new InvalidArgumentException("Liczba lat posiadania samochodu musi być nieujemną liczbą całkowitą.");
        }

        $this->procentUbezpieczenia = $procentUbezpieczenia;
        $this->liczbaLat = $liczbaLat;
    }

    public function ObliczCene() {
        $cenaAutaZDodatkami = parent::ObliczCene();
        $procentowaWartosc = $this->procentUbezpieczenia / 100;
        $pomniejszenieZaLata = (100 - $this->liczbaLat) / 100;
        $cenaUbezpieczenia = $cenaAutaZDodatkami * $procentowaWartosc * $pomniejszenieZaLata;
        return $cenaAutaZDodatkami + $cenaUbezpieczenia;
    }

    public function getProcentUbezpieczenia() {
        return $this->procentUbezpieczenia;
    }

    public function getLiczbaLat() {
        return $this->liczbaLat;
    }
}

// Przykład użycia:
try {
    header('Content-type: text/plain');
    
    $noweAuto = new NoweAuto("ModelX", 30000, 4.5);
    echo "Cena Nowego Auta o modelu " . $noweAuto->getModel() . " w PLN: " . $noweAuto->ObliczCene() . " PLN\n";

    $autoZDodatkami = new AutoZDodatkami("ModelY", 30000, 4.5, 500, 300, 800);
    echo "Cena Auta z Dodatkami o modelu " . $autoZDodatkami->getModel() . " w PLN: " . $autoZDodatkami->ObliczCene() . " PLN\n";

    $ubezpieczoneAuto = new Ubezpieczenie("ModelZ", 30000, 4.5, 500, 300, 800, 5.0, 3);
    echo "Cena Ubezpieczonego Auta o modelu " . $ubezpieczoneAuto->getModel() . " w PLN: " . $ubezpieczoneAuto->ObliczCene() . " PLN\n";
} catch (InvalidArgumentException $e) {
    echo "Błąd: " . $e->getMessage() . "\n";
}
?>
