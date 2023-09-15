<?php

namespace app\models;

use app\models\CurrencyCourseValue;

class CurrencyCourseValueFactory
{
    public function create(string $code, float $value) : CurrencyCourseValue 
    {
        $currencyCourseValue = new CurrencyCourseValue();
        $currencyCourseValue->code = $code;
        $currencyCourseValue->value = $value;
        return $currencyCourseValue;
    }
} 