<?php
/**
 * Created by PhpStorm.
 * User: Reebok
 * Date: 21.04.2020
 * Time: 17:29
 */

namespace Models;

require_once DB;

use Helpers\Html;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use System\App;

class User
{
    public static function getAllUsers()
    {
        return array_values(\R::findAll('users'));
    }

    public static function getUserByID($id)
    {
        return \R::findOne('users', 'id = ?', array($id));
    }

    public static function getUserByName($name)
    {
        return \R::findOne('users', 'name = ?', array($name));
    }

    public static function getUserByEmail($email)
    {
        return \R::findOne('users', 'email = ?', array($email));
    }

    public static function getUserByToken($token)
    {
        return \R::findOne('users', 'token = ?', array($token));
    }

    public static function addUser($userData)
    {
        $user = \R::dispense('users');
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        if (!empty($userData['description']))
        {
            $user->description = $userData['description'];
        }
        $user->password = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->verified = false;
        do {
            $token = uniqid();
            $fake_token = User::getUserByToken($token);
        } while (!empty($fake_token));

        $user->token = $token;
        $user->join_date = \R::isoDate();

        return \R::store($user);
    }

    public static function getLastGames()
    {
        $games = array();

        if (($user = User::getLoggedUser()) !== null)
        {
            if ($user['last'] !== null)
            {
                $ids = json_decode($user['last']);
            } else
            {
                return $games;
            }

            for ($i = 0; $i < count($ids); $i++)
            {
                $games[] = Game::getGameByID($ids[$i]);
            }

            return $games;
        } else
        {
            App::redirect('games', 'index');
        }

        return null;
    }

    public static function signinUser($userData)
    {
        $vars = array();
        $alert = '';
        $errors = array();

        if (isset($userData['do_login'])) {
            $user = User::getUserByName($userData['name']);

            if ($user) {
                if (!password_verify($userData['password'], $user['password'])) {
                    $errors[] = 'Неправильний пароль!';
                }
            } else {
                $errors[] = 'Користувача з таким логіном не існує!';
            }

            if (!empty($errors)) {
                $alert = '<div class="alert alert-danger alert-signup">
                    <strong>' . array_shift($errors) . '</strong>
                  </div>';
            } else
            {
                $_SESSION['logged_user'] = $user['id'];
                $alert = '<div class="alert alert-success alert-signup">
                                <strong>Ви успішно авторизовані! Зараз ви можете перейти до ігор</strong>
                              </div>';
                unset($userData);

                $vars['user'] = $user;
            }
        }

        $vars['alert'] = $alert;

        return $vars;
    }

    public static function signupUser($userData)
    {
        $vars = array();
        $alert = '';
        $errors = array();

        if (isset($userData['do_signup'])) {
            if (trim($userData['name']) == "") {
                $errors[] = 'Введіть логін!';
            }
            if (trim($userData['email']) == "") {
                $errors[] = 'Введіть email!';
            }
            if (trim($userData['password']) == "") {
                $errors[] = 'Введіть пароль!';
            }
            if (trim($userData['allowPassword']) != trim($userData['password'])) {
                $errors[] = 'Повторний пароль введено некоректно!';
            }
            if (User::getUserByName($userData['name'])) {
                $errors[] = 'Користувач з таким логіном вже існує!';
            }
            if (User::getUserByEmail($userData['email'])) {
                $errors[] = 'Користувач з таким email вже існує!';
            }

            if (empty($errors)) {
                if ($id = User::addUser($userData))
                {
                    $_SESSION['logged_user'] = $id;

                    if (User::verifyUserEmail(User::getLoggedUser()['email'], User::getLoggedUser()['token']))
                    {
                        $alert = '<div class="alert alert-success alert-signup">
                                <strong>Ви успішно зареєстровані, підтвердіть, будь ласка, свою електронну пошту</strong>
                              </div>';
                        unset($data);
                    } else
                    {
                        $alert = '<div class="alert alert-success alert-signup">
                                <strong>
                                Ви успішно зареєстровані, але здається у нас помилочка (зверніться до підтримки сайту)
                                </strong>
                              </div>';
                        unset($data);
                    }
                } else
                {
                    $alert = '<div class="alert alert-danger alert-signup">
                                <strong>
                                Помилка реєстрації (зверніться до підтримки сайту)
                                </strong>
                              </div>';
                }
            } else {
                $alert = '<div class="alert alert-danger alert-signup">
                    <strong>' . array_shift($errors) . '</strong>
                  </div>';
            }
        }

        $vars['alert'] = $alert;

        return $vars;
    }

