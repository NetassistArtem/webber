<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = 'Просмотр счета';


?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
<?php
//Debugger::PrintR($bill_data);
//Debugger::PrintR($payers_data);

?>
    <div>
        <?= $header_data[$bill_data->header_id]['text'];  ?>
    </div>
    <div class="bill_number" ><h3>Рахунок № <?= $bill_data->bill_id  ?></h3></div>
    <div class="bill_date" ><p>від <?= Yii::$app->formatter->asDate($bill_data->date, 'yyyy-MM-dd') ?></p></div>
    <div>
        <table  class="table table-responsive table-no-border" >
            <tr>
                <td></td>
                <td><p>Платник:</p></td>
                <td><p><?= $payers_data[$bill_data->payer_id]['name']; ?></p></td>
            </tr>
            <tr>
                <td></td>
                <td><p>Особа для контактів:</p></td>
                <td><p><?= $payers_data[$bill_data->payer_id]['contact_person']; ?></p></td>
            </tr>
            <tr>
                <td></td>
                <td><p>Телефон/факс:</p></td>
                <td><p><?= $payers_data[$bill_data->payer_id]['phone']; ?></p></td>
            </tr>
        </table>
    </div>
    <div>
        <table class="table table-bordered table-hover" >
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
            foreach($services_bill_id_array as $k => $v):
                $sum = ($prices_array[$k] != -1? $prices_array[$k] : 0)* ($quantity_array[$k] != -1? $quantity_array[$k] : 0);
                $all_sum += $sum;
                ?>

            <tr>
                <td><?= $v ?></td>
                <td><?=$services_data[$services_id_array[$k]]['name'] ?></td>
                <td><?=$units_data[$units_id_array[$k]]['name'] ?></td>
                <td><?=$quantity_array[$k] ?></td>
                <td><?=$prices_array[$k] ?></td>
                <td><?=$sum ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="table-no-border" >
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Сумма:</td>
                <td><?= $all_sum ?></td>
            </tr>
            <tr class="table-no-border" >
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>ПДВ:</td>
                <td><?= $all_sum/5 ?></td>
            </tr>
            <tr class="table-no-border" >
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>До сплати:</td>
                <td><?= ($all_sum/5)+$all_sum ?></td>
            </tr>
            </tbody>
        </table>
    </div>




</div>