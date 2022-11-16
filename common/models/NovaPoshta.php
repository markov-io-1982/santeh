<?php
namespace common\models;

use Yii;
use yii\base\Model;

/*

ref
number
TypeOfWarehouse
warehouseType: cargo/post/mini/postomat
warehouseTypeDescription: Вантажне відділення/Поштове відділення/Parcel Shop/Поштомат приват банку
phone
city
cityRu
city_ref
y
x
h24: true/										// 
isPostomat: true/false
PostFinance: 0/
POSTerminal: 0/
BicycleParking: 0/
HasAdditionalServices: false/
address: 
addressRu: 
max_weight_allowed:

*/


class NovaPoshta extends Model
{

	public static function getSitiesNP() {
		$np = file_get_contents ('http://novaposhta.ua/shop/office/getjsonwarehouselist');
		$a = json_decode ($np, true);

		$warehouse_by_city = array();
		foreach($a['response'] as $warehouse){
			$cityName = $warehouse['cityRu'];
			$address = $cityName .  ' № ' . $warehouse['number'] . ' - '  . $warehouse['addressRu'];
			$fullAdress = $address;
		    $warehouse_by_city[$cityName][$fullAdress] = $address;    
		}
		ksort($warehouse_by_city); //сортируем по городам

		return $warehouse_by_city;		
	}

}