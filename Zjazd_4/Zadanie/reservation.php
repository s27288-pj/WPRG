<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<h1>Brak zalogowania</h1>";
    echo "<p>Musisz się zalogować, aby uzyskać dostęp do formularza rezerwacji.</p>";
    echo '<a href="login.php"><button>Zaloguj się</button></a>';
    exit;
}

function getValue($name) {
    return isset($_COOKIE[$name]) ? htmlspecialchars($_COOKIE[$name]) : '';
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Formularz rezerwacji</title>
</head>
<body>
    <h1>Formularz rezerwacji</h1>
    <form action="clear_form_cookies.php" method="post" style="display: inline;">
        <input type="submit" value="Wyczyść ciasteczka">
    </form>
    <form action="logout.php" method="post" style="display: inline;">
        <input type="submit" value="Wyloguj się">
    </form>
    <br><br>
    <form action="reservation_handler.php" method="post">
        <label for="quantity">Ilość osób: </label>
        <select name="quantity" id="quantity">
            <option value="0">Wybierz</option>
            <option value="1" <?= getValue('quantity') == '1' ? 'selected' : '' ?>>1 osoba</option>
            <option value="2" <?= getValue('quantity') == '2' ? 'selected' : '' ?>>2 osoby</option>
            <option value="3" <?= getValue('quantity') == '3' ? 'selected' : '' ?>>3 osoby</option>
            <option value="4" <?= getValue('quantity') == '4' ? 'selected' : '' ?>>4 osoby</option>
        </select>
        <br>
        <h2>Dane osobowe</h2>
        <div id="person-details">
            <?php
            $quantity = getValue('quantity');
            for ($i = 1; $i <= $quantity; $i++) {
                echo '<div>
                        <h2>Dane osoby ' . $i . '</h2>
                        <label for="first_name_' . $i . '">Imię:</label>
                        <input type="text" name="first_name_' . $i . '" value="' . getValue('first_name_' . $i) . '" required>
                        <br>
                        <label for="last_name_' . $i . '">Nazwisko:</label>
                        <input type="text" name="last_name_' . $i . '" value="' . getValue('last_name_' . $i) . '" required>
                        <br>
                        <label for="email_' . $i . '">Email:</label>
                        <input type="email" name="email_' . $i . '" value="' . getValue('email_' . $i) . '" required>
                        <br>
                        <label for="phone_' . $i . '">Telefon:</label>
                        <input type="tel" name="phone_' . $i . '" value="' . getValue('phone_' . $i) . '" required>
                        <br>
                    </div>';
            }
            ?>
        </div>
        <h2>Dane rezerwacji</h2>
        <label for="address">Adres: </label>
        <input type="text" name="address" id="address" value="<?= getValue('address') ?>" required>
        <br>
        <label for="credit_card">Numer karty kredytowej:</label>
        <input type="text" name="credit_card" id="credit_card" value="<?= getValue('credit_card') ?>" required>
        <br>
        <label for="arrival_date">Data przyjazdu: </label>
        <input type="date" name="arrival_date" id="arrival_date" value="<?= getValue('arrival_date') ?>" required>
        <br>
        <label for="departure_date">Data wyjazdu: </label>
        <input type="date" name="departure_date" id="departure_date" value="<?= getValue('departure_date') ?>" required>
        <br>
        <label for="arrival_time">Godzina przyjazdu: </label>
        <input type="time" name="arrival_time" id="arrival_time" value="<?= getValue('arrival_time') ?>">
        <br>
        <label for="child_bed">Dostawienie łóżka dla dziecka:</label>
        <input type="checkbox" name="child_bed" id="child_bed" <?= getValue('child_bed') ? 'checked' : '' ?>>
        <br>
        <label for="amenities">Udogodnienia:</label><br>
        <?php
        $amenities = ['Klimatyzacja', 'Popielniczka', 'Parking', 'Śniadanie w cenie'];
        $selectedAmenities = isset($_COOKIE['amenities']) ? explode(',', $_COOKIE['amenities']) : [];
        foreach ($amenities as $amenity) {
            $checked = in_array($amenity, $selectedAmenities) ? 'checked' : '';
            echo "<input type='checkbox' name='amenities[]' value='$amenity' $checked> $amenity<br>";
        }
        ?>
        <br>
        <input type="submit" value="Zarezerwuj">
    </form>
    <script>
        document.getElementById('quantity').addEventListener('change', function() {
            var quantity = this.value;
            var personDetails = document.getElementById('person-details');
            personDetails.innerHTML = '';
            for (var i = 1; i <= quantity; i++) {
                personDetails.innerHTML += '<div>\
                    <h2>Dane osoby ' + i + '</h2>\
                    <label for="first_name_' + i + '">Imię:</label>\
                    <input type="text" name="first_name_' + i + '" required>\
                    <br>\
                    <label for="last_name_' + i + '">Nazwisko:</label>\
                    <input type="text" name="last_name_' + i + '" required>\
                    <br>\
                    <label for="email_' + i + '">Email:</label>\
                    <input type="email" name="email_' + i + '" required>\
                    <br>\
                    <label for="phone_' + i + '">Telefon:</label>\
                    <input type="tel" name="phone_' + i + '" required>\
                    <br>\
                </div>';
            }
        });
    </script>
</body>
</html>
