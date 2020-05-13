<?php
/**
 * Created by PhpStorm.
 * User: Reebok
 * Date: 27.04.2020
 * Time: 18:49
 */

namespace Models;

use System\App;

require_once DB;

class Comment
{
    public static function getCommentByID($id)
    {
        return \R::findOne('comments', 'id = ?', array($id));
    }

    public static function getCommentsByGameID($gameID)
    {
        return array_values(\R::find('comments', 'game_id = ? ORDER BY add_date DESC', array($gameID)));
    }

    public static function getUserComments()
    {
        return array_values(\R::find('comments', 'user_id = ?', array(User::getLoggedUser()['id'])));
    }

    public static function getCommentUser($userID)
    {
        return \R::findOne('users', 'id = ?', array($userID));
    }

    public static function addComment($gameID, $data)
    {
        $comment = \R::dispense('comments');
        $comment->user_id = User::getLoggedUser()['id'];
        $comment->game_id = $gameID;
        $comment->comment_text = trim($data['comment-text']);

        return \R::store($comment);
    }

    public static function deleteCommentByID($id)
    {
        $comment = \R::findOne('comments', 'id = ?', array($id));

        if ($comment !== null)
        {
            \R::trash($comment);
        }

        App::redirect('games', 'gamepage', 'id=' . $_GET['id']);
    }

    public static function updateCommentByID($id, $data)
    {
        $comment = \R::findOne('comments', 'id = ?', array($id));
        $comment->comment_text = trim($data['comment-text']);
        $comment->add_date = \R::isoDateTime();

        return \R::store($comment);
    }

    public static function getCommentsData($gameID, $data)
    {
        $vars = array();
        $alert = '';
        $errors = array();

        $vars['task'] = 'do_comment';

        if (isset($data['do_comment'])) {
            if (empty(trim($data['comment-text']))) {
                $errors[] = 'Коментар не може бути пустим!';
            }

            if (empty($errors)) {
                if (Comment::addComment($gameID, $data)) {
                    unset($_POST['do_comment']);
                    App::redirect('games', 'gamepage', 'id=' . $gameID);
                } else {
                    $alert = '<div class="alert alert-danger alert-signup">
                    <strong>Помилка! (Зверніться до підтримки сайту)</strong>
                  </div>';
                }
            } else {
                $alert = '<div class="alert alert-danger alert-signup">
                    <strong>' . array_shift($errors) . '</strong>
                  </div>';
            }
        } else if (isset($data['edit_comment']))
        {
            if (empty(trim($data['comment-text']))) {
                $errors[] = 'Коментар не може бути пустим!';
            }

            if (empty($errors)) {
                if (Comment::updateCommentByID($_GET['cid'], $data)) {
                    unset($_POST['edit_comment']);
                    App::redirect('games', 'gamepage', 'id=' . $gameID);
                } else {
                    $alert = '<div class="alert alert-danger alert-signup">
                    <strong>Помилка! (Зверніться до підтримки сайту)</strong>
                  </div>';
                }
            } else {
                $alert = '<div class="alert alert-danger alert-signup">
                    <strong>' . array_shift($errors) . '</strong>
                  </div>';
            }
        }

        $vars['alert'] = $alert;

        $comments = Comment::getCommentsByGameID($gameID);
        $user_comments = Comment::getUserComments();

        $vars['comments'] = $comments;
        $vars['user_comments'] = $user_comments;

        if (isset($_GET['do']))
        {
            if (isset($_GET['cid']))
            {
                if ($comment = Comment::getCommentByID($_GET['cid']))
                {
                    if ((User::getLoggedUser()['type'] == 'admin') ||
                        (User::getLoggedUser()['id'] == $comment['user_id']))
                    {
                        switch ($_GET['do'])
                        {
                            case 'edit':
                                $vars['update_text'] = $comment['comment_text'];
                                $vars['task'] = 'edit_comment';
                                break;
                            case 'delete':
                                Comment::deleteCommentByID($_GET['cid']);
                                break;
                            default:
                                App::redirect('games', 'gamepage', 'id=' . $_GET['id']);
                        }
                    } else
                    {
                        App::redirect('games', 'gamepage', 'id=' . $_GET['id']);
                    }
                } else
                {
                    App::redirect('games', 'gamepage', 'id=' . $_GET['id']);
                }
            }
        }

        return $vars;
    }

}