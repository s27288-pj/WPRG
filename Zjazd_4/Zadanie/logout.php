<?php
session_start();
session_destroy();
echo "<h1>Zostałeś wylogowany</h1>";
    echo "<p>Chcesz zalogować się ponownie?.</p>";
    echo '<a href="login.php"><button>Zaloguj się</button></a>';
    exit;
?>
