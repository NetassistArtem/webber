<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use app\models\Bills;


$this->title = 'Счета';
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Список счетов</p>
        </div>
        <div class="panel-body">


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

                    <?php foreach($bills_data_page as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#bills_tr_<?= $k+1 ?>">
                            <td><?= $v['bill_id'] ? Bills::toSmallDateFormat($v['bill_id']) : 'Нет данных' ?></td>
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
                                <a href="/bills/bill-print?id=<?= $v['id']?>"  class="btn btn-success">Распечатать счет</a>
                                <a href="/bills/act-print?id=<?= $v['id'] ?>"  class="btn btn-success">Распечатать акт</a>
                                <a href="/bills/act-view?bill_id=<?= $v['bill_id'] ?>"  class="btn btn-success">Просмотреть акт</a>
                                <a href="/bills/act-edit?bill_id=<?= $v['bill_id'] ?>"  class="btn btn-success">Редактировать акт</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>




            <div class="col-lg-12 col-md-12 col-sm-12 pagination-custom">
                <?php echo LinkPager::widget([
                    'pagination' => $pages,
                ]); ?>

            </div>

        </div>
    </div>


</div>