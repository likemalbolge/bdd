<title><?= $title ?></title>

<div class="container mt-5">
    <form method="post">
        <div class="form-group">
            <label for="password">Підтвердіть дію, ввівши пароль</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <button type="submit" class="btn btn-danger" name="do_delete">Видалити обліковий запис</button>
    </form>

    <?= $alert ?>
</div>