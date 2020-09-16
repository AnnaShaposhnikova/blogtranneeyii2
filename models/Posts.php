<?php


namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\validators\FileValidator;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

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
            [['is_release','title','intro_text','full_text'],'safe'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
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


    public function afterFind()
    {
        $monthes =[
            1 => "Января",
            2 => "Февраля",
            3 => "Марта",
            4 => "Апреля",
            5 => "Мая",
            6 => "Июня",
            7 => "Июля",
            8 => "Августа",
            9 => "Сентября",
            10 => "Октября",
            11 => "Ноября",
            12 => "Декабря",
        ];
//        $this->date = date("j",$this->date).$monthes[date("n", $this->date)].date("Y",$this->date);
//        $this->intro_text = $this->replaceContent($this->intro_text);
//        $this->full_text = $this->replaceContent($this->full_text);
//        $this->link = Yii::$app->UrlManager->createUrl(["site/post",
//                                                        "id" => $this->id]);

    }

    public function replaceContent($text){
        $text = $this->youtube($text);
        $text = $this->flowplayer($text);
        return $text;

    }

    private function youtube($text){
        if(strpos($text,"youtube") == false) {
            return $text;
        }
        $reg = "/{youtube:([\w-_]*)?,(\d*)?,(\d*)?}/i";
        $text = preg_replase($reg, str_replace(["%name%", "%width%", "%height"], ["\\1", "\\2", "\\3"]),
                file_get_contents(Yii::$app->basePath . Yii::$app->params["dir_tmpl"] . "youtube.tpl", $text));

        return $text;
    }

    private function flowplayer($text){
        if(strpos($text,"flowplayer") == false) {
            return $text;
        }
        $reg = "/{flowplayer:([\w-_]*)?,(\d*)?,(\d*)?}/i";
        $text = preg_replase($reg, str_replace(["%name%", "%width%", "%height"], ["\\1", "\\2", "\\3"]),
            file_get_contents(Yii::$app->basePath . Yii::$app->params["dir_tmpl"] . "flowplayer.tpl", $text));

        return $text;
    }

    public static function setNumber($posts){
        $all_realeses = Posts::find()->where(['is_release' => 1])->orderBy("date")->all();
        $number = 1;
        foreach($all_realeses as $realese){
            foreach ($posts as $post){
                if($post->id == $realese->id){
                    $post->number = $number;
                }
            }
            $number++;
        }

    }

    public function uploadFile()
    {
        if (!is_null($this->imageFile)) {
            $fileName = md5($this->imageFile->baseName . uniqid()) . '.' . $this->imageFile->extension;
            $this->img = $fileName;
            return $this->imageFile->saveAs('@app/web/uploads/' . $fileName);
        }
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