<title><?= $title ?></title>

<div class="container mt-5">
    <?php if (isset($_POST['do_repair'])) : ?>
        <form method="post">
            <div class="form-group">
                <label for="password">На вашу електронну скриньку надійшло повідомлення з кодом. Не забудьте перевірити
                спам, так, як повідомлення помилково могло поступити туди!</label>
                <input type="text" class="form-control" id="token" name="token">
            </div>

            <button type="submit" class="btn btn-primary" name="repair_token">Підтвердити</button>
        </form>

        <?= $alert ?>
    <?php elseif (isset($_POST['repair_token'])) : ?>
        <form method="post">
            <div class="form-group">
                <label for="password">Введіть ваш новий пароль</label>
                <input type="text" class="form-control" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-primary" name="repair_password">Підтвердити</button>
        </form>

        <?= $alert ?>
    <?php else : ?>
        <form method="post">
            <div class="form-group">
                <label for="password">Введіть e-mail на який був зареєстрований обліковий запис</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>

            <button type="submit" class="btn btn-primary" name="do_repair">Відновити пароль</button>
        </form>

        <?= $alert ?>
    <??>
    <?php endif; ?>
</div>