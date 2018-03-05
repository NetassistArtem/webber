<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = 'Редактирование клиента';

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Редактирование - <?= $payer->name ?></p>
        </div>
        <div class="panel-body">
            <?php if($payer->delete == 1): ?>
                <div class="alert alert-warning" >
                    Запрашиваемый клиент удален. Восстановить можно в разделе <b><a href="/arhive">Архив</a></b>.
                </div>
            <?php else: ?>

            <?php Pjax::begin(['id' => 'payer_edit']); ?>
            <div class="">
                <a class="btn btn-info" href="/payers" >Вернуться к списку клиентов</a>
                <a class="btn btn-info" href="/payers/payer?id=<?= $payer->id ?>" >Вернуться к "<?= $payer->name ?>"</a>
            </div>


                <?php $form_payer_edit = ActiveForm::begin([
                    'id' => 'payerEditForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-8 col-md-8 col-sm-8\">{input}</div>\n<div class=\"col-lg-2 col-md-2 col-sm-2\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-2 col-md-2 col-sm-2 control-label'],
                    ],

                ]); ?>

            <?= $form_payer_edit->field($PayerEditForm, 'id')->hiddenInput(['value' => $payer->id])->label(false) ?>
                <?= $form_payer_edit->field($PayerEditForm, 'name')->label('Имя клиента')->textInput(['value' => $payer->name]) ?>
                <?= $form_payer_edit->field($PayerEditForm, 'comment')->label('Комментарий')->textInput(['value' => $payer->comment]) ?>
                <?= $form_payer_edit->field($PayerEditForm, 'contact_person')->label('Контактное лицо')->textInput(['value' => $payer->contact_person]) ?>
                <?= $form_payer_edit->field($PayerEditForm, 'phone')->label('Телефоны')->textInput(['value' => $payer->phone]) ?>
                <?= $form_payer_edit->field($PayerEditForm, 'person_id')->label('ИП №')->textInput(['value' => $payer->person_id]) ?>
                <?= $form_payer_edit->field($PayerEditForm, 'certificat_pdv_id')->label('Свидетельство платильщика НДС №')->textInput(['value' => $payer->certificat_pdv_id]) ?>
            <?= $form_payer_edit->field($PayerEditForm, 'edrpo')->label('ЄДРПОУ')->textInput(['value' => $payer->edrpo]) ?>
                <?= $form_payer_edit->field($PayerEditForm, 'address_ur')->label('Адресс юредический')->textInput(['value' => $payer->address_ur]) ?>
                <?= $form_payer_edit->field($PayerEditForm, 'address_connection')->label('Адресс подключения')->textInput(['value' => $payer->address_connection]) ?>
                <?= $form_payer_edit->field($PayerEditForm, 'address_post')->label('Адрес почтовый')->textInput(['value' => $payer->address_post]) ?>
                <?= $form_payer_edit->field($PayerEditForm, 'email')->label('E-mail')->textInput(['value' => $payer->email]) ?>
                <?= $form_payer_edit->field($PayerEditForm, 'contract_id')->label('Номер договора')->textInput(['value' => $payer->contract_id]) ?>
                <?= $form_payer_edit->field($PayerEditForm, 'contract_date')->label('Дата договора')->textInput(['value' => $payer->contract_date]) ?>


                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary btn-block', 'name' => 'payers-add-button', 'id' => 'payers-add-id', ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>




            <?php Pjax::end(); ?>

           <?php endif; ?>

        </div>
    </div>


</div>