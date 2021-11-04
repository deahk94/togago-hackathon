<?php

namespace app\controllers;

use yii\web\Controller;
use app\forms\CtripForm;

class CtripController extends Controller
{
    public function actionIndex()
	{
		$model = new CtripForm;
		$model->seach_hotel();
	}
}