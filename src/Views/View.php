<?php

namespace Views;


class View
{
    public static function render($template, $data = [])
    {
        $fullPath = __DIR__ . '/Templates/' . ucfirst(CONTROLLER) . '/' . $template . '.php';

        if (!file_exists($fullPath))
        {
            Html::element('error404');
        } else
        {
            if (!empty($data))
            {
                foreach ($data as $key => $value)
                {
                    $$key = $value;
                }
            }

            include($fullPath);
        }
    }
}