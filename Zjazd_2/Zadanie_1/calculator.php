<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wynik</title>
</head>

<body>
    <h2>Wynik</h2>

    <?php
    if (isset($_POST['number1'], $_POST['number2'], $_POST['operation'])) {
        $number1 = $_POST['number1'];
        $number2 = $_POST['number2'];
        $operation = $_POST['operation'];

        switch ($operation) {
            case 'add':
                $result = $number1 + $number2;
                echo "Wynik dodawania: $result";
                break;
            case 'subtract':
                $result = $number1 - $number2;
                echo "Wynik odejmowania: $result";
                break;
            case 'multiply':
                $result = $number1 * $number2;
                echo "Wynik mnożenia: $result";
                break;
            case 'divide':
                if ($number2 != 0) {
                    $result = $number1 / $number2;
                    echo "Wynik dzielenia: $result";
                } else {
                    echo "Nie można dzielić przez zero!";
                }
                break;
            default:
                echo "Nieprawidłowa operacja";
        }
    } else {
        echo "Nie wszystkie dane zostały przesłane.";
    }
    ?>
</body>

</html>