<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{
    public static function notNull(string $value, string $expectMessage = null)
    {
        if (empty($value)) 
            throw new EntityValidationException($expectMessage ?? "Should not empty");
    }

    public static function strMaxLenght(string $value, int $maxLenght = 100, string $expectMessage = null)
    {
        if (strlen($value) >= $maxLenght) 
            throw new EntityValidationException($expectMessage ?? "Should not greater than {$maxLenght} characters");
    }

    public static function strMinLenght(string $value, int $minLenght = 3, string $expectMessage = null)
    {
        if (strlen($value) <= $minLenght) 
            throw new EntityValidationException($expectMessage ?? "Should not less than {$minLenght} characters");
    }

    public static function strCanNullAndMaxLenght(string $value, int $maxLenght = 100, string $expectMessage = null)
    {
        if (!empty($value) && strlen($value) >= $maxLenght) 
            throw new EntityValidationException($expectMessage ?? "Should not greater than {$maxLenght} characters");
    }
}