<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
//use yii\grid\GridView;
use kartik\grid\GridView;

/**
 * @var yii\web\View $this
 * @var common\models\Company $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->session->getFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <i class="fa fa-check"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->getFlash('error')): ?>
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-check"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<?php $this->beginBlock('action-bar') ?>
<?php $company_details_buttons =  '<div class="tab-right-buttons">'.
     Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) .
    Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) .
'</div>';
?>
<?php $this->endBlock() ?>
<?php
if (isset($columns) && isset($headers)) {
    if(isset($_GET['edit'])) {
        $view = $this->render('map', ['model' => $model, 'selected_columns' => $selected_columns, 'columns' => $columns, 'headers' => $headers, 'map' => $map]);
    }
    else {
        $view = $this->render('map', ['model' => $model, 'columns' => $columns, 'headers' => $headers, 'map' => $map]);
    }

} else {
    $view = $this->render('map', ['map' => $map]);
}
?>
<?php $userAddButton = '<div class="tab-right-buttons">'.
     Html::a('Add User', ['users/create', 'company_id' => $model->id], ['class' => 'btn btn-primary']) .
 '</div>' ;?>
<?php
echo \yii\bootstrap\Tabs::widget([
    'items' => [
        [
            'label' => 'Details',
            'content' => $company_details_buttons . '<div class="box"><div class="box-body no-padding">' . DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label' => 'Logo',
                            'value' => Html::img(Yii::getAlias('@web/uploads/companies/') . $model->logo_file_name),
                            'format' => 'html'
                        ],
                        'slug',
                        'description:ntext',
                        'status:boolean',
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) . '</div></div>',
            'active' => true
        ],
        [
            'label' => 'Users',
            'content' => $userAddButton . '<div class="box"><div class="box-body no-padding">' . GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'columns' => [
                        'username',
                        //'auth_key',
                        //'password_hash',
                        //'password_reset_token',
                        'email:email',
                        'status:boolean:Active',
                        //'created_at',
                        //'updated_at',
                        'updated_at:datetime',
                        ['class' => 'yii\grid\ActionColumn', 'controller' => 'users', 'template' => '{update} {delete}'],
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => ['scrollingTop' => ''],
                    'layout' => GridView::TEMPLATE_1,
                    'beforeTemplate' => '<div class="export-summary">{export} {summary}</div>',
                    'panel' => [
                        'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Create User', ['users/create', 'company_id' => $model->id], ['class' => 'btn btn-success']),
                    ],
                ]) . '</div></div>',
        ],
        [
            'label' => 'Mapping',
            'content' => $view,
        ],
    ],
]);

?>

<!--
div class="box">
    <div class="box-body no-padding">
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'Logo',
                    'value' => Html::img(Yii::getAlias('@web/uploads/companies/') . $model->logo_file_name),
                    'format' => 'html'
                ],
                'slug',
                'description:ntext',
                'status:boolean',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>

    </div>
</div>


<h3> Company Users</h3>

<div class="box">
    <div class="box-body no-padding">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                'username',
                //'auth_key',
                //'password_hash',
                //'password_reset_token',
                'email:email',
                'status:boolean:Active',
                //'created_at',
                //'updated_at',
                'updated_at:datetime',
                ['class' => 'yii\grid\ActionColumn', 'controller' => 'users', 'template' => '{update} {delete}'],
            ],
            'responsive'=>true,
            'hover'=>true,
            'floatHeader'=>true,
            'floatHeaderOptions'=>['scrollingTop'=>''],
            'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> Users</h3>',
                'type'=>'success',
                'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create User', ['users/create', 'company_id' => $model->id], ['class' => 'btn btn-success']),
                'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
                'showFooter'=>false
            ],
        ]); ?>
    </div>
</div>
-->

<style>
    .table-bordered {
        width: 100% !important;
    }
</style>