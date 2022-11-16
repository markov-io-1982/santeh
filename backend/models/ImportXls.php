<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Import form
 */
class ImportXls extends Model
{
    public $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Файл для импорта',
        ];
    }

}
