<?php

namespace nullref\admin\models;

use nullref\useful\DropDownTrait;
use nullref\useful\PasswordTrait;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $id
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property integer $status
 * @property string $passwordHash
 * @property string $passwordResetToken
 * @property integer $passwordResetExpire
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property string $authKey
 * @property string $emailConfirmToken
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    use PasswordTrait;
    use DropDownTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     * @param string $authKey
     */
    public function validateAuthKey($authKey)
    {
        return $authKey == md5($this->email . $this->passwordHash);
    }

    /**
     * @inheritdoc
     * @param mixed $token
     * @param null $type
     * @return void|IdentityInterface
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return 'admin' . $this->id;
    }

    /**
     * Generate and set confirm token
     * @return string
     */
    public function generateConfirmToken()
    {
        return $this->emailConfirmToken = md5($this->id . $this->email . time());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ],
        ]);
    }

    /**
     * Finds an identity by the given ID.
     * @param integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        $id = str_replace('admin', '', $id);
        return self::findOne($id);
    }

    public function getName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['passwordHash', 'password'], 'safe'],
            [['email'], 'required'],
            [['status', 'passwordResetExpire', 'createdAt', 'updatedAt'], 'integer'],
            [['email', 'firstName', 'lastName', 'passwordResetToken', 'emailConfirmToken'], 'string', 'max' => 255],
            [['authKey'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     * @return string|void
     */
    public function getAuthKey()
    {
        return md5($this->email . $this->passwordHash);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'email' => Yii::t('user', 'Email'),
            'firstName' => Yii::t('user', 'First Name'),
            'lastName' => Yii::t('user', 'Last Name'),
            'status' => Yii::t('user', 'Status'),
            'passwordHash' => Yii::t('user', 'Password Hash'),
            'passwordResetToken' => Yii::t('user', 'Password Reset Token'),
            'passwordResetExpire' => Yii::t('user', 'Password Reset Expire'),
            'createdAt' => Yii::t('user', 'Created At'),
            'updatedAt' => Yii::t('user', 'Updated At'),
            'authKey' => Yii::t('user', 'Auth Key'),
            'emailConfirmToken' => Yii::t('user', 'Email Confirm Token'),
        ];
    }
}
