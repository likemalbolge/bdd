<?php
use Helpers\Html;
use Models\User;
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a href="<?= Html::link('games', 'news') ?>" class="navbar-brand">
        <?= Html::image('logo.jpg', 'logo') ?>
        Бавки для дітий
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="<?= Html::link('games', 'index') ?>" class="nav-link">
                    Ігри
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Html::link('games', 'about') ?>" class="nav-link">
                    Про ресурс
                </a>
            </li>
            <?php if (User::getLoggedUser() !== null) : ?>
                <li class="nav-item">
                    <a href="<?= Html::link('users', 'index') ?>" class="nav-link">
                        <?= User::getLoggedUser()['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Html::link('users', 'signin', 'logout=1') ?>" class="nav-link">
                        Вихід
                    </a>
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <a href="<?= Html::link('users', 'signin') ?>" class="nav-link">
                        Вхід
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Html::link('users', 'signup') ?>" class="nav-link">
                        Реєстрація
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <?php if ((CONTROLLER == 'games' && (ACTION == 'index' || ACTION == 'search'))) : ?>
            <form class="form-inline my-2 my-lg-0" action="<?= BASE_URL . 'games/search' ?>" method="get">
                <input class="form-control mr-sm-2" type="text" name="query" placeholder="Пошук">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Пошук</button>
            </form>
        <?php endif; ?>
    </div>
</nav>