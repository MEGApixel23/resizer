<?php

namespace app\v1\forms;

use app\v1\models\Image;
use app\v1\models\UserInterface;
use yii\base\Model;
use Imagine\Gd\Imagine;
use Imagine\Gd\Image as ImagineImage;
use yii\base\ErrorException;

/**
 * Class CreateImageForm
 * @package app\v1\forms
 */
class CreateImageForm extends Model
{
    public $width;
    public $height;
    public $image;

    private $_user;
    private $_filename;

    /* @inheritdoc */
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

    /**
     * @param array $data
     * @param null $formName
     * @return bool
     */
    public function load($data, $formName = null)
    {
        return parent::load($data, $formName === null ? '' : $formName);
    }

    /* @param UserInterface $user */
    public function setUser(UserInterface $user)
    {
        $this->_user = $user;
    }

    /**
     * @return Image|bool
     */
    public function save()
    {
        if (!$this->validate())
            return false;

        $imagePath = $this->resize();

        if (!$imagePath) {
            $this->addError('image', 'Could not resize image');
            return false;
        }

        $image = new Image();
        $image->setUser($this->_user);
        $image->filename = $this->_filename;
        $image->height = $this->height;
        $image->width = $this->width;

        if ($image->save())
            return $image;

        return false;
    }

    /**
     * @return bool|string
     * @throws ErrorException
     */
    private function resize()
    {
        $imagine = new Imagine();
        $image = $imagine->open($this->image->tempName);
        $box = $this->getBox($image);
        $this->width = $box->getWidth();
        $this->height = $box->getHeight();
        $path = $this->generateFilePath([
            'width' => $this->width,
            'height' => $this->height,
            'extension' => $this->image->extension
        ]);
        $image->resize($box)->save($path);

        if (file_exists($path)) {
            return $path;
        }

        return false;
    }

    /**
     * @param array $options
     * @return string
     */
    private function generateFilePath(array $options)
    {
        $randomPart = time() . '_' . mt_rand(10000, 90000);
        $filename =
            "{$randomPart}_{$options['width']}x{$options['height']}.{$options['extension']}";
        $filePath = Image::basePath() . '/' . $filename;

        if (file_exists($filePath))
            return $this->generateFilePath($options);

        $this->_filename = $filename;
        return $filePath;
    }

    /**
     * @param $image
     * @return \Imagine\Image\Box|\Imagine\Image\BoxInterface
     * @throws ErrorException
     */
    private function getBox($image)
    {
        if (!($image instanceof ImagineImage))
            throw new ErrorException('invalid image');

        $size = $image->getSize();
        $width = $size->getWidth();
        $height = $size->getHeight();

        if ($width <= $this->width && $height <= $this->height) {
            return $size;
        }

        if ($width/$this->width >= $height/$this->height)
            return $image->getSize()->widen($this->width);
        else
            return $image->getSize()->widen($this->height);
    }
}