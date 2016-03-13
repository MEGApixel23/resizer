<?php

namespace app\v1\controllers;

use Yii;
use app\v1\extensions\controllers\ApiAuthController;
use app\v1\forms\CreateImageForm;
use yii\data\ActiveDataProvider;
use app\v1\models\Image;
use yii\web\UploadedFile;

class ImageController extends ApiAuthController
{
    public function actionIndex()
    {
        $query = Image::find()->where(['user_id' => $this->_user->id]);
        Yii::$app->response->headers->set('X-Total-Count', $query->count());

        $provider = new ActiveDataProvider([
            'query' => $query
        ]);

        return call_user_func(function ($images) {
            /* @var $images Image[] */
            foreach ($images as $image) {
                yield [
                    'id' => $image->id,
                    'url' => $image->getUrl(),
                    'width' => $image->width,
                    'height' => $image->height,
                    'date' => date('c', $image->created_at),
                ];
            }
        }, $provider->getModels());
    }

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