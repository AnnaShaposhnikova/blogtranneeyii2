<?php

namespace app\models;

use app\traits\Restore;
use app\traits\SoftDelete;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\Expression;
use yii\validators\EmailValidator;
use yii\validators\RequiredValidator;
use yii\validators\UniqueValidator;
use yii\behaviors\TimestampBehavior;

/**
 * @property int $id
 * @property int $role
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * */

class Users extends ActiveRecord implements \yii\web\IdentityInterface
{

    use SoftDelete;
    use Restore;

    const USER_ROLE = 1;
    const ADMIN_ROLE = 2;

    const SCENARIO_ADMIN_CREATE = 'create';

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['role','first_name','last_name','email','password'],RequiredValidator::class],
            [['first_name','last_name'], 'string', 'length' => [3, 24]],
            [['email'], EmailValidator::class],
            [['email'],UniqueValidator::class],
            [['password'],'string', 'min' => 8],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADMIN_CREATE] = ['role','first_name','last_name','email'];
        return $scenarios;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],

                'value' => new Expression('NOW()'),
            ],
        ];

    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new Exception('Not emplemented');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($email)
    {
        return static::findOne(['email'=> $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
//        return Yii::$app->security->validatePassword($password, $this->password);

    return   password_verify($password,$this->password);
    }

   public function passwordHash($password){
        return $this->password = password_hash($password,PASSWORD_ARGON2ID );
    }

}
