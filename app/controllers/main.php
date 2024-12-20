<?php

class MainController extends Controller
{
    /**
     * Главная страница
     */
    public function index()
    {
        $this->view->render("Главная", "main");
    }
}