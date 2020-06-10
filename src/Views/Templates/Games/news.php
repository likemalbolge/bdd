<?php
use Helpers\Html;
?>

<title><?= $title ?></title>

<div class="container gt-container">
    <div class="row justify-content-center">
        <h1>Новини</h1>
    </div>
</div>
<a id="button"></a>
<div class="container">
    <div class="row">
        <?php for ($i = 0; $i < count($data['news']); $i++) : ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card mb-3">
                    <h3 class="card-header text-center">На сайті з'явилася нова гра</h3>
                    <div class="card-body">
                        <h5 class="card-title"><?= $data['news'][$i]['title']; ?></h5>
                        <h6 class="card-subtitle text-muted"><?= $data['news'][$i]['description']; ?></h6>
                    </div>
                    <?= Html::image($data['news'][$i]['img'], 'game-img') ?>
                    <div class="card-body">
                        <p class="card-text">Підтримка мобільних пристроїв:
                            <?= $data['news'][$i]['mobile_ready']; ?></p>
                    </div>
                    <p class="text-center">Теги</p>
                    <hr class="my-0">
                    <ul class="list-group list-group-flush">
                        <?php for ($j = 0; $j < 3; $j++) : ?>
                        <?php if (isset($data['tags'][$i][$j])) : ?>
                            <li class="list-group-item"><?= $data['tags'][$i][$j]; ?></li>
                        <?php endif; endfor; ?>
                    </ul>
                    <div class="card-footer text-muted">
                        Опубліковано: <?= $data['news'][$i]["add_date"] ?>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>