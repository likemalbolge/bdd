<?php
require __DIR__ . '/config/app.php';
use Helpers\Html;
use System\App;
?>
<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="<?= WEB . 'img/favicon.ico' ?>" type="image/x-icon">
    <?= Html::css('bootstrap.min.css') ?>
    <?= Html::css('font-awesome.min.css') ?>
    <?php Html::css('https://fonts.googleapis.com/icon?family=Material+Icons') ?>
    <?= Html::css('style.css') ?>
</head>
<body>
<?php Html::element('navbar') ?>

<div class="container body">
    <div class="row">
        <?php App::run() ?>
    </div>
</div>

<?= Html::element('footer') ?>

<?= Html::script('jquery.min.js') ?>
<?= Html::script('popper.min.js') ?>
<?= Html::script('bootstrap.min.js') ?>
<?= Html::script('control.js') ?>
<?= Html::script('btt.js') ?>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

</body>
</html>
