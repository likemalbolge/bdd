<title><?= $title ?></title>

<div class="container mt-5">
    <form method="post">
        <h5 class="text-center">Зміна основних даних</h5>
        <div class="form-group">
            <label for="name">Ваш логін</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $data['name'] ?>">
        </div>
        <div class="form-group">
            <label for="description">Ваш опис</label>
            <input type="text" class="form-control" id="description" name="description"
                   value="<?= $data['description'] ?>">
        </div>
        <hr class="my-4">
        <h5 class="text-center">Зміна паролю</h5>
        <div class="form-group">
            <label for="old_password">Старий пароль</label>
            <input type="password" class="form-control" id="old_password" name="old_password">
        </div>
        <div class="form-group">
            <label for="new_password">Новий пароль</label>
            <input type="password" class="form-control" id="new_password" name="new_password">
        </div>
        <?php if (($logged_user['type'] == 'admin') && ($logged_user['id'] !== $_GET['id'])) : ?>
            <hr class="my-4">
            <h5 class="text-center">Можливості адміністратора</h5>
            <div class="form-group">
                <label for="usertype">Тип користувача (user або admin)</label>
                <input type="text" class="form-control" id="usertype" name="usertype" value="<?= $data['type'] ?>">
            </div>
            <div class="form-group">
                <label for="verified">Верифіковано (0 — ні, 1 — так)</label>
                <input type="text" class="form-control" id="verified" name="verified" value="<?= $data['verified'] ?>">
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary" name="do_edit">Редагувати</button>
    </form>

    <?= $alert ?>
</div>