<?php
/**
 * Created by PhpStorm.
 * User: Reebok
 * Date: 21.04.2020
 * Time: 17:11
 */

namespace Models;

use System\App;

require_once DB;

class Game
{
    public static function getAllGames()
    {
        $vars = array();
        $errors = array();
        $alert = '';

        if (User::getLoggedUser() !== null) {
            if (!User::getLoggedUser()['verified']) {
                $errors[] = 'Для доступу до ігор ви мусите підтвердити вашу електронну пошту';
            }
        } else {
            $errors[] = 'Ви мусите авторизуватися для доступу до ігор';
        }

        if (empty($errors)) {
            $games = Game::getGames();
            $vars['games'] = $games;
            $vars['alert'] = $alert;
        } else {
            $alert = '<div class="alert alert-warning alert-signup">
                <strong>' . array_shift($errors) . '</strong>
            </div>';
            $vars['alert'] = $alert;
        }
        return $vars;
    }

    public static function findGames($query)
    {
        $games = array();

        $games['by-title'] = array_values(\R::find('games', 'title LIKE ?', ['%' . $query . '%']));
        $games['by-tags'] = array_values(\R::find('games', 'tags LIKE ?', ['%' . $query . '%']));

        return $games;
    }

    public static function getAllNews()
    {
        $vars = array();
        $news = Game::getGames();
        $tags = array();

        for ($i = 0; $i < count($news); $i++) {
            $tags[] = explode(",", $news[$i]["tags"]);
        }

        $vars['news'] = $news;
        $vars['tags'] = $tags;

        return $vars;
    }

    public static function getGames()
    {
        return array_values(\R::findAll('games', 'ORDER BY add_date DESC'));
    }

    public static function getGameByID($id)
    {
        return \R::findOne('games', 'id = ?', array($id));
    }

    public static function getGameData($id)
    {
        $vars = array();

        User::addToUserLast($id);

        if ($game = Game::getGameByID($id)) {
            $resolution = explode(',', $game['resolution']);
            $tags = explode(',', $game['tags']);

            $vars['game'] = $game;
            $vars['resolution'] = $resolution;
            $vars['tags'] = $tags;

            return $vars;
        } else
        {
            App::redirect('games', 'index');
        }

        return null;
    }

    public static function addGame($data)
    {
        $game = \R::dispense('games');

        $errors = array();
        $alert = '';

        if (trim($data['title']) == "") {
            $errors[] = 'Введіть назву!';
        }
        if (trim($data['link']) == "") {
            $errors[] = 'Введіть посилання!';
        }
        if (trim($data['resolution']) == "") {
            $errors[] = 'Введіть розміри вікна!';
        }
        if (trim($data['img']) == "") {
            $errors[] = 'Введіть шлях до логотипу!';
        }
        if (trim($data['description']) == "") {
            $errors[] = 'Введіть опис!';
        }
        if (trim($data['tags']) == "") {
            $errors[] = 'Введіть теги!';
        }
        if (trim($data['developer']) == "") {
            $errors[] = 'Введіть назву організації/розробника!';
        }
        if (trim($data['mobile_ready']) == "") {
            $errors[] = 'Введіть статус підтримки для мобільних пристроїв!';
        }

        if (empty($errors))
        {
            $game->title = $data['title'];
            $game->link = $data['link'];
            $game->resolution = $data['resolution'];
            $game->img = $data['img'];
            $game->description = $data['description'];
            $game->tags = $data['tags'];
            $game->developer = $data['developer'];
            $game->mobile_ready = $data['mobile_ready'];
            $game->add_date = \R::isoDate();

            \R::store($game);
        } else
        {
            $alert = '<div class="alert alert-danger text-center mt-3">
                    <strong>' . array_shift($errors) . '</strong>
                  </div>';
        }

        return $alert;
    }

    public static function editGameByID($id, $data)
    {
        $game = Game::getGameByID($id);

        $errors = array();
        $alert = '';

        if (trim($data['title']) == "") {
            $errors[] = 'Введіть назву!';
        }
        if (trim($data['link']) == "") {
            $errors[] = 'Введіть посилання!';
        }
        if (trim($data['resolution']) == "") {
            $errors[] = 'Введіть розміри вікна!';
        }
        if (trim($data['img']) == "") {
            $errors[] = 'Введіть шлях до логотипу!';
        }
        if (trim($data['description']) == "") {
            $errors[] = 'Введіть опис!';
        }
        if (trim($data['tags']) == "") {
            $errors[] = 'Введіть теги!';
        }
        if (trim($data['developer']) == "") {
            $errors[] = 'Введіть назву організації/розробника!';
        }
        if (trim($data['mobile_ready']) == "") {
            $errors[] = 'Введіть статус підтримки для мобільних пристроїв!';
        }

        if (empty($errors))
        {
            $game->title = $data['title'];
            $game->link = $data['link'];
            $game->resolution = $data['resolution'];
            $game->img = $data['img'];
            $game->description = $data['description'];
            $game->tags = $data['tags'];
            $game->developer = $data['developer'];
            $game->mobile_ready = $data['mobile_ready'];

            \R::store($game);
        } else
        {
            $alert = '<div class="alert alert-danger text-center mt-3">
                    <strong>' . array_shift($errors) . '</strong>
                  </div>';
        }

        return $alert;
    }

    public static function deleteGameByID($id)
    {
        $game = \R::findOne('games', 'id = ?', array($id));

        if ($game !== null)
        {
            \R::trash($game);
        } else
        {
            App::redirect('users', 'index');
        }
    }

    public static function searchGames($query)
    {
        if (($user = User::getLoggedUser()) !== null)
        {
            if ($user['verified'])
            {
                if (isset($query) && !empty($query))
                {
                    $games = Game::findGames($query);
                    return $games;
                } else
                {
                    App::redirect('games', 'index');
                }
            } else
            {
                App::redirect('games', 'index');
            }
        } else
        {
            App::redirect('games', 'index');
        }

        return null;
    }
}