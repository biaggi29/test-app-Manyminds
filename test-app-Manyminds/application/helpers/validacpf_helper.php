<?php defined('BASEPATH') OR exit('No direct script access allowed');
function is_valid_cpf($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11) {
        return false;
    }

    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += ($cpf[$i] * (10 - $i));
    }
    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : (11 - $resto);
    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += ($cpf[$i] * (11 - $i));
    }
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : (11 - $resto);
    return ($cpf[9] == $digito1 && $cpf[10] == $digito2);
}