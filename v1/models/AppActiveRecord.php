<?php

namespace app\v1\models;

use yii\db\ActiveRecord;

class AppActiveRecord extends ActiveRecord
{
    public function setUser(UserInterface $user)
    {
        $this->user_id = $user->getId();
    }
}