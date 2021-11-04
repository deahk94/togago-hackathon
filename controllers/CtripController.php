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

	public function actionDestination()
	{
		$model = new CtripForm;
		$model->search_destination();
	}

	public function actionHotel()
	{
		$model = new CtripForm;
		$model->seach_hotel();
	}

	public function actionNearbyHotel()
	{
		$model = new CtripForm;
		$model->search_nearby_hotel();
	}
}