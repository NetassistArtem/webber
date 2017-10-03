<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;

$this->title = 'Редактирование настроек';

?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Редактирование - <?= $setting->name ?></p>
        </div>
        <div class="panel-body">

                <?php Pjax::begin(['id' => 'setting-edit']); ?>



                <?php $form_setting_edit = ActiveForm::begin([
                    'id' => 'settingEditForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],

                ]); ?>


                <?= $form_setting_edit->field($SettingsEditForm, 'value')->label('Единица измерения')->textInput(['value' => $setting->value]) ?>
                <?= $form_setting_edit->field($SettingsEditForm, 'key')->hiddenInput(['value' => $setting->key])->label(false) ?>

                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Изменить", ['class' => 'btn btn-primary btn-block', 'name' => 'setting-edit-button', 'id' => 'setting-edit-id', ]) ?>
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