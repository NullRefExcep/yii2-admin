<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel nullref\admin\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Admins');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('admin', 'Create Admin'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'email:email',
            'firstName',
            'lastName',
            'role',
            // 'status',
            // 'passwordHash',
            // 'passwordResetToken',
            // 'passwordResetExpire',
            // 'createdAt',
            // 'updatedAt',
            // 'authKey',
            // 'emailConfirmToken:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
