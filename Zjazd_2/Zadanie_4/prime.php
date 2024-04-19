<?php
function czyLiczbaPierwsza($liczba)
{
    global $iteracje;
    $iteracje = 0;
    if ($liczba < 2) {
        return false;
    }

    $iteracje = 1;
    for ($i = 2; $i <= sqrt($liczba); $i++) {
        $iteracje++;
        if ($liczba % $i == 0) {
            return false;
        }
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["number"]) && is_numeric($_POST["number"])) {
        $liczba = intval($_POST["number"]);
        if ($liczba > 0) {
            if (czyLiczbaPierwsza($liczba)) {
                echo "$liczba jest liczbą pierwszą.";
            } else {
                echo "$liczba nie jest liczbą pierwszą.";
            }
            echo "<br>Liczba iteracji potrzebnych do sprawdzenia: $iteracje";
        } else {
            echo "Wprowadź liczbę całkowitą dodatnią.";
        }
    } else {
        echo "Wprowadź poprawną liczbę całkowitą.";
    }
}
