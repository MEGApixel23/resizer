<?php

namespace app\v1\forms;

use yii\base\Model;

class CreateImageForm extends Model
{
    public $width;
    public $height;
    public $image;

    public function rules()
    {
        return [
            ['width', 'required'],
            ['width', 'number', 'max' => 3000, 'min' => 50],

            ['height', 'required'],
            ['height', 'number', 'max' => 3000, 'min' => 50],

            [['image'], 'required'],
            [['image'], 'image']
        ];
    }

    public function load($data, $formName = null)
    {
        return parent::load($data, $formName === null ? '' : $formName);
    }
}