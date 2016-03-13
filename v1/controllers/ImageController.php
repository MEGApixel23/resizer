<?php

namespace app\v1\controllers;

use Yii;
use app\v1\extensions\controllers\ApiAuthController;
use app\v1\forms\CreateImageForm;
use yii\web\UploadedFile;

class ImageController extends ApiAuthController
{
    public function actionCreate()
    {
        $createImageForm = new CreateImageForm();
        $createImageForm->load(Yii::$app->request->post());
        $createImageForm->image = UploadedFile::getInstanceByName('image');
        $createImageForm->setUser($this->_user);

        $image = $createImageForm->save();

        if (!$image) {
            Yii::$app->response->statusCode = 400;
            return [
                'error' => 'VALIDATION_ERROR',
                'message' => 'Wrong input data',
                'data' => $createImageForm->getErrors()
            ];
        }

        return [
            'id' => $image->id,
            'url' => $image->getUrl(),
            'width' => $image->width,
            'height' => $image->height,
            'date' => date('c', $image->created_at),
        ];
    }
}