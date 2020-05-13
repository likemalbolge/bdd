<?php
/**
 * Created by PhpStorm.
 * User: Reebok
 * Date: 21.04.2020
 * Time: 17:02
 */

namespace Controllers;

use Models\Comment;
use Models\Game;
use Models\User;
use System\App;
use Views\View;

class GamesController
{
    public function index()
    {
        View::render('index', ['title' => 'Ігри', 'data' => Game::getAllGames()]);
    }

    public function news()
    {
        View::render('news', ['title' => 'Новини', 'data' => Game::getAllNews()]);
    }

    public function gamepage()
    {
        if (User::getLoggedUser() !== null)
        {
            if (isset($_GET['id']))
            {
                Game::addView($_GET['id']);
                View::render('gamepage', ['gameData' => Game::getGameData($_GET['id']),
                    'commentsData' => Comment::getCommentsData($_GET['id'], $_POST)]);
            }
        } else
        {
            App::redirect('game', 'index');
        }
    }

    public function about()
    {
        View::render('about', ['title' => 'Про ресурс']);
    }

    public function search()
    {
        View::render('search', ['title' => 'Пошук', 'data' => Game::searchGames($_GET['query'])]);
    }

    public function add()
    {
        if (User::getLoggedUser()['type'] !== 'admin')
        {
            App::redirect('users', 'index');
        }

        if (isset($_POST['do_add']))
        {
            $add_error = Game::addGame($_POST);
            if ($add_error == "")
            {
                App::redirect('users', 'index');
            } else
            {
                View::render('add', ['title' => 'Додати гру', 'alert' => $add_error]);
            }
        } else
        {
            View::render('add', ['title' => 'Додати гру', 'alert' => '']);
        }
    }

    public function delete()
    {
        if (User::getLoggedUser()['type'] !== 'admin')
        {
            App::redirect('users', 'index');
        }

        if (isset($_GET['id']))
        {
            Game::deleteGameByID($_GET['id']);
            App::redirect('games', 'deletetable');
        } else
        {
            App::redirect('users', 'index');
        }
    }

    public function edit()
    {
        $logged_user = User::getLoggedUser();

        if ((!isset($_GET['id'])) || ($logged_user['type'] !== 'admin'))
        {
            App::redirect('users', 'index');
        }

        if (isset($_POST['do_edit']))
        {
            $edit_error = Game::editGameByID($_GET['id'], $_POST);
            if ($edit_error == "")
            {
                App::redirect('games', 'edittable');
            } else
            {
                View::render('edit', ['title' => 'Редагування гри',
                    'data' => Game::getGameByID($_GET['id']), 'alert' => $edit_error]);
            }
        } else
        {
            View::render('edit', ['title' => 'Редагування гри',
                'data' => Game::getGameByID($_GET['id']), 'alert' => '']);
        }
    }

    public function deletetable()
    {
        View::render('deletetable', ['title' => 'Видалити гру', 'games' => Game::getGames()]);
    }

    public function edittable()
    {
        View::render('edittable', ['title' => 'Редагувати гру', 'games' => Game::getGames()]);
    }

    public function statistics()
    {
        View::render('statistics', ['title' => 'Статистика популярності ігор', 'data' => Game::getStatistics()]);
    }
}