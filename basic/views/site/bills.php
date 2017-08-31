<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = 'Счета';

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Список счетов</p>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'bills_add']); ?>

            <div class="margin_bottom">
                <a class="btn btn-success" href="/bills/add-bill-main" >Новый счет</a>
            </div>


            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>Номер счета</th>
                        <th>Дата</th>
                        <th>Платильщик</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($bills_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#bills_tr_<?= $k+1 ?>">
                            <td><?= $v['bill_id'] ? $v['bill_id'] : 'Нет данных' ?></td>
                            <td><?= $v['date']? Yii::$app->formatter->asDate($v['date'], 'dd.MM.yyyy')  : 'Нет данных' ?></td>
                            <td><?= $v['payer_id']? $payers_id_name[$v['payer_id']] : '<span class="badge  badge-danger" >Нет платильщика</span>'  ?>
                                <?= $v['services_id']? '' : '<span class="badge  badge-danger badge-danger-custom" >Нет услуг</span>'  ?>
                                <?php if($v['services_id']): ?>

                                <?= ($v['units_id'] != -1 && $v['quantity'] != -1 && $v['prices'] != -1)? '' : '<span class="badge  badge-danger badge-danger-custom-2" >Не все данные в услугах</span>'  ?>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr id="bills_tr_<?= $k+1 ?>" class="collapse" >
                            <td colspan="3">
                                <a href="/bills/edit-bill-main?id=<?= $v['id'] ?>" class="btn btn-primary">Редактировать</a>
                                <a href="/bills/bill-view?id=<?= $v['id'] ?>"  class="btn btn-success">Просмотреть счет</a>
                                <a href="/bills/bill_print?id=<?= $v['id'] ?>"  class="btn btn-success">Распечатать счет</a>
                                <a href="/bills/bill_act_print?id=<?= $v['id'] ?>"  class="btn btn-success">Распечатать акт</a>
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