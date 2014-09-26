<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\import $this
 */

$this->title = 'Import Jobs';
$this->params['breadcrumbs'][] = ['label' => 'Job', 'url' => 'jobs/index'];
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

<div class="jobs-import">

    <div class="panel panel-content">
    <?php if(isset($data['error'])):?>
        <p class="danger"><?= $data['error'] ?></p>
    <?php endif; ?>
    <?php if(isset($data['success'])):?>
        <p class="success"><?= $data['success'] ?></p>
    <?php endif; ?>
    <div class="form">
        <?php echo Html::beginForm(['jobs/import'], 'post',array('enctype'=>'multipart/form-data')); ?>

             <span class="btn btn-default btn-file form-control">
                Browse<?php echo Html::fileInput('file', '', ['class' => 'form-control']); ?>
             </span>
            <?php echo Html::hiddenInput('import','1'); ?>

        <div class="form-group">
            <?php echo Html::submitButton('Submit',['class'=>'btn btn-primary']); ?>
        </div>
        <span class="filename" style="padding-left: 85px;"></span>
        <?php echo Html::endForm(''); ?>
    </div>
</div>
