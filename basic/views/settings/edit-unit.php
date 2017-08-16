<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;

$this->title = 'Редактирование единици измерения';

?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Редактирование - <?= $unit->name ?></p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'unit-edit']); ?>



                <?php $form_unit_edit = ActiveForm::begin([
                    'id' => 'unitAddForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],

                ]); ?>


                <?= $form_unit_edit->field($UnitEditForm, 'name')->label('Единица измерения')->textInput(['value' => $unit->name]) ?>
            <?= $form_unit_edit->field($UnitEditForm, 'id')->hiddenInput(['value' => $unit->id])->label(false) ?>

                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Изменить", ['class' => 'btn btn-primary btn-block', 'name' => 'unit-edit-button', 'id' => 'unit-edit-id', ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            <?php Pjax::end(); ?>

            <div class="margin_top">
                <a class="btn btn-info" href="/settings" >Вернуться к настройкам</a>
            </div>

        </div>

    </div>

</div>
