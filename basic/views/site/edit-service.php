<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;

$this->title = 'Редактирование услуги';

?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Редактирование - <?= $service->name ?></p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'service-edit']); ?>



                <?php $form_service_edit = ActiveForm::begin([
                    'id' => 'serviceAddForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-8 col-md-8 col-sm-8\">{input}</div>\n<div class=\"col-lg-2 col-md-2 col-sm-2\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-2 col-md-2 col-sm-2 control-label'],
                    ],

                ]); ?>


                <?= $form_service_edit->field($ServiceEditForm, 'name')->label('Название услуги')->textInput(['value' => $service->name]) ?>
            <?= $form_service_edit->field($ServiceEditForm, 'id')->hiddenInput(['value' => $service->id])->label(false) ?>

                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Изменить", ['class' => 'btn btn-primary btn-block', 'name' => 'service-edit-button', 'id' => 'service-edit-id', ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            <?php Pjax::end(); ?>

            <div class="margin_top">
                <a class="btn btn-info" href="/services" >Вернуться к списку услуг</a>
            </div>

        </div>

    </div>

</div>
