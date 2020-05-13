<?php
use Helpers\Html;
?>

<title><?= $title ?></title>

<div class="container">
    <table class="table table-hover mt-3">
        <thead>
        <tr class="table-primary">
            <th scope="col">ID</th>
            <th scope="col">Гра</th>
            <th scope="col">Розробник</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($games); $i++) : ?>
            <tr>
                <th scope="row"><?= $games[$i]['id'] ?></th>
                <td><a href="
            <?= Html::link('games', 'delete', 'id=' . $games[$i]['id']) ?>"
                       data-toggle="tooltip" data-placement="top" title="Натисніть, щоб видалити"
                       style="text-decoration:none;">
                        <?= $games[$i]['title'] ?>
                    </a></td>
                <td><?= $games[$i]['developer'] ?></td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>
</div>