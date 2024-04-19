<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Podsumowanie rezerwacji</title>
</head>

<body>
    <h1>Podsumowanie rezerwacji</h1>

    <?php
    function validate_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $quantity = validate_input($_POST["quantity"]);
        $address = validate_input($_POST["address"]);
        $credit_card = validate_input($_POST["credit_card"]);
        $arrival_date = validate_input($_POST["arrival_date"]);
        $departure_date = validate_input($_POST["departure_date"]);
        $arrival_time = validate_input($_POST["arrival_time"]);
        $child_bed = isset($_POST["child_bed"]) ? "Tak" : "Nie";
        $amenities = isset($_POST["amenities"]) ? implode(", ", $_POST["amenities"]) : "Brak";

        if (!in_array($quantity, ['1', '2', '3', '4'])) {
            $errors[] = "Proszę wybrać prawidłową ilość osób.";
        }
        if (empty($errors) && strtotime($arrival_date) >= strtotime($departure_date)) {
            $errors[] = "Data przyjazdu musi być wcześniejsza niż data wyjazdu.";
        }
        if (empty($errors) && strtotime($arrival_date) < strtotime(date("Y-m-d"))) {
            $errors[] = "Data przyjazdu musi być późniejsza niż dzisiaj.";
        }
        if (empty($errors) && strtotime($arrival_date) == strtotime(date("Y-m-d")) && strtotime($arrival_time) < strtotime(date("H:i"))) {
            $errors[] = "Godzina przyjazdu musi być późniejsza niż obecna godzina.";
        }
        if ($credit_card != "" && !preg_match("/^[0-9]{16}$/", $credit_card)) {
            $errors[] = "Numer karty kredytowej musi składać się z 16 cyfr.";
        }

        $summary = "";
        $summary .= "<h2>Dziękujemy za dokonanie rezerwacji. Poniżej znajdziesz szczegóły: </h2>";
        $summary .= "<h2>Dane gości:</h2>";
        $summary .= "<p>Ilość osób: $quantity</p>";
        $summary .= "<br>";

        for ($i = 1; $i <= $quantity; $i++) {
            $first_name = validate_input($_POST["first_name_$i"]);
            $last_name = validate_input($_POST["last_name_$i"]);
            $email = validate_input($_POST["email_$i"]);
            $phone = validate_input($_POST["phone_$i"]);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Proszę podać prawidłowy adres email dla gościa: $first_name $last_name.";
            }
            if ($phone != "" && !preg_match("/^[0-9]{9}$/", $phone)) {
                $errors[] = "Numer telefonu musi składać się z 9 cyfr dla gościa: $first_name $last_name.";
            }

            $summary .= "<p>Dane osoby $i:</p>";
            $summary .= "<p>Imię: $first_name</p>";
            $summary .= "<p>Nazwisko: $last_name</p>";
            $summary .= "<p>Email: $email</p>";
            $summary .= "<br>";
        }

        if (empty($errors)) {
            echo $summary;
            echo "<h2>Dane rezerwacji:</h2>";
            echo "<p>Adres: $address</p>";
            echo "<p>Numer karty kredytowej: $credit_card</p>";
            echo "<p>Data przyjazdu: $arrival_date</p>";
            echo "<p>Data wyjazdu: $departure_date</p>";
            echo "<p>Czas pobytu: " . (strtotime($departure_date) - strtotime($arrival_date)) / 86400 . " dni</p>";
            echo "<p>Godzina przyjazdu: $arrival_time</p>";
            echo "<p>Dostawienie łóżka dla dziecka: $child_bed</p>";
            echo "<p>Udogodnienia: $amenities</p>";
        } else {
            foreach ($errors as $error) {
                echo "<p style='color: red;'>$error</p>";
            }
        }
    } else {
        echo "<p>Formularz nie został przesłany.</p>";
    }
    ?>
</body>

</html>