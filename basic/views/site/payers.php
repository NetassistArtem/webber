<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = 'Клиенты';

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Список клиентов</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'payers_add']); ?>

            <div class="margin_bottom">
                <button class="btn btn-success" data-toggle="collapse" data-target="#add_payers">Добавить клиента</button>
            </div>
            <div id="add_payers" class="collapse">

                <?php $form_payer_add = ActiveForm::begin([
                    'id' => 'payerAddForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-8 col-md-8 col-sm-8\">{input}</div>\n<div class=\"col-lg-2 col-md-2 col-sm-2\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-2 col-md-2 col-sm-2 control-label'],
                    ],

                ]); ?>


                <?= $form_payer_add->field($PayerAddForm, 'name')->label('Имя клиента') ?>
                <?= $form_payer_add->field($PayerAddForm, 'contact_person')->label('Контактное лицо') ?>
                <?= $form_payer_add->field($PayerAddForm, 'phone')->label('Телефоны') ?>
                <?= $form_payer_add->field($PayerAddForm, 'person_id')->label('ИП №') ?>
                <?= $form_payer_add->field($PayerAddForm, 'certificat_pdv_id')->label('Свидетельство платильщика НДС №') ?>
                <?= $form_payer_add->field($PayerAddForm, 'address_ur')->label('Адресс юредический') ?>
                <?= $form_payer_add->field($PayerAddForm, 'address_connection')->label('Адресс подключения') ?>
                <?= $form_payer_add->field($PayerAddForm, 'address_post')->label('Адрес почтовый') ?>
                <?= $form_payer_add->field($PayerAddForm, 'email')->label('E-mail') ?>
                <?= $form_payer_add->field($PayerAddForm, 'contract_id')->label('Номер договора') ?>
                <?= $form_payer_add->field($PayerAddForm, 'contract_date')->label('Дата договора') ?>


                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary btn-block', 'name' => 'payers-add-button', 'id' => 'payers-add-id', ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>





            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Имя клиента</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($payers_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#payer_tr_<?= $k+1 ?>">
                            <td><?= $k+1 ?></td>
                            <td><?= $v['name'] ?></td>
                        </tr>

                        <tr id="payer_tr_<?= $k+1 ?>" class="collapse" >
                            <td colspan="2">
                                <a href="/payers/edit-payer?id=<?= $v['id'] ?>" class="btn btn-primary">Редактировать</a>
                                <a href="/payers/delete-payer?id=<?= $v['id'] ?>" onclick="return confirm('Вы уверены что хотите удалить <?= $v['name'] ?>')" class="btn btn-danger">Удалить</a>
                                <a href="/payers/payer?id=<?= $v['id'] ?>"  class="btn btn-success">Детальнее</a>
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