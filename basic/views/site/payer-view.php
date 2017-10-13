<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = 'Страница клиента';

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" panel panel-default">
        <div class="panel-heading">
            <p>Клиен - <?= $payer->name ?></p>
        </div>
        <div class="panel-body">
            <?php echo '';//Pjax::begin(['id' => 'payers_add']); ?>




            <?php if ($payer->delete == -1): ?>
                <div class="margin_bottom">

                    <a href="/payers/edit-payer?id=<?= $payer->id ?>" class="btn btn-primary">Редактировать</a>
                    <a href="/payers/delete-payer?id=<?= $payer->id ?>"
                       onclick="return confirm('Вы уверены что хотите удалить <?= $payer->name ?>')"
                       class="btn btn-danger">Удалить</a>

                </div>
            <?php else: ?>

                <div class="alert alert-warning">
                    Запрашиваемый клиент удален. Восстановить можно в разделе <b><a href="/arhive">Архив</a></b>.
                </div>
            <?php endif; ?>

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>

                    <tr>
                        <th>Свойство</th>
                        <th>Значение</th>
                    </tr>

                    </thead>
                    <tbody>
                    <tr>
                        <td>Имя клиента</td>
                        <td><?= $payer->name ?></td>
                    </tr>
                    <tr>
                        <td>Контактное лицо</td>
                        <td><?= $payer->contact_person ?></td>
                    </tr>
                    <tr>
                        <td>Телефоны</td>
                        <td><?= $payer->phone ?></td>
                    </tr>
                    <tr>
                        <td>ИП №</td>
                        <td><?= $payer->person_id ?></td>
                    </tr>
                    <tr>
                        <td>Свидетельство платильщика НДС №</td>
                        <td><?= $payer->certificat_pdv_id ?></td>
                    </tr>
                    <tr>
                        <td>ЄДРПОУ</td>
                        <td><?= $payer->edrpo ?></td>
                    </tr>
                    <tr>
                        <td>Адресс юредический</td>
                        <td><?= $payer->address_ur ?></td>
                    </tr>
                    <tr>
                        <td>Адресс подключения</td>
                        <td><?= $payer->address_connection ?></td>
                    </tr>
                    <tr>
                        <td>Адрес почтовый</td>
                        <td><?= $payer->address_post ?></td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td><?= $payer->email ?></td>
                    </tr>
                    <tr>
                        <td>Номер договора</td>
                        <td><?= $payer->contract_id ?></td>
                    </tr>
                    <tr>
                        <td>Дата договора</td>
                        <td><?= $payer->contract_date ?></td>
                    </tr>


                    </tbody>
                </table>
            </div>


            <?php echo '';//Pjax::end(); ?>
        </div>
    </div>


</div>