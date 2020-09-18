<?php

namespace app\models;

use app\traits\Restore;
use app\traits\SoftDelete;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\validators\EmailValidator;
use yii\validators\RequiredValidator;
use yii\validators\UniqueValidator;
use yii\behaviors\TimestampBehavior;

class Users extends ActiveRecord implements \yii\web\IdentityInterface
{

    use SoftDelete;
    use Restore;

//    public $id;
//    public $first_name;
//    public $last_name;
//    public $password;
//    public $authKey;
//    public $accessToken;

    const USER_ROLE = 1;
    const ADMIN_ROLE = 2;

    const SCENARIO_ADMIN_CREATE = 'create';

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];

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
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($email)
    {
        return static::findOne($email);
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
        return $this->authKey;
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
        return $this->password === $password;
    }

}
