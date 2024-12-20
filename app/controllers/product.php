<?php

class ProductController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = new ProductModel();
    }

    /**
     * Страница просмотра товара
     */
    public function page()
    {
        $product = $this->model->getProductById($_GET["id"]);
        $this->view->render($product["title"], "product", ["product" => $product]);
    }

    /**
     * Получить список товаров по характеристикам в json
     */
    public function get()
    {
        header("Content-Type: application/json");
        try {
            $result = $this->model->getProducts(...$_GET);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    /**
     * Получить уникальные значения каждой категории в json
     * Для построения выпадающих списков на фронте
     */
    public function categories()
    {
        header("Content-Type: application/json");
        echo json_encode($this->model->getCategories());
    }

}