<?php
$liczba1 = 1;
$liczba2 = 100;

function isPrime($number)
{
    if ($number < 2) {
        return false;
    }
    for ($i = 2; $i <= sqrt($number); $i++) {
        if ($number % $i === 0) {
            return false;
        }
    }
    return true;
}

for ($i = $liczba1; $i <= $liczba2; $i++) {
    if (isPrime($i)) {
        echo $i . " ";
    }
}
