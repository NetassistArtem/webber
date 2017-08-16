<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;

$this->title = 'Редактирование футера';

$this->registerJsFile(
    'js/ckeditor/ckeditor.js',
    ['depends' => 'app\assets\AppAsset',
        'position' => \yii\web\View::POS_HEAD]
);

?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Редактирование - <?= $footer->name ?></p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'footer-edit']); ?>



                <?php $form_footer_edit = ActiveForm::begin([
                    'id' => 'footerAddForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-8 col-md-8 col-sm-8\">{input}</div>\n<div class=\"col-lg-2 col-md-2 col-sm-2\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-2 col-md-2 col-sm-2 control-label'],
                    ],

                ]); ?>
            <?= $form_footer_edit->field($FooterEditForm, 'id')->hiddenInput(['value' => $footer->id])->label(false) ?>
            <?= $form_footer_edit->field($FooterEditForm, 'name')->textInput(['value' => $footer->name])->label('Имя футера') ?>
            <?= $form_footer_edit->field($FooterEditForm, 'text')->textarea(['rows' => 5, 'id'=>'text_footer', 'value' => $footer->text])->label('Текст футера') ?>
            <?= $form_footer_edit->field($FooterEditForm, 'footer_header')->hiddenInput(['value'=>$footer->footer_header])->label(false) ?>
            <script type="text/javascript">
                CKEDITOR.replace( 'text_footer' );
            </script>


                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Изменить", ['class' => 'btn btn-primary btn-block', 'name' => 'header-edit-button', 'id' => 'header-edit-id', ]) ?>
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
