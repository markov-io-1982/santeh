<?php

namespace backend\components;

class CheckIfLoggedIn extends \yii\base\Behavior
{

	public function events () {
		return [
			\yii\web\Application::EVENT_BEFORE_REQUEST => 'checkIfLoggedIn'
		];
	}

	public function checkIfLoggedIn () {
        if (\Yii::$app->getRequest()->getCookies()->has('lang')) {
			\Yii::$app->language = \Yii::$app->getRequest()->getCookies()->getValue('lang');
		}

        if (!\Yii::$app->getRequest()->getCookies()->has('curr')) {
			$curr = \Yii::$app->params['currency'];
			\Yii::$app->response->cookies->add(new \yii\web\Cookie([
			    'name' => 'curr',
			    'value' => $curr,
			]));
		}
	}
}

?>