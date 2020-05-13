<?php
use Helpers\Html;
?>

<title><?= $title ?></title>

<div class="container">
    <div class="row justify-content-center">
        <?= $data['alert'] ?>
    </div>
</div>
<?php if (empty($data['alert'])) : ?>
    <div class="container gt-container">
        <div class="row justify-content-center">
            <h1>Список ігор</h1>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php for ($i = 0; $i < count($data['games']); $i++) : ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card gm-card text-center" style="width: 15rem;">
                        <?= Html::image($data['games'][$i]['img'], 'game-img') ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= $data['games'][$i]["title"] ?></h5>
                            <a href="<?= Html::link('games', 'gamepage',
                                'id=' . $data['games'][$i]['id']) ?>" class="btn btn-primary">
                                Грати
                            </a>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
<?php endif; ?>