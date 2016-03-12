<?php

namespace app\v1\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $width
 * @property integer $height
 * @property string $filename
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Image extends \yii\db\ActiveRecord implements ImageInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'width', 'height', 'created_at', 'updated_at'], 'integer'],
            [['width', 'height', 'filename'], 'required'],
            [['filename'], 'string', 'max' => 255],
            [['filename'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [TimestampBehavior::className()]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'width' => 'Width',
            'height' => 'Height',
            'filename' => 'Filename',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
