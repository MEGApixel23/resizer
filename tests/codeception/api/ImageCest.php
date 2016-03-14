<?php

use app\v1\models\Device;
use app\v1\models\User;
use app\v1\models\Image;

class ImageCest
{
    public static $goodImage = 'Octocat.png';

    private $_device;

    public function _before(ApiTester $I)
    {
        $this->_device = Device::find()->one();

        if (!$this->_device) {
            $user = new User();
            $user->save();

            $device = new Device();
            $device->generateToken();
            $device->setUser($user);
            $device->save();

            $this->_device = $device;
        }
    }

    public function resize(ApiTester $I)
    {
        $I->wantTo('Resize image');
        $I->setHeader('Authorization', $this->_device->token);
        $I->sendPOST('/image', [
            'width' => 200,
            'height' => 200,
        ], [
            'image' => [
                'name' => self::$goodImage,
                'type' => mime_content_type(codecept_data_dir(self::$goodImage)),
                'error' => UPLOAD_ERR_OK,
                'size' => filesize(codecept_data_dir(self::$goodImage)),
                'tmp_name' => codecept_data_dir(self::$goodImage),
            ]
        ]);

        $I->expect('Take response with proper images params');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    /**
     * @param ApiTester $I
     * @after clearData
     */
    public function listOfImages(ApiTester $I)
    {
        $I->wantTo('see list of resized images');

        $I->setHeader('Authorization', $this->_device->token);
        $I->sendGET('/image');

        $I->seeResponseCodeIs(200);
        $I->canSeeResponseIsJson();
        $response = $I->grabResponse();

        $response = json_decode($response);

        for ($i = 0; $i < count($response); $i++) {
            $I->assertTrue(isset($response[$i]->id));
            $I->assertTrue(isset($response[$i]->url));
            $I->assertTrue(isset($response[$i]->width));
            $I->assertTrue(isset($response[$i]->height));
            $I->assertTrue(isset($response[$i]->date));
        }
    }

    protected function clearData()
    {
        $images = Image::find()->all();

        for ($i = 0; $i < count($images); $i++) {
            $image = $images[$i];

            /** @var $image Image */
            unlink(Yii::$aliases['@webroot'] . '/uploads/' . $image->filename);
            $image->delete();
        }

        $this->_device->user->delete();
    }
}