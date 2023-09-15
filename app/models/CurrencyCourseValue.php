<?php

namespace app\models;

use yii\db\ActiveRecord;

class CurrencyCourseValue extends ActiveRecord
{
    const RUS_NOMINAL = 100;

    public static function getActiveСurrencies(): array
    {
        return ['USD', 'EUR', 'CNY', 'BYN'];
    }

    public function calculateCourse(float $quantity, float $course): string
    {
        return number_format(($this->getAttribute("value") * $quantity) / $course, 4, '.', ' ');
    }
} 