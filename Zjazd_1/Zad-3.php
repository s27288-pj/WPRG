<?php

function fibonacci($n)
{
    $fib = [0, 1];

    for ($i = 2; $i <= $n; $i++) {
        $fib[$i] = $fib[$i - 1] + $fib[$i - 2];
    }

    return $fib;
}

function printOddElements($arr)
{
    foreach ($arr as $key => $value) {
        if ($value % 2 !== 0) {
            echo ($key) . ": " . $value . "\n";
        }
    }
}

$N = 10;

$fibonacciSequence = fibonacci($N);
printOddElements($fibonacciSequence);
