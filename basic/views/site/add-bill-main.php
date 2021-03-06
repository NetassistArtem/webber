<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = 'Новый счет';

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="margin-badge">
        <span class="badge-active-font" ><span class="badge badge-pill badge-active" >1</span> Добавление основных данных</span>
        <span class="glyphicon glyphicon-chevron-right" ></span>
        <span class="badge-inactive" ><span class="badge badge-pill" >2</span> Добавление услуг</span>
    </div>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Основные данные счета</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'bills_add']); ?>





                <?php $form_bill_add = ActiveForm::begin([
                    'id' => 'billAddForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-8 col-md-8 col-sm-8\">{input}</div>\n<div class=\"col-lg-2 col-md-2 col-sm-2\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-2 col-md-2 col-sm-2 control-label'],
                    ],

                ]); ?>



                <?= $form_bill_add->field($BillAddMainForm, 'date')->input('date',['value' => Yii::$app->formatter->asDate('now', 'dd-MM-yyyy')])->label('Дата') ?>


            <?='';//$form_bill_add->field($BillAddMainForm, 'payer_id')->dropDownList($payers_id_name, ['prompt' => 'Выберите клиента'])->label('Клиент') ?>
            <?= $form_bill_add->field($BillAddMainForm, 'payer_id')->input('text',['list'=> 'payers_list', 'autocomplete'=>"off"])->label('Клиент') ?>

            <datalist id="payers_list">
                <?php foreach($payers_id_name as $k => $v): ?>
                    <option value='<?= $v  ?>' />
                <?php endforeach; ?>

            </datalist>



            <?= $form_bill_add->field($BillAddMainForm, 'info')->textarea(['rows' => 3])->label('Дополнительная информация') ?>
                <?php $BillAddMainForm->header_id = $settings_data['default_header'];
                echo $form_bill_add->field($BillAddMainForm, 'header_id')->dropDownList($header_data, ['prompt' => 'Выберите хедер'])->label('Хедер счета') ?>
                <?php  $BillAddMainForm->footer_id = $settings_data['default_footer'];
                echo $form_bill_add->field($BillAddMainForm, 'footer_id')->dropDownList($footer_data, ['prompt' => 'Выберите футер'])->label('Футер счета') ?>




                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary btn-block', 'name' => 'bills-add-button', 'id' => 'bills-add-id', ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>




            <?php Pjax::end(); ?>
        </div>
    </div>


</div>