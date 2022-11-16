<?php
namespace backend\models;

use Yii;
use yii\base\Model;


class Informers extends Model
{
	
	public static function getNewOrders()
	{	
		$new_orders = Order::find()
			->where(['order_status_id' => [2,3]])	// где статус 2 = новый, статус 3 = Оплачено (не отправлено)
			->count(); 
		return $new_orders;   
	}

	public static function getNewStandartOrders()
	{
		$new_standart_orders = Order::find()
			->where(['order_status_id' => 2, 'type' => 0])	// статус 2 = новый, тип 0 = стандартный
			->count(); 
		return $new_standart_orders; 		
	}

	public static function getNewOrdersPbWm()
	{
		$new_standart_orders = Order::find()
			->where(['order_status_id' => 3, 'type' => 0])	// статус 2 = новый, тип 0 = стандартный
			->count(); 
		return $new_standart_orders; 		
	}	

	public static function getNewOneClickOrders()
	{
		$new_standart_orders = Order::find()
			->where(['order_status_id' => 2, 'type' => 1])	// статус 2 = новый, тип 0 = один клик
			->count();
		return $new_standart_orders; 		
	}

	public static function getNewReviews()
	{
		$new_reviews = Review::find()
			->where(['status' => 0])		// не опубликованый
			->count();
		return $new_reviews;
	}

}