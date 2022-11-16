<?php
/**
 * Created by PhpStorm.
 * User: ret284
 * Date: 13.04.2017
 * Time: 22:52
 */

namespace backend\widgets;

use yii\base\Widget;
use backend\models\Category;

class MenuWidget extends Widget
{
    /**
     * The template for view list category
     */
    public $tpl;

    /**
     * All categories from the database
     */
    public $data;

    /**
     * The tree result for builds category
     */
    public $tree;

    /**
     * The result html code for view manu
     */
    public $menuHtml;

    /**
     * Using parent method init()
     */
    public function init()
    {
        parent::init();
        if ($this->tpl === null)
            $this->tpl = 'menu';
        $this->tpl .= '.php';
    }

    /**
     * @return mixed
     */
    public function run()
    {
        // Get cache
        /** @noinspection PhpUndefinedClassInspection */
        //$menu = Yii::$app->cache->get('menu');
        //if ($menu) return $menu;

        $this->data = Category::find()->indexBy('id')->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);

        // Set cache
        /** @noinspection PhpUndefinedClassInspection */
        //Yii::$app->cache->set('menu', $this->menuHtml, 10 * 60); // I use lifetime of 1 minutes
        return $this->menuHtml;
    }

    /**
     * Build tree elements
     * @return array
     */
    protected function getTree()
    {
        $tree = [];
        foreach ($this->data as $id => &$node) {
            if (!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }

    /**
     * Build htnl menu
     * @param $inputTree
     * @return string $string
     */
    protected function getMenuHtml($inputTree)
    {
        $string = '';
        foreach ($inputTree as $key => $category) {
            $string .= $this->getToTemplate($category);
        }
        return $string;
    }

    /**
     * @param $category
     * @return string
     */
    protected function getToTemplate($category)
    {
        ob_start();
        include __DIR__ . '/views/' . $this->tpl;
        return ob_get_clean();
    }


}