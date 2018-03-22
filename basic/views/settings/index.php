<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;

//use dosamigos\ckeditor\CKEditor;
//use app\components\dosamigos\ckeditor\CKEditor;

use yii\widgets\Pjax;

$this->title = 'Настройки';

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
            <p>Основные данные</p>
        </div>
        <div class="panel-body">
            <div class="margin_bottom">
                <a href="/settings/edit-main-settings" class="btn btn-primary">Редактировать</a>
            </div>


            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>Имя Директора</th>
                        <th>Название предприятия</th>
                        <th>ЭДРПОУ</th>
                        <th>ИПН</th>
                        <th>Свидетельство №</th>
                        <th>Юр. Адрес</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?= $main_settings_data['name_dir'] ?></td>
                        <td><?= $main_settings_data['name_firm'] ?></td>
                        <td><?= $main_settings_data['edrpo'] ?></td>
                        <td><?= $main_settings_data['ipn'] ?></td>
                        <td><?= $main_settings_data['certificate'] ?></td>
                        <td><?= $main_settings_data['adress'] ?></td>
                    </tr>

                    </tbody>
                </table>
            </div>


        </div>
    </div>


    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Единици измерения</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'unit_add']); ?>

            <div class="margin_bottom">
                <button class="btn btn-success" data-toggle="collapse" data-target="#add_unit">Добавить единици
                    измерения
                </button>
            </div>
            <div id="add_unit" class="collapse">

                <?php $form_unit_add = ActiveForm::begin([
                    'id' => 'unitAddForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],

                ]); ?>


                <?= $form_unit_add->field($UnitAddForm, 'name')->label('Новая единица измерения') ?>


                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary btn-block', 'name' => 'unit-add-button', 'id' => 'unit-add-id',]) ?>
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
                    <?php foreach ($units_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#unit_tr_<?= $k + 1 ?>">
                            <td><?= $k + 1 ?></td>
                            <td><?= $v['name'] ?></td>
                        </tr>

                        <tr id="unit_tr_<?= $k + 1 ?>" class="collapse">
                            <td colspan="2">
                                <a href="/settings/edit-unit?id=<?= $v['id'] ?>"
                                   class="btn btn-primary">Редактировать</a>
                                <a href="/settings/delete-unit?id=<?= $v['id'] ?>"
                                   onclick="return confirm('Вы уверены что хотите удалить <?= $v['name'] ?>')"
                                   class="btn btn-danger">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>


            <?php Pjax::end(); ?>
        </div>
    </div>


    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Хедеры</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'header_add']); ?>

            <div class="margin_bottom">
                <button class="btn btn-success" data-toggle="collapse" data-target="#add_header">Добавить новый хедер
                </button>
            </div>
            <div id="add_header" class="collapse">

                <?php $form_header_add = ActiveForm::begin([
                    'id' => 'headerAddForm',
                    'options' => ['data-pjax' => false],
                    //   'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-12 col-md-12 col-sm-12\">{input}</div>\n<div class=\"col-lg-12 col-md-12 col-sm-12\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label'],
                    ],

                ]); ?>


                <?= $form_header_add->field($HeaderAddForm, 'name')->label('Имя хедера') ?>
                <?= $form_header_add->field($HeaderAddForm, 'text')->textarea(['rows' => 5, 'id' => 'text_header'])->label('Текст хедера') ?>
                <?= $form_header_add->field($HeaderAddForm, 'footer_header')->hiddenInput(['value' => 1])->label(false) ?>
                <script type="text/javascript">
                    CKEDITOR.replace('text_header');
                </script>

                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary btn-block', 'name' => 'header-add-button', 'id' => 'header-add-id',]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>


            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Текст хедера</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($headers_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#header_tr_<?= $k + 1 ?>">
                            <td><?= $v['name'] ?></td>
                            <td><?= $v['text'] ?></td>
                        </tr>

                        <tr id="header_tr_<?= $k + 1 ?>" class="collapse">
                            <td colspan="2">
                                <a href="/settings/edit-header?id=<?= $v['id'] ?>"
                                   class="btn btn-primary">Редактировать</a>
                                <a href="/settings/delete-header?id=<?= $v['id'] ?>"
                                   onclick="return confirm('Вы уверены что хотите удалить <?= $v['name'] ?>')"
                                   class="btn btn-danger delete">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>


    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Футеры</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'header_add']); ?>

            <div class="margin_bottom">
                <button class="btn btn-success" data-toggle="collapse" data-target="#add_footer">Добавить новый футер
                </button>
            </div>
            <div id="add_footer" class="collapse">

                <?php $form_footer_add = ActiveForm::begin([
                    'id' => 'footerAddForm',
                    'options' => ['data-pjax' => false],
                    //  'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-12 col-md-12 col-sm-12\">{input}</div>\n<div class=\"col-lg-12 col-md-12 col-sm-12\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label'],
                    ],

                ]); ?>


                <?= $form_footer_add->field($FooterAddForm, 'name')->label('Имя футера') ?>
                <?= $form_footer_add->field($FooterAddForm, 'text')->textarea(['rows' => 5, 'id' => 'text_footer'])->label('Текст футера') ?>
                <?= $form_footer_add->field($FooterAddForm, 'footer_header')->hiddenInput(['value' => 2])->label(false) ?>
                <script type="text/javascript">
                    CKEDITOR.replace('text_footer');
                </script>

                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary btn-block', 'name' => 'header-add-button', 'id' => 'header-add-id',]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>


            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Текст футера</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($footers_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#footer_tr_<?= $k + 1 ?>">
                            <td><?= $v['name'] ?></td>
                            <td><?= $v['text'] ?></td>
                        </tr>

                        <tr id="footer_tr_<?= $k + 1 ?>" class="collapse">
                            <td colspan="2">
                                <a href="/settings/edit-footer?id=<?= $v['id'] ?>"
                                   class="btn btn-primary">Редактировать</a>
                                <a href="/settings/delete-footer?id=<?= $v['id'] ?>"
                                   onclick="return confirm('Вы уверены что хотите удалить <?= $v['name'] ?>')"
                                   class="btn btn-danger delete">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>


    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Количество элементов на странице</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'settings']); ?>


            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Значение</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(isset($settings_data[1])):
                    foreach ($settings_data[1] as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#setting_tr_1_<?= $k + 1 ?>">
                            <td><?= $v['name'] ?></td>
                            <td><?= $v['value'] ?></td>
                        </tr>

                        <tr id="setting_tr_1_<?= $k + 1 ?>" class="collapse">
                            <td colspan="2">
                                <a href="/settings/edit-setting?key=<?= $v['key'] ?>"
                                   class="btn btn-primary">Изменить</a>
                            </td>
                        </tr>
                    <?php endforeach;
                    endif;
                    ?>

                    </tbody>
                </table>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>




    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Значения по умолчанию</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'settings-default']); ?>


            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>Параметр</th>
                        <th>Значение</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    if(isset($settings_data[2])):
                    foreach ($settings_data[2] as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#setting_tr_2_<?= $k + 1 ?>">
                            <td><?= $v['name'] ?></td>
                            <?php if($v['key'] == 'default_unit'): ?>
                                <td><?= isset($units_id_name_array[$v['value']])? $units_id_name_array[$v['value']]: '';  ?></td>
                                <?php elseif($v['key'] == 'default_header'): ?>
                                <td><?= isset($headers_id_name_array[$v['value']])? $headers_id_name_array[$v['value']] : '';  ?></td>
                                <?php elseif($v['key'] == 'default_footer'): ?>
                                <td><?= isset($footers_id_name_array[$v['value']])? $footers_id_name_array[$v['value']] : '';  ?></td>
                                <?php else: ?>
                                <td><?= $v['value'] ?></td>
                            <?php endif; ?>

                        </tr>

                        <tr id="setting_tr_2_<?= $k + 1 ?>" class="collapse">
                            <td colspan="2">
                                <a href="/settings/edit-setting?key=<?= $v['key'] ?>"
                                   class="btn btn-primary">Изменить</a>
                            </td>
                        </tr>
                    <?php endforeach;
                    endif;
                    ?>

                    </tbody>
                </table>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>










    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Логотип</p>
        </div>
        <div class="panel-body">

            <div class="margin_bottom">
                <a href="/settings/edit-logo" class="btn btn-primary">Изменить логотип</a>
            </div>
            <?php $logo_url = !empty($logo_data)? $logo_data[0]['url'] : ''; ?>
                <div class=" col-lg-12 col-md-12 col-sm-12 logo-preview">
                    <img class="" src="/<?= $logo_url ?>" alt="">
                </div>


        </div>
    </div>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Услуги с дополнительной информацией</p>
        </div>
        <p>Услуги к названию которых добавляется месяц и год. [Название услуги]+[месяц]+[год]</p>
        <p>Например: "Тестовая услуга сентябрь 2017"</p>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'month_year_add']); ?>

            <div class="margin_bottom">
                <button class="btn btn-success" data-toggle="collapse" data-target="#month_year_services">Добавить к услуге месяц и год
                </button>
            </div>
            <div id="month_year_services" class="collapse">

                <?php $form_month_year_services = ActiveForm::begin([
                    'id' => 'monthYearServicesForm',
                    'options' => ['data-pjax' => false],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-4\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-sm-4 control-label'],
                    ],

                ]); ?>


                <?= $form_month_year_services->field($MonthYearServicesForm, 'services_id')->dropDownList($services_id_name_select, ['prompt' => 'Выберите услугу'])->label('Услуги') ?>


                <div class="form-group">
                    <div class="col-lg-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-4">
                        <?= Html::submitButton("Добавить", ['class' => 'btn btn-primary btn-block', 'name' => 'month-year-add-button', 'id' => 'month-year-add-id',]) ?>
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
                    <?php foreach ($services_with_monthyear_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#month_year_services_<?= $k + 1 ?>">
                            <td><?= $k + 1 ?></td>
                            <td><?= $v['name'] ?></td>
                        </tr>

                        <tr id="month_year_services_<?= $k + 1 ?>" class="collapse">
                            <td colspan="2">
                                <a href="/settings/delete-month-year-services?id=<?= $v['id'] ?>"
                                   onclick="return confirm('Вы уверены что хотите удалить подпись месяца и года для усгуги <?= $v['name'] ?>')"
                                   class="btn btn-danger">Удалить подпись месяца и года у выбранной услуги</a>
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