<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator nullref\admin\generators\stuff\Generator */


echo $form->field($generator, 'file')->dropDownList($generator->getDropDownList());