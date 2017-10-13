<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\debugger\Debugger;

AppAsset::register($this);

$f_url = Yii::$app->request->url;
$no_get_url = explode('?',$f_url)[0];

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php


    NavBar::begin([
        'brandLabel' => 'Webber',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    if(Yii::$app->request->pathInfo != 'login'){
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],

        'items' => [

            ['label' => 'Счета', 'url' => ['/bills'], 'active' => (
                $no_get_url == "/bills" ||
                $no_get_url == "/bills/edit-bill" ||
                $no_get_url == "/bills/bill-view" ||
                $no_get_url == "/bills/bill-print" ||
                $no_get_url == "/bills/bill-act-print" ||
                $no_get_url == "/bills/add-bill-main" ||
                $no_get_url == "/bills/add-bill-second" ||
                $no_get_url == "/bills/edit-bill-main" ||
                $no_get_url == "/bills/act-view" ||
                $no_get_url == "/bills/act-edit" ||
                $no_get_url == "/bills/act-print"

            )],
            ['label' => 'Услуги', 'url' => ['/services'], 'active' => (
                $no_get_url == "/services" ||
                $no_get_url == "/services/edit-service"


            )],
            ['label' => 'Клиенты', 'url' => ['/payers'], 'active' => (
                $no_get_url == "/payers" ||
                $no_get_url == "/payers/edit-payer" ||
                $no_get_url == "/payers/payer"


            )],
            ['label' => 'Настройки', 'url' => ['/settings'], 'active' => (
                $no_get_url == "/settings" ||
                $no_get_url == "/settings/edit-unit" ||
                $no_get_url == "/settings/edit-header" ||
                $no_get_url == "/settings/edit-footer" ||
                $no_get_url == "/settings/edit-main-settings" ||
                $no_get_url == "/settings/edit-setting" ||
                $no_get_url == "/settings/edit-logo"

            )],
            ['label' => 'Архив', 'url' => ['/arhive'], 'active' => (
                $no_get_url == "/arhive"
            )],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/logout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    }
    NavBar::end();
    ?>

    <div class="container">

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Webber <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
