<?php

use yii\bootstrap\ActiveForm;

/**
 * @var \yii\web\View $this
 * @var \nullref\admin\models\PasswordResetForm $model
 */
?>
<div class="main-login">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= Yii::t('admin', 'Please enter new password') ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php $form = ActiveForm::begin(); ?>
                        <fieldset>
                            <?= $form->field($model, 'newPassword')->passwordInput() ?>
                            <?php if ($model->hasNewPasswordRepeat): ?>
                                <?= $form->field($model, 'newPasswordRepeat')->passwordInput() ?>
                            <?php endif ?>
                        </fieldset>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>