<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $model \nullref\admin\models\LoginForm */

$this->title = Yii::t('admin', 'Sign in');

$this->registerCss(<<<CSS
.toggle-password {
    cursor: pointer;
    user-select: none;
}
.field-login-form-rememberme {
    padding-left: 5px;
    user-select: none;
}
.field-login-form-rememberme input {
    cursor: pointer;
}
CSS
);

$this->registerJs(<<<JS
jQuery('.toggle-password').on('click', function() {
    var i = jQuery(this).find('i');
    i.toggleClass('glyphicon-eye-open').toggleClass('glyphicon-eye-close');
    var input = jQuery(this).parent('.input-group').find('input');
    var type = input.attr('type');
    input.attr('type', type =='password' ? 'text': 'password')
});
JS
);

$passwordInputTemplate = <<<HTML
<div class="input-group">
    <span class="input-group-addon">
        <i class="glyphicon glyphicon-lock"></i>
    </span>
    {input}
    <span class="input-group-addon toggle-password">
        <i class="glyphicon glyphicon-eye-open"></i>
    </span>
</div>
{hint}
{error}
HTML;
?>
<div class="main-login">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= Yii::t('admin', 'Please Sign In') ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php $form = ActiveForm::begin(); ?>
                        <fieldset>

                            <?= $form->field($model, 'login', [
                                'template' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>{input}</div>{hint}{error}'
                            ])->textInput([
                                'placeholder' => ArrayHelper::getValue($model->attributeLabels(), 'username')
                            ]); ?>

                            <?= $form->field($model, 'password', [
                                'template' => $passwordInputTemplate,
                            ])->passwordInput([
                                'placeholder' => ArrayHelper::getValue($model->attributeLabels(), 'password')
                            ]); ?>

                            <?= $form->field($model, 'rememberMe', [
                                'template' => '<div class="checkbox"><label>{input}</label></div>'
                            ])->checkbox() ?>


                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('admin', 'Sign in'),
                                    ['class' => 'btn btn-lg btn-primary btn-block']) ?>
                            </div>
                        </fieldset>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
