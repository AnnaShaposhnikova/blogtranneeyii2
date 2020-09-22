<?php


namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\validators\FileValidator;
use yii\validators\RequiredValidator;
use yii\validators\SafeValidator;
use yii\web\UploadedFile;

class Posts extends ActiveRecord
{
    public $number;
    public $link;

    /**
     * @var UploadedFile
     */
    public $imageFile;

    public static function tableName()
    {
        return 'bl_posts';
    }

    public function rules()
    {
        return [
            [['is_release','title','intro_text','full_text'], SafeValidator::class],
            ['imageFile',RequiredValidator::class, 'when'=>function($model){
                return $model->isNewRecord;
            }],
            [['imageFile'], FileValidator::class, 'extensions' => 'png, jpg, gif'],
        ];
    }

    public function load($data, $formName = null)
    {
        $res = parent::load($data, $formName);
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        return $res;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public function uploadFile()
    {
        if (!$this->imageFile) {
            return true;
        }
        $fileName = md5($this->imageFile->baseName . uniqid()) . '.' . $this->imageFile->extension;
        $this->img = $fileName;
        return $this->imageFile->saveAs('@app/web/uploads/' . $fileName);
    }

    public function beforeSave($insert)
    {
        if (!$this->uploadFile()) {
            return false;
        }
        return parent::beforeSave($insert);
    }

    public function delete()
    {
        $path = Yii::getAlias('@app/web/uploads' ).'/'.$this->img;
        if(isset($this->img) && file_exists($path )){
           unlink($path);
        }

        return parent::delete();
    }
}