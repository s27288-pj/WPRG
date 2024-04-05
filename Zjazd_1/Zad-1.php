<?php
$tab[0] = "jablko";
$tab[1] = "gruszka";
$tab[2] = "sliwka";
$tab[3] = "wisnia";
$tab[4] = "porzeczka";

$i = 0;
for ($i = 0; $i < count($tab); $i++) {
    $string = $tab[$i];
    $reverse = '';
    if ($string[0] == 'p') {
        echo "True\t";
    } else {
        echo "False\t";
    }
    $j = 0;
    while (!empty($string[$j])) {
        $reverse = $string[$j] . $reverse;
        $j++;
    }
    echo $reverse . "\n";
}
