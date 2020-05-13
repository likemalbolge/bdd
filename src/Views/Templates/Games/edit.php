<title><?= $title ?></title>

<div class="container mt-5">
    <form method="post">
        <div class="form-group">
            <label for="title">Назва гри</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $data['title'] ?>">
        </div>
        <div class="form-group">
            <label for="link">Посилання на гру</label>
            <input type="text" class="form-control" id="link" name="link"
                   value="<?= $data['link'] ?>">
        </div>
        <div class="form-group">
            <label for="resolution">Розміри вікна (через кому)</label>
            <input type="text" class="form-control" id="resolution" name="resolution"
                   value="<?= $data['resolution'] ?>">
        </div>
        <div class="form-group">
            <label for="img">Шлях до логотипу</label>
            <input type="text" class="form-control" id="img" name="img"
                   value="<?= $data['img'] ?>">
        </div>
        <div class="form-group">
            <label for="description">Опис</label>
            <input type="text" class="form-control" id="description" name="description"
                   value="<?= $data['description'] ?>">
        </div>
        <div class="form-group">
            <label for="tags">Теги (через кому, мінімум 3)</label>
            <input type="text" class="form-control" id="tags" name="tags"
                   value="<?= $data['tags'] ?>">
        </div>
        <div class="form-group">
            <label for="developer">Розробник гри</label>
            <input type="text" class="form-control" id="developer" name="developer"
                   value="<?= $data['developer'] ?>">
        </div>
        <div class="form-group">
            <label for="mobile_ready">Підтримка мобільних пристроїв</label>
            <input type="text" class="form-control" id="mobile_ready" name="mobile_ready"
                   value="<?= $data['mobile_ready'] ?>">
        </div>

        <button type="submit" class="btn btn-primary" name="do_edit">Редагувати</button>
    </form>

    <?= $alert ?>
</div>