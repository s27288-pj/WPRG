<?php
if(isset($_GET['birthdate'])) {
    $birthdate = $_GET['birthdate'];

    function data_urodzenia_true($data) {
        $dzis = new DateTime();
        if (strtotime($data) > strtotime($dzis->format('Y-m-d'))) {
            return false;
        } else if (strtotime($data) <= strtotime($dzis->format('Y-m-d'))) {
            return true;
        }
    }

    function dzien_tygodnia($data) {
        $dzien_tyg = date('N', strtotime($data));
        $dni_tygodnia = array('poniedziałek', 'wtorek', 'środę', 'czwartek', 'piątek', 'sobotę', 'niedzielę');
        return $dni_tygodnia[$dzien_tyg - 1];
    }

    function wiek($data) {
        $dzis = new DateTime();
        $urodzenie = new DateTime($data);
        $roznica = $dzis->diff($urodzenie);
        return $roznica->y;
    }

    function dni_do_urodzin($data) {
        $dzis = new DateTime();
        $urodzenie = new DateTime($data);
        $urodzenie->setDate($dzis->format('Y'), $urodzenie->format('m'), $urodzenie->format('d') + 1);
        if ($urodzenie < $dzis) {
            $dzis->setDate($dzis->format('Y') + 1, $dzis->format('m'), $dzis->format('d'));
        }
        $roznica = $dzis->diff($urodzenie);
        return $roznica->days;
    }

    if (data_urodzenia_true($birthdate) === true) {

        $dzien = dzien_tygodnia($birthdate);
        $wiek = wiek($birthdate);
        $dni_do_urodzin = dni_do_urodzin($birthdate);

        if ($wiek == 0 && $dni_do_urodzin == 0) {
            echo "Urodziłeś/aś się dzisiaj. Wszystkiego najlepszego!";
            return;
        } else {
            echo "Urodziłeś/aś się w dniu: $dzien.<br>";
            echo "Masz obecnie $wiek lat.<br>";
            if ($dni_do_urodzin == 0) {
                echo "Dziś są Twoje urodziny. Wszystkiego najlepszego!";
            } else {
                echo "Do Twoich urodzin pozostało: $dni_do_urodzin dni.";
            }
        }
    } else {
        echo "Podana data jest datą przyszłą.";
    }

}