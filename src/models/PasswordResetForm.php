<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\admin\models;

use Yii;
use yii\base\Model;

class PasswordResetForm extends Model
{
    public $newPassword;
    public $newPasswordRepeat;

    public $hasNewPasswordRepeat = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $result = [
            [['newPassword', 'newPasswordRepeat'], 'safe'],
        ];
        if ($this->hasNewPasswordRepeat) {
            $result[] = [['newPassword'], 'compare', 'compareAttribute' => 'newPasswordRepeat'];
        }
        return $result;
    }

    /**
     * @param Admin $user
     * @return bool
     */
    public function changePassword(Admin $user)
    {
        if ($this->validate()) {
            $user->setPassword($this->newPassword);
            return $user->save();
        }
        return false;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'newPassword' => Yii::t('admin', 'New Password'),
            'newPasswordRepeat' => Yii::t('admin', 'New Password Repeat'),
        ];
    }
} 