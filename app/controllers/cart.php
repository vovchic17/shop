<?php

class CartController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new CartModel();
    }

    /**
     * Страница корзины
     */
    public function index()
    {
        $this->view->render("Корзина", "cart");
    }

    public function purchase()
    {
        $this->view->render("Успешная покупка", "purchase");
    }

    public function add()
    {
        $data = json_decode(file_get_contents('php://input'));
        $this->model->add(
            $_SESSION["id"],
            $data->product_id,
            $data->quantity
        );
        header("Content-Type: application/json");
        echo json_encode(["success" => true]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents('php://input'));
        $this->model->delete($_SESSION["id"], $data->product_id);
        header("Content-Type: application/json");
        echo json_encode(["success" => true]);
    }

    public function getProduct()
    {
        header("Content-Type: application/json");
        echo json_encode($this->model->getProduct($_SESSION["id"], $_GET["id"]));
    }

    public function getCart()
    {
        header("Content-Type: application/json");
        echo json_encode($this->model->getCart($_SESSION["id"]));
    }

    public function order()
    {
        $this->model->order($_SESSION["id"]);
        header("Content-Type: application/json");
        echo json_encode(["success" => true]);
    }
}