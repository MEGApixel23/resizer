<?php

namespace app\v1\controllers;

use app\v1\extensions\controllers\ApiAuthController;
use Yii;
use app\v1\forms\CreateImageForm;
use yii\web\UploadedFile;

class ImageController extends ApiAuthController
{
    public function actionCreate()
    {
        $createImageForm = new CreateImageForm();
        $createImageForm->load(Yii::$app->request->post());
        $createImageForm->image = UploadedFile::getInstanceByName('image');

        if (!$createImageForm->validate()) {
            Yii::$app->response->statusCode = 400;
            return [
                'error' => 'VALIDATION_ERROR',
                'message' => 'Wrong input data',
                'data' => $createImageForm->getErrors()
            ];
        }
    }
}