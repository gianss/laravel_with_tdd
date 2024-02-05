<?php

namespace App\Traits;

trait BinaryConversionTrait
{
    public function convertBinaryToDecimal($binaryValue)
    {
        // Converte a string binária para um número decimal
        return bindec($binaryValue);
    }
}
