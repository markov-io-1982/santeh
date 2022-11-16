<?php
namespace backend\models;

use Yii;
use yii\base\Model;


class Slug extends Model
{
	
	public static function getSlug($string, $lengths)
	{

	$arr = array (
		'й'=>'j','ц'=>'c','у'=>'u','к'=>'k','е'=>'e','н'=>'n','г'=>'g','ш'=>'sh',
		'щ'=>'sch','з'=>'z','х'=>'h','ъ'=>'','ф'=>'f','ы'=>'y','в'=>'v','а'=>'a',
		'п'=>'p','р'=>'r','о'=>'o','л'=>'l','д'=>'d','ж'=>'zh','э'=>'e','я'=>'ja',
		'ч'=>'ch','с'=>'s','м'=>'m','и'=>'y','т'=>'t','ь'=>'','б'=>'b','ю'=>'ju','ё'=>'e', 'є' => 'e',

		'Й'=>'J','Ц'=>'C','У'=>'U','К'=>'K','Е'=>'E','Н'=>'N','Г'=>'G','Ш'=>'SH',
		'Щ'=>'SCH','З'=>'Z','Х'=>'H','Ъ'=>'','Ф'=>'F','Ы'=>'Y','В'=>'V','А'=>'A',
		'П'=>'P','Р'=>'R','О'=>'O','Л'=>'L','Д'=>'D','Ж'=>'ZH','Э'=>'E','Я'=>'JA',
		'Ч'=>'CH','С'=>'S','М'=>'M','И'=>'Y','Т'=>'T','Ь'=>'','Б'=>'B','Ю'=>'JU','Ё'=>'E',

		'і'=>'i', 'ї' => 'i', 'b' => 'b', 'І' => 'i',

		' '=>'-', '\''=>'', '"'=>'', '\t'=>'', '«'=>'', '»'=>'', '?'=>'', '!'=>'', '*'=>''	
	);
	
    $str = strtr($string, $arr);
	
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

	$clean = substr($clean, 0, $lengths);
	
	return $clean;        
	}
}