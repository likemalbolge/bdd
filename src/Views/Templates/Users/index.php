<?php
use Helpers\Html;
use Models\User;
?>

<title><?= $data['name'] ?></title>

<div class="container user-container">
    <h1 class="text-center"><?= $data['name'] ?></h1>
    <p class="lead ml-5"><?= $data['description'] ?></p>
    <div class="row justify-content-center">
        <a class="user-control btn"
           href="<?= Html::link('users', 'edit', 'id=' . User::getLoggedUser()['id']) ?>"
           data-toggle="tooltip" data-placement="top" title="Редагувати профіль"
        >
            <?= Html::image('edit.png') ?>
        </a>
        <a class="user-control btn"
           href="<?= Html::link('users', 'delete', 'id=' . User::getLoggedUser()['id']) ?>"
           data-toggle="tooltip" data-placement="top" title="Видалити профіль"
        >
            <?= Html::image('delete.png') ?>
        </a>
    </div>
    <hr class="my-4">
    <h3 class="text-center">Нещодавні ігри</h3>
    <div class="container">
        <div class="row justify-content-center">
            <?php if (count($last) > 0) :
            for ($i = 0; $i < count($last); $i++) : ?>
                <div class="card mr-5" style="width: 8rem;">
                    <a href="<?= Html::link('games', 'gamepage', 'id=' . $last[$i]['id']) ?>">
                        <?= Html::image($last[$i]['img'], 'card-img-top') ?>
                    </a>
                    <p class="card-text text-center" style="color: #212121;">
                        <?= $last[$i]['title'] ?>
                    </p>
                </div>
            <?php endfor;
            else : ?>
            <p>Немає нещодавних ігор</p>
            <?php endif; ?>
        </div>
    </div>
    <?php if (User::getLoggedUser()['type'] == 'admin') : ?>
        <hr class="my-4">
        <h3 class="text-center">Панель адміністратора</h3>
        <div class="admin">
            <a class="btn btn-primary mt-2" href="
    <?= Html::link('games', 'add') ?>">
                Додати гру</a>
            <a class="btn btn-primary mt-2" href="
    <?= Html::link('games', 'edittable') ?>">
                Редагувати гру</a>
            <a class="btn btn-primary mt-2" href="
    <?= Html::link('games', 'deletetable') ?>">
                Видалити гру</a>
            <a class="btn btn-primary mt-4" href="
    <?= Html::link('users', 'signup') ?>">
                Додати користувача</a>
            <a class="btn btn-primary mt-2" href="
    <?= Html::link('users', 'edittable') ?>">
                Редагувати користувача</a>
            <a class="btn btn-primary mt-2" href="
    <?= Html::link('users', 'deletetable') ?>">
                Видалити користувача</a>
        </div>
    <?php endif; ?>
</div>