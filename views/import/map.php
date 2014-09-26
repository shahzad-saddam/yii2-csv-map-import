<?php

use yii\helpers\Html;

/**
 * @var yii\web\import $this
 */

//$this->title = 'Map Job fields';
//$this->params['breadcrumbs'][] = ['label' => 'Job', 'url' => 'jobs/index'];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body no-padding">
        <?php if (isset($headers)): ?>
            <div class="col-md-10" style="position: relative; z-index: 999;padding-top: 20px;">
                <?php echo Html::beginForm(['companies/map', 'company_id' =>  Yii::$app->request->get('id')], 'post', array('enctype' => 'multipart/form-data', 'class' => 'form-horizontal')); ?>

                <?php foreach ($headers as $header): ?>
                    <div class="form-group required">
                        <label class="col-sm-4 control-label" for="<?= $header ?>"><?= $header ?></label>
                        <div class="col-sm-8">
                            <?php if(isset($_GET['edit'])){ ?>
                                <?php echo Html::dropDownList($header, $selection = $selected_columns[$header], $columns, ['class' => 'form-control']); ?>
                            <?php  }else{ ?>
                                <?php echo Html::dropDownList($header, $selection = null, $columns, ['class' => 'form-control']); ?>
                            <?php } ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="form-group">
                    <?php echo Html::submitButton('Submit', ['class' => 'btn btn-success']); ?>
                    <?php if(isset($_GET['edit'])): ?>
                    <?= Html::a('Cancel', ['', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php endif; ?>
                </div>

                <?php echo Html::endForm(''); ?>
            </div>
        <?php else: ?>
        <div class="jobs-import">

            <div class="panel panel-content">
                <?php if (isset($data['error'])): ?>
                    <p class="danger"><?= $data['error'] ?></p>
                <?php endif; ?>
                <?php if (isset($data['success'])): ?>
                    <p class="success"><?= $data['success'] ?></p>
                <?php endif; ?>
                <div class="form">
                    <?php echo Html::beginForm('#', 'post', array('enctype' => 'multipart/form-data', 'class' => 'map-form')); ?>
                    <?= Html::a('Update', ['', 'id'=>$_GET['id'], 'edit' => 'map'], ['class' => 'btn btn-success']) ?>
                    <?php echo Html::submitButton('Submit', ['class' => 'btn btn-success']); ?>
                    <span class="btn btn-default btn-file form-control">
                            Browse<?php echo Html::fileInput('file', '', ['class' => 'form-control']); ?>
                        </span>
                        <?php echo Html::hiddenInput('import', '1'); ?>


                    <span class="filename"></span>
                    <?php echo Html::endForm(''); ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="box">
                <table class="table table-striped table-bordered detail-view">
                    <tbody>
                    <tr>
                        <th>Table field</th>
                        <th>CSV field</th>
                    </tr>
                    <?php $extra = array(); ?>
                    <?php foreach ($map as $item): ?>
                        <tr>
                            <?php if($item->columname != 'dump'): ?>

                            <td> <?= $item->columname?></td>
                            <td><?= $item->csvfield ?></td>

                            <?php else: ?>

                                <?php $extra[] = $item->csvfield; ?>

                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>Extra Information</td>
                        <td><?= implode(', ', $extra)?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>