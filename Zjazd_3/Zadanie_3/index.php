<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Form</title>
</head>
<body>
    <form method="post">
        <label for="path">Ścieżka:</label>
        <input type="text" id="path" name="path" required><br><br>
        <label for="directory">Nazwa katalogu:</label>
        <input type="text" id="directory" name="directory" required><br><br>
        <label for="operation">Operacja:</label>
        <select id="operation" name="operation">
            <option value="read" selected>Odczyt</option>
            <option value="create">Utworzenie</option>
            <option value="delete">Usunięcie</option>
        </select><br><br>
        <input type="submit" name="submit" value="Wyślij">
    </form>
</body>
</html>

<?php
function handle_directory($path, $directory, $operation = "read") {
    if (substr($path, -1) !== '/') {
        $path .= '/';
    }

    if ($operation === "read" || $operation === "delete") {
        if (!is_dir($path . $directory)) {
            echo "Katalog $directory nie istnieje.";
            return;
        }
    }

    switch ($operation) {
        case "read":
            $contents = scandir($path . $directory);
            echo "Zawartość katalogu: $directory:<br>";
            foreach ($contents as $item) {
                if ($item !== '.' && $item !== '..') {
                    echo "$item<br>";
                }
            }
            break;
        case "delete":
            if (count(scandir($path . $directory)) <= 2) {
                if (rmdir($path . $directory)) {
                    echo "Katalog $directory usunięty pomyślnie.";
                } else {
                    echo "Nie udało się usunąć katalogu $directory.";
                }
            } else {
                echo "Katalog $directory nie jest pusty. Usuń jego zawartość przed próbą usunięcia.";
            }
            break;
        case "create":
            if (!is_dir($path . $directory)) {
                if (mkdir($path . $directory)) {
                    echo "Katalog $directory utworzony pomyślnie.";
                } else {
                    echo "Nie udało się utworzyć katalogu $directory.";
                }
            } else {
                echo "Katalog $directory już istnieje.";
            }
            break;
        default:
            echo "Nieznana operacja.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $path = $_POST["path"];
    $directory = $_POST["directory"];
    $operation = $_POST["operation"];

    handle_directory($path, $directory, $operation);
}
?>
