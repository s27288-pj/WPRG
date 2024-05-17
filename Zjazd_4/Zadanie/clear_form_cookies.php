<?php
session_start();

$formCookies = [
    'quantity', 'address', 'credit_card', 'arrival_date', 'departure_date', 'arrival_time', 
    'child_bed', 'amenities', 'first_name_1', 'last_name_1', 'email_1', 'phone_1',
    'first_name_2', 'last_name_2', 'email_2', 'phone_2', 
    'first_name_3', 'last_name_3', 'email_3', 'phone_3', 
    'first_name_4', 'last_name_4', 'email_4', 'phone_4'
];

foreach ($formCookies as $cookie) {
    setcookie($cookie, '', time() - 3600, '/');
}

header("Location: reservation.php");
exit;
?>
