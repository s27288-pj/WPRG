<?php
if(isset($_GET['number'])) {
    $argument = $_GET['number'];

    function silnia_rekurencyjna($n) {
        if ($n <= 1) {
            return 1;
        } else {
            return $n * silnia_rekurencyjna($n - 1);
        }
    }

    function silnia_nierekurencyjna($n) {
        $result = 1;
        for ($i = 1; $i <= $n; $i++) {
            $result *= $i;
        }
        return $result;
    }

    function measure_time($function, $argument) {
        $start_time = microtime(true);
        $function($argument);
        $end_time = microtime(true);
        $execution_time = ($end_time - $start_time) * 1000;
        return $execution_time;
    }

    $silnia_rekurencyjna_time = measure_time('silnia_rekurencyjna', $argument);
    $silnia_nierekurencyjna_time = measure_time('silnia_nierekurencyjna', $argument);

    echo "Silnia dla argumentu: $argument<br>";
    echo "Rekurencyjnie czas: $silnia_rekurencyjna_time ms<br>";
    echo "Nierekurencyjnie czas: $silnia_nierekurencyjna_time ms";
}