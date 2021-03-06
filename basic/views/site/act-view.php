<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = '';
//Debugger::EhoBr($payers_data);
//Debugger::testDie();

?>

<div class="site-about">

    <a href="/bills/act-edit?bill_id=<?= $bill_data['bill_id'] ?>" class="btn btn-primary">Редактировать акт</a>
    <a href="/bills/act-print?bill_id=<?= $bill_data['bill_id'] ?>" class="btn btn-success">Распечатать акт</a>
    <a href="/bills/bill-print?id=<?= $bill_data['id'] ?>" class="btn btn-success">Распечатать счет</a>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    //  Debugger::PrintR($bill_data);
    //Debugger::PrintR($payers_data);
   // Debugger::PrintR($main_settings_data);
    // Debugger::testDie();

    ?>

    <div class="text-center">
        <p>АКТ № <b><?= $act_data['act_id'] ? $act_data['act_id'] : $bill_id_small ?></b></p>
        <p>здачі-прийнятя робіт (надання послуг)</p>
    </div>
    <div>
        <div style="display: inline-block;width: 50%;"><p class="text-left"><b>м.Київ</b></p></div>
        <div style="display: inline-block;width: 49%;"><p class="text-right">
                <b><?= Yii::$app->formatter->asDate($last_day_month, 'dd-MM-yyyy') ?></b></p></div>
    </div>
    <div>
        <p style="margin-left: 38px" >Ми, представники Замовника <b><?= $payers_data? $payers_data->name : ' ...... ' ?></b></p>
        <p style="display: inline-block; margin-left: 38px">в особі </p>
        <p style="display: inline-block;width: 50%; margin: 0; border-bottom: solid 1px black"></p>
        <p>з одного боку, та представник <?= $main_settings_data['name_firm'] ?> в особі Директора
            <?= $main_settings_data['name_dir'] ?>, з іншого боку, склали цей акт про те, що Виконавецем були проведені
            такі роботи (надані такі послуги) згідно договору № <b><?= $payers_data? $payers_data->contract_id : ' ...... ' ?></b> від
            <b><?= $payers_data? $payers_data->contract_date : ' ...... ' ?></b></p>

    </div>
    <table class="table table-sm table-responsive table-no-border " >

        <?php
        $all_sum = '';
        foreach ($services_bill_id_array as $k => $v):
            $sum = ($prices_array[$k] != -1 ? $prices_array[$k] : 0) * ($quantity_array[$k] != -1 ? $quantity_array[$k] : 0);
            $all_sum += $sum;
            ?>

            <tr>

                <td style="width: 45%" ><?= $services_id_array[0] ? $services_data[$services_id_array[$k]]['name'] : '..........' ?></td>
                <td><?= number_format($sum, 2, '.', ''); ?> грн</td>

            </tr>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <td></td>
        </tr>

        <tr class = "table-padding-custom">
            <td>Загальна вартість робіт (послуг) без ПДВ:</td>
            <td><?= number_format($all_sum, 2, '.', ''); ?> грн</td>
        </tr>
        <tr class = "table-padding-custom" >
            <td>ПДВ 20%:</td>
            <td><?= number_format(($all_sum / 5), 2, '.', ''); ?> грн</td>
        </tr>
        <tr class = "table-padding-custom" >
            <td>Загальна вартість робіт (послуг) з ПДВ:</td>
            <td><?= number_format((($all_sum / 5) + $all_sum), 2, '.', ''); ?> грн</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Сторони претензій одна до одної не мають.</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
    </table>

        <table class="table table-sm table-responsive table-no-border " >
        <tr class = "table-padding-custom" >
            <td style="width: 70%" >Від Виконавця</td>
            <td>Від Замовника</td>
        </tr>
        <tr class = "table-padding-custom-bottom" >
            <td>Директор <?= $main_settings_data['name_firm'] ?></td>
            <td></td>
        </tr>
        <tr class = "table-padding-custom-bottom-2" >
            <td><p style="display: inline-block;width: 20%; margin: 0; border-bottom: solid 1px black"></p>/<b><?= $main_settings_data['name_dir'] ?>/</b></td>
            <td><p style="display: inline-block;width: 60%; margin: 0; border-bottom: solid 1px black"></p>/........................../</td>
        </tr>
        <tr class = "table-padding-custom" >
            <td><b><?= Yii::$app->formatter->asDate($last_day_month, 'dd-MM-yyyy') ?></b></td>
            <td><b><?= Yii::$app->formatter->asDate($last_day_month, 'dd-MM-yyyy') ?></b></td>
        </tr>
        <tr class = "table-padding-custom" >
            <td><?= $main_settings_data['name_firm'] ?></td>
            <td><?= $payers_data? $payers_data->name : ' ...... ' ?></td>
        </tr>
        <tr class = "table-padding-custom" >
            <td><p class = column-first-custom>ЄДРПОУ</p><p class = column-second-custom ><?= $main_settings_data->edrpo ?></p></td>
            <td><p class = column-first-custom-2 >ЄДРПОУ</p><p class = column-second-custom ><?= $payers_data? $payers_data->edrpo : ' ..... ' ?></p></td>
        </tr>
        <tr class = "table-padding-custom" >
            <td><p class = column-first-custom>ІПН</p><p class = column-second-custom ><?= $main_settings_data->ipn ?></p></td>
            <td><p class = column-first-custom-2 >ІПН</p><p class = column-second-custom ><?= $payers_data? $payers_data->person_id : ' ..... ' ?></p></td>
        </tr>
        <tr class = "table-padding-custom" >
            <td><p class = column-first-custom>Свідоцтво №</p><p class = column-second-custom ><?= $main_settings_data->certificate ?></p></td>
            <td><p class = column-first-custom-2 >Свідоцтво №</p><p class = column-second-custom ><?= $payers_data? $payers_data->certificat_pdv_id : ' ..... ' ?></p></td>
        </tr>
        <tr class = "table-padding-custom" >
            <td><p class = column-first-custom>Юр. адреса:</p><p class = column-second-custom ><?= $main_settings_data->adress ?></p></td>
            <td><p class = column-first-custom-2 >Юр. адреса:</p><p class = column-second-custom ><?= $payers_data? $payers_data->address_ur : ' ..... ' ?></p></td>
        </tr>

    </table>

    <hr>


    <div class="text-center">
        <p>АКТ № <b><?= $act_data['act_id'] ? $act_data['act_id'] : $bill_id_small ?></b></p>
        <p>здачі-прийнятя робіт (надання послуг)</p>
    </div>
    <div>
        <div style="display: inline-block;width: 50%;"><p class="text-left"><b>м.Київ</b></p></div>
        <div style="display: inline-block;width: 49%;"><p class="text-right">
                <b><?= Yii::$app->formatter->asDate($last_day_month, 'dd-MM-yyyy') ?></b></p></div>
    </div>
    <div>
        <p style="margin-left: 38px" >Ми, представники Замовника <b><?= $payers_data? $payers_data->name : ' ...... ' ?></b></p>
        <p style="display: inline-block; margin-left: 38px">в особі </p>
        <p style="display: inline-block;width: 50%; margin: 0; border-bottom: solid 1px black"></p>
        <p>з одного боку, та представник <?= $main_settings_data['name_firm'] ?> в особі Директора
            <?= $main_settings_data['name_dir'] ?>, з іншого боку, склали цей акт про те, що Виконавецем були проведені
            такі роботи (надані такі послуги) згідно договору № <b><?= $payers_data? $payers_data->contract_id : ' ...... ' ?></b> від
            <b><?= $payers_data? $payers_data->contract_date : ' ...... ' ?></b></p>

    </div>
    <table class="table table-sm table-responsive table-no-border " >

        <?php
        $all_sum = '';
        foreach ($services_bill_id_array as $k => $v):
            $sum = ($prices_array[$k] != -1 ? $prices_array[$k] : 0) * ($quantity_array[$k] != -1 ? $quantity_array[$k] : 0);
            $all_sum += $sum;
            ?>

            <tr>

                <td style="width: 45%" ><?= $services_id_array[0] ? $services_data[$services_id_array[$k]]['name'] : '..........' ?></td>
                <td><?=  number_format($sum, 2, '.', ''); ?> грн</td>

            </tr>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <td></td>
        </tr>

        <tr class = "table-padding-custom">
            <td>Загальна вартість робіт (послуг) без ПДВ:</td>
            <td><?= number_format($all_sum, 2, '.', ''); ?> грн</td>
        </tr>
        <tr class = "table-padding-custom" >
            <td>ПДВ 20%:</td>
            <td><?= number_format(($all_sum / 5), 2, '.', ''); ?> грн</td>
        </tr>
        <tr class = "table-padding-custom" >
            <td>Загальна вартість робіт (послуг) з ПДВ:</td>
            <td><?= number_format((($all_sum / 5) + $all_sum), 2, '.', ''); ?> грн</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Сторони претензій одна до одної не мають.</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
    </table>
    <table class="table table-sm table-responsive table-no-border " >
        <tr class = "table-padding-custom" >
            <td style="width: 70%" >Від Виконавця</td>
            <td>Від Замовника</td>
        </tr>
        <tr class = "table-padding-custom-bottom" >
            <td>Директор <?= $main_settings_data['name_firm'] ?></td>
            <td></td>
        </tr>
        <tr class = "table-padding-custom-bottom-2" >
            <td><p style="display: inline-block;width: 20%; margin: 0; border-bottom: solid 1px black"></p>/<b><?= $main_settings_data['name_dir'] ?>/</b></td>
            <td><p style="display: inline-block;width: 60%; margin: 0; border-bottom: solid 1px black"></p>/........................../</td>
        </tr>
        <tr class = "table-padding-custom" >
            <td><b><?= Yii::$app->formatter->asDate($last_day_month, 'dd-MM-yyyy') ?></b></td>
            <td><b><?= Yii::$app->formatter->asDate($last_day_month, 'dd-MM-yyyy') ?></b></td>
        </tr>
        <tr class = "table-padding-custom" >
            <td><?= $main_settings_data['name_firm'] ?></td>
            <td><?= $payers_data? $payers_data->name : ' ...... ' ?></td>
        </tr>
        <tr class = "table-padding-custom" >
            <td><p class = column-first-custom>ЄДРПОУ</p><p class = column-second-custom ><?= $main_settings_data->edrpo ?></p></td>
            <td><p class = column-first-custom-2 >ЄДРПОУ</p><p class = column-second-custom ><?= $payers_data? $payers_data->edrpo : ' ..... ' ?></p></td>
        </tr>
        <tr class = "table-padding-custom" >
            <td><p class = column-first-custom>ІПН</p><p class = column-second-custom ><?= $main_settings_data->ipn ?></p></td>
            <td><p class = column-first-custom-2 >ІПН</p><p class = column-second-custom ><?= $payers_data? $payers_data->person_id : ' ..... ' ?></p></td>
        </tr>
        <tr class = "table-padding-custom" >
            <td><p class = column-first-custom>Свідоцтво №</p><p class = column-second-custom ><?= $main_settings_data->certificate ?></p></td>
            <td><p class = column-first-custom-2 >Свідоцтво №</p><p class = column-second-custom ><?= $payers_data? $payers_data->certificat_pdv_id : ' ..... ' ?></p></td>
        </tr>
        <tr class = "table-padding-custom" >
            <td><p class = column-first-custom>Юр. адреса:</p><p class = column-second-custom ><?= $main_settings_data->adress ?></p></td>
            <td><p class = column-first-custom-2 >Юр. адреса:</p><p class = column-second-custom ><?= $payers_data? $payers_data->address_ur : ' ..... ' ?></p></td>
        </tr>

    </table>




</div>
