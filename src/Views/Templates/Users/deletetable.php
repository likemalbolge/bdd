<?php
use Helpers\Html;
?>

<title><?= $title ?></title>

<div class="container">
    <table class="table table-hover mt-3">
        <thead>
        <tr class="table-primary">
            <th scope="col">ID</th>
            <th scope="col">Користувач</th>
            <th scope="col">Тип</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($users); $i++) : ?>
            <tr>
                <th scope="row"><?= $users[$i]['id'] ?></th>
                <td><a href="
            <?= Html::link('users', 'delete', 'id=' . $users[$i]['id']) ?>"
                       data-toggle="tooltip" data-placement="top" title="Натисніть, щоб видалити"
                       style="text-decoration:none;">
                        <?= $users[$i]['name'] ?>
                    </a></td>
                <td><?= $users[$i]['type'] ?></td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>
</div>