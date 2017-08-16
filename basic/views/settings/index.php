<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
//use dosamigos\ckeditor\CKEditor;
//use app\components\dosamigos\ckeditor\CKEditor;

use yii\widgets\Pjax;

$this->title = 'Настройки';

$this->registerJsFile(
    'js/ckeditor/ckeditor.js',
    ['depends' => 'app\assets\AppAsset',
        'position' => \yii\web\View::POS_HEAD]
);

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Единици измерения</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'unit_add']); ?>

            <div class="margin_bottom">
                <button class="btn btn-success" data-toggle="collapse" data-target="#add_unit">Добавить единици измерения</button>
            </div>
            <div id="add_unit" class="collapse">

                <?php $form_unit_add = ActiveForm::begin([
                    'id' => 'unitAddForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],

                ]); ?>


                <?= $form_unit_add->field($UnitAddForm, 'name')->label('Новая единица измерения') ?>


                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary btn-block', 'name' => 'unit-add-button', 'id' => 'unit-add-id', ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>





            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Название</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($units_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#unit_tr_<?= $k+1 ?>">
                            <td><?= $k+1 ?></td>
                            <td><?= $v['name'] ?></td>
                        </tr>

                        <tr id="unit_tr_<?= $k+1 ?>" class="collapse" >
                            <td colspan="2">
                                <a href="/settings/edit-unit?id=<?= $v['id'] ?>" class="btn btn-primary">Редактировать</a>
                                <a href="/settings/delete-unit?id=<?= $v['id'] ?>" class="btn btn-danger">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>





            <?php Pjax::end(); ?>
        </div>
    </div>













    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Хедеры</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'header_add']); ?>

            <div class="margin_bottom">
                <button class="btn btn-success" data-toggle="collapse" data-target="#add_header">Добавить новый хедер</button>
            </div>
            <div id="add_header" class="collapse">

                <?php $form_header_add = ActiveForm::begin([
                    'id' => 'headerAddForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-8 col-md-8 col-sm-8\">{input}</div>\n<div class=\"col-lg-2 col-md-2 col-sm-2\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-2 col-md-2 col-sm-2 control-label'],
                    ],

                ]); ?>


                <?= $form_header_add->field($HeaderAddForm, 'name')->label('Имя хедера') ?>
                <?= $form_header_add->field($HeaderAddForm, 'text')->textarea(['rows' => 5, 'id'=>'text_header'])->label('Текст хедера') ?>
                <?= $form_header_add->field($HeaderAddForm, 'footer_header')->hiddenInput(['value'=>1])->label(false) ?>
                <script type="text/javascript">
                    CKEDITOR.replace( 'text_header' );
                </script>

                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary btn-block', 'name' => 'header-add-button', 'id' => 'header-add-id', ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>





            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Текст хедера</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($headers_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#header_tr_<?= $k+1 ?>">
                            <td><?= $v['name'] ?></td>
                            <td><?= $v['text'] ?></td>
                        </tr>

                        <tr id="header_tr_<?= $k+1 ?>" class="collapse" >
                            <td colspan="2">
                                <a href="/settings/edit-header?id=<?= $v['id'] ?>" class="btn btn-primary">Редактировать</a>
                                <a href="/settings/delete-header?id=<?= $v['id'] ?>" onclick="return confirm('Вы уверены что хотите удалить <?= $v['name'] ?>')"  class="btn btn-danger delete">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>













    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Футеры</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'header_add']); ?>

            <div class="margin_bottom">
                <button class="btn btn-success" data-toggle="collapse" data-target="#add_footer">Добавить новый футер</button>
            </div>
            <div id="add_footer" class="collapse">

                <?php $form_footer_add = ActiveForm::begin([
                    'id' => 'footerAddForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-8 col-md-8 col-sm-8\">{input}</div>\n<div class=\"col-lg-2 col-md-2 col-sm-2\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-2 col-md-2 col-sm-2 control-label'],
                    ],

                ]); ?>


                <?= $form_footer_add->field($FooterAddForm, 'name')->label('Имя футера') ?>
                <?= $form_footer_add->field($FooterAddForm, 'text')->textarea(['rows' => 5, 'id'=>'text_footer'])->label('Текст футера') ?>
                <?= $form_footer_add->field($FooterAddForm, 'footer_header')->hiddenInput(['value'=>2])->label(false) ?>
                <script type="text/javascript">
                    CKEDITOR.replace( 'text_footer' );
                </script>

                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary btn-block', 'name' => 'header-add-button', 'id' => 'header-add-id', ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>





            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Текст футера</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($footers_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#footer_tr_<?= $k+1 ?>">
                            <td><?= $v['name'] ?></td>
                            <td><?= $v['text'] ?></td>
                        </tr>

                        <tr id="footer_tr_<?= $k+1 ?>" class="collapse" >
                            <td colspan="2">
                                <a href="/settings/edit-footer?id=<?= $v['id'] ?>" class="btn btn-primary">Редактировать</a>
                                <a href="/settings/delete-footer?id=<?= $v['id'] ?>" onclick="return confirm('Вы уверены что хотите удалить <?= $v['name'] ?>')" class="btn btn-danger delete">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>










</div>