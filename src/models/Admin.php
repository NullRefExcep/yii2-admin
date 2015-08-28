<?php

namespace nullref\admin\models;

use nullref\admin\Module;
use nullref\useful\DropDownTrait;
use nullref\useful\JsonBehavior;
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
 * @property string $username
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property integer $status
 * @property integer $role
 * @property string $passwordHash
 * @property string $passwordResetToken
 * @property integer $passwordResetExpire
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property string $authKey
 * @property string $emailConfirmToken
 * @property string|array $data
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    use PasswordTrait;
    use DropDownTrait;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('admin', 'Active'),
            self::STATUS_INACTIVE => Yii::t('admin', 'Inactive'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    public function afterSave($insert, $changedAttributes)
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('admin');
        if ($module->enableRbac && $insert) {
            $roles = $module->get('roleContainer')->getRoles($module->get('authManager'));
            $module->get('authManager')->assign($roles[$this->role], $this->id);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeSave($insert)
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('admin');
        if ($module->enableRbac && !$insert && ($this->role != $this->oldAttributes['role'])) {
            $roles = $module->get('roleContainer')->getRoles($module->get('authManager'));
            if (isset($roles[$this->oldAttributes['role']])) {
                $module->get('authManager')->revoke($roles[$this->oldAttributes['role']], $this->id);
            }
            $module->get('authManager')->assign($roles[$this->role], $this->id);
        }

        return parent::beforeSave($insert);
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
        return $this->id;
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
     * Finds an identity by the given ID.
     * @param integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @inheritdoc
     * @return string|void
     */
    public function getAuthKey()
    {
        return md5($this->email . $this->passwordHash);
    }

    public function getName()
    {
        return $this->firstName . ' ' . $this->lastName;
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
            'json' => [
                'class' => JsonBehavior::className(),
                'fields' => ['data'],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['passwordHash', 'password', 'role', 'data'], 'safe'],
            [['email','username'], 'required'],
            [['email'], 'email'],
            [['username'], 'unique'],
            [['status', 'passwordResetExpire', 'createdAt', 'updatedAt'], 'integer'],
            [['email', 'firstName', 'lastName', 'passwordResetToken', 'emailConfirmToken'], 'string', 'max' => 255],
            [['authKey'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'email' => Yii::t('user', 'Email'),
            'username' => Yii::t('user', 'Username'),
            'firstName' => Yii::t('user', 'First Name'),
            'lastName' => Yii::t('user', 'Last Name'),
            'status' => Yii::t('user', 'Status'),
            'password' => Yii::t('user', 'Password'),
            'passwordHash' => Yii::t('user', 'Password Hash'),
            'passwordResetToken' => Yii::t('user', 'Password Reset Token'),
            'passwordResetExpire' => Yii::t('user', 'Password Reset Expire'),
            'createdAt' => Yii::t('user', 'Created At'),
            'updatedAt' => Yii::t('user', 'Updated At'),
            'authKey' => Yii::t('user', 'Auth Key'),
            'role' => Yii::t('user', 'Role'),
            'emailConfirmToken' => Yii::t('user', 'Email Confirm Token'),
        ];
    }

    /**
     * @param $value
     * @return array|null|ActiveRecord
     */
    public static function findByUsername($value)
    {
        return static::find()->orWhere(['username' => $value])->orWhere(['email' => $value])->one();
    }


}
