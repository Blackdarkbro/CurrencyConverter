<?php

namespace components\helpers;

use SimpleXMLElement;

class CurrencyCourseHelper
{
    public static function CurrencyCoursesCoefficients(): SimpleXMLElement 
    {
        $get = ['date_req' => date('d/m/Y')];
        $ch = curl_init('http://www.cbr.ru/scripts/XML_daily.asp?' . http_build_query($get));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return simplexml_load_string($response);
    }
}