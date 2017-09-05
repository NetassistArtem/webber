
<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;


use app\components\debugger\Debugger;




?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>


    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<div class="container">
    <div>
        <?= $bill_data->header_id ? $header_data[$bill_data->header_id]['text'] : '<div class="bill-view-header-no" ><p>Нет хедера</p></div>'; ?>
    </div>
    <div class="bill_number"><p>Рахунок № <?= $bill_data->bill_id ?></p></div>
    <div class="bill_date"><p>від <?= Yii::$app->formatter->asDate($bill_data->date, 'yyyy-MM-dd') ?></p></div>
    <div>
        <table class="table table-responsive table-no-border">
            <tr>
                <td></td>
                <td><p>Платник:</p></td>
                <td>
                    <p><?= $bill_data->payer_id ? $payers_data[$bill_data->payer_id]['name'] : '<div class="bill-view-header-no" ><p>Нет платильщик</p></div>'; ?></p>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><p>Особа для контактів:</p></td>
                <td>
                    <?php if($bill_data->payer_id): ?>
                        <p><?= $payers_data[$bill_data->payer_id]['contact_person'] ? $payers_data[$bill_data->payer_id]['contact_person'] : '<span></span>'; ?></p>
                    <?php else: ?>
                        <span ></span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><p>Телефон/факс:</p></td>
                <td>
                    <?php if($bill_data->payer_id): ?>
                        <p><?= $payers_data[$bill_data->payer_id]['phone'] ? $payers_data[$bill_data->payer_id]['phone'] : '<span></span>'; ?></p>
                    <?php else: ?>
                        <span></span>
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
                    <p><?= $bill_data->info ? $bill_data->info : '<span></span>'; ?></p>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <?= $bill_data->footer_id ? $footer_data[$bill_data->footer_id]['text'] : '<div class="bill-view-header-no" ><p>Нет футера</p></div>'; ?>
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
