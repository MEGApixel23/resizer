<?php

namespace app\v1\extensions\controllers;

use Yii;
use app\v1\models\User;

class ApiAuthController extends ApiController
{
    protected $_user;

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $token = Yii::$app->request->headers->get('Authorization');

            if ($token) {
                $user = User::findByToken($token);
                if ($user) {
                    $this->_user = $user;
                    return true;
                }
            }

            return $this->notAllowed([
                'error' => 'UNAUTHORIZED_ERROR',
                'message' => 'Wrong token has been provided'
            ]);
        }

        return false;
    }

    public function notAllowed(array $data = [])
    {
        $response = &Yii::$app->response;
        $response->setStatusCode(401);
        $response->data = $data;
        $response->send();

        return false;
    }
}