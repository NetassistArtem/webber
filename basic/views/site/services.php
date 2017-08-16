<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = 'Услуги';

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Список услуг</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'services_add']); ?>

            <div class="margin_bottom">
                <button class="btn btn-success" data-toggle="collapse" data-target="#add_services">Добавить услугу</button>
            </div>
            <div id="add_services" class="collapse">

                <?php $form_service_add = ActiveForm::begin([
                    'id' => 'servicesAddForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-8 col-md-8 col-sm-8\">{input}</div>\n<div class=\"col-lg-2 col-md-2 col-sm-2\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-2 col-md-2 col-sm-2 control-label'],
                    ],

                ]); ?>


                <?= $form_service_add->field($ServiceAddForm, 'name')->label('Имя услги') ?>


                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary btn-block', 'name' => 'services-add-button', 'id' => 'services-add-id', ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>





            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Название</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($services_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#service_tr_<?= $k+1 ?>">
                            <td><?= $k+1 ?></td>
                            <td><?= $v['name'] ?></td>
                        </tr>

                        <tr id="service_tr_<?= $k+1 ?>" class="collapse" >
                            <td colspan="2">
                                <a href="/services/edit-service?id=<?= $v['id'] ?>" class="btn btn-primary">Редактировать</a>
                                <a href="/services/delete-service?id=<?= $v['id'] ?>" onclick="return confirm('Вы уверены что хотите удалить <?= $v['name'] ?>')" class="btn btn-danger">Удалить</a>
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