<?php
namespace common\models;

use Yii;
use yii\base\Model;


class Configs extends Model
{

	// добавить/обновить переменную
	public static function addConf($code, $title, $content) {

		if ($code && $title && $content) {
			$arr = json_decode(file_get_contents(__DIR__ . '/../../common/app-config/config.json'));
			// $arr->$code->title = $title;
			// $arr->$code->content = $content;

			$arr = (array)$arr;
			$arr[$code] = [
				'title' => $title,
				'content' => $content
			];
			$arr = (object)$arr;			

			$file = json_encode($arr);
			file_put_contents(__DIR__ . '/../../common/app-config/config.json', $file);

			return true;			
		}
		else {
			return false;
		}

	}


	// добавить/обновить переменную
	public static function updateConf($code, $content) {

		if ($code && $content) {
			$arr = json_decode(file_get_contents(__DIR__ . '/../../common/app-config/config.json'));
			// $arr->$code->title = $title;
			// $arr->$code->content = $content;

			$arr = (array)$arr;
			$arr[$code] = [
				'title' => $arr[$code]->title,
				'content' => $content
			];
			$arr = (object)$arr;			

			$file = json_encode($arr);
			file_put_contents(__DIR__ . '/../../common/app-config/config.json', $file);

			return true;			
		}
		else {
			return false;
		}

	}


	public static function getConf()
	{
		$file = file_get_contents(__DIR__ . '/../../common/app-config/config.json');
		if ($file) {
			return json_decode($file);
		} else {
			return false;
		}
		
	}

	// удалить переменную
	public static function delConf($code)
	{
		if ($code) {
			$arr = json_decode(file_get_contents(__DIR__ . '/../../common/app-config/config.json'));
			unset($arr->$code);

			$file = json_encode($arr);
			file_put_contents(__DIR__ . '/../../common/app-config/config.json', $file);

			return true;			
		}
		else {
			return false;
		}	
	}

	// получить значение переменной по коду
	public static function byCode($code)
	{
		$file = file_get_contents(__DIR__ . '/../../common/app-config/config.json');
		if ($file) {
			$arr = json_decode($file);
			if (isset($arr->$code)) {
				return $arr->$code->content;
			}
			else {
				return false;
			}
		}
		else {
			return '';
		}
	}

}