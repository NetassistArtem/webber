<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;
use yii\widgets\Pjax;

$this->title = 'Архив удаленных элементов';

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div>
        <div class="btn btn-block btn-primary margin_top2 btn_color1" data-toggle="collapse" data-target="#unit_all" >
            Единици измерения
        </div>
    </div>

    <div class=" panel panel-default collapse" id="unit_all" >
        <div class="panel-heading">
            <p>Удаленные единици измерения</p>
        </div>
        <div class="panel-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Название</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($units_data)): ?>
                        <tr>
                            <td colspan="2"> <div class="alert alert-info" >Удаленные единици измерения отсутствуют</div></td>
                        </tr>

                    <?php else: ?>


                    <?php foreach($units_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#unit_tr_<?= $k+1 ?>">
                            <td><?= $k+1 ?></td>
                            <td><?= $v['name'] ?></td>
                        </tr>

                        <tr id="unit_tr_<?= $k+1 ?>" class="collapse" >
                            <td colspan="2">
                                <a href="/arhive-return-unit?id=<?= $v['id'] ?>" class="btn btn-primary">Востановить</a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div>
        <div class="btn btn-block btn-primary margin_top2 btn_color2" data-toggle="collapse" data-target="#header_all" >
            Хедеры
        </div>
    </div>


    <div class=" panel panel-default collapse" id="header_all" >
        <div class="panel-heading">
            <p>Удаленные хедеры</p>
        </div>
        <div class="panel-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Текст хедера</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php if(empty($headers_data)): ?>
                        <tr>
                            <td colspan="2"> <div class="alert alert-info" >Удаленные хедеры  отсутствуют</div></td>
                        </tr>

                    <?php else: ?>

                    <?php foreach($headers_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#header_tr_<?= $k+1 ?>">
                            <td><?= $v['name'] ?></td>
                            <td><?= $v['text'] ?></td>
                        </tr>

                        <tr id="header_tr_<?= $k+1 ?>" class="collapse" >
                            <td colspan="2">
                                <a href="/arhive-return-header?id=<?= $v['id'] ?>" class="btn btn-primary">Востановить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div>
        <div class="btn btn-block btn-primary margin_top2 btn_color3" data-toggle="collapse" data-target="#footer_all" >
            Футуры
        </div>
    </div>


    <div class=" panel panel-default collapse" id="footer_all" >
        <div class="panel-heading">
            <p>Удаленные футеры</p>
        </div>
        <div class="panel-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Текст футера</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php if(empty($footers_data)): ?>
                        <tr>
                            <td colspan="2"> <div class="alert alert-info" >Удаленные футеры  отсутствуют</div></td>
                        </tr>

                    <?php else: ?>

                        <?php foreach($footers_data as $k => $v): ?>

                            <tr data-toggle="collapse" data-target="#footer_tr_<?= $k+1 ?>">
                                <td><?= $v['name'] ?></td>
                                <td><?= $v['text'] ?></td>
                            </tr>

                            <tr id="footer_tr_<?= $k+1 ?>" class="collapse" >
                                <td colspan="2">
                                    <a href="/arhive-return-footer?id=<?= $v['id'] ?>" class="btn btn-primary">Востановить</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div>
        <div class="btn btn-block btn-primary margin_top2 btn_color4" data-toggle="collapse" data-target="#services_all" >
            Услуги
        </div>
    </div>


    <div class=" panel panel-default collapse" id="services_all" >
        <div class="panel-heading">
            <p>Удаленные услуги</p>
        </div>
        <div class="panel-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Название</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($services_data)): ?>
                        <tr>
                            <td colspan="2"> <div class="alert alert-info" >Удаленные услуги  отсутствуют</div></td>
                        </tr>

                    <?php else: ?>
                    <?php foreach($services_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#service_tr_<?= $k+1 ?>">
                            <td><?= $k+1 ?></td>
                            <td><?= $v['name'] ?></td>
                        </tr>

                        <tr id="service_tr_<?= $k+1 ?>" class="collapse" >
                            <td colspan="2">
                                <a href="/arhive-return-service?id=<?= $v['id'] ?>" class="btn btn-primary">Востановить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div>
        <div class="btn btn-block btn-primary margin_top2 btn_color5" data-toggle="collapse" data-target="#payers_all" >
            Клиенты
        </div>
    </div>


    <div class=" panel panel-default collapse" id="payers_all" >
        <div class="panel-heading">
            <p>Удаленные клиенты</p>
        </div>
        <div class="panel-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-border-custom">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Имя клиента</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($payers_data)): ?>
                        <tr>
                            <td colspan="2"> <div class="alert alert-info" >Удаленные клиенты  отсутствуют</div></td>
                        </tr>

                    <?php else: ?>
                    <?php foreach($payers_data as $k => $v): ?>

                        <tr data-toggle="collapse" data-target="#payer_tr_<?= $k+1 ?>">
                            <td><?= $k+1 ?></td>
                            <td><?= $v['name'] ?></td>
                        </tr>

                        <tr id="payer_tr_<?= $k+1 ?>" class="collapse" >
                            <td colspan="2">
                                <a href="/arhive-return-payer?id=<?= $v['id'] ?>" class="btn btn-primary">Востановить</a>
                                <a href="/payers/payer?id=<?= $v['id'] ?>"  class="btn btn-success">Детальнее</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



</div>