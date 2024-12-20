<?php

class OrdersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new OrdersModel();
    }

    /**
     * Страница заказов
     */
    public function index()
    {
        $this->view->render("Заказы", "orders");
    }

    public function get()
    {
        header("Content-Type: application/json");
        echo json_encode($this->model->getOrders($_SESSION["id"]));
    }
}