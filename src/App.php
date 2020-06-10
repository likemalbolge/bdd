<?php

namespace System;


use Helpers\Html;

class App
{
    public static function run()
    {
        if (CONTROLLER == null)
        {
            App::redirect('games', 'news');
        } else if (ACTION == null)
        {
            App::redirect(CONTROLLER, 'index');
        } else
        {
            $controller = 'Controllers\\' . ucfirst(CONTROLLER) . 'Controller';
            $action = ACTION;

            if (!class_exists($controller))
            {
                Html::element('error404');
            } else
            {
                $objController = new $controller;

                if (!method_exists($objController, $action))
                {
                    Html::element('error404');
                } else
                {
                    $objController->$action();
                }
            }
        }
    }

    public static function redirect($controller, $action, $query = '')
    {
        if (!headers_sent()){
            header("Location: " . BASE_URL . $controller . '/' . $action . '?' . $query); exit;
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . BASE_URL . $controller . '/' . $action . '?' . $query . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . BASE_URL .
                $controller . '/' . $action . '?' . $query . '" />';
            echo '</noscript>'; exit;
        }
    }

    public static function out_redirect($to)
    {
        if (!headers_sent()){
            header("Location: " . $to); exit;
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . $to . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $to . '" />';
            echo '</noscript>'; exit;
        }
    }
}