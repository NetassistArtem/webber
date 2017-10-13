<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;
Pjax::begin(['id' => 'bill_edit']);
$this->title = 'Редактирование счета №'.$bill_data['bill_id'];

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="margin-badge">

            <span class="badge-active-font" ><span class="badge badge-pill badge-active" >1</span> Редактирование основных данных</span>

        <span class="glyphicon glyphicon-chevron-right" ></span>

            <span class="badge-inactive" ><span class="badge badge-pill" >2</span> Редактирование услуг</span>


    </div>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Основные данные счета</p>
        </div>
        <div class="panel-body">





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
            <?php $BillEditMainForm->payer_id = $bill_data['payer_id'] ?  $payers_id_name_select[$bill_data['payer_id']]: '';

            echo $form_bill_edit->field($BillEditMainForm, 'payer_id')->input('text',['list'=> 'payers_list', 'autocomplete' => "off"])->label('Клиент');
            //echo $form_bill_edit->field($BillEditMainForm, 'payer_id')->dropDownList($payers_id_name, ['prompt' => 'Выберите клиента'])->label('Клиент') ?>
            <datalist id="payers_list">
                <?php foreach($payers_id_name_select as $k => $v): ?>
                    <option value='<?= $v  ?>' />
                <?php endforeach; ?>

            </datalist>



            <?= $form_bill_edit->field($BillEditMainForm, 'info')->textarea(['rows' => 3, 'value' => $bill_data['info']])->label('Дополнительная информация') ?>
            <?php $BillEditMainForm->header_id = $bill_data['header_id'];
            echo $form_bill_edit->field($BillEditMainForm, 'header_id')->dropDownList($header_id_name_select, ['prompt' => 'Выберите хедер'])->label('Хедер счета') ?>
            <?php $BillEditMainForm->footer_id = $bill_data['footer_id'];
            echo $form_bill_edit->field($BillEditMainForm, 'footer_id')->dropDownList($footer_id_name_select, ['prompt' => 'Выберите футер'])->label('Футер счета');
            echo $form_bill_edit->field($BillEditMainForm, 'id')->hiddenInput(['value' => $bill_data['id']])->label(false);
            ?>




            <?php if($prev_id): ?>
                <a href="/bills/edit-bill-main?id=<?= $first_id ?>" class="btn btn-success"><span class="glyphicon glyphicon-fast-backward" ></span><span class="player_text">FIRST</span></a>
                <a href="/bills/edit-bill-main?id=<?= $prev_id ?>" class="btn btn-success"><span class="glyphicon glyphicon-step-backward" ></span><span class="player_text">PREV</span></a>
            <?php else: ?>
                <a  class="btn btn-success" disabled><span class="glyphicon glyphicon-fast-backward" ></span><span class="player_text">FIRST</span></a>
                <a  class="btn btn-success" disabled><span class="glyphicon glyphicon-step-backward" ></span><span class="player_text">PREV</span></a>
            <?php endif;?>

            <a href="/bills" class="btn btn-success" ><span class="glyphicon glyphicon glyphicon-eject" ></span><span class="player_text">HOME</span></a>

            <?php if($next_id):?>
                <a href="/bills/edit-bill-main?id=<?= $next_id ?>" class="btn btn-success" ><span class="glyphicon glyphicon-step-forward" ></span><span class="player_text">NEXT</span></a>
                <a href="/bills/edit-bill-main?id=<?= $last_id ?>" class="btn btn-success" ><span class="glyphicon glyphicon-fast-forward" ></span><span class="player_text">LAST</span></a>
            <?php else: ?>
                <a  class="btn btn-success" disabled><span class="glyphicon glyphicon-step-forward" ></span><span class="player_text">NEXT</span></a>
                <a  class="btn btn-success" disabled><span class="glyphicon glyphicon-fast-forward" ></span><span class="player_text">LAST</span></a>
            <?php endif;?>


                    <?= Html::submitButton("Сохранить и выйти", ['class' => 'btn btn-primary ', 'name' => 'bills-edit-button', 'id' => 'bill-edit-id', 'value' =>1 ]) ?>
                    <?= Html::submitButton("Сохранить и редактировать услуги", ['class' => 'btn btn-primary', 'name' => 'bills-edit-next-button', 'id' => 'bill-edit-next-id', 'value' =>1 ]) ?>
                    <a href="/bills" class="btn btn-success">Вернуться к списку счетов</a>


            <?php ActiveForm::end(); ?>





        </div>
    </div>


</div>
<?php Pjax::end(); ?>