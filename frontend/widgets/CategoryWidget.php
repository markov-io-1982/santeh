<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

use frontend\models\Category;

class CategoryWidget extends Widget
{

    public function run()
    {

    	$category = Yii::$app->request->get('category');

    	$categories = Category::find()
    		->where(['status' => 1])
    		->all();

        return $this->render('category', [
        	'categories' => $categories,
        	'category' => $category,
		]);
    }

}

?>