<?php
// Database credentials - XAMPP
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wprg_zad5";

// Connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully<br>";

// Create record in table
$insert_sql = "INSERT INTO testing (name, description) VALUES ('Sample Name', 'Sample Description')";
if (mysqli_query($conn, $insert_sql)) {
    echo "New record created successfully<br>";
} else {
    echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
}

// Select all records from table
$select_sql = "SELECT * FROM testing";
$result = mysqli_query($conn, $select_sql);

if (mysqli_num_rows($result) > 0) {
    echo "Number of rows: " . mysqli_num_rows($result) . "<br><br>";

    echo "Using mysqli_fetch_row:<br>";
    while ($row = mysqli_fetch_row($result)) {
        echo "id: " . $row[0] . " - Name: " . $row[1] . " - Description: " . $row[2] . " - Created At: " . $row[3] . "<br>";
    }

    mysqli_data_seek($result, 0);

    echo "<br>Using mysqli_fetch_array:<br>";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "id: " . $row["id"] . " - Name: " . $row["name"] . " - Description: " . $row["description"] . " - Created At: " . $row["created_at"] . "<br>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>
