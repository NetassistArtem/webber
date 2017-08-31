<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = 'Редактирование счета №'.$bill_data['bill_id'];

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Основные данные счета</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'bill_edit']); ?>




            <?php $form_bill_edit = ActiveForm::begin([
                'id' => 'billEditMainForm',
                'options' => ['data-pjax' => false],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-8 col-md-8 col-sm-8\">{input}</div>\n<div class=\"col-lg-2 col-md-2 col-sm-2\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 col-md-2 col-sm-2 control-label'],
                ],

            ]); ?>



            <?= $form_bill_edit->field($BillEditMainForm, 'date')->input('date',['value' => Yii::$app->formatter->asDate($bill_data['date'], 'yyyy-MM-dd')])->label('Дата') ?>
            <?php $BillEditMainForm->payer_id = $bill_data['payer_id'];
            echo $form_bill_edit->field($BillEditMainForm, 'payer_id')->dropDownList($payers_id_name, ['prompt' => 'Выберите клиента'])->label('Клиент') ?>
            <?= $form_bill_edit->field($BillEditMainForm, 'info')->textarea(['rows' => 3, 'value' => $bill_data['info']])->label('Дополнительная информация') ?>
            <?php $BillEditMainForm->header_id = $bill_data['header_id'];
            echo $form_bill_edit->field($BillEditMainForm, 'header_id')->dropDownList($header_data, ['prompt' => 'Выберите хедер'])->label('Хедер счета') ?>
            <?php $BillEditMainForm->footer_id = $bill_data['footer_id'];
            echo $form_bill_edit->field($BillEditMainForm, 'footer_id')->dropDownList($footer_data, ['prompt' => 'Выберите футер'])->label('Футер счета');
            echo $form_bill_edit->field($BillEditMainForm, 'id')->hiddenInput(['value' => $bill_data['id']])->label(false);
            ?>






                    <?= Html::submitButton("Сохранить и выйти", ['class' => 'btn btn-primary ', 'name' => 'bills-edit-button', 'id' => 'bill-edit-id', 'value' =>1 ]) ?>
                    <?= Html::submitButton("Сохранить и редактировать услуги", ['class' => 'btn btn-primary', 'name' => 'bills-edit-next-button', 'id' => 'bill-edit-next-id', 'value' =>1 ]) ?>
                    <a href="/bills" class="btn btn-success">Вернуться к списку счетов</a>


            <?php ActiveForm::end(); ?>




            <?php Pjax::end(); ?>
        </div>
    </div>


</div>