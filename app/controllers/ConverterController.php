<?php

namespace app\controllers;

use Yii;
use app\models\CurrencyCourseValue;
use yii\web\Response;
use yii\web\Controller;

class ConverterController extends Controller
{
    public function actionCalculate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->post();
        $result = [];

        if (Yii::$app->request->isAjax && isset($request['currencyCode']) && isset($request['value'])) {
            $currencies = CurrencyCourseValue::find()->all();
            $requestedCourse = CurrencyCourseValue::findOne(['code' => $request['currencyCode']]);
            foreach($currencies as $currencyCourse) {
                if ($request['currencyCode'] !== $currencyCourse->code) {
                    $result[] = [
                        'currencyCode' => $currencyCourse->code,
                        'value' => $currencyCourse->calculateCourse((float)$request['value'],  $requestedCourse->value)
                    ];
                }
            }

            return ["success" => true, 'response' => $result];
        }

        return ["success" => false];
    }
}
