<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = '';

//Debugger::EhoBr('test '.$next_id);

?>
<div class="site-about">

    <?php if ($prev_id): ?>
        <a href="/bills/bill-view?id=<?= $first_id ?>" class="btn btn-success"><span
                class="glyphicon glyphicon-fast-backward"></span><span class="player_text">FIRST</span></a>
        <a href="/bills/bill-view?id=<?= $prev_id ?>" class="btn btn-success"><span
                class="glyphicon glyphicon-step-backward"></span><span class="player_text">PREV</span></a>
    <?php else: ?>
        <a class="btn btn-success" disabled><span class="glyphicon glyphicon-fast-backward"></span><span
                class="player_text">FIRST</span></a>
        <a class="btn btn-success" disabled><span class="glyphicon glyphicon-step-backward"></span><span
                class="player_text">PREV</span></a>
    <?php endif; ?>

    <a href="/bills" class="btn btn-success"><span class="glyphicon glyphicon glyphicon-eject"></span><span
            class="player_text">HOME</span></a>

    <?php if ($next_id): ?>
        <a href="/bills/bill-view?id=<?= $next_id ?>" class="btn btn-success"><span
                class="glyphicon glyphicon-step-forward"></span><span class="player_text">NEXT</span></a>
        <a href="/bills/bill-view?id=<?= $last_id ?>" class="btn btn-success"><span
                class="glyphicon glyphicon-fast-forward"></span><span class="player_text">LAST</span></a>
    <?php else: ?>
        <a class="btn btn-success" disabled><span class="glyphicon glyphicon-step-forward"></span><span
                class="player_text">NEXT</span></a>
        <a class="btn btn-success" disabled><span class="glyphicon glyphicon-fast-forward"></span><span
                class="player_text">LAST</span></a>
    <?php endif; ?>

    <a href="/bills/edit-bill-main?id=<?= $bill_data['id'] ?>" class="btn btn-primary">Редактировать счет</a>
    <a href="/bills/bill-print?id=<?= $bill_data['id'] ?>" class="btn btn-success">Распечатать счет</a>
    <a href="/bills/act-print?id=<?= $bill_data['id'] ?>" class="btn btn-success">Распечатать акт</a>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    //  Debugger::PrintR($bill_data);
    //Debugger::PrintR($payers_data);

    ?>
    <div id="header_main">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 logo_position">
                <img src="<?= $logo_url ?>" alt="">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <?php if ($bill_data['header_id']): ?>
                    <?= isset($header_data[$bill_data['header_id']]['text']) ? $header_data[$bill_data['header_id']]['text'] : $header_arhive_data[$bill_data['header_id']]['text'] . ' <span class="badge  badge-danger" >Хедер удален</span>' ?>
                <?php else: ?>
                    <div class="bill-view-header-no" ><p>Нет хедера</p></div>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <div class="bill_number"><h3>Рахунок № <?= $bill_data['bill_id'] ?></h3></div>
    <div class="bill_date"><p>від <?= Yii::$app->formatter->asDate($bill_data['date'], 'yyyy-MM-dd') ?></p></div>
    <div>
        <table class="table table-responsive table-no-border">
            <tr>
                <td></td>
                <td><p>Платник:</p></td>

                <?php if ($bill_data['payer_id']): ?>
                    <td><?= isset($payers_data[$bill_data['payer_id']]['name']) ? $payers_data[$bill_data['payer_id']]['name'] : $payers_arhive_data[$bill_data['payer_id']]['name'] . ' <span class="badge  badge-danger" >Клиент удален</span>' ?></td>
                <?php else: ?>
                    <td><span class="badge  badge-danger">Нет данных</span></td>
                <?php endif; ?>

            </tr>
            <tr>
                <td></td>
                <td><p>Особа для контактів:</p></td>
                <td>
                    <?php if ($bill_data['payer_id']):
                        if (isset($payers_data[$bill_data['payer_id']])): ?>
                            <p><?= $payers_data[$bill_data['payer_id']]['contact_person'] ? $payers_data[$bill_data['payer_id']]['contact_person'] : '<span class="badge  badge-danger" >Нет данных</span>'; ?></p>
                        <?php else: ?>
                            <p><?= $payers_arhive_data[$bill_data['payer_id']]['contact_person'] ? $payers_arhive_data[$bill_data['payer_id']]['contact_person'] . ' <span class="badge  badge-danger" >Клиент удален</span>' : '<span class="badge  badge-danger" >Нет данных</span>'; ?></p>
                        <?php endif; ?>

                    <?php else: ?>
                        <span class="badge  badge-danger">Нет данных</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><p>Телефон/факс:</p></td>
                <td>
                    <?php if ($bill_data['payer_id']):
                        if (isset($payers_data[$bill_data['payer_id']])): ?>
                            <p><?= $payers_data[$bill_data['payer_id']]['phone'] ? $payers_data[$bill_data['payer_id']]['phone'] : '<span class="badge  badge-danger" >Нет данных</span>'; ?></p>
                        <?php else: ?>
                            <p><?= $payers_arhive_data[$bill_data['payer_id']]['phone'] ? $payers_arhive_data[$bill_data['payer_id']]['phone'] . ' <span class="badge  badge-danger" >Клиент удален</span>' : '<span class="badge  badge-danger" >Нет данных</span>'; ?></p>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="badge  badge-danger">Нет данных</span>
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


                    <?php if ($services_id_array[0]): ?>
                        <td><?= isset($services_data[$services_id_array[$k]]['name']) ? $services_data[$services_id_array[$k]]['name'] : $services_arhive_data[$services_id_array[$k]]['name'] . ' <span class="badge  badge-danger" >Услуга удалена</span>' ?></td>
                    <?php else: ?>
                        <td><span class="badge  badge-danger">Нет данных</span></td>
                    <?php endif; ?>




                    <?php if ($services_id_array[0]): ?>

                        <?php if (isset($units_data[$units_id_array[$k]]['name'])): ?>
                            <td><?= $units_data[$units_id_array[$k]]['name'] != -1 ? $units_data[$units_id_array[$k]]['name'] : '<span class="badge  badge-danger" >Нет данных</span>' ?></td>
                        <?php else: ?>
                            <td><?= isset($units_data[$units_id_array[$k]]['name']) ? $units_data[$units_id_array[$k]]['name'] : $units_arhive_data[$units_id_array[$k]]['name'] . ' <span class="badge  badge-danger" >Единица удалена</span>' ?></td>
                        <?php endif; ?>

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

        <?php if ($bill_data['footer_id']): ?>

            <?= isset($footer_data[$bill_data['footer_id']]['text']) ? $footer_data[$bill_data['footer_id']]['text'] : $footer_arhive_data[$bill_data['footer_id']]['text'] . ' <span class="badge  badge-danger" >Футер удален</span>' ?>
        <?php else: ?>
            <div class="bill-view-header-no" ><p>Нет футера</p></div>
        <?php endif; ?>

    </div>


</div>

<script type="text/javascript">
    var ptch;
    ptch = document.querySelector('#header_main img').getAttribute('src');
    document.querySelector('#header_main img').setAttribute('src', '/' + ptch);
</script>