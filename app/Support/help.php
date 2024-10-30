<?php

function dd($termo)
{
    echo '<pre>';
    var_dump($termo);
    echo '</pre>';
    die;
}

function generateSixDigitPassword() {
    // Gera um número aleatório entre 100000 e 999999
    return random_int(100000, 999999);
}
