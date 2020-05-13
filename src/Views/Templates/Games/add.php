<title><?= $title ?></title>

<div class="container mt-5">
    <form method="post">
        <div class="form-group">
            <label for="title">Назва гри</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="link">Посилання на гру</label>
            <input type="text" class="form-control" id="link" name="link">
        </div>
        <div class="form-group">
            <label for="resolution">Розміри вікна (через кому)</label>
            <input type="text" class="form-control" id="resolution" name="resolution">
        </div>
        <div class="form-group">
            <label for="img">Шлях до логотипу</label>
            <input type="text" class="form-control" id="img" name="img">
        </div>
        <div class="form-group">
            <label for="description">Опис</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>
        <div class="form-group">
            <label for="tags">Теги (через кому)</label>
            <input type="text" class="form-control" id="tags" name="tags">
        </div>
        <div class="form-group">
            <label for="developer">Розробник гри</label>
            <input type="text" class="form-control" id="developer" name="developer">
        </div>
        <div class="form-group">
            <label for="mobile_ready">Підтримка мобільних пристроїв</label>
            <input type="text" class="form-control" id="mobile_ready" name="mobile_ready">
        </div>

        <button type="submit" class="btn btn-primary" name="do_add">Додати гру</button>
    </form>

    <?= $alert ?>
</div>