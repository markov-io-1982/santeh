<?php
namespace common\models;

use Yii;
use yii\base\Model;


class Counters extends Model
{
	
	public static function getPrice($price)
	{	
		return $price;        
	}

	public static function getCurrency() {
		return 'грн';
	}
}