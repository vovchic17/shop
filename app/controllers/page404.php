<?php

class Page404Controller extends Controller
{
    /**
     * Страница не найдена
     */
    public function index()
    {
        $this->view->render("Страница не найдена", 'page404');
    }
}