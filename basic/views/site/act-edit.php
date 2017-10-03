<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = 'Редактирование акта №'.($act_data['act_id']? $act_data['act_id'] : $act_data['bill_id']) ;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Данные для редактирования</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'act_edit']); ?>




            <?php $form_act_edit = ActiveForm::begin([
                'id' => 'actEditForm',
                'options' => ['data-pjax' => false],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-8 col-md-8 col-sm-8\">{input}</div>\n<div class=\"col-lg-2 col-md-2 col-sm-2\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 col-md-2 col-sm-2 control-label'],
                ],

            ]); ?>



            <?= $form_act_edit->field($ActEditForm, 'date')->input('date',['value' => $act_data['date']? Yii::$app->formatter->asDate($act_data['date'], 'yyyy-MM-dd'): ''])->label('Дата') ?>
            <?= $form_act_edit->field($ActEditForm, 'act_id')->textInput(['value' => $act_data['act_id']] )->label('Номер акта') ?>
            <?= $form_act_edit->field($ActEditForm, 'bill_id')->hiddenInput(['value' => $act_data['bill_id']])->label(false);
            ?>






            <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary ', 'name' => 'act-edit-button', 'id' => 'act-edit-id', 'value' =>1 ]) ?>
            <a href="/bills" class="btn btn-success">Перейти к списку счетов</a>
            <a href="/bills/act-view?bill_id=<?=$act_data['bill_id'] ?>" class="btn btn-success">Просмотреть акт</a>


            <?php ActiveForm::end(); ?>




            <?php Pjax::end(); ?>
        </div>
    </div>


</div>