<?php
/**
 * Created by PhpStorm.
 * User: Reebok
 * Date: 21.04.2020
 * Time: 22:09
 */

namespace Controllers;

use Models\User;
use System\App;
use Views\View;

class UsersController
{
    public function index()
    {
        if (isset($_GET['verify']))
        {
            if (($user = User::getUserByToken($_GET['verify'])) !== null)
            {
                $user->verified = true;
                \R::store($user);
            }
            App::redirect('games', 'index');
        }

        View::render('index', ['data' => User::getLoggedUser(), 'last' => User::getLastGames()]);
    }

    public function signin()
    {
        if (isset($_GET['logout']))
        {
            unset($_SESSION['logged_user']);
            App::redirect('games', 'news');
        }

        if (User::getLoggedUser() !== null)
        {
            App::redirect('users', 'index');
        }

        View::render('signin', ['title' => 'Вхід', 'data' => User::signinUser($_POST)]);
    }

    public function signup()
    {
        $user = User::getLoggedUser();
        if ($user !== null && $user['type'] !== 'admin')
        {
            App::redirect('users', 'index');
        }

        View::render('signup', ['title' => 'Реєстрація', 'data' => User::signupUser($_POST)]);
    }

    public function edit()
    {
        $logged_user = User::getLoggedUser();

        if ((!isset($_GET['id'])) || (($logged_user['type'] !== 'admin') && ($logged_user['id'] !== $_GET['id'])))
        {
            App::redirect('users', 'index');
        }

        if (User::getUserByID($_GET['id']) == null)
        {
            App::redirect('users', 'index');
        }

        if (isset($_POST['do_edit']))
        {
            $edit_error = User::editUserByID($_GET['id'], $_POST);
            if ($edit_error == "")
            {
                if ($logged_user['id'] == $_GET['id'])
                {
                    App::redirect('users', 'index');
                } else
                {
                    App::redirect('users', 'edittable');
                }

            } else
            {
                View::render('edit', ['title' => 'Редагування профілю',
                    'data' => User::getUserByID($_GET['id']), 'logged_user' => User::getLoggedUser(),
                    'alert' => $edit_error]);
            }
        } else
        {
            View::render('edit', ['title' => 'Редагування профілю',
                'data' => User::getUserByID($_GET['id']), 'logged_user' => User::getLoggedUser(),
                'alert' => '']);
        }
    }

    public function delete()
    {
        $logged_user = User::getLoggedUser();
        $alert = '';

        if ((!isset($_GET['id'])) || (($logged_user['type'] !== 'admin') && ($logged_user['id'] !== $_GET['id'])))
        {
            App::redirect('users', 'index');
        }

        if (User::getUserByID($_GET['id']) == null)
        {
            App::redirect('users', 'index');
        }

        if (($logged_user['type'] == 'admin') && ($logged_user['id'] !== $_GET['id']))
        {
            User::deleteUserByID($_GET['id']);
            App::redirect('users', 'deletetable');
        } else
        {
            if (isset($_POST['do_delete']))
            {
                if (password_verify($_POST['password'], $logged_user['password']))
                {
                    User::deleteUserByID($_GET['id']);
                    App::redirect('games', 'news');
                } else
                {
                    $alert = '<div class="alert alert-danger text-center mt-3">
                    <strong>Невірний пароль</strong>
                  </div>';
                }
            }
        }

        View::render('delete', ['title' => 'Видалення облікового запису', 'alert' => $alert]);
    }

    public function deletetable()
    {
        View::render('deletetable', ['title' => 'Видалити користувача', 'users' => User::getAllUsers()]);
    }

    public function edittable()
    {
        View::render('edittable', ['title' => 'Редагувати користувача', 'users' => User::getAllUsers()]);
    }

    public function forgot() {
        $alert = '';

        if (isset($_POST['do_repair'])) {
            if (($user = User::getUserByEmail($_POST['email'])) !== null) {
                do {
                    $token = uniqid();
                    $fake_token = User::getUserByToken($token);
                } while (!empty($fake_token));

                $user->token = $token;

                \R::store($user);

                $_SESSION['repUser'] = $_POST['email'];

                User::repairUsersPassword($_POST['email'], $token);
            } else {
                $alert = '<div class="alert alert-danger text-center mt-3">
                    <strong>Користувача з такою поштою не знайдено!</strong>
                  </div>';
                unset($_POST['do_repair']);
            }
        } else if (isset($_POST['repair_token'])) {
            if (($user = User::getUserByToken($_POST['token'])) == null)
            {
                unset($_POST['repair_token']);
                $_POST['do_repair'] = '';
                $alert = '<div class="alert alert-danger text-center mt-3">
                    <strong>Невірно введений код!</strong>
                  </div>';
            }
        } else if (isset($_POST['repair_password'])) {
            if (trim($_POST['password']) == "") {
                $alert = '<div class="alert alert-danger text-center mt-3">
                    <strong>Введіть пароль</strong>
                  </div>';
            } else
            {
                $regexp = '/^\S*(?=\S{8,20})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';

                if (!preg_match($regexp, $_POST['password']))
                {
                    unset($_POST['repair_password']);
                    $_POST['repair_token'] = '';
                    $alert = '<div class="alert alert-danger text-center mt-3">
                    <strong>Пароль має складатись з літер англійського алфавіту,
                    містити не менше 8-ми символів, не більше 20 символів,
                    хоча б одну велику і одну маленьку літеру і хоча б одну цифру</strong>
                  </div>';
                } else {
                    $repUser = User::getUserByEmail($_SESSION['repUser']);
                    $repUser->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    \R::store($repUser);
                    App::redirect('users', 'signin');
                }
            }
        }

        View::render('forgot', ['title' => 'Відновлення паролю', 'alert' => $alert]);
    }

    public function repairPassword() {

    }

}