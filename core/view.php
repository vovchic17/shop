<?php

class View
{
    static function render($title, $view, $data = null)
    {
        if ($data) {
            extract($data);
        }
        require 'app/views/base.php';
    }
}