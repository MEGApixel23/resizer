<?php

namespace app\v1\controllers;

use app\v1\extensions\controllers\ApiController;
use app\v1\models\Device;
use app\v1\models\User;

class AuthController extends ApiController
{
    public function actionIndex()
    {
        $user = new User();

        if (!$user->save())
            return false;

        $device = new Device();
        $device->setUser($user);
        $device->generateToken();

        if (!$device->save())
            return false;

        return [
            'id' => $user->id,
            'token' => $device->token
        ];
    }
}