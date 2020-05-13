<?php
/**
 * Created by PhpStorm.
 * User: Reebok
 * Date: 21.04.2020
 * Time: 16:27
 */

namespace Helpers;


class Html
{
    public static function css($filename)
    {
        if (file_exists($filename))
        {
            return '<link rel="stylesheet" href="' . $filename . '">';
        } else if (strpos($filename, 'http') !== false)
        {
            return '<link rel="stylesheet" href="' . $filename . '">';
        }
        $fullPath = WEB . 'css/' . $filename;
        return '<link rel="stylesheet" href="' . $fullPath . '">';
    }

    public static function script($filename)
    {
        if (file_exists($filename))
        {
            return '<script src="' . $filename . '"></script>';
        } else if (strpos($filename, 'http') !== false)
        {
            return '<script src="' . $filename . '"></script>';
        }
        $fullPath = WEB . 'js/' . $filename;
        return '<script src="' . $fullPath . '"></script>';
    }

    public static function element($filename)
    {
        $fullPath = ELEMENTS . $filename . '.php';
        include($fullPath);
    }

    public static function icon($name)
    {
        return '<i class="material-icons">' . $name . '</i>';
    }

    public static function link($controller, $action, $query = '')
    {
        return BASE_URL . $controller . '/' . $action . '?' . $query;
    }

    public static function image($filename, $class = '')
    {
        if (file_exists($filename))
        {
            return '<img src="' . $filename . '">';
        } else if (strpos($filename, 'http') !== false)
        {
            return '<img src="' . $filename . '">';
        }
        $fullPath = WEB . 'img/' . $filename;
        return '<img src="' . $fullPath . '" class="' . $class . '">';
    }
}