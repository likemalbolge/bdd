<?php
use Helpers\Html;
use Models\Comment;
use Models\User;
?>

<title><?= $gameData['game']['title'] ?></title>

<div class="container gt-container">
    <div class="row justify-content-center">
        <h1><?= $gameData['game']['title'] ?></h1>
    </div>
</div>
<div class="container game-container">
    <div class="row justify-content-center">
        <iframe src="<?= $gameData['game']['link'] ?>"
                width="<?= $gameData['resolution'][0] ?>" height="<?= $gameData['resolution'][1] ?>"
                allowfullscreen="true" scrolling="none" frameborder="0">
        </iframe>
    </div>
    <div class="row justify-content-center tags">
        <div class="col-sm-12 developer">
            <?= 'Розробник гри: ' . $gameData['game']['developer'] ?>
        </div>
        <div class="col-sm-12">
            <?php for ($i = 0; $i < count($gameData['tags']); $i++) : ?>
                <a href="
                <?= Html::link('games', 'search', 'query=' . trim($gameData['tags'][$i])); ?>"
                   class="badge badge-info tag">
                    <?= $gameData['tags'][$i] ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
</div>
<div class="container comments-container">
    <div class="row justify-content-center">
        <h2>Коментарі</h2>
    </div>
    <?php if ($commentsData['closed'] == '') : ?>
        <div class="row justify-content-center mb-3">
            <form method="post">
                <textarea class="form-control comment-text" maxlength="1000" rows="5" cols="100" name="comment-text">
                </textarea>
                <button type="submit" class="btn btn-primary" name="<?= $commentsData['task'] ?>">
                    <?php if ($commentsData['task'] == 'do_comment') { echo 'Залишити'; }
                    else if ($commentsData['task'] == 'edit_comment') { echo 'Редагувати'; } ?> коментар
                </button>
            </form>
        </div>
    <?php else : ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="alert alert-warning alert-signup">
                    <strong><?= $commentsData['closed'] ?></strong>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row justify-content-center">
        <?= $commentsData['alert'] ?>
    </div>
    <div class="container media-container">
        <?php for ($i = 0; $i < count($commentsData['comments']); $i++) : ?>
            <div class="row justify-content-start mb-3 ml-5">
                <div class="media">
                    <div class="media-body cmnt_body">
                        <p class="cmnt-id" style="display: none"><?= $commentsData['comments'][$i]['id'] ?></p>
                        <h5 class="mt-0">
                            <?php $cu = Comment::getCommentUser($commentsData['comments'][$i]['user_id']) ?>
                            <?= $cu['name'] ?>
                            <?php if ($cu['type'] == 'admin') : ?>
                                <span class="badge badge-warning badge-pill admin-tag">admin</span>
                            <?php endif; ?>
                        </h5>
                        <p><?= $commentsData['comments'][$i]['comment_text'] ?></p>
                        <small><?= $commentsData['comments'][$i]['add_date'] ?></small>
                        <button class="control control-edit">
                            <?= Html::image('edit.png') ?>
                        </button>
                        <button class="control control-delete">
                            <?= Html::image('delete.png') ?>
                        </button>
                    </div>
                </div>
            </div>
            <?php if ($i < count($commentsData['comments']) - 1) { echo '<hr class="my-4">'; } ?>
        <?php endfor; ?>
    </div>
</div>

<script>
    var uc = <?= json_encode($commentsData['user_comments']) ?>;
    var userType = <?= json_encode(User::getLoggedUser()['type']) ?>;
    var link = <?= json_encode(Html::link('games', 'gamepage', 'id=' . $_GET['id'])) ?>;
    var taVal = <?= isset($commentsData['update_text']) ? json_encode($commentsData['update_text']) :
        json_encode('') ?>;
</script>