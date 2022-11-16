<?php
namespace common\models;

use Yii;
use yii\base\Model;
use keltstr\simplehtmldom\SimpleHTMLDom as SHD;
use yii\helpers\ArrayHelper;


class Price extends Model
{
	

	// public static function updateСourse() {

	// 	$victim_link = "http://minfin.com.ua/";
	// 	$victim = SHD::file_get_html ( $victim_link );


	// 	if ( ! empty ( $victim ) ) {

	// 		$element = $victim->find('#currencyWgt', 0)->find('a', 1)->find('span', 1)->find('span', 4)->find('text', 0);
	// 		$currency = SHD::str_get_html ( $element->innertext );
			
	// 		$currency = strip_tags ( trim ( $currency ) );
	// 		$currency = (float)str_replace(',', '.', $currency);

	// 		//$currency = round ( $currency, 2 );

	// 		\common\models\Configs::addConf('ccr', 'Курс USD', $currency);

	// 		return $currency;

	// 	} else {
	// 		return false;
	// 	}

	// }

	public static function updateСourse() {

        $file = file_get_contents("http://resources.finance.ua/ru/public/currency-cash.json");

        $file = json_decode($file);

        $file_array = (array)$file;

        if ($file_array) {

	        $banks = ArrayHelper::index($file_array['organizations'], 'id');

	        $id = '7oiylpmiow8iy1sma7w'; //id ПриватБанка

	        $usd_uah = (float)$banks['7oiylpmiow8iy1sma7w']->currencies->USD->ask;
	        $eur_uah = (float)$banks['7oiylpmiow8iy1sma7w']->currencies->EUR->ask;
	        $rub_uah = (float)$banks['7oiylpmiow8iy1sma7w']->currencies->RUB->ask;

	        $usd_eur = $usd_uah/$eur_uah;
	        $usd_rub = $usd_uah/$rub_uah;

	        if (
				\common\models\Configs::updateConf('ccr', $usd_uah) &&
				\common\models\Configs::updateConf('currensy_usd_eur', $usd_eur) &&
				\common\models\Configs::updateConf('corrency_USD_RUB', $usd_rub)
	        	) {
	        	return [
	        		'bank' => 'PrivatBank',
	        		'usd_uah' => $usd_uah, 
	        		'usd_eur' => $usd_eur, 
	        		'usd_rub' => $usd_rub
	        	];
	        }
	        else {
	        	return false;
	        }

			

		} else {
			return false;
		}

	}


	public static function getPrice($price)
	{	
		$cur_currency = Yii::$app->getRequest()->getCookies()->getValue('curr');

		if ($cur_currency == 'usd') {
			return round($price, 2);  			
		}
		else if ($cur_currency == 'eur') {
			$ccr = \common\models\Configs::byCode('currensy_usd_eur');
			return round($price * $ccr, 2); 			
		}
		else if ($cur_currency == 'rub') {
			$ccr = \common\models\Configs::byCode('corrency_USD_RUB');
			//return round($price * $ccr, 2);
			$price = round(($price * $ccr) * 100)/100;		
			return $price; 			
		}
		else {
			$ccr = \common\models\Configs::byCode('ccr');
			return round($price * $ccr, 2); 
		}
      
	}

	public static function getCurrency() {

		$cur_currency = Yii::$app->getRequest()->getCookies()->getValue('curr');

		if ($cur_currency == 'usd') {
			return '<i class="fa fa-usd"></i>';  			
		}
		else if ($cur_currency == 'eur') {
			return '<i class="fa fa-eur"></i>'; 			
		}
		else if ($cur_currency == 'rub') {
			return '<i class="fa fa-rub"></i>'; 				
		}
		else {
			//return '&#8372;';
			return 'грн';
		}
	}
}