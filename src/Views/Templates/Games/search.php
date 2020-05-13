<?php
use Helpers\Html;
?>

<title><?= $title ?></title>

<div class="container gt-container">
    <div class="row justify-content-center">
        <h1>Пошук</h1>
    </div>
</div>
<div class="container">
    <div class="row">
        <?php for ($i = 0; $i < count($data['by-title']); $i++) : ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card gm-card text-center" style="width: 15rem;">
                    <?= Html::image($data['by-title'][$i]['img'], 'game-img') ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $data['by-title'][$i]["title"] ?></h5>
                        <a href="
                        <?= Html::link('games', 'gamepage', 'id=' . $data['by-title'][$i]['id']) ?>"
                           class="btn btn-primary">
                            Грати
                        </a>
                    </div>
                </div>
            </div>
        <?php endfor; ?>

        <?php for ($i = 0; $i < count($data['by-tags']); $i++) : ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card gm-card text-center" style="width: 15rem;">
                    <?= Html::image($data['by-tags'][$i]['img'], 'game-img') ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $data['by-tags'][$i]["title"] ?></h5>
                        <a href="
                        <?= Html::link('games', 'gamepage', 'id=' . $data['by-tags'][$i]['id']) ?>"
                           class="btn btn-primary">
                            Грати
                        </a>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>