    public static function editUserByID($id, $data)
    {
        $user = User::getUserByID($id);
        $errors = array();
        $alert = '';

        if (trim($data['name']) == "") {
            $errors[] = 'Введіть логін!';
        }
        if (trim($data['description']) == "") {
            $errors[] = 'Введіть опис!';
        }
        if ((User::getLoggedUser()['type'] == 'admin') && (User::getLoggedUser()['id'] !== $_GET['id']))
        {
            if (trim($data['usertype']) == "") {
                $errors[] = 'Введіть тип користувача!';
            } else
            {
                $user->type = $data['usertype'];
            }
        }
        if ((trim($data['old_password']) == "") xor (trim($data['new_password']) == "")) {
            $errors[] = 'Пароль не введено!';
        } else if ((trim($data['old_password']) !== "") && (trim($data['new_password']) !== ""))
        {
            if (!password_verify($data['old_password'], $user['password'])) {
                $errors[] = 'Неправильний пароль!';
            } else
            {
                $user->password = password_hash($data['new_password'], PASSWORD_DEFAULT);
            }
        }

        if (empty($errors))
        {
            $user->name = $data['name'];
            $user->description = $data['description'];

            \R::store($user);
        } else
        {
            $alert = '<div class="alert alert-danger text-center mt-3">
                    <strong>' . array_shift($errors) . '</strong>
                  </div>';
        }

        return $alert;
    }

    public static function deleteUserByID($id)
    {
        $user = \R::findOne('users', 'id = ?', array($id));
        if ($user !== null)
        {
            \R::trash($user);
        } else
        {
            App::redirect('users', 'index');
        }
    }

    public static function getLoggedUser()
    {
        if (isset($_SESSION['logged_user']))
        {
            if ($user = User::getUserById($_SESSION['logged_user']))
            {
                return $user;
            } else
            {
                return null;
            }
        } else
        {
            return null;
        }
    }

    public static function verifyUserEmail($userEmail, $userToken)
    {
        $mail = new PHPMailer(true);

        try
        {
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username   = 'bavkyverify@gmail.com';
            $mail->Password   = 'fosypassword';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->CharSet = "UTF-8";

            $mail->setFrom('bavkyverify@gmail.com', 'Верифікація Бавок');
            $mail->addAddress($userEmail);

            $mail->isHTML(true);
            $mail->Subject = 'Підтвердження аккаунту';
            $mail->Body    = '<div class="jumbotron">
  <h1 class="display-4">Привіт, друже!</h1>
  <p class="lead">Вітаємо з реєстрацією на порталі "Бавки для дітий"</p>
  <hr class="my-4">
  <p>Щоб продовжити, ти повинен підтвердити свою електронну адресу, для цього просто відкрий посилання нижче</p>
  <a class="btn btn-primary btn-lg" href="'
                . Html::link('users', 'index', 'verify=' . $userToken) .
                '" role="button">Перейти</a>
</div>';
            $mail->AltBody = 'Ой, здається у нас помилочка (зверніться до підтримки сайту)';
            $mail->send();
            return true;
        } catch (Exception $e)
        {
            return false;
        }
    }

    public static function addToUserLast($gameID)
    {
        if (Game::getGameByID($gameID) !== null)
        {
            if (($user = User::getLoggedUser()) !== null)
            {
                if ($user['last'] !== null)
                {
                    $last = json_decode($user['last']);
                } else
                {
                    $last = array();
                }

                if (!in_array($gameID, $last))
                {
                    array_unshift($last, $gameID);

                    if (count($last) > 5)
                    {
                        array_pop($last);
                    }
                } else {
                    $key = array_search($gameID, $last);
                    unset($last[$key]);

                    array_unshift($last, $gameID);
                }

                $user['last'] = json_encode($last);
                \R::store($user);
            } else
            {
                App::redirect('games', 'index');
            }
        }
    }
}