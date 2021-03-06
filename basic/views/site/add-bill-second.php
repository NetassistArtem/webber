<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->registerJsFile(
    'js/collapseService.js',
    ['depends' => 'app\assets\AppAsset']
);
$this->registerJsFile(
    'js/insertNds.js',
    ['depends' => 'app\assets\AppAsset']
);

if(!$edit){
    $this->title = 'Новый счет';
}else{
    $this->title = 'Редактирование счета №'.$bill_id;
}


?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(!$edit): ?>
    <div class="margin-badge">
        <span ><span class="badge badge-pill" >1</span> Добавление основных данных</span>
        <span class="glyphicon glyphicon-chevron-right" ></span>
        <span class="badge-active-font" ><span class="badge badge-pill badge-active" >2</span> Добавление услуг</span>
    </div>
    <?php else:?>
        <div class="margin-badge">
            <span ><span class="badge badge-pill" >1</span> Редактирование основных данных</span>
            <span class="glyphicon glyphicon-chevron-right" ></span>
            <span class="badge-active-font" ><span class="badge badge-pill badge-active" >2</span> Редактирование услуг</span>
        </div>

    <?php endif; ?>
    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Добавление / редактирование услуг</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'bills_add']); ?>




                <div class="table-responsive saved-services-block">
                    <h3>Сохраненные услуги</h3>

                    <table id="table-services" class="table table-bordered table-hover table-border-custom">
                        <thead class="table-service-thead">
                        <tr>
                            <th>Услуга</th>
                            <th>Единици измерения</th>
                            <th>Цена, грн.</th>
                            <th>Количество</th>

                            <th class="collapse-th-td">Стоимость, грн.</th>
                            <th class="collapse-th-td">НДС, грн.</th>
                            <th class="collapse-th-td">Стоимость с НДС, грн.</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($bill_services['services'][0]):


                        $all_sum = '';
                        $all_nds = '';
                        $all_price_sum_nds = '';

                        foreach ($bill_services['services'] as $k => $v): ?>
                            <?php $sum = ($bill_services['quantity'][$k] == -1 ? 0 : $bill_services['quantity'][$k]) * ($bill_services['prices'][$k] == -1 ? 0 : $bill_services['prices'][$k]);
                            $nds =  $sum / 5;
                            $price_sum_nds = $sum + $nds;
                            $all_sum += $sum;
                            $all_nds += $nds;
                            $all_price_sum_nds += $price_sum_nds;
                            ?>
                            <tr id="service_<?= $k + 1 ?>" data-toggle="collapse"
                                data-target="#service_tr_<?= $k + 1 ?>">
                                <?php if($v): ?>
                                    <td><?= isset($services_data[$v]) ? $services_data[$v] : $services_arhive_data[$v]. ' <span class="badge  badge-danger" >Услуга удалена</span>' ?></td>
                                    <?php else: ?>
                                    <td><span class="badge  badge-danger" >Нет данных</span></td>
                                <?php endif; ?>


                                <?php if($bill_services['units'][$k] != -1): ?>
                                    <td><?= isset($units_data[$bill_services['units'][$k]]) ? $units_data[$bill_services['units'][$k]] : $units_arhive_data[$bill_services['units'][$k]]. ' <span class="badge  badge-danger" >Единица удалена</span>' ?></td>
                                <?php else: ?>
                                    <td><span class="badge  badge-danger" >Нет данных</span></td>
                                <?php endif; ?>


                                <td><?= $bill_services['prices'][$k] != -1 ? $bill_services['prices'][$k] : '<span class="badge  badge-danger" >Нет данных</span>' ?></td>
                                <td><?= $bill_services['quantity'][$k] != -1 ? $bill_services['quantity'][$k] : '<span class="badge  badge-danger" >Нет данных</span>' ?></td>

                                <td class="collapse-th-td"><?= number_format($sum, 2, '.', ''); ?></td>
                                <td class="collapse-th-td"><?= number_format($nds, 2, '.', ''); ?></td>
                                <td class="collapse-th-td"><?= number_format($price_sum_nds, 2, '.', ''); ?></td>
                            </tr>

                            <tr id="service_change_<?= $k + 1 ?>" class="collapse">
                                <td colspan="4">


                                    <?php $form_bill_edit_second = ActiveForm::begin([
                                        'id' => 'billAddForm',
                                        'options' => ['data-pjax' => false],
                                        'layout' => 'horizontal',
                                        'fieldConfig' => [
                                            'template' => "{label}\n<div class=\"col-lg-12 col-md-12 col-sm-12\">{input}</div>\n<div class=\"col-lg-2 col-md-2 col-sm-2\">{error}</div>",
                                            'labelOptions' => ['class' => 'control-label'],
                                        ],

                                    ]); ?>


                                    <table
                                        class="table table-bordered table-hover table-border-custom table-edit-services">
                                        <thead class="table-service-edit-thead">
                                        <tr>
                                            <th>Услуга</th>
                                            <th>Единици измерения</th>
                                            <th>Цена, грн.</th>
                                            <th>Количество</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <?php
                                                $BillAddSecondForm->services_id = $v;
                                                echo $form_bill_edit_second->field($BillAddSecondForm, 'services_id')->dropDownList($services_id_name_select, ['prompt' => 'Выберите услугу'])->label(false) ?>
                                            </td>
                                            <td>
                                                <?php $BillAddSecondForm->units_id = $bill_services['units'][$k];
                                                echo $form_bill_edit_second->field($BillAddSecondForm, 'units_id')->dropDownList($units_id_name_select, ['prompt' => 'Выберите единици'])->label(false) ?>
                                            </td>
                                            <td>
                                                <p>Без НДС</p>
                                                <?php $p = $bill_services['prices'][$k] != -1 ? $bill_services['prices'][$k] : '';
                                                echo $form_bill_edit_second->field($BillAddSecondForm, 'prices')->label(false)->input('number', ['value' => $p, 'step' => '0.01', 'class'=> 'form-control insertNdsValueEdit', 'onkeyup' => 'insertNds("insertNdsValueEdit", "price-nds-edit");']);
                                                ?>
                                                <p>С НДС</p>
                                                <div id="price-nds-edit" class="form-control inactive-form-control" >

                                                </div>

                                            </td>
                                            <td>
                                                <?php $q = $bill_services['quantity'][$k] != -1 ? $bill_services['quantity'][$k] : '';
                                                echo $form_bill_edit_second->field($BillAddSecondForm, 'quantity')->label(false)->input('number', ['value' => $q]);
                                                echo $form_bill_edit_second->field($BillAddSecondForm, 'services_bill_id')->hiddenInput(['value' => $bill_services['services_bill_id'][$k]])->label(false);
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary', 'name' => 'edit-service', 'value' => 1]) ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <?php ActiveForm::end(); ?>

                                </td>
                            </tr>


                            <tr id="service_tr_<?= $k + 1 ?>" class="collapse">
                                <td colspan="4">
                                    <button class="btn btn-primary col-lg-3 col-md-3 col-sm-3 "
                                            onclick="hideService(<?= $k + 1 ?>)" data-toggle="collapse"
                                            data-target="#service_change_<?= $k + 1 ?>">Редактировать
                                    </button>
                                    <?php $form_bill_delete_second = ActiveForm::begin([
                                        'id' => 'serviceDeleteForm',
                                        'options' => ['data-pjax' => false,
                                            'class' => 'col-lg-3 col-md-3 col-sm-3',
                                        ],


                                    ]);

                                    echo $form_bill_edit_second->field($BillAddSecondForm, 'services_bill_id')->hiddenInput(['value' => $bill_services['services_bill_id'][$k]])->label(false);
                                    ?>
                                    <?= Html::submitButton("Удалить", ['class' => 'btn btn-danger', 'name' => 'delete-service', 'value' => 1]) ?>
                                    <?php ActiveForm::end(); ?>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <th colspan="7" class="centre" ><span class="badge badge-warning">Нет сохраненных услуг</span></th>


                            </tr>
                        <?php endif; ?>

                        </tbody>
                    </table>
                </div>




            <div class="row">
                <?php $form_bill_add_second = ActiveForm::begin([
                    'id' => 'billAddForm',
                    'options' => ['data-pjax' => false,
                        'class' => "col-lg-9 col-md-9 col-sm-9"],
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-7 col-md-7 col-sm-7\">{input}</div>\n<div class=\"col-lg-2 col-md-2 col-sm-2\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-3 control-label'],
                    ],

                ]); ?>



                <?php $BillAddSecondForm->services_id = '';
                echo $form_bill_add_second->field($BillAddSecondForm, 'services_id')->dropDownList($services_data, ['prompt' => 'Выберите услугу'])->label('Услуги');
                $BillAddSecondForm->units_id = $settings_data['default_unit'];
                echo $form_bill_add_second->field($BillAddSecondForm, 'units_id')->dropDownList($units_data, ['prompt' => 'Выберите единици'])->label('Единици измерения') ?>
                <?=$form_bill_add_second->field($BillAddSecondForm, 'quantity')->label('Количество')->input('number',['value' =>$settings_data['default_quantity']['value']]) ?>
                <?= $form_bill_add_second->field($BillAddSecondForm, 'prices')->label('Цена (Без НДС)')->input('number', ['step' => '0.01', 'class'=> 'form-control insertNdsValue', 'onkeyup' => 'insertNds("insertNdsValue", "price-nds");']) ?>
                <div class="row" >
                    <div class="col-lg-3 col-md-3 col-sm-3 control-label" >
                        <p>Цена с НДС</p>

                    </div>
                    <div  class="col-lg-2 col-md-2 col-sm-2 " >
                        <div id="price-nds" class="form-control inactive-form-control" >

                        </div>

                    </div>
                </div>





                <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary', 'name' => 'save-service', 'value' => 1, 'id' => 'save-service',]) ?>
                <?= Html::submitButton("Добавить еще услугу", ['class' => 'btn btn-primary', 'name' => 'more-service', 'value' => 1, 'id' => 'more-service',]) ?>
                <a href="/bills/bill-view?bill_id=<?= $bill_id ?>" class="btn btn-success">Перейти к сохраненному счету</a>


                <?php ActiveForm::end(); ?>

                <?php if ($bill_services['services'][0]): ?>
              <div class="col-lg-3 col-md-3 col-sm-3">
                <table id="table-result" class="table table-bordered table-hover table-border-custom" >
                    <thead></thead>
                    <tbody>
                    <tr>
                        <td>Сумма</td>
                        <td><?= number_format($all_sum, 2, '.', ''); ?></td>
                    </tr>
                    <tr>
                        <td>НДС</td>
                        <td><?= number_format($all_nds, 2, '.', ''); ?></td>
                    </tr>
                    <tr>
                        <td>К оплате</td>
                        <td><?= number_format($all_price_sum_nds, 2, '.', ''); ?></td>
                    </tr>
                    </tbody>
                </table>
              </div>
                <?php endif; ?>

            </div>


            <?php Pjax::end(); ?>
        </div>
    </div>


</div>