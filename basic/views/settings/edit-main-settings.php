<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;

$this->title = 'Редактирование основных данных';

?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Редактирование</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'unit-edit']); ?>



            <?php $form_main_settings_edit = ActiveForm::begin([
                'id' => 'MainSettingsEditForm',
                'options' => ['data-pjax' => false],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                ],

            ]); ?>


            <?= $form_main_settings_edit->field($MainSettingsEditForm, 'name_dir')->label('Имя директора')->textInput(['value' => $main_settings_data->name_dir]) ?>
            <?= $form_main_settings_edit->field($MainSettingsEditForm, 'name_firm')->label('Название предприятия')->textInput(['value' => $main_settings_data->name_firm]) ?>
            <?= $form_main_settings_edit->field($MainSettingsEditForm, 'edrpo')->label('ЭДРПОУ')->textInput(['value' => $main_settings_data->edrpo]) ?>
            <?= $form_main_settings_edit->field($MainSettingsEditForm, 'ipn')->label('ИПН')->textInput(['value' => $main_settings_data->ipn]) ?>
            <?= $form_main_settings_edit->field($MainSettingsEditForm, 'certificate')->label('Свидетельство №')->textInput(['value' => $main_settings_data->certificate]) ?>
            <?= $form_main_settings_edit->field($MainSettingsEditForm, 'adress')->label('Юридический адрес')->textInput(['value' => $main_settings_data->adress]) ?>

            <div class="form-group">
                <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                    <?= Html::submitButton("Изменить", ['class' => 'btn btn-primary btn-block', 'name' => 'settings-edit-button', 'id' => 'settings-edit-id', ]) ?>
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
