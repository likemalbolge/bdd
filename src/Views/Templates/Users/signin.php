<title><?= $title ?></title>

<div class="container gt-container">
    <div class="row justify-content-center">
        <h1><?= $title ?></h1>
    </div>
</div>

<div class="container ls-form-container">
    <form method="post">
        <div class="form-group">
            <label for="name">Ваш логін</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Введіть логін">
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
        </div>
        <button type="submit" class="btn btn-primary" name="do_login">Вхід</button>
    </form>
    <?= $data['alert'] ?>
</div>