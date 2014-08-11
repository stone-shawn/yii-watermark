<?php 
require 'watermark.class.php';

class Yiiwatermark extends CApplicationComponent {

    public $watermarkImage;

    private $watermark;

    public function init()
    {
        parent::init();
    }

    public function setWatermark($path, $place)
    {
        $watermark = new Watermark($path);
        $watermark->setWatermarkImage(Yii::getPathOfAlias('webroot') . $this->watermarkImage);
        $watermark->imageType = $this->getImageType($path);
        $watermark->setType(Watermark::CENTER);
        if($watermark->save() === true) {
            Yii::log($path . ', set watermark successfully!', 'info', 'uploadPhoto');
            return true;
        } else {
            Yii::log($path . ', set watermark failed!', 'info', 'uploadPhoto');
            return false;
        }
    }

    private function getImageType($image) {
        $type = exif_imagetype($image);
        switch ($type) {
            case IMAGETYPE_GIF:
                $ext = 'gif';
                break;
            case IMAGETYPE_JPEG:
                $ext = 'jpg';
                break;
            case IMAGETYPE_PNG:
                $ext = 'png';
                break;
            default:
              throw new CException('Invalid image file type');
              break;
        } 
        return $ext;
    }
} 