<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = '';


?>
<div class="site-about">
    <?php if($prev_id): ?>
    <a href="/bills/bill-view?id=<?= $prev_id ?>" class="btn btn-success"><span class="glyphicon glyphicon-chevron-left" ></span></a>
    <?php endif;
    if($next_id):?>
    <a href="/bills/bill-view?id=<?= $next_id ?>" class="btn btn-success"><span class="glyphicon glyphicon-chevron-right" ></span></a>
    <?php endif;?>
    <a href="/bills/edit-bill-main?id=<?= $bill_data['id'] ?>" class="btn btn-primary">Редактировать счет</a>
    <a href="/bills/bill-print?id=<?= $bill_data['id'] ?>"  class="btn btn-success">Распечатать счет</a>
    <a href="/bills/act-print?id=<?= $bill_data['id'] ?>"  class="btn btn-success">Распечатать акт</a>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
  //  Debugger::PrintR($bill_data);
    //Debugger::PrintR($payers_data);

    ?>
    <div id="header_main" >
        <?= $bill_data['header_id'] ? $header_data[$bill_data['header_id']]['text'] : '<div class="bill-view-header-no" ><p>Нет хедера</p></div>'; ?>
    </div>
    <div class="bill_number"><h3>Рахунок № <?= $bill_data['bill_id']?></h3></div>
    <div class="bill_date"><p>від <?= Yii::$app->formatter->asDate($bill_data['date'], 'yyyy-MM-dd') ?></p></div>
    <div>
        <table class="table table-responsive table-no-border">
            <tr>
                <td></td>
                <td><p>Платник:</p></td>
                <td>
                    <p><?= $bill_data['payer_id'] ? $payers_data[$bill_data['payer_id']]['name'] : '<div class="bill-view-header-no" ><p>Нет платильщик</p></div>'; ?></p>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><p>Особа для контактів:</p></td>
                <td>
                    <?php if($bill_data['payer_id']): ?>
                    <p><?= $payers_data[$bill_data['payer_id']]['contact_person'] ? $payers_data[$bill_data['payer_id']]['contact_person'] : '<span class="badge  badge-danger" >Нет данных</span>'; ?></p>
                        <?php else: ?>
                        <span class="badge  badge-danger" >Нет данных</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><p>Телефон/факс:</p></td>
                <td>
                    <?php if($bill_data['payer_id']): ?>
                    <p><?= $payers_data[$bill_data['payer_id']]['phone'] ? $payers_data[$bill_data['payer_id']]['phone'] : '<span class="badge  badge-danger" >Нет данных</span>'; ?></p>
                    <?php else: ?>
                        <span class="badge  badge-danger" >Нет данных</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    <div>

        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>№</th>
                <th>Найменування</th>
                <th>Од.вим.</th>
                <th>Кільк.</th>
                <th>Ціна,грв.</th>
                <th>Сумма, грв.</th>
            </tr>
            </thead>
            <tbody>

            <?php
            $all_sum = '';
            foreach ($services_bill_id_array as $k => $v):
                $sum = ($prices_array[$k] != -1 ? $prices_array[$k] : 0) * ($quantity_array[$k] != -1 ? $quantity_array[$k] : 0);
                $all_sum += $sum;
                ?>

                <tr>
                    <td><?= $v ?></td>

                    <td><?= $services_id_array[0] ? $services_data[$services_id_array[$k]]['name'] : '<span class="badge  badge-danger" >Нет данных</span>' ?></td>
                    <?php if ($services_id_array[0]): ?>
                        <td><?= $units_data[$units_id_array[$k]]['name'] != -1 ? $units_data[$units_id_array[$k]]['name'] : '<span class="badge  badge-danger" >Нет данных</span>' ?></td>
                        <td><?= $quantity_array[$k] != -1 ? $quantity_array[$k] : '<span class="badge  badge-danger" >Нет данных</span>' ?></td>
                        <td><?= $prices_array[$k] != -1 ? $prices_array[$k] : '<span class="badge  badge-danger" >Нет данных</span>' ?></td>
                        <td><?= $sum ?></td>
                    <?php else: ?>
                        <td><span class="badge  badge-danger">Нет данных</span></td>
                        <td><span class="badge  badge-danger">Нет данных</span></td>
                        <td><span class="badge  badge-danger">Нет данных</span></td>
                        <td><span class="badge  badge-danger">Нет данных</span></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            <tr class="table-no-border">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Сумма:</td>
                <td><?= $all_sum ?></td>
            </tr>
            <tr class="table-no-border">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>ПДВ:</td>
                <td><?= $all_sum / 5 ?></td>
            </tr>
            <tr class="table-no-border">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>До сплати:</td>
                <td><?= ($all_sum / 5) + $all_sum ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div>
        <table class="table table-responsive table-no-border">
            <tr>

                <td><p>Додаткова інформація:</p></td>
                <td>
                    <p><?= $bill_data['info'] ? $bill_data['info'] : '<span class="badge badge-warning" >Нет информации</span>'; ?></p>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <?= $bill_data['footer_id'] ? $footer_data[$bill_data['footer_id']]['text'] : '<div class="bill-view-header-no" ><p>Нет футера</p></div>'; ?>
    </div>


</div>

<script type="text/javascript">
    var ptch;
    ptch = document.querySelector('#header_main img').getAttribute('src');
    document.querySelector('#header_main img').setAttribute('src', '/'+ptch);
</script>