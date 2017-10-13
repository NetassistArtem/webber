<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\widgets\Pjax;

$this->title = 'Смена логотипа';

?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Смена логотипа</p>
        </div>
        <div class="panel-body">

            <div class="margin_bottom">
                <button class="btn btn-success" data-toggle="collapse" data-target="#load_logo">Загрузить изображение на сервер</button>
            </div>



            <div class="saved-services-block" >

            </div>








            <div id="load_logo" class="collapse">

                <?php $form_logo_load = ActiveForm::begin([
                    'id' => 'logoLoadForm',
                    'options' => ['data-pjax' => false , 'enctype' => 'multipart/form-data'],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],

                ]); ?>


                <?= $form_logo_load->field($LogoLoadForm, 'logo')->fileInput()->label('Изображение') ?>


                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Загрузить", ['class' => 'btn btn-primary btn-block', 'name' => 'logo-add-button', 'id' => 'logo-add-id',]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>









            <?php if(Yii::$app->session->hasFlash('failDeleteLogo')): ?>
            <div class="alert alert-danger" >
                <p><?= Yii::$app->session->getFlash('failDeleteLogo')['value']; ?></p>
            </div>
            <?php endif; ?>


            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>адрес</th>
                        <th>Изображение</th>
                        <th>Установленный логотип</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($logos_data as $k => $v): ?>
                        <?php $selected = $v['selected'] == 1 ? "<span class='glyphicon glyphicon-ok' ></span>" :'' ?>

                        <tr class="background<?=$v['selected'] ?>" data-toggle="collapse" data-target="#logo_tr_<?= $k + 1 ?>">
                            <td><?= $v['id'] ?></td>
                            <td><?= $v['url'] ?></td>
                            <td><img class="img-position-list" src="/<?= $v['url'] ?>" alt=""></td>
                            <td><?= $selected ?></td>
                        </tr>

                        <tr id="logo_tr_<?= $k + 1 ?>" class="collapse">
                            <td colspan="4">
                                <a href="/settings/change-logo?id=<?= $v['id'] ?>"
                                   class="btn btn-primary">Сохранить как новый логотип</a>
                                <a href="/settings/delete-logo?id=<?= $v['id'] ?>"
                                   onclick="return confirm('Вы уверены что хотите удалить изображение <?= $v['url'] ?>')"
                                   class="btn btn-danger delete">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>


        </div>
    </div>

</div>
