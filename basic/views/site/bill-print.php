
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
    <link rel="stylesheet" href="css/site.css">
    <style>
        table.table-1 > tr , table.table-1 > td, table.table-1 > p {
            margin: 0;
            padding-bottom: 0;
            padding-top: 0;
            line-height: 1
        }
    </style>



    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<div class="container">
    <div id="header_main" >
        <?= $bill_data->header_id ? $header_data[$bill_data->header_id]['text'] : '<div class="bill-view-header-no" ><p>Нет хедера</p></div>'; ?>

    </div>
    <div class="bill_number" style="margin: 0; padding-bottom: 5px;padding-top: -80px;" ><p style="margin: 0">Рахунок № <?= $bill_data->bill_id ?></p></div>
    <div class="bill_date" style="margin: 0; padding-bottom: 5px;padding-top: -40px;"><p>від <?= Yii::$app->formatter->asDate($bill_data->date, 'yyyy-MM-dd') ?></p></div>
    <div>
        <table class="table table-sm table-no-border table-1" >
            <tr style="margin: 0; padding: 0;" >
                <td style="margin: 0; padding-bottom: 0;padding-top: 0;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 0;padding-top: 0;line-height: 1;" ><p style="margin: 0; padding: 0;" >Платник:</p></td>
                <td style="margin: 0; padding-bottom: 0;padding-top: 0;line-height: 1;" >
                    <p style="margin: 0; padding-bottom: 0;padding-top: 0;line-height: 1;" ><?= $bill_data->payer_id ? $payers_data[$bill_data->payer_id]['name'] : '<div class="bill-view-header-no" ><p>Нет платильщик</p></div>'; ?></p>
                </td>
            </tr>
            <tr style="margin: 0; padding: 0;">
                <td style="margin: 0; padding-bottom: 0;padding-top: 0;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 0;padding-top: 0;line-height: 1;" ><p style="margin: 0; padding: 0;" >Особа для контактів:</p></td>
                <td style="margin: 0; padding-bottom: 0;padding-top: 0;line-height: 1;" >
                    <?php if($bill_data->payer_id): ?>
                        <p style="margin: 0; padding: 0;" ><?= $payers_data[$bill_data->payer_id]['contact_person'] ? $payers_data[$bill_data->payer_id]['contact_person'] : '<span></span>'; ?></p>
                    <?php else: ?>
                        <span ></span>
                    <?php endif; ?>
                </td>
            </tr  >
            <tr style="margin: 0; padding-bottom: 10px;padding-top: 0;line-height: 1;" >
                <td style="margin: 0; padding-bottom: 5px;padding-top: 0; line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 5px;padding-top: 0; line-height: 1;" ><p style="margin: 0; padding: 0;" >Телефон/факс:</p></td>
                <td style="margin: 0; padding-bottom: 5px;padding-top: 0; line-height: 1;" >
                    <?php if($bill_data->payer_id): ?>
                        <p style="margin: 0; padding: 0;" ><?= $payers_data[$bill_data->payer_id]['phone'] ? $payers_data[$bill_data->payer_id]['phone'] : '<span></span>'; ?></p>
                    <?php else: ?>
                        <span></span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    <div>

        <table class="table table-bordered table-hover " style="margin: 0; padding: 0;line-height: 1;">
            <thead style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;">
            <tr style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;">
                <th style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;">№</th>
                <th style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;">Найменування</th>
                <th style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;">Од.вим.</th>
                <th style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;">Кільк.</th>
                <th style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;">Ціна,грв.</th>
                <th style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;">Сумма, грв.</th>
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
                    <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ><?= $v ?></td>

                    <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ><?= $services_id_array[0] ? $services_data[$services_id_array[$k]]['name'] : '<span class="badge  badge-danger" >Нет данных</span>' ?></td>
                    <?php if ($services_id_array[0]): ?>
                        <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ><?= $units_data[$units_id_array[$k]]['name'] != -1 ? $units_data[$units_id_array[$k]]['name'] : '<span class="badge  badge-danger" >Нет данных</span>' ?></td>
                        <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ><?= $quantity_array[$k] != -1 ? $quantity_array[$k] : '<span class="badge  badge-danger" >Нет данных</span>' ?></td>
                        <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ><?= $prices_array[$k] != -1 ? $prices_array[$k] : '<span class="badge  badge-danger" >Нет данных</span>' ?></td>
                        <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ><?= $sum ?></td>
                    <?php else: ?>
                        <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ><span class="badge  badge-danger">Нет данных</span></td>
                        <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ><span class="badge  badge-danger">Нет данных</span></td>
                        <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ><span class="badge  badge-danger">Нет данных</span></td>
                        <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ><span class="badge  badge-danger">Нет данных</span></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            <tr class="table-no-border">
                <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" >Сумма:</td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ><?= $all_sum ?></td>
            </tr>
            <tr class="table-no-border">
                <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" >ПДВ:</td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 2px;line-height: 1;" ><?= $all_sum / 5 ?></td>
            </tr>
            <tr class="table-no-border">
                <td style="margin: 0; padding-bottom: 2px;padding-top: 5px;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 5px;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 5px;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 5px;line-height: 1;" ></td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 5px;line-height: 1;" >До сплати:</td>
                <td style="margin: 0; padding-bottom: 2px;padding-top: 5px;line-height: 1;" ><?= ($all_sum / 5) + $all_sum ?></td>
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